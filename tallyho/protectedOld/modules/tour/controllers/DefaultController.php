<?php

class DefaultController extends Controller
{	
	public function filters()
    {
        return array(
            'accessControl',
        );
    }
    
    public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'view', 'public', 'wsIndex', 'wsView'),
				'users'=>array('*'),
			),
			array('allow',  // allow only the logged in users to perform 'index'
				'actions'=>array('restrictedView', 'create', 'update', 'unpublish', 'publish',
						  'statusUpdate', 'deleteCategory'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
	);}
	

	public function actionIndex()
	{
		$criteria  = array('condition' => 'status!=' . Tour::STATUS_DRAFT . ' AND status!=' . Tour::STATUS_OVER);
		$dataProvider=new CActiveDataProvider('Tour', array('criteria' => $criteria));
		
		$this->render('index',array(
				'dataProvider' => $dataProvider,
		));
	}
	
	public function actionWsIndex()
	{	
		$criteria  = array('condition' => 'status!=' . Tour::STATUS_DRAFT . ' AND status!=' . Tour::STATUS_OVER);
		$dataProvider=new CActiveDataProvider('Tour', array('criteria' => $criteria));
	
		$modelAttributeNames = 'id, location, level, start_date, status';
		echo Yii::app()->common->renderJson($dataProvider->getData(), $modelAttributeNames );
	}
	
	/**
	 * Displays a particular model.
	 * This view is for the owner role.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id, $cid=NULL)
	{	
		$tour_id = $this->viewCommon($id, $cid);
		
		/*	In case the logged in user is a guest, after logging in the return url is set here	*/
		Yii::app()->user->setReturnUrl(array("//tour/default/view", "id" => $tour_id)) ;
		
	}
	
	/**
	 * View2 is just like view however, it always opens with a popup.
	 * Scenario is - player is not logged in but opts to enrol. The page redirects to login, then returns to view2.
	 * View2 loads with the popup.
	 * The reason for a separate method is that both the functions have different authorization levels.
	 */
	public function actionRestrictedView($id, $cid)
	{
		$this->viewCommon($id, $cid);
	}
	
	private function viewCommon($id, $cid=NULL){
		$tour = $this->loadModel($id);
		$tour->start_date = date_format(date_create($tour->start_date), 'd M Y');
		$tour->enrolby_date = date_format(date_create($tour->enrolby_date), 'd M Y');
		
		$dataProvider=new CActiveDataProvider('Category', array(
				'criteria'=>array(
						'with'=>array('tour'),
						'condition'=>'tour.id=:id',
						'params'=>array(':id'=>$id),
				),
		));
		
		if(Yii::app()->user->hasRole('contact')){
			$tour = Tour::model()->findByPk($id);
			
			if($tour == null)
				$isTourOwner = false;
			else
				$isTourOwner = Yii::app()->user->data()->contact->org_id == $tour->org_id;
		} else
			$isTourOwner = false;
		
		$datetime1 = date_create($tour->start_date);
		$datetime2 = date_create('now');
		

		if($tour->status < Tour::STATUS_ONGOING && $datetime1 < $datetime2)
			$overdueMessage = " (Overdue)";
		else
			$overdueMessage = "";
		
		//$view_name = $cid == null ? 'view' : 'view';
		$this->render('view',array(
				'model'=>$tour,
				'tourId'=>$id,
				'isTourOwner'=> $isTourOwner,
				'overdueMessage' => $overdueMessage,
				'categoryId' => $cid,
		));
		
		return $id;
	}
	
	
	public function actionWsView($id)
	{
		$tour = $this->loadModel($id);
		$dataProvider=new CActiveDataProvider('Category', array(
				'criteria'=>array(
						'with'=>array('tour'),
						'condition'=>'tour.id=:id',
						'params'=>array(':id'=>$id),
				),
		));
		$modelAttributeNames = 'id, tour_id, category, draw_status';
		echo Yii::app()->common->renderJson($dataProvider->getData(), $modelAttributeNames );
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() 
	{
		if( Yii::app()->user->isContact()){
			$model=new Tour;
			
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);
			if(isset($_POST['Tour'])){
				$model->attributes = $_POST['Tour'];
				
				if($model->start_date != null)
					$model->start_date = date_format(
							date_create_from_format(
									'd/m/Y', $model->start_date), 'Y-m-d');
				if($model->enrolby_date != null)
					$model->enrolby_date = date_format(
						date_create_from_format(
								'd/m/Y', $model->enrolby_date), 'Y-m-d');
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}

			$model->org_id = Yii::app()->user->data()->contact->org_id;
			$model->status = Tour::STATUS_DRAFT;
			$this->render('create',array(
					'model'=>$model,
			));
		} else {
			throw new CHttpException(404,'Insufficient authorization to perform this action.');
		}
	}
	
	/**
	 * Open an existing model in edit mode.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate($id)
	{
		$model= $this->loadModel($id);
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if(isset($_POST['Tour']))
		{
			$old_type = $model->type;
			
			$model->attributes=$_POST['Tour'];
			if($model->start_date != null)
					$model->start_date = date_format(
							date_create_from_format(
									'd/m/Y', $model->start_date), 'Y-m-d');
			if($model->enrolby_date != null)
				$model->enrolby_date = date_format(
					date_create_from_format(
							'd/m/Y', $model->enrolby_date), 'Y-m-d');

			/*	Business rule: If payment type change for the tour then its category must align	*/
			if($old_type != $model->type){
				switch($model->type){
					case Tour::TYPE_ALL_PAID:
						foreach($model->categories as $category){
							if($category->is_paid == false){
								$category->is_paid = true;
								$category->save(false, 'is_paid');
							}
						}
						break;
					case Tour::TYPE_ALL_FREE:
						foreach($model->categories as $category){
							if($category->is_paid == true){
								$category->is_paid = false;
								$category->save(false, 'is_paid');
							}
						}
						break;
					case Tour::TYPE_SOME_FREE:
						//do nothing
						break;
								
					default:
				}
			}
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
	
		//Changing date format for display from yyyy-mm-dd to dd/mm/yyyy
		$model->start_date = date_format(date_create($model->start_date), 'd/m/Y');
		$model->enrolby_date = date_format(date_create($model->enrolby_date), 'd/m/Y');
		$this->render('update',array(
				'model'=>$model,
		));
	}
	
	public function actionUnpublish($id){
		/* this function does not delete the tournament but makes it hidden from public by changing it status */
		$model = $this->loadModel($id);
		$model->status = Tour::STATUS_DRAFT;
		if($model->save('status')){
			$this->actionView($id);
		}
	}
	
	public function actionPublish($id){
		/* this function makes the tournament published to the public view by changing it status */
		$model = $this->loadModel($id);
		$model->status = $model->status + 1;
		if($model->save('status'))
			$this->actionView($id);
	}
	
	public function actionStatusUpdate($id){
		$model = $this->loadModel($id);
		if($model->status != Tour::STATUS_OVER)
		$model->status++;
		if($model->save('status')){
			$this->actionView($id);
		} else {
			foreach($model->errors as $error)
				print_r($error);// . "<br>";
		}
	}
	

	public function actionDeleteCategory($cid){
		$model = Category::model()->findById($cid);
		if($model != null){
			$model->delete();
		}
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tour the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tour::model()->findByPk($id);
		if($model===null){
			throw new CHttpException(404,'The requested event does not exist. Do not mess with the URL');
		}
		return $model;
	}
	
	
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}