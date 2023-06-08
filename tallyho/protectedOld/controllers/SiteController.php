<?php

class SiteController extends Controller
{
	public $layout='//layouts/zapi';
	
// 	public function filters()
// 	{
// 		return array(
// 				'accessControl', // perform access control for CRUD operations
// 				'postOnly + delete', // we only allow deletion via POST request
// 		);
// 	}
	
//Not working !!!!!
// 	public function accessRules()
// 	{
// 		return array(
// 				array('allow', 
// 						'actions'=>array('index', 'contact', 'error', 'login'),
// 						'users'=>array('*'),
// 				),
// 				array('allow',  // allow only the logged in users to perform 
// 						'actions'=>array('logout', 'admin', 'cleanData'),
// 						'users'=>array('@'),
// 				),
// 				array('allow', // allow admin user to perform 'admin' and 'delete' actions
// 						'actions'=>array('admin'),
// 						'users'=>array('admin'),
// 				),
// 				array('deny',  // deny all users
// 						'users'=>array('*'),
// 				),
// 		);
// 	}
	
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// Check if DB connectivity is there. If not show a plain page.
		try {
			$db = Yii::app()->getDb();
		} catch (Exception $ex){
			$this->redirect(array('site/page/view/dbdown'));
			return;
		}
		
		/*	When someone goes home, the initial return-url should be reset	*/
		Yii::app()->user->setReturnUrl(null) ;
		
		/*
		 * For the case where an organizer contact has logged with no organization being created.
		 * Typically for the first time registered contact.
		 */
		if(Yii::app()->user->data()->type == YumUser::TYPE_CONTACT)
			if(!isset(Yii::app()->user->data()->contact->organization))
				$this->redirect(array('/organization/default/create'));

		CController::forward("tour/default/public");
	}
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionAdmin()
	{
		/*
		 * When an admin selects to perform administrative tasks
		 */
		$message = 'Welcome to the Admin Console';
		$this->render('admin', array('message'=>$message));
	}
	
	/*
	 * The standard test cases are grouped under TestDataAsha. This contains 1 organization, 2 
	 * contacts, 2 players, 1 tournament, 2 categories, 32 players, 64 matches etc. Some of the
	 * models are set as cascade delete and they are automatically taken care of. Rest will be
	 * deleted in this controller.
	 */
	public function actionCleanTestData()
	{
		
		Yii::app()->db->createCommand('DELETE FROM  `payment`')->execute();
		Yii::app()->db->createCommand('DELETE FROM  `set`')->execute();
		Yii::app()->db->createCommand('DELETE FROM  `match`')->execute();
		Yii::app()->db->createCommand('DELETE FROM  `participant`')->execute();
		Yii::app()->db->createCommand('DELETE FROM  `membership`')->execute();
		Yii::app()->db->createCommand('DELETE FROM  `player`')->execute();
		Yii::app()->db->createCommand('DELETE FROM  `contact`')->execute();
		Yii::app()->db->createCommand('DELETE FROM  `category`')->execute();
		Yii::app()->db->createCommand('DELETE FROM  `tour`')->execute();
		Yii::app()->db->createCommand('DELETE FROM  `organization`')->execute();
		Yii::app()->db->createCommand('DELETE FROM `user` WHERE username <> "admin"')->execute();
		
		//Remove logos and profile pictures
		
		$this->render('admin', array('message'=>'Test data has been cleaned.'));
	}
	
	public function actionAddPlayers()
	{
		$count = Player::model()->countBySql('SELECT id FROM player WHERE id >= :start_id', array(':start_id'=>'4000'));
		if($count == '0'){
			$batch_sql = file_get_contents(Yii::app()->basePath . '/../data-model/unregistered-players.sql');
			Yii::app()->db->getPdoInstance()->exec($batch_sql);
			$this->render('admin', array('message'=>'Test players have been created.'));
		} else {
			$this->render('admin', array('message'=>'Test players already exist. Creation skipped.'));
		}
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error = Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionPopup()
	{
		$this->renderPartial('popup', array('model'=>'dummy'), false, true);
	}
	public function actionRegister()
	{
		$userType = $_POST['userType'];
		$this->redirect(array('registration/registration', 'userType'=>$userType,));
	}
	
	public function actionReader($page){
		$this->renderPartial('pages/' . $page);
	}
}