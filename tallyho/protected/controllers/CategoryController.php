<?php
/*
 * This controller manages categories as an entity like creating, and deleting categories for a tournament.
 * There is no update action for the categories because categories do not have properties that undergo changes frequently.
 * Deleting a category must require its matches and enrolments to be deleted at the database. 
 * @todo implementation is going on to handle deep-recursive deletion at the database level.
 * 
 * Categories are also managed through its status - published or not, draw prepared or not. Those status will be managed by
 * the controllers - DrawController and EnrolController.
 */
class CategoryController extends Controller
{
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
				'actions'=>array('view', 'index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','delete','update'),
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

	public function actionIndex($eid) //, $action='def', $id=NULL)
	{
		// if($action == 'enr' && $id !== NULL){
		// 	$this->actionEnrol($id);
		// }
		
		$event = Event::model()->findByPk($eid);
		
		if($event == null){
			throw new CHttpException(404,'The requested event does not exist.');
		}
		
		$dataProvider=new CActiveDataProvider('Category', array(
				'criteria'=>array(
						'with'=>array('event'),
						'condition'=>'event.id=:id',
						'params'=>array(':id'=>$eid),
				),
		));
		
		$userType = Yii::app()->user->isGuest? -1 : 1;// Yii::app()->user->data()->type;
	
		$this->render('index', array(
				'dataProvider' => $dataProvider,
				//'isEventManager' => Yii::app()->user->isEventManager($eid),
				'event'=>$event,
				'userType' => $userType,
		));
		
		Yii::app()->user->setReturnUrl(array("//category/index", "eid" => $eid)) ;
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * This action leads to a popup view.
	 */
	public function actionCreate($tid)
	{
		$model = new Category;
		$model->event_id = $tid;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category'])) {
			$model->attributes=$_POST['Category'];
			
			$event = $model->event;	// via relationship
			
			//Convert date formats
			if($model->start_date != null){
				$model->start_date = date_format(
					date_create_from_format(
							'd/m/Y H:i', $model->start_date), 'Y-m-d H:i:s');
			}
			
			if($model->start_date >= $event->start_date || $model->start_date == 0){
				if(!$model->save()){
					$this->render('error', array(
							'err_code' => 'CAT001',
							'err_message' => 'Save validation error. Check all the input values again!',
							'err_source' => $this->createUrl('/event/default/view/id/' . $event->id ),
					));
					return;
				} else {
					$this->redirect($this->createUrl('//category/default/index', array('tid'=>$tid)));
				}
			} else {
				$this->render('error', array(
					'err_code' => 'CAT000',
					'err_message' => 'Category start date (' . 
									 date_format(date_create($model->start_date), 'd M Y') . 
									 ') cannot be earlier than the event date (' .
									 date_format(date_create($event->start_date), 'd M Y') . 
									 ').',
					'err_source' => $this->createUrl('/event/default/view/id/' . $event->id ),
				));
				return;
			}
			$this->redirect(Yii::app()->request->urlReferrer);	//@todo: include an error message
		} else {
			$model->is_paid = $model->event->type == Event::TYPE_ALL_PAID;
			$model->is_aita = $model->event->is_aita;	//default the value with the event is_aita value
			
			$sql = 'SELECT code, name FROM lookup WHERE type = "AgeGroup" AND 
					code NOT IN (SELECT category FROM category WHERE event_id = '. $tid. ')';
			$command = Yii::app()->db->createCommand($sql);
			$records = $command->queryAll();
			
			$validCategories = array();
			$validCategories['AgeGroup'] = array();
			
			foreach($records as $row)
				$validCategories['AgeGroup'][$row['code']]=$row['name'];
			
			//$validCategories = Lookup::items('AgeGroup');
			$this->render('create',array(
				'model'=>$model,
				'validCategories'=>$validCategories,
				'tourId'=>$tid,
			));
		}
	}

	private function actionEnrol($id){
		$model = $this->loadModel($id);
				
		//Check if the user is a player or an organizer
		if(!Yii::app()->user->isPlayer()){
			Yii::app()->user->setFlash('error', 'You need to sign-in as a player to join this track.');
			$this->redirect(Yii::app()->request->urlReferrer);

		}
		
		//Check if there is a gender mismatch
		$genderCode = Yii::app()->user->data()->player->gender;
			
		if($genderCode !== ($model->category % 2)) { //Gender mismatch
			Yii::app()->user->setFlash('enrol', 'This track is not for players of your gender.');
			//$this->actionIndex($model->event_id);
			return;
		}
		
		//Check if the current player is already enrolled
		
		$count = Enrolment::model()->countByAttributes(array(
				'event_id'=>$model->event_id,
				'category'=>$model->category,
		));
		
		if($count > 0){
			Yii::app()->user->setFlash('enrolError',
					'You have already joined this track.');
			//$this->actionIndex($model->event_id);
			return;
		}
		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if($this->loadModel($id)->delete()){
		
			//@todo: The corresponding children and grandchildren should be deleted
			// enrolments based on event_id and category code
			// matches based on event_id and category code
			// Important - this is a data-model logic. Should it not go into the model?
			// update: deletion of enrolments with the category is done
		}
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $this->redirect(Yii::app()->request->urlReferrer)); //array('admin'));
	}


	public function actionView($id)
	{
		
		$category = $this->loadModel($id);
		
		$isEventManager = Yii::app()->user->isEventManager($category->event_id);
		
		$this->render('view',array(
				'model' => $category,
				'isEventManager' => $isEventManager,
		));
	}
	
	public function actionUpdate($id)
	{
		$category = $this->loadModel($id);
		if(isset($_POST['Category'])) {
			$category->attributes=$_POST['Category'];
			if($category->start_date != null){
				$category->start_date = date_format(
					date_create_from_format(
							'd/m/Y H:i', $category->start_date), 'Y-m-d H:i:s');
			}
			if($category->save())
				$this->redirect(array('view','id'=>$category->id));
			
		}
		if($category->start_date != null)
			$category->start_date = date_format(date_create_from_format('Y-m-d H:i:s', $category->start_date), 'd/m/Y H:i');
		$this->render('update',array(
				'model' => $category
		));
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
}