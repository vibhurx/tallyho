<?php
/**
 * Use this controller for showing all the past, present and upcoming participation for a player.
 * Player will have a lazy relationship called "participations".
 */

class EnrolController extends Controller
{
	public $layout='//layouts/column2_p';
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array('list', 'view', 'success'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'createFor', 'update', 'delete', 'success', 'ajaxSave', 'ajaxWildcardUpdate',
								'searchPlayer'),
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
	
		$this->render('view',array(
				'model'=>$model,));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * This method is called when a logged in player enrols.
	 * $id : Category ID for which the enrolment has to take place.
	 */
	public function actionCreate($cid, $src=null)
	{
		$category = Category::model()->findByPk($cid);
		
		if($category == null){
			Yii::app()->user->setFlash('error', 'Invalid Category');
			$this->redirect(Yii::app()->request->urlReferrer);
//			This did not work earlier. Replacement code.
// 			if($src == 1)
// 				$this->redirect(array('/category/default/view', 'id'=>$cid));
// 			else
// 				$this->redirect(array('/category/default/index', 'tid'=>$category->tour_id));
		}
		
		if(!Yii::app()->user->isPlayer()){
			Yii::app()->user->setFlash('error', 'You need to be a Player to enrol in a tournament.');
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		
		$genderCode = Yii::app()->user->data()->player->gender;
		
		if($genderCode != ($category->category % 2)) { //Gender mismatch odd=boys(1); even=girls(0)
			Yii::app()->user->setFlash('error', 'Gender Mismatch');
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		
		$participant=new Participant;
	
		if(isset($_POST['Participant'])){
			
			$participant->attributes=$_POST['Participant'];
			try {
				if($participant->save()){
					Yii::app()->user->setFlash('notice', 'Your enrollment has been registered.');
					$this->redirect(Yii::app()->request->urlReferrer);
// 					if($src == 1)
// 						$this->redirect(array('/category/default/view', 'id'=>$cid));
// 					else
// 						$this->redirect(array('/category/default/index', 'tid'=>$category->tour_id));
				}
			} catch(CException $ex) {
				//throw new CHttpException(404,'');
				Yii::app()->user->setFlash('error', 'You have already joined this track.');
				$this->redirect(Yii::app()->request->urlReferrer);
// 				if($src == 1)
// 					$this->redirect(array('/category/default/view', 'id'=>$cid));
// 				else
// 					$this->redirect(array('/category/default/index', 'tid'=>$category->tour_id));
			}
		}
		
		//$model->id = 0; //zero for auto-increment to work at the DB level	
		/*	A contact may select to enrol as a guest user. Once logged in the following statement bombs.
		 * 	Make sure the contact does not reach here.
		 */
		$participant->player_id = Yii::app()->user->data()->player->id;
		$participant->tour_id = $category->tour_id;
		$participant->category = $category->category;			//code for U12Boys, U12Girls etc.
		$participant->seed = Participant::MAX_POSSIBLE_SEED;
		
		if($category->is_aita){
			$participant->seed_points = $participant->player->aita_points;
		} else {
				
			/*	If the category is non-AITA, then the seeding is based on the points earned
			 * 	within the organization. If the player is a member of the organization, then update
			 *  the seed_points, else set it to 0.
			 */
			// 				$membership = Membership::model()->findByAttributes(array(
			// 						'org_id' => $category->tour->org_id,
			// 						'player_id' => $participant->player->id,
			// 				));
		
			// 				if($membership == null){	//the player is not a member
			$participant->seed_points = 0;
			// 				} else {
			// 					$participant->seed_points = $membership->points;
			// 				}
			
		}
		
		$tour = Tour::model()->findByPk($participant->tour_id);
		
		$this->render('create', array(
			'participant'=>$participant,
			'tour'=>$tour,
			'genderCode'=>$genderCode
		));

	}

	/**
	 * Creates a new participation by a contact.
	 * It is called from a fancy-box
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * This method is invoked when a contact enrols any player. We need to ensure that the contact is able to select
	 * or create a new (unregistered) player.
	 * $id : Category ID for which the enrolment has to take place
	 */
	public function actionCreateFor($cid)
	{
		if(isset($_POST['Participant'])){
			$this->save(false);	//If called as a web-service: boolean
//			$this->redirect('//participant/draw/index/cid/' . $cid);
		}
		/* Find category name from the Category.Category_ID - select `name` from lookup where `type`='AgeGroup' and 'id'=?
		 * find tour name from Category.ID - select location from tour where id = (select tour_id from category where id = 1);
		*/
		$category = Category::model()->findByPk($cid);
		$categoryCategory = $category->category;		//code for U12Boys, U12Girls etc.
		$tourId = $category->tour_id;
			
		$participant=new Participant;
	
		$categoryName = Lookup::item("AgeGroup", $categoryCategory);
		$tour = Tour::model()->findByPk($tourId);
		$tourName = $tour->location;
		
		$participant->tour_id = $category->tour_id;
		$participant->category = $category->category;	//code for U12Boys, U12Girls etc.
		
		$this->render('createFor', array(
				'categoryGender'=>($category->category + 1) % 2 + 1,	//boys will be 1; girls 2
				'participant'=>$participant,
				'is_popped_up' => true, // redundant, may be
				'categoryId' => $cid,
		));
	}
	
/*
 * 
 */	
	public function actionSearchPlayer(){
		if(isset($_POST['term'])){
			$term = $_POST['term'];
			
			if(strlen($term)<2)
				return;
			
			if(isset($_POST['gen'])){
				$gen = $_POST['gen'];
						
				if($gen < 1 || $gen > 2)
					return;
					
				$sql = "SELECT id, 	given_name, family_name FROM `player`
					WHERE (given_name LIKE '" . $term . "%' OR family_name LIKE '" . $term . "%') AND gender = " . $gen;	//	Both qual as well as main
			
			} else {
				$sql = "SELECT id, 	given_name, family_name FROM `player` 
					WHERE given_name LIKE '$term%' OR family_name LIKE '$term%'" ;
			
			}
			
			$command = Yii::app()->db->createCommand($sql);
			$players = $command->queryAll();
			
			echo json_encode($players);
		}
	}
	/*
	 * Save a model and returns its ID
	 */
	public function actionAjaxSave(){
		$this->save(true);	//web-service flag is true.
	}
	
	/*	----------------------------------------------------------------------------------------------------------
	 * 
	 *	---------------------------------------------------------------------------------------------------------- */
	private function save($is_webservice){
		$participant = new Participant;
	
		if(isset($_POST['Participant'])){
			$participant->attributes=$_POST['Participant'];
			try {
				if($participant->save()){
					//Make the corresponding category 'dirty' <<< @todo can we move this logic to DB?
					$category = Category::model()->findByAttributes(array('category'=>  $participant->category,
							'tour_id'=> $participant->tour_id ));
					if($category == null){
						throw new CHttpException(404,'Category data is inconsistent. Please report to the admin.');
						
					} else {
						if($category->draw_status != Category::STATUS_NOT_PREPARED){
							$category->draw_status = Category::STATUS_NOT_PREPARED;
							$category->save(false, 'draw_status');
						}
					}
					if($is_webservice){
// 						echo '{ "id": ' . $participant->id . ', "given_name": "' . $participant->player->given_name .
// 							'", "family_name": "' . $participant->player->family_name . '", "aita_no": "' . $participant->player->aita_no .
// 							'", "aita_points": ' . $participant->player->aita_points . '}';
						echo CJSON::encode(array("id" => $participant->id, "given_name"=> $participant->player->given_name,
							"family_name"=> $participant->player->family_name, "aita_no"=> $participant->player->aita_no,
							"aita_points"=> $participant->player->aita_points));
					} else {
						$this->redirect(array('/participant/draw/index', 'cid' => $category->id));
//						$this->redirect(Yii::app()->request->urlReferrer); //<< this makes the view reload
					}
				} else {
					if($is_webservice){
						//@todo: flash the error instead of directing.
						echo CJSON::encode(array('success'=>'false', 'error'=>'Error code 45500: Save failed.'));
						//throw new CHttpException(404,'The enrollment could not be saved. Try again.');
					} else { //now this part is not used because enrolfor is removed from the category list- 20-03-2015
						$this->redirect(Yii::app()->request->urlReferrer); 
					}
				}
			} catch(CException $ex) {
				if($is_webservice){
					echo CJSON::encode(array('success'=>'false', 'error'=>'Error code 45501: Save failed.'));
				} else {
					throw new CHttpException(404,'The player is already enrolled in this category.');
					//@todo: Show a message and continue showing the same form
				}
			}
		}
	}
	/*
	 * 
	 */
	public function actionAjaxWildcardUpdate(){
		$id = $_POST['id'];
		$newval = $_POST['newval'];
		
		$model = Participant::model()->findByPk($id);
		if($model == null){
			echo 'Model object is null';
			//throw new CHttpException(1111, "Wildcard for this player could not be set. Contact admin.");
			return;
		}
		
		$count = Participant::model()->countByAttributes(array(
            'tour_id'=> $model->tour_id,
			'category'=>$model->category,
			'wild_card'=> 1
        ));
		
		if($newval == 1 && $count >= Category::MAX_WILD_CARD){
			//throw new CHttpException(1110, "Cannot have more than " . Category::MAX_WILD_CARD . " wildcards.");
			echo 'Wildcard entries maxxed out. Remove a wild card before updating.';
			return;
		}
		
		
		$model->wild_card = $newval;
		if($model->save(false, array('wild_card')))
			echo "OK";
		else
			echo "Not OK";
				//throw new CHttpException(1111, "Wildcard for this player could not be set. Contact admin.");
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Participant']))
		{
			$model->attributes=$_POST['Participant'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * List a particular model.
	 */
	public function actionIndex($tid, $category)
	{
		//$request = Yii::app()->request;
		//$cat_id = $id; //$request->getParam('id', 1);
		//$model = Participant::model()->findAll(); //category_id = $id
		$criteria  = array('condition' => 'tour_id=' . $tid . ' AND category=' . $category);
		$dataProvider=new CActiveDataProvider('Participant', array('criteria' => $criteria));
		
		/* Find category name from the Category.Category_ID - select `name` from lookup where `type`='AgeGroup' and 'id'=?
		 * find tour name from Category.ID - select location from tour where id = (select tour_id from category where id = 1);
		*/
		$category_name = Lookup::item("AgeGroup", $category);
		$tour_name = Tour::model()->findByPk($tid)->location;
	
// 		$dataProvider=new CActiveDataProvider('Participant', array(
// 				'criteria' => array('condition' => 'category=' . $category,
// 						'with' => array('player'=>array('alias'=> 'player')),
// 						'order' => 'seed ASC',
// 				),
// 				'pagination' => false,
// 		));
		
		$this->render('list',array(
				'dataProvider'=>$dataProvider,
				'category_name'=>$category_name,
				'tour_name'=>$tour_name,
		));
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$participant = $this->loadModel($id);
		$category_code = $participant->category;
		$tour_id = $participant->tour_id;
		
		$participant->delete();

		$category = Category::model()->findByAttributes(array('tour_id'=>$tour_id, 'category'=>$category_code));
		
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('//participant/draw/index', 'cid'=>$category->id));
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
