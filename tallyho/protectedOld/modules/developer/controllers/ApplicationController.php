<?php

class ApplicationController extends Controller
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
				'actions'=>array('create','update','delete'),
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
	public function actionCreate($did)
	{
		$model=new Application;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		if(isset($_POST['Application']))
		{
			$model->attributes=$_POST['Application'];

			$model->start_date = date_format(date_create_from_format('d/m/Y', $model->start_date), 'Y-m-d');
			$model->end_date = ($model->type == 3)
				?  date_format(date_create_from_format('d/m/Y', $model->end_date),'Y-m-d')
				: ($model->type == 1)
					? date("Y-m-d", strtotime("30 day"))
					: "9999-12-31";

			if($model->save())
				$this->redirect(array('/developer'));
		}

		$developer = Developer::model()->findByPk($did);
		
		if($developer != null){
			$model->developer_id = $developer->id;
			$model->id = str_ireplace("{", "", 
							str_ireplace("}", "", 
								str_ireplace("-", "", com_create_guid())));
			$model->secret_key = str_ireplace("{", "", 
									str_ireplace("}", "", 
										str_ireplace("-", "", com_create_guid())));
			$model->start_date = date_format(date_create(), 'd/m/Y');
			$model->end_date =  date("d/m/Y", strtotime("30 day"));
			$model->active_flag = true;
			
			$this->render('create',array(
					'model'=>$model,
			));
		} else {
			//redirect
			$this->redirect(array('/developer'));
		}
		
		
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

		if(isset($_POST['Application']))
		{
			$model->attributes=$_POST['Application'];

			$model->start_date = date_format(date_create_from_format('d/m/Y', $model->start_date), 'Y-m-d');
			$model->end_date = ($model->type == 3)
				?  date_format(date_create_from_format('d/m/Y', $model->end_date), 'Y-m-d')
				: ($model->type == 1)
					? date("Y-m-d", strtotime("30 day"))
					: "9999-12-31";
					
			if($model->save())
				$this->redirect(array('/developer'));
		}

		$model->start_date = date_format(date_create($model->start_date), 'd/m/Y');
		$model->end_date   = date_format(date_create($model->end_date), 'd/m/Y');
		
		$this->render('update',array(
			'model'=>$model,
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
		$this->redirect(array('/developer'));

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
// 		if(!isset($_GET['ajax']))
// 			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Application');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Application('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Application']))
			$model->attributes=$_GET['Application'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Application the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Application::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Application $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='application-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
