<?php 
/**	
 * Used for player role only.
 * Use this controller for showing all the participants for a tour and category
 * List would list all the enrolled participants
 * Draw will display them in main and qualifying tree mode
 */
?>
<?php

class DefaultController extends Controller
{
	/**
	 * Lists all models - DEPRECATED
	 */
// 	public function actionIndex()
// 	{
// 		$dataProvider=new CActiveDataProvider('Participant', array(
// 			'criteria' => array('condition' => 'player_id="' .
// 							 Yii::app()->user->data()->player->id . '"'),
// 		));
// 		$this->render('index',array(
// 			'dataProvider'=>$dataProvider,
// 		));
// 	}

	//Specially made for JSON output
	public function actionWsName($id)
	{
		$modelAttributeNames = 'id, given_name, family_name, fullName';
		
		$participant = Participant::model()->findByPk($id);
		
		if($participant == null){
			echo Yii::app()->common->renderJson(array(), $modelAttributeNames );;
		} else {
			$player[] = $participant->player;
			echo Yii::app()->common->renderJson($player, $modelAttributeNames );
		}
	}
	
}