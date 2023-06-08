<?php

class DefaultController extends Controller
{
	
	public function accessRules()
	{
		return array(
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('create','addnew', 'createDialog'),
						'users'=>array('@'),
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