<?php 
/**	
 * Used for player role only.
 * Use this controller for showing all the enrolments for a event and category
 * List would list all the enrolled enrolments
 * Draw will display them in main and qualifying tree mode
 */
?>
<?php

class EnrolmentController extends Controller
{
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array('index', 'enrol', 'generate', 'seed', 'sort',
						'updatePoints', 'updateSeedPoints', 'togglePaymentStatus', 'delete'),
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
	
	public function actionIndex() //only for logged in users
	{
		$user_id = Yii::app()->user->data()->id;
		$player = Player::model()->find('user_id=:user_id', array(':user_id'=>$user_id));

		if($player == null)
			$this->redirect('site/error');
		else {
			$dataProvider=new CActiveDataProvider('Enrolment', array(
				'criteria' => array('condition' => 'player_id="' .
								$player->id . '"'),
			));
			$this->render('index',array(
				'dataProvider'=>$dataProvider,
			));
		}
	}

	public function actionEnrol($cid)
	{
		$category = Category::model()->findByPk($cid);
		
		
		if($category == null){
			Yii::app()->user->setFlash('error', 'Invalid Category');
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		
		if(!Yii::app()->user->hasRole('Player')){
			Yii::app()->user->setFlash('error', 'You need to be a Player to enrol in a tournament.');
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		
		$user_id = Yii::app()->user->data()->id;
		$player = Player::model()->find('user_id=:user_id', array(':user_id'=>$user_id));

		if($player->gender != ($category->category % 2)) { //Gender mismatch odd=boys(1); even=girls(0)
			Yii::app()->user->setFlash('error', 'Gender Mismatch');
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		
		$enrolment=new enrolment;
	
		if(isset($_POST['Enrolment'])){
			
			$enrolment->attributes=$_POST['Enrolment'];
			try {
				if($enrolment->save()){
					Yii::app()->user->setFlash('success', 'Your enrolment is successful.');
					$this->redirect(array('enrolment/index'));
				}
			} catch(CException $ex) {
				//throw new CHttpException(404,'');
				Yii::app()->user->setFlash('error', 'You have already joined this track.');
				$this->redirect(Yii::app()->user->returnUrl);
// 				if($src == 1)
// 					$this->redirect(array('/category/default/view', 'id'=>$cid));
// 				else
// 					$this->redirect(array('/category/default/index', 'tid'=>$category->event_id));
			}
		}
		
		//$model->id = 0; //zero for auto-increment to work at the DB level	
		/*	A contact may select to enrol as a guest user. Once logged in the following statement bombs.
		 * 	Make sure the contact does not reach here.
		 */
		$enrolment->player_id = $player->id;
		$enrolment->event_id = $category->event_id;
		$enrolment->category = $category->category;			//code for U12Boys, U12Girls etc.
		$enrolment->seed = Enrolment::MAX_POSSIBLE_SEED;
		
		$event = Event::model()->findByPk($enrolment->event_id);
		
		$this->render('enrol', array(
			'enrolment'=>$enrolment,
			'event'=>$event,
			'genderCode'=>$player->gender
		));
	}

	//Specially made for JSON output
	public function actionWsName($id)
	{
		$modelAttributeNames = 'id, given_name, family_name, fullName';
		
		$enrolment = Enrolment::model()->findByPk($id);
		
		if($enrolment == null){
			echo Yii::app()->common->renderJson(array(), $modelAttributeNames );;
		} else {
			$player[] = $enrolment->player;
			echo Yii::app()->common->renderJson($player, $modelAttributeNames );
		}
	}
	
}