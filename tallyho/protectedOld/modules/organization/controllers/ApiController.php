<?php

/*
 * Thsi controller will be removed.
 * 
 */

class ApiController extends Controller
{
	
	public function accessRules()
	{
		return array(
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('logoUrl'),
						'users'=>array('*'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	/*
	 * Show the logged in players enrolments, payment history and memberships
	 */
	public function actionLogoUrl($id){
		header('Content-type:application/json');
		
		$model = Organization::model()->findByPk($id);
		
		if($model != null){
			echo CJSON::encode(
					array(
						"success"=> "true",
						"message"=> "Info: Organization exists.",
						"data" => array("url" => urlencode("images/olog/". $model->id . "/" . $model->logo))
			));
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Organization does not exist."));
		}
		
		
	}
	
}