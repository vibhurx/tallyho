<?php

class ApiController extends Controller
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
			array('allow',  // allow only the logged in users to perform 'index'
				'actions'=>array('index', 'view', 'byOrg', 'myTours'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
	);}
	
	/*
	 * 
	 */
	public function actionIndex(){	
// 		$criteria  = array(
// 				'with'=>array('organization'),
// 				'condition' => 'status!=:draft AND status!=:over',
// 				'params'=>array(':draft'=>Tour::STATUS_DRAFT, ':over'=>Tour::STATUS_OVER),
// 		);
// 		$dataProvider=new CActiveDataProvider('Tour', array('criteria' => $criteria));
	
		$sql = "SELECT t.id,
			t.location, t.level, t.start_date, t.status, t.org_id, 
			o.logo AS logo_url
			FROM `tour` t
			LEFT JOIN organization o ON t.org_id = o.id
			WHERE t.status!=" . Tour::STATUS_DRAFT . " AND t.status!=" . Tour::STATUS_OVER;
		$command = Yii::app()->db->createCommand($sql);
		$records = $command->queryAll();
		
		foreach($records as &$record){
			$f_name = $record['logo_url'];
			$record['logo_url'] = urlencode("images/olog/" . $record['org_id'] . "/$f_name");
		}
		
		$modelAttributeNames = 'id, location, level, start_date, status, org_id, logo_url';
		echo Yii::app()->common->renderJson($records, $modelAttributeNames );
	}
	
	public function actionView($id) {
		$tour = Tour::model()->findByPk($id);
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
	
	public function actionByOrg($oid) {
		
		$criteria  = array('condition' => 'status!=' . Tour::STATUS_DRAFT
				. ' AND status!=' . Tour::STATUS_OVER
				. ' AND org_id=' . $oid);
		$dataProvider=new CActiveDataProvider('Tour', array('criteria' => $criteria));
	
		$modelAttributeNames = 'id, location, level, start_date, status';
		echo Yii::app()->common->renderJson($dataProvider->getData(), $modelAttributeNames );
	}
	
	public function actionMyTours($user) {
		$oUser = YumUser::model()->findByAttributes(array('username'=>$user));
		if($oUser != null)
			if($oUser->contact != null){
				$oid = $oUser->contact->organization->id;
				$dataProvider=new CActiveDataProvider('Tour', array('criteria' => array('condition' => 'org_id=' . $oid)));
			
				$modelAttributeNames = 'id, location, level, start_date, status';
				echo Yii::app()->common->renderJson($dataProvider->getData(), $modelAttributeNames );
			} else {
				echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid access: The client app is not authorized to access. Must log-in as a contact. "));
			}
		else {
				echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid user: The username supplied does not exist."));
		}
	}
}