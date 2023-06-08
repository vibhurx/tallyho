<?php

class DefaultController extends Controller
{	
	public $layout='//layouts/column1';
	
	public function accessRules()
	{
		return array(
				array('allow',
						'actions'=>array('index'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('create', 'addnew', 'createDialog, paymentHistory'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	/*
	 * Show the logged in players enrolments, payment history and memberships
	 */
	public function actionIndex()
	{
		$enrolments = new CActiveDataProvider('Participant', array(
			'criteria' => array('condition' => 'player_id=:player_id',
							 'params' => array(':player_id' => Yii::app()->user->data()->player->id)),
		));
		$payments = new CActiveDataProvider('Payment', array(
			'criteria' => array('condition'=>'player_id=:player_id',
								'params' => array(':player_id' => Yii::app()->user->data()->player->id))
		));
		$memberships = new CActiveDataProvider('Membership', array(
			'criteria' => array(
						'condition' => 'player_id=:player_id',
						'params' => array(':player_id' => Yii::app()->user->data()->player->id ))
		));
		
		$this->render('index',array(
			'enrolments'=>$enrolments,
			'payments' => $payments,
			'memberships' => $memberships,
		));
	}
	
	public function actionCreate()
	{
		$model=new Player;
		// Ajax Validation enabled
		//$this->performAjaxValidation($model);
		// Flag to know if we will render the form or add a new player.
		$flag=true;
		//Disable email field if a player is self-registering
		$isEmailDisabled = Yii::app()->user->data()->type == YumUser::TYPE_PLAYER;
	
		if(isset($_POST['Player']))	{
			$model->attributes=$_POST['Player'];
			if($model->date_of_birth != null)
				$model->date_of_birth = date_format(
						date_create_from_format(
								'd/m/Y', $model->date_of_birth), 'Y-m-d');
						if($model->save()) {
							$this->redirect($this->createUrl('/participant/draw/index/cid/'.$cid));
						}
		}
	
		$this->render('create',array(
				'model'=>$model,
				//'isEmailDisabled' => $isEmailDisabled,
				//'categoryId'=> $cid,
		));
	}
	/*
	 * Show the logged in players enrolments, payment history and memberships
	*/
	public function actionPaymentHistory()
	{
		$id = Yii::app()->user->data()->player->id;
		
		$payments = new CActiveDataProvider('Payment', array(
				'criteria' => array('condition'=>'player_id=:player_id',
						'params' => array(':player_id' => Yii::app()->user->data()->player->id))
		));

		$this->render('payment',array(
				'payments' => $payments,
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAddnew()
	{
 		$player=new Player;
		
// 		// Ajax Validation enabled
 		$this->performAjaxValidation($player);
	
 		if(isset($_POST['Player']))	{
 			$player->attributes = $_POST['Player'];
			
			if($player->save()) {
//  				if(Yii::app()->request->isAjaxRequest){
// 					echo CJSON::encode(array(
// 							'status'=>'success',
// 							'div'=>"Player successfully added"
// 					));
					echo CHtml::tag('option',array ('value'=>$player->id, 'selected'=>true),
							CHtml::encode($player->given_name),true);
 			} else {
 				//$this->renderPartial('save_failure');
 			}
		} else {
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
			$this->renderPartial('createDialog',array('player'=>$player,),false,true);
		}

	}
	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='participant-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}