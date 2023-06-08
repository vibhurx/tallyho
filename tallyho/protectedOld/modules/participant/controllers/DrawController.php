<?php
/**
 * Use this controller for showing all the past, present and upcoming participation for a player.
 * Player will have a lazy relationship called "participations".
 */

class DrawController extends Controller
{
	public $layout='//layouts/column2_p';
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('list', 'tree32s', 'view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'create', 'generate', 'seed', 'sort',
						'updatePoints', 'updateSeedPoints', 'togglePaymentStatus', 'delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
	 */
	public function actionCreate($cid)
	{	
		$category = Category::model()->findByPk($cid);
		
		$categoryName = Lookup::item("AgeGroup", $category->category);
		$tour_id = $category->tour_id;
		$tour = Tour::model()->findByPk($tour_id);
		$tourLocation = $tour->location;
		
		$dataProvider=new CActiveDataProvider('Participant', array(
				'criteria' => array('condition' => 'category=' . $category->category . ' AND tour_id=' . $tour_id,
						'order' => 'seed ASC', 'offset'=> 0,
						//'limit' => $category->mdraw_size
				),
				'pagination' => false,
		));
		
		if(isset($_POST['Category'])){
			$category->attributes = $_POST['Category'];
		} else {
			//set an initial draw size
			$category->mdraw_size = $category->mdraw_size != null? $category->mdraw_size : 
				$dataProvider->totalItemCount < 20? 16 : 
					$dataProvider->totalItemCount < 40? 32 : 
						64;
		}
				
		
		$this->render('create', array(
			  'dataProvider' => $dataProvider,
					'tourId' => $tour_id,
			   'tourLocation'=> $tourLocation,
			  'categoryName' => $categoryName,
				  'category' => $category,
			   'isTourOwner' => Yii::app()->user->isTourOwner($tour_id),
					   'cid' => $cid,
				  'drawSize' => $category->mdraw_size,
				  'qlRounds' => $category->qdraw_levels,
			   'mainEntries' => $category->mdraw_direct,
				'qualLevels' => $category->qdraw_levels,
			  'totalEnroled' => $dataProvider->totalItemCount
		));
	}

	/**
	 * 
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		//Remove the references from the matches << done at DB level
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/** 
	 * Generate action: generates all the match objects corresponding to the draw selected - 16, 32 etc.
	 * 1. Store the new positions after user modifications (drag-drop) where???
	 * 2. Create a bunch of Match (qualifying/main) objects with each pair of participant updated in the match.
	 * 3. Update category field status to Prepared.
	 * 4. Finally a view appears with link to the main and qualifying draws.
	 *
	 * @todo: Need to provide a link to delete a draw and start afresh from the list of participants.
	 * 	Should look like in the categories view - "delete the draw", which appears for only those where draw 
	 *  status is prepared.
	 */
	public function actionGenerate($cid, $drawSize)
	{
		$category = Category::model()->findByPk($cid);
		$categoryCode = $category->category;
		$tourId = $category->tour_id;
		$is_paid = $category->is_paid;
		$mainDrawSize = $category->mdraw_size;
		
		//Pull out all the participants with their ids
		if($is_paid)
			$dataProvider=new CActiveDataProvider('Participant', array(
				'criteria' => array('condition' => 'category=:category AND tour_id=:tourId AND payment_status=true',
								'params'=>array(':category'=>$categoryCode, ':tourId'=>$tourId)),
				'sort'=>array('defaultOrder'=>'seed'),
				'pagination'=>false,
			));
		else
			$dataProvider=new CActiveDataProvider('Participant', array(
					'criteria' => array('condition' => 'category=:category AND tour_id=:tourId',
							'params'=>array(':category'=>$categoryCode, ':tourId'=>$tourId)),
					'sort'=>array('defaultOrder'=>'seed'),
					'pagination'=>false,
			));
		//@correction: instead of seeds, use the id and sequence for draw making
		// like 1_1: pl1, 1_2: pl2, 2_1: pl3, 2_2: pl4, ..., n_1: pl2n-1, n_2: pl2n
		// Note: player positions would come from the previous screen. 

		
// 		$arrSeeds = array();
// 		foreach($dataProvider->getData() as $record){
// 			$arrSeeds[$record->seed]=$record->id;
// 		}
		
		//Main draw
		if(intval($drawSize) === 32){
			$arrHierarchy = array(1=>array(1,32), 2=>array(16,17), 3=>array(8,25), 4=>array(9,24), 5=>array(4,29), 6=>array(13,20), 7=>array(5,28), 8=>array(12,21),
					9=>array(2,31), 10=>array(15,18), 11=>array(7,26), 12=>array(10,23), 13=>array(3,30), 14=>array(14,19), 15=>array(6,27), 16=>array(11,22));
		} elseif(intval($drawSize) === 16){
			$arrHierarchy = array(1=>array(1,16), 2=>array(8,9), 3=>array(4,13), 4=>array(5,12), 5=>array(2,15), 6=>array(7,10), 7=>array(3,14), 8=>array(6,11));
		}
		else
			throw new CHttpException(404,'Are you sure you have passed the draw size coz I ain\'t getting nothing');
		
		for($i=0; $i<$mainDrawSize; $i++){
	//		foreach($arrHierarchy as $seq=>$seedPair){
			$seedPair = $arrHierarchy[$i];
			$seq = $i;
			$match = new Match;
			$match->sequence = $seq;
			$match->team1Player1 = $arrSeeds[$seedPair[0]];
			$match->team2Player1 = $arrSeeds[$seedPair[1]];
			$match->tour_id = $category->tour_id; // Category ID, not the lookup code @caution: refine
			$match->category = $category->category; // Category ID, not the lookup code @caution: refine
			$match->level = 1;
			if(!$match->save())
				throw new CHttpException(404,'Match could not be saved.');
		}
		
		$category->draw_status = Category::STATUS_PREPARED;
		if($category->save())
			$this->render('success', array('message'=>'The draw has been generated successfully. Select the link to go back',
					'tourId'=>$tourId, 'isTourOwner'=>$this->isTourOwner));
		else
			throw new CHttpException(404,'Draw has failed or partially created. Contact your administrator.');
	}

	/**
	 * Lists all the enrollments under current category and tournament.
	 * @caution: Action Seed of this controller uses this function internally.
	 */
	public function actionIndex($cid)
	{
		
		//If the current logged in user is a player, then it should stop access
		//An organizer is allowed to view only their own list.

		if(Yii::app()->user->data()->type == YumUser::TYPE_PLAYER){
			$this->redirect(array('..'));
		}
		
		$category = Category::model()->findByPk($cid);
		if($category == null){
			new Exception();
			return;
		}
		
		if(isset($_POST['seed_points'])){
			//echo "participant_id: " . $_POST['participant_id'];
			$participant = Participant::model()->findByPk($_POST['participant_id']);
			if($participant != null){
				$participant->seed_points = $_POST['seed_points'];
				if($participant->save(false, 'seed_points')){
					if($category->draw_status == Category::STATUS_SEEDED){
						$category->draw_status = Category::STATUS_NOT_PREPARED;
						if(!$category->save(false, 'draw_status')){
							echo "Category save failed";
							return;
						}
					}
				} else {
					echo "Save failed";
					return;
				}
			} else {
				echo "Invalid Participant";
				return;
			}
		} elseif(isset($_POST['direction'])){
			//echo "participant_id: " . $_POST['participant_id'];

			if(isset($_POST['participant_id'])){
				$mode = isset($_POST['mode'])?$_POST['mode']: null;
				$remark = isset($_POST['remark'])?$_POST['remark']: null;
				if($this->actionTogglePaymentStatus($_POST['participant_id'], $mode, $remark)){
					$category = Category::model()->findByPk($cid);
				}
			} else {
				echo "Invalid Participant";
				return;
			}
		}
		/* Find category name from the Category.Category_ID - select `name` from lookup where `type`='AgeGroup' and 'id'=?
		 * find tour name from Category.ID - select location from tour where id = (select tour_id from category where id = 1);
		*/
		$categoryCode = $category->category;
		$tour_id = $category->tour_id;
		$categoryName = Lookup::item("AgeGroup", $category->category);
		$tour = Tour::model()->findByPk($tour_id);
		$tourName = $tour->location;
		
		$dataProvider=new CActiveDataProvider('Participant', array(
			'criteria' => array('condition' => 'category=:category AND tour_id=:tourId',
							'params'=>array(':category'=>$categoryCode, ':tourId'=>$tour_id)),
			'sort'=>array('defaultOrder'=>'seed'),
			'pagination'=>false,
		));

		
		$this->render('index', array(
			'dataProvider'=> $dataProvider,
			'pagination'=> false,
			'categoryName'=> $categoryName,
			'tourName'=> $tourName,
			'isTourOwner'=> Yii::app()->user->isTourOwner($tour_id),
			'cid' => $cid,
			'org_id' => $tour->org_id,
			'status' => $category->draw_status,
			'tourId' => $tour_id,
			'is_aita' => $category->is_aita,
			'is_paid' => $category->is_paid,
		));
	}

	/**
	 * Displays the draw view of a tour-category (all the 32 or 64 items) in a tree mode (how?)
	 * @param integer $id the ID of the category of the tournament
	 */
	public function actionList($id)
	{
		//$request = Yii::app()->request;
		$cat_id = $id; //$request->getParam('id', 1);
		$model = Participant::model()->findAll(); //category_id = $id	
		
		/* Find category name from the Category.Category_ID - select `name` from lookup where `type`='AgeGroup' and 'id'=?
		 * find tour name from Category.ID - select location from tour where id = (select tour_id from category where id = 1);
		*/
		$category_name = Lookup::item("AgeGroup", $cat_id);
		$tour_id = Category::model()->findByPk($cat_id)->tour_id;
		$tour_name = Tour::model()->findByPk($tour_id)->location;
		
		$dataProvider=new CActiveDataProvider('Participant', array(
			'criteria' => array('condition' => 'category=' . $cat_id,
								'with' => array('player'=>array('alias'=> 'player')),
								'order' => 'seed ASC',
						),
			'pagination' => false,
		));
		$this->render('list',array(
			'dataProvider'=>$dataProvider,
			'category_name'=>$category_name,
			'tour_name'=>$tour_name,
		));
	}

	/**
	 * Generate seed on the basis of the points.
	 */	
	public function actionSeed($cid) {

		
		if(Yii::app()->user->data()->type == YumUser::TYPE_PLAYER){
			throw new CHttpException(404,'Players are not authorized to perform his activity.');
		}
		
		//Get the Category model
		$category = Category::model()->findByPk($cid);
		$tour_id = $category->tour_id;
		$is_paid = $category->is_paid;
		
		$str_condition = $is_paid 
			? 'category=:category AND tour_id=:tour_id AND payment_status = true'
			: 'category=:category AND tour_id=:tour_id';
		
		
		$criteria = array('condition' => $str_condition,
			'params' => array(':category'=>$category->category, ':tour_id' => $tour_id));
		
		
		$dataProvider=new CActiveDataProvider('Participant', array(
			'criteria' => $criteria,
			'sort'=>array('defaultOrder'=>'seed'),
			'pagination' => false,
		));
		
		$arrPoints = array();
		
		// ptr1 and ptr2 are the pointers to traverse the array of seed
		/* This part has been devised so that if the participants are already sorted 
		 * then it should not keep performing expensive operations. 
		 * Skip if all is sorted.
		 */
		$ptr1 = Participant::MAX_POSSIBLE_POINTS;
		$ptr2 = 0;
		$sorted = true;
		
	
		//	Check if the list is already sorted. It will save unnecessary data save if already sorted.
		/*	Transfer the dataProvider data to an array with the participant ID as keys
		 * 	If any participant is not assigned a seed then it is unsorted
		 * 	If 2 consequtive participants' seed-points are not in decreasing order then it is unsorted
		 */
		foreach($dataProvider->getData() as $record){
			
			$arrPoints[$record->id] = $record->seed_points;
			$ptr2 = $record->seed_points;
			
			if($record->seed == Participant::MAX_POSSIBLE_SEED){
				$sorted = false;
			} else {
				if($ptr1 < $ptr2 ){ //The previous player must have higher points, else not sorted.
					$sorted = false;
				}
			}
			$ptr1 = $ptr2;
		}


		if(!$sorted) {
			arsort($arrPoints, SORT_NUMERIC);		//Sort on points - descending
		
			//save all the records
			$index = 0;
			
			$transaction = Yii::app()->getDb()->beginTransaction();
			
			foreach($arrPoints as $id=>$points){
				$participant = Participant::model()->findByPk($id);	//for 64 participants this could be expensive
				$participant->seed = ++$index;
				if(!$participant->save(false, 'seed')){
					$transaction->rollback();
					throw new CHttpException(404,'Seeding could not be completed due to save error. Report to the admin.');
				}
			}			
			
			// Once the seed is generated, the Category status to be set to 'SEEDED'
			if($category->draw_status != Category::STATUS_SEEDED){
				$category->draw_status = Category::STATUS_SEEDED;
				if(	$category->save(false, 'draw_status'))
					if(isset($transaction)){
						$transaction->commit();
					}
				else
					if(isset($transaction)){
						$transaction->rollback();
						throw new CHttpException(404,'Seeding could not be completed due to some error. Report to the admin.');
					}
			} else {
				if(isset($transaction)){
					$transaction->commit();
				}
			}
		} else {
// 			echo "The list is already sorted. Nothing to do";
// 			return;
		}
			
		//call index to show the updated values.
		$this->redirect($this->createUrl('index', array('cid'=>$cid)));

	}
	

	/**
	 * Updates new AITA point for the related Player.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $cid the ID of the model to be updated
	 */
	public function actionUpdatePoints()
	{
	
		$request = Yii::app()->request;
		$participantId = $request->getParam('participant_id', 1);
		$aita_points = $request->getParam('seed_points', 1);
	
		$participant=$this->loadModel($participantId);
		$player = $participant->player;
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		$player->aita_points = $aita_points;
		if($player->save(false, 'aita_points'))
			//echo $aita_points; //$this->actionIndex($cid);
			echo CJSON::encode(array('aita_points'=>$aita_points));
		else
			throw new CHttpException(404,'AITA Points could not be saved.');
	
	}
	
	/**
	 * Updates the seed point for the participant. Could be that the organizer does not believe your club point.
	 * @param integer $cid the ID of the model to be updated
	 */
	public function actionUpdateSeedPoints()
	{
	
		$request = Yii::app()->request;
		$participant_id = $request->getParam('participant_id', 1);
		$seed_points = $request->getParam('seed_points', 1);
	
		$participant = $this->loadModel($participant_id);
	
		$participant->seed_points = $seed_points;
		if($participant->save(false, 'seed_points')){
			//echo $aita_points; //$this->actionIndex($cid);
			
			// Once the seed is generated, the Category status to be set to 'SEEDED'
			$category = Category::model()->findByAttributes(
					array('tour_id' => $participant->tour_id,
						'category' => $participant->category
				));
		
			if($category != null){
				if($category->draw_status != Category::STATUS_SEEDED){
					$category->draw_status = Category::STATUS_SEEDED;
					$category->save(false, 'draw_status');
				}
			}
			echo CJSON::encode(array('seed_points'=>$seed_points));
		} else {
			throw new CHttpException(404,'Seed Points could not be saved.');
		}
	}
	/**
	 * Updates payment status from unpaid to paid.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $cid the ID of the model to be updated
	 */
	public function actionTogglePaymentStatus($participant_id, $mode, $remark)
	{
		//$request = Yii::app()->request;
		//$participant_id = $request->getParam('participant_id');
		$participant = null;
		try{
			$participant = $this->loadModel($participant_id);	//returns 404 if not found
		} catch(Exception $ex){
			echo "error";
			return;
		}
		$category = Category::model()->findByAttributes(array('tour_id'=>$participant->tour_id,
						'category'=>$participant->category));
		if($category != null){
			$transaction = Yii::app()->getDb()->beginTransaction();
			
			$payment = new Payment;
			$payment->player_id = $participant->player_id;
			$payment->participant_id = $participant_id;
			$payment->amount = $category->is_aita 
				? $participant->player->aita_no == null
					? $category->others_fee
					: $category->member_fee
				: Membership::model()->isMember($category->tour->org_id,$participant->player->id)
					? $category->member_fee
					: $category->others_fee;
			
			$payment->direction = $participant->payment_status? -1: 1;
			$payment->mode =  $mode;
			$payment->free_text = $remark;
			$payment->entry_date = Date('Y-m-d h:i:s');
			
			if($payment->save()){
				$participant->payment_status = !$participant->payment_status ;
				//if new status is unpaid, then amount is considered refunded
				if($participant->payment_status){
					$participant->fee_paid = $payment->amount;
				} else {
					$participant->fee_paid = 0;
				}
				$participant->seed = 999;
				if($participant->save(false, 'payment_status, fee_paid')){
// 					echo CJSON::encode(array('payment_status'=>$participant->payment_status,
// 							'fee_paid'=>$participant->fee_paid));
					if($category->draw_status == Category::STATUS_SEEDED){
						$category->draw_status = Category::STATUS_NOT_PREPARED;
						if(!$category->save(false, 'draw_status')){
							echo "Category save failed";
							return false;
						}
					}
					$transaction->commit();
					return true;
				} else {
					echo "participant not saved";
					$transaction->rollback();
					return false;
				}
			} else {
				if(isset($payment->errors)){
					foreach($payment->getErrors() as $error)
						print_r($error);
				}
				echo "payment not saved";
				$transaction->rollback();
				return false;
			}
		} else {
			//echo "no-category";
			return false;
		}
	}
	
	/**
	 * Views the draw in the form of a tree. This tree is created from the existing set of matches for 
	 * this tour and category combination. Matches with levels 1,2,3... are for the main draw, those with
	 * 0,-1,-2, .. are for the qualifying draw.
	 */
	public function actionView($cid, $qual = false)
	{
		if($qual == null) $qual = 0;
		$category = Category::model()->findByPk($cid);
		$tour_id = $category->tour_id;
		
		if($category->draw_status == Category::STATUS_NOT_PREPARED){
			//@todo this should be a popup screen in the calling view.
			$this->renderPartial('success', 
					array('message'=>'The draw is not yet prepared by the organizers. Please visit later.<br/>',
						  'tourId'=>$tour_id, 'isTourOwner'=>$this->isTourOwner),
					false, true);
		} else {
		
			$categoryName = Lookup::item("AgeGroup", $category->category);
			$tour = Tour::model()->findByPk($tour_id);
			$tourLocation = $tour->location;
			$drawSize = $category->mdraw_size;
			$qlRounds = $category->qdraw_levels;
			
			//If there are no qualifying rounds then exit show a message.
			if($qlRounds == 0 && $qual){
				$this->renderPartial('success', array(
						'tourId'=>$tour_id,
						'message'=>'There are no qualifying rounds in this category.'));
				$qual = false; //continue with the main draw
			}
			
			$sqlCond = $qual?" AND level <= 0":"";
			$dataProvider=new CActiveDataProvider('Match', array(
					'criteria' => array('condition' => 'category=:category AND tour_id=:tourId'.$sqlCond,
									'params'=>array(':category'=>$category->category, ':tourId'=>$tour_id) ),
					'pagination' => false,
			));
				
			$this->render('view', array(
					'dataProvider'=>$dataProvider,
					'tourId' => $tour_id,
					'tourLocation'=> $tourLocation,
					'categoryName' => $categoryName,
					'isTourOwner' => Yii::app()->user->isTourOwner($tour_id),
					'cid'=>$cid,
					'drawSize'=>$drawSize,
					'qual'=>$qual,
					'qlRounds'=> $qlRounds,
					'mainEntries' => $category->mdraw_direct,
					'qualLevels' => $category->qdraw_levels,
					'totalEnroled' => $dataProvider->totalItemCount
					
			));
		}
	}

	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Participant('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Participant']))
			$model->attributes=$_GET['Participant'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Participant the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Participant::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Participant $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='participant-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
