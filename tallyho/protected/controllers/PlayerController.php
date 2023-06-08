<?php

class PlayerController extends Controller
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
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array( 'index', 'admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all models. Admin access only
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Player');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id=null)
	{
		if(isset($id))
			$model=$this->loadModel($id);
		else {
			$model = Yii::app()->user->data()->player;
			if($model == null)
				throw new CHttpException(501,'The selected player profile does not exist.');
		}
		
		if(isset($_POST['Player']))
			$this->redirect(array('/player/api/uploadPicture', 'id'=>$id));
		//	$this->uploadPicture($id);
		
		$this->render('view',array(
				'model'=>$model,));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionAddNew($id)
	{
		$model = new Player;
//		$model->id = $this-> encode($id; //primary key
		$model->player_id = 0; //email ID
		
		if(isset($_POST['Player']))	{
			$this->redirect(array('view','id'=>$model->id));
		}
		
		$this->render('create',array(
				'model'=>$model,));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * THIS IS NOT WORKING
	 * The only time it is called is from "Enrol-A-Player/Player Not There". How about referring back.
	 */
	public function actionCreate()
	{
		$model=new Player;
		// Ajax Validation enabled
		//$this->performAjaxValidation($model);
		// Flag to know if we will render the form or add a new player.
		//$flag=true;
		//Disable email field if a player is self-registering
		
		if(isset($_POST['Player']))	{
			$model->attributes=$_POST['Player'];
			$model->user_id = Yii::app()->user->data()->id;
			if($model->date_of_birth != null)
				$model->date_of_birth = date_format(
					date_create_from_format(
							'd/m/Y', $model->date_of_birth), 'Y-m-d');
			if($model->save()) {
				$role = YumRole::model()->findByAttributes(array('title'=>'player'));
				Yii::app()->db->createCommand(sprintf(
						'insert into %s (user_id, role_id) values(%s, %s)',
						Yum::module('role')->userRoleTable,
						$model->id,
						$role->id))->execute();
				$this->redirect($this->createUrl('/'), array('model'=>$model));
			}
		}
	
		$this->render('create',array(
			'model'=>$model,
// 			'isEmailDisabled' => $isEmailDisabled,
// 			'categoryId'=> $cid,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreateUnregistered()
	{
		$model=new Player;
		// Ajax Validation enabled
		//$this->performAjaxValidation($model);
		// Flag to know if we will render the form or add a new player.
		
		if(isset($_POST['Player']))	{
			$model->attributes=$_POST['Player'];
			if($model->date_of_birth != null)
				$model->date_of_birth = date_format(
					date_create_from_format(
							'd/m/Y', $model->date_of_birth), 'Y-m-d');
			if($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
			}
		}
	
		$isEmailDisabled = false;
		$model->player_id = 1;
		
		$this->renderPartial('create',array(
				'model'=>$model,
				'isEmailDisabled' => $isEmailDisabled,
			),false,true);
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id=null)
	{
		if(isset($id))
			$model=$this->loadModel($id);
		else {
			$model = Yii::app()->user->data()->player;
			if($model == null)
				$model = new Player;	//First time creation
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Player']))
		{
			$model->attributes=$_POST['Player'];
			if($model->date_of_birth != null)
				$model->date_of_birth = date_format(
					date_create_from_format('d/m/Y', $model->date_of_birth), 'Y-m-d');
			if($model->save()){
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		
// 		$isEmailDisabled = false;
		
		$model->date_of_birth = date_format(date_create($model->date_of_birth), 'd/m/Y');
		$this->render('update',array(
			'model'=>$model,
// 			'isEmailDisabled' => $isEmailDisabled,
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
	 * Upload profile pictures
	 */
	private function uploadPicture($id){
		$model = $this->loadModel($id);
		$model->attributes = $_POST['Player'];
		$image = CUploadedFile::getInstance($model, 'picture_file');
		$model->picture = $image->name;
			
		if($model->save(false, array('picture'))){
			$structure = Yii::app()->basePath . '/../images/ppic/' . $model->id . '/';
			if (!file_exists($structure)){
				if (!mkdir($structure, 0777, true))
					$image->saveAs($structure . $image->name);
			} else
				$image->saveAs($structure . $image->name);
		} else {
			throw new CHttpException(403,'The profile picture, ' . $model->picture . ', could not be uploaded.');
		}
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Player('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Player']))
			$model->attributes=$_GET['Player'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Player the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Player::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Player $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='player-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
