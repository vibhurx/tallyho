<?php

class DrawController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $isTourOwner = false;
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view', 'fetchPlayerList'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'update', 'delete', 'make', 'save', 'remake',
						'schedule'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * This action leads to a popup view.
	 */
	public function actionCreate($tid)
	{
		$model=new Category;
		$model->tour_id = $tid;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			if($model->save())
				$this->redirect(Yii::app()->request->urlReferrer);
		} else {
			$this->renderPartial('create',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionSave($id)
	{
		$category =$this->loadModel($id);
		$tour = Tour::model()->findByPk($category->tour_id);
		
		//	Check if the user is the owner of this tournament. It is unlikely that the non-owner will reach this point.
		if(!Yii::app()->user->isTourOwner($category->tour_id)) 	//exit unceremoniously
			throw new CHttpException(404, 'You are not allowed to access draws that do not belong to your organization.');
		
		
		if($category->draw_status == Category::STATUS_NOT_PREPARED){
		
			$this->redirect($this->createUrl('/participant/draw/index', array('cid'=>$id)));
		
		} elseif($category->draw_status == Category::STATUS_SEEDED){
			
			//1. Delete all the matches if there is any. More like precautionary
			$category->deleteMatches();
			
			//2. Read all the draw-leaves - Post parameter
			$json_parties   = isset($_POST['jsonForPlayerPositions'])?$_POST['jsonForPlayerPositions']: null;
			$newDrawSize    = isset($_POST['mdraw_size'])?$_POST['mdraw_size']: null;
			$newQDrawLevels = isset($_POST['qdraw_levels'])?$_POST['qdraw_levels']: null;
			$newDrawDirect  = isset($_POST['mdraw_direct'])?$_POST['mdraw_direct']: null;
			$newQDrawSize   = isset($_POST['qdraw_size'])?$_POST['qdraw_size']: null;
			
			$allFine = false;
			
			if($json_parties == null || $json_parties == 'empty'){
				
				throw new CHttpException(400, 'The data communication between the client and the server has failed. Player position information is not available. Report to the admin with the error no 5507.');
				
			} else {
				
				$match = null;
				$transaction=Yii::app()->getDb()->beginTransaction();
				
				//	@todo: What if the participants are not in the order
				foreach(json_decode($json_parties) as $participant){
					if($participant->playerSeq == 1){
						$match = new Match();
						$match->category = $category->category;
						$match->tour_id = $category->tour_id;
						if($participant->type == 'main'){
							$match->level = $participant->level;
						} elseif($participant->type == 'qualifying'){
							$match->level = $participant->level - $newQDrawLevels -1;
						}
						$match->sequence =  $participant->matchSeq ;
						if(trim($participant->participantId) != '' && $participant->participantId != null)
							$match->player11 = $participant->participantId;

					} elseif($participant->playerSeq == 2) {
						if(trim($participant->participantId) != '' && $participant->participantId != null)
							$match->player21 = $participant->participantId;
						if($match->save()){
							if(!$allFine)
								$allFine = true;
						} else {
							echo 'Save failed <br>';
							$transaction->rollback();
							//rollback and exit
						}
					}
							
// 					//In case of doubles
// 					$match->player12 = isset($matchJson['player12']) ? $matchJson['player12'] : null;
// 					$match->player22 = isset($matchJson['player22']) ? $matchJson['player22'] : null;
										
				} //end foreach
				if($allFine){
					$category->draw_status  = Category::STATUS_PREPARED;
					$category->mdraw_size   = $newDrawSize;
					$category->qdraw_size   = $newQDrawSize;
					$category->mdraw_direct = $newDrawDirect;
					$category->qdraw_levels = $newQDrawLevels;
					$category->save(array('draw_status', 'mdraw_size', 'qdraw_size', 'mdraw_direct', 'qdraw_levels'));
					$transaction->commit();
				} else {
					$transaction->rollback();
				}
			}
			//Why does it have to be specified as redirect. Commenting it until figure it out.
			$this->redirect($this->createUrl('view', array('id'=>$id))); //, 'redirect'=>'true')));	
		
		} else {
			
			throw new CHttpException(404, 'This link is unaccessible for this scenario. Report to admin with error code 5506');	
		}
	
	}


	/*
	 * Action to prepare a draw. It views a tree based on logic, as a suggestion. The logic is based on parameters set by
	 * the organizers like draw-size, how many qualifying rounds, no of direct entries (category table) and wild cards (participant table).
	 * Accessed by owning-organizers
	 * Only under draw_status as NON_PREPARED or SEEDED
	 */
	
	public function actionMake($id) 
	{
		if(isset($_POST['jsonForPlayerPositions'])){
			$this->actionSave($id);
			return;
		}
		
		$category = Category::model()->findByPk($id);
		$tour = Tour::model()->findByPk($category->tour_id);
		$is_paid = $category->is_paid;

		//Check if the user is the owner of this tournament. It is unlikely that the non-owner will reach this point.
		if(!Yii::app()->user->isTourOwner($category->tour_id)) 	//exit unceremoniously
			throw new CHttpException(404, 'You are not allowed to access draws that do not belong to your organization.');
		
		if($category->draw_status == Category::STATUS_NOT_PREPARED)
			$this->redirect($this->createUrl('/participant/draw/index', array('cid'=>$id)));
		elseif($category->draw_status == Category::STATUS_SEEDED){
			//Use AR instead of DataProvider. We need to handle arrays.
			if($is_paid)
				$participants = Participant::model()->findAllByAttributes(array('category'=>  $category->category,
							'tour_id'=> $category->tour_id, 'payment_status'=>true ));
			else
				$participants = Participant::model()->findAllByAttributes(array('category'=>  $category->category,
						'tour_id'=> $category->tour_id ));
			
			$participantsArr = array();
			foreach($participants as $participant){
				$participantsArr[$participant->id]['id'] = $participant->id;
				$participantsArr[$participant->id]['seed'] = $participant->seed;
				$participantsArr[$participant->id]['shortName'] = $participant->player->shortName;
			}

				
			$this->render('make', array(
					'id' => $id,
					'category' => $category,
					'tourLocation'=> $tour->location,
					'totalEnroled' => sizeof($participants), //$dataProvider->totalItemCount,
					'participants' => $participantsArr,
					'isTourOwner' => Yii::app()->user->isTourOwner($category->tour_id),
					'tourId'=> $tour->id,
			));
		} else {
			throw new CHttpException(404, 'This link is unaccessible for this scenario. Report to admin with error code 5505');
		}
	}

	/*
	 * 
	 */
	public function actionView($id){
		$category = Category::model()->findByPk($id);
		$tour = Tour::model()->findByPk($category->tour_id);
		
		$matches = Match::model()->findAllByAttributes(array('category'=>  $category->category,
				'tour_id'=> $category->tour_id ));
		
		if($matches == null){
			Yii::app()->user->setFlash('error', 'The bracket has not been drawn yet.');
			$this->redirect(array('/category/default/view', 'id'=>$id));
		}

		$main_draw_size  = $category->mdraw_size;
		$qual_draw_size  = $category->qdraw_size;
		$main_last_level = log($main_draw_size)/log(2);
		$qual_last_level = -1;
		
		$participantsArr = array();
		$scoreArr = array();		//struct: [{"seq": 5, "score": [{"set_no": "1", "points":[6,4]}, { .. }, { .. }]]
		
		foreach($matches as $item){
			$draw_type = $item->level > 0 ? 'main' : 'qualifying';
			$winner = $item->winner;	// possible values are null, 1 or 2
			if($winner > 0){			// how would it behave when null
				$sets = $item->sets;
				
				$scoreArr[$item->sequence]['seq'] = $item->sequence;		//	Redundant, see if it can be removed.
				$scores = array();
				foreach($sets as $set){
					$score = array();
					$score['set_no'] = $set->set_no; 
					$score['points'] = array($set->team1, $set->team2);
					$scores[] = $score;
				}
				$scoreArr[$item->sequence]['score'] = $scores;
			}
			
			if(isset($item->participant11)){
				$participant = $item->participant11;
				$key = $participant->id . $item->sequence; //unique enough << problem
				$participantsArr[$key]['id'] = $participant->id;
				$participantsArr[$key]['seq'] = $item->sequence . '_1';
				$participantsArr[$key]['drawType'] = $draw_type;
				$participantsArr[$key]['seed'] = $participant->seed;
				$participantsArr[$key]['shortName'] = $participant->player->shortName;
				if($winner == 1){
					$participantsArr[$key]['winner'] = true;
					
				}
			}
				
			if(isset($item->participant21)){
				$participant = $item->participant21;
				$key = $participant->id . $item->sequence; //unique enough
				$participantsArr[$key]['id'] = $participant->id;
				$participantsArr[$key]['seq'] = $item->sequence . '_2';
				$participantsArr[$key]['drawType'] = $draw_type;
				$participantsArr[$key]['seed'] = $participant->seed;
				$participantsArr[$key]['shortName'] = $participant->player->shortName;
				if($winner == 2)
					$participantsArr[$key]['winner'] = true;
			}

			
		//	The last level does not have corresponding Match entities. They need to be filled up on conditions
		//	Conditions being - if the penultimate level has a winner then add an item in the last level.
		//	Check if there is a winner in the penultimate level
			if($item->level == $main_last_level || $item->level == $qual_last_level){		//	Main & Qual are mutually exclusive
				if($winner){		//If there is a winner, create the winning phantom entry. "Phantom" because there are no manifestation in Match table
					$draw_size = $item->level == $main_last_level ? $main_draw_size : $qual_draw_size;
					$next_seq  = ($draw_size/2 + ($item->sequence + $item->sequence % 2)/2) . '_1';
					$next_key  = $participant->id . $next_seq ;
								
					$participant = $winner == 1 ? $item->participant11 : $item->participant21;
					
					$participantsArr[$next_key]['id'] = 		$participant->id;
					$participantsArr[$next_key]['seq'] = 		$next_seq;
					$participantsArr[$next_key]['drawType'] =	$draw_type;
					$participantsArr[$next_key]['seed'] = 		$participant->seed;
					$participantsArr[$next_key]['shortName'] = 	$participant->player->shortName;
					$participantsArr[$next_key]['final'] = 	true;
						
				}	
			}
		}
		
		$this->render('view', array(
						 'id' => $id,
				   'category' => $category,
				'tourLocation'=> $tour->location,
					  'tourId'=> $tour->id,
				'isTourOwner' => Yii::app()->user->isTourOwner($tour->id),
			   'participants' => $participantsArr,
					  'scores'=> $scoreArr,
		));
	}
	
	/*
	 * The qualified players are placed in the main draw. Pre-condition is that the main draw should have been made.
	 * Our app does not allow qualifying and main rounds to be separately build. So the pre-condition is always met.
	 * @todo: incomplete
	 */
	public function actionUpdate($id){
		$category = Category::model()->findByPk($id);
		
		//	Take all the qualified players. Condition - level -1 and winner 1/2
		//	Who are not already in the main draw ????
		//	order by seed asc
		$sql = "SELECT t.id, 
						IF(winner=1,t.player11,t.player21) AS player, 
						IF(winner=1, p.seed, q.seed) AS seed 
				FROM `match` t 
					LEFT JOIN participant p ON t.player11 = p.id 
					LEFT JOIN participant q ON t.player21 = q.id 
				WHERE t.tour_id=" . $category->tour_id . " AND t.category=" . $category->category . "
					AND level = -1 
					AND NOT ISNULL(winner) ORDER BY seed";
		$command = Yii::app()->db->createCommand($sql);
		$completed_qual_matches = $command->queryAll();
		
	   /*
		*	Place them in main draw per their seeding lowest with highest
		*	List matches where player11 or player21 are missing. List their participant->seed as well.
		*	order by seed desc.
		*	Make sure that the empty slot opponent might have already been "walked-over" to the next round. Avoid those.
		*	This method could be called repeatedly until all the qualifiers are taken care off.
		*/
		$sql = "SELECT t.id,
					IF(ISNULL(player11), 'empty', player11) as player11,  
					IF(ISNULL(player21), 'empty', player21) as player21,
					IF(ISNULL(player11), q.seed, p.seed) as seed  
				FROM `match` t
					LEFT JOIN participant p ON t.player11=p.id
					LEFT JOIN participant q ON t.player21=q.id 
				WHERE t.tour_id=" . $category->tour_id . " AND t.category=" . $category->category . "
					AND level = 1 
					AND (ISNULL(t.player11) OR ISNULL(t.player21))
					AND ISNULL(winner)
				ORDER BY seed DESC";
		$command = Yii::app()->db->createCommand($sql);
		$empty_places = $command->queryAll();
		
		//	Assuming that the number of qualifiers will be smaller than available slots.
		//	There is no particular logic used. The qualified players are allotted by first-available-position. 
		for($i=0; $i<sizeof($completed_qual_matches); $i++){
			$match = $empty_places[$i];
			if($match != null){
				if($match->player11 != null){
					$match->player11 = $completed_qual_matches[i]->id;
				} else {
					$match->player21 = $completed_qual_matches[i]->id;
				}
				$match->save(false, array('player11', 'player21'));
			}
		}
		
		//	loop over the matches and update player11 or player21, whichever is missing
		
		
		//	How to revert >> take all the qualified players find them in level 1 of main and remove them from the matches
	}
	
	/*
	 * Drops the older draw and remakes the draw-bracket. The matches which are partially done are also dropped.
	 * If the organizer wishes to retain the matches then they have to manually update the scores.
	 */
	public function actionRemake($id){
		//	Remove all the matches
		$category = Category::model()->findByPk($id);
		$tour = Tour::model()->findByPk($category->tour_id);
			
		$matches = Match::model()->findAllByAttributes(array('category'=>  $category->category,
				'tour_id'=> $category->tour_id ));
		
		//$transaction = Yii::app()->db->createTransaction();
		$transaction=Yii::app()->getDb()->beginTransaction();
		try{
			foreach($matches as $match)
				$match->delete();		//	@todo what happens to the scoreboard of the matches already played.
			
			//Reset Category draw_status to Not Prepared
			$category->draw_status = Category::STATUS_NOT_PREPARED;
			$category->save(false, array('draw_status'));

		} catch(Exception $ex) {
			$transaction->rollback();
			return;
		}
		$transaction->commit();		

		//	Redirect to make
		$this->actionMake($id);

	}
	
	/*
	 * Input id : Category table PK, id.
	 */
	public function actionSchedule($id){

		if(isset($_GET['dur'])){
			if(isset($_GET['condn'])){
				$this->actionAutoSchedule($id, $_GET['dur'], true);
			} else {
				$this->actionAutoSchedule($id, $_GET['dur'], false);
			}
// 		} elseif(isset($_GET['court-selection-form')){
			
		} else {
			$category = Category::model()->findByPk($id);
			$tour = Tour::model()->findByPk($category->tour_id);
	
			$dataProvider = new CActiveDataProvider('Match', array(
				'criteria'=>array(
					'condition'=>'category=:category AND tour_id=:tour_id',
					'params'=>array(':tour_id'=>$category->tour_id, ':category'=>$category->category),
					'order' => 'level, sequence',
				),
//				'sort'=>array('defaultOrder'=>array('level', 'sequence')),
			));
			
			//	Display the calendar layout
			$this->render('schedule', array(
				'id' => $id,	//Category.id
				'tourId' => $category->tour_id,
				'dataProvider'=> $dataProvider,
			));
		}
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Category the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function isTourOwner($orgId){
		//Check if the user is the owner of this tournament. It is unlikely that the non-owner will reach this point.
		$this->isTourOwner = Yii::app()->user->data()->contact->organization->org_id == $orgId;
		if(!$this->isTourOwner) 	//exit unceremoniously
			throw new CHttpException(404, 'You are not allowed to access draws that do not belong to your organization.');
		return true;
	}
	/**
	 * Performs the AJAX validation.
	 * @param Category $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Return data to browser as JSON and end application.
	 * @param array $data
	 */
// 	protected function renderJSON($data)
// 	{
// 		//header('Content-type: application/json');
// 		echo CJSON::encode($data);
	
// // 		foreach (Yii::app()->log->routes as $route) {
// // 			if($route instanceof CWebLogRoute) {
// // 				$route->enabled = false; // disable any weblogroutes
// // 			}
// // 		}
// // 		Yii::app()->end();
// 	}
}
