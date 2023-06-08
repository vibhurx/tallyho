<?php

/*
 * 
 * asdfasdf
 */

class MembershipController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
		),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'selectPlayer', 'delete'),
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($org_id)
	{
		$model=new Membership;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Membership']))
		{
			$model->attributes=$_POST['Membership'];
			if($model->since != null)
				$model->since = date_format(date_create_from_format( 'd/m/Y', $model->since), 'Y-m-d');
			$model->org_id = $org_id;
			if($model->save())
			$this->redirect(array('view','id'=>$model->id));
		}

		$model->org_id = $org_id;
		
		$this->render('create',array(
			'model'=>$model,
			'player_name' => null,
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

		if(isset($_POST['Membership']))
		{
			$model->attributes=$_POST['Membership'];
			if($model->since != null)
				$model->since = date_format(date_create_from_format('d/m/Y', $model->since), 'Y-m-d');
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$player_name = $model->player->fullName;
		$model->since = date_format(date_create($model->since), 'd/m/Y');
		$this->render('update',array(
			'model'=>$model,
			'player_name' => $player_name,
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
	public function actionIndex($id)
	{
		//$dataProvider=new CActiveDataProvider('Membership');

		$dataProvider=new CActiveDataProvider('Membership', array(
			'criteria' => array('condition' => 'org_id=:oid', 'params'=> array(':oid' => $id),)));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'org_id'=>$id));

	}

	public function actionSelectPlayer(){
		$this->renderPartial('createFor', array(
				)
		);
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Membership('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Membership']))
		$model->attributes=$_GET['Membership'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Membership the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Membership::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Membership $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='membership-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
//Testing comment