<?php

class OrganizerController extends Controller
{
	
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
				'actions'=>array('index','view','logoFilename'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin', 'staff'),
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
		if(isset($_POST['Organizer']))
			$this->uploadLogo($id);
		
		$model = $this->loadModel($id);
		
		//	For displaying tournaments
//  		$criteria  = array('condition' => 'org_id=' . $model->id);
//  		$tourProvider=new CActiveDataProvider('Event', array('criteria' => $criteria));
		//	End of tournament display part
		$staffProvider = new CActiveDataProvider('Staff', 
				array('criteria' => array('condition' => 'org_id='.$model->id),
				));
		
		$this->render('view',array(
				'model'=>$model,
				'staffProvider'=>  $staffProvider,//new CArrayDataProvider($model->staff),
// 				'tourProvider' => $tourProvider,
				'isOrgAdmin' => Yii::app()->user->isGuest || $model->admin_id == Yii::app()->user->data()->id,
		));
	
		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Organizer;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Organizer']))
		{
			$model->attributes=$_POST['Organizer'];
			$model->admin_id = Yii::app()->user->data()->id;	//Changed from contact ID to user ID
			try {
				if($model->save()){
					$role = YumRole::model()->findByAttributes(array('title'=>'staff'));
					
					// Add the staff role to the user - table `user_role`
// 					echo $model->admin_id;
// 					echo '<br>';
// 					echo $role->id ;
// 					echo '<br>';
// 					echo Yum::module('role')->userRoleTable;
// 					return;
					
					Yii::app()->db->createCommand(sprintf(
							'insert into %s (user_id, role_id) values(%s, %s)',
							Yum::module('role')->userRoleTable,
							$model->admin_id,
							$role->id))->execute();
					
					// Add the user to the staff list - table `org_user`
					Yii::app()->db->createCommand(sprintf(
							'insert into %s (user_id, org_id) values(%s, %s)',
							'org_user',
							$model->admin_id,
							$model->id))->execute();
					
					$this->redirect(array('view', 'id'=>$model->id));
				}
			} catch(Exception $ex) { 
				throw new CHttpException(404,'Creation of organizer failed. Try again.');
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
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

		if(isset($_POST['Organizer']))
		{
			$model->attributes=$_POST['Organizer'];
							
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Staff list 
	 */
	public function actionStaff($id) {
		$model = $this->loadModel($id);
		$dataProvider =  new CArrayDataProvider('YumUser');
		$dataProvider->setData($model->staff);
		$this->render('staff', array(
			'dataProvider'=>$dataProvider,
			'model' => $model,
		));
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Organizer');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	private function uploadLogo($id){
		$model = $this->loadModel($id);
		$model->attributes = $_POST['Organizer'];
		$image = CUploadedFile::getInstance($model, 'logo_file');
		$model->logo = $image->name;
		if($model->save()){
			$structure = Yii::app()->basePath . '/../images/olog/' . $model->id . '/';
			if (!file_exists($structure)){
				if (!mkdir($structure, 0777, true))
					$image->saveAs($structure . $image->name);
			} else
				$image->saveAs($structure . $image->name);
			
		}else{
			throw new CHttpException(403,'The logo, ' . $model->logo . ', could not be uploaded.');
		}
	}
	
	/**
	 * Returns logo file-name
	 * @param unknown $id
	 */
	public function actionLogoFilename($id){
		$model = $this->loadModel($id);
		echo  CJSON::encode(array('logo'=>$model->logo));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Organizer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Organizer']))
			$model->attributes=$_GET['Organizer'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Organizer the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Organizer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Organizer $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='organizer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
