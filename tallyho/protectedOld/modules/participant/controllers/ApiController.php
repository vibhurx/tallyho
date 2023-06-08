<?php 
/**	
 * Used for player role only.
 * Use this controller for showing all the participants for a tour and category
 * List would list all the enrolled participants
 * Draw will display them in main and qualifying tree mode
 */
?>
<?php

class ApiController extends Controller
{
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		header('Content-type:application/json');
		
		if(isset($_GET['username'])){
			$username = $_GET['username'];
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Username is missing."));
			return;
		}
		$user = YumUser::model()->findByAttributes(array('username'=>$username));
		if($user != null){
			$player = Player::model()->findByAttributes(array('user_id'=>$user->id));
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Username does not exist."));
			return;
		}	
		$sql = "SELECT 
					t.location, pa.id, pa.tour_id, pa.category, pa.seed, t.start_date, pl.given_name,
					pl.family_name, o.id AS org_id, o.logo AS logo_url
				FROM participant pa
					JOIN tour t ON t.id = pa.tour_id
					JOIN player pl ON pa.player_id = pl.id
					JOIN user u ON pl.user_id = u.id
					JOIN organization o ON t.org_id = o.id
				WHERE u.username = '$username'";
		$command = Yii::app()->db->createCommand($sql);
		$records = $command->queryAll();
		
		foreach($records as &$record){
			$f_name = $record['logo_url'];
			$record['logo_url'] = urlencode("images/olog/" . $record['org_id'] . "/$f_name");
		}
		
		$modelAttributeNames = 'location, start_date, category, seed, given_name, family_name, tour_id, org_id, logo_url';
		$jsonRecords = CJSON::decode(Yii::app()->common->renderJson($records, $modelAttributeNames));
		$output = array("success"=>"true", "result"=>$jsonRecords);
		echo CJSON::encode($output);
		
	}

	/*
	 * Web-service to enrol a player for a tournament-category. The input comes as GET ULR parameters like -
	 * 		?username={username}&tour={tour_id}&category={category}
	 */
	public function actionEnrol()
	{
		header('Content-type:application/json');
		
		if(isset($_GET['username'])){
			$username = $_GET['username'];
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Username is missing."));
			return;
		}
		if(isset($_GET['category'])){
			$category = $_GET['category'];
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Category is missing."));
			return;
		}
		if(isset($_GET['tour'])){
			$tour_id = $_GET['tour'];
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Tour ID is missing."));
			return;
		}
		$categoryModel = Category::model()->findByAttributes(array('tour_id'=>$tour_id, 'category'=>$category));
		if($categoryModel == null){
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid category: This category does not exist for the selected tournament."));
			return;
		}
		if($categoryModel->draw_status == Category::STATUS_NOT_PREPARED){
		
			$user = YumUser::model()->findByAttributes(array('username'=>$username));
			if($user == null){
				echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: User does not exist."));
				return;
			} elseif($user->type != YumUser::TYPE_PLAYER ){
				echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: User is not a player."));
				return;
			} else {
				$gender = ($categoryModel->category + 1) % 2 + 1;
				if($gender == $user->player->gender ){
					$player_id = $user->player->id;
					
					// Check duplicate
					$participants = Participant::model()->findAllByAttributes(array('tour_id'=>$tour_id,
										'category'=>$category, 'player_id'=>$player_id));
					if(sizeof($participants) > 0){
						echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Duplicate entry: The user has already enrolled for this tour-category."));
						return;
					}
										
					$participant=new Participant;
			
					$participant->tour_id = $tour_id;
					$participant->category = $category;
					$participant->player_id = $player_id;	// Dicey
					$participant->seed = 999;
					
					try {
						if($participant->save()){
							echo CJSON::encode(array("success"=> "true", "reason"=> "", "message"=>"The player has been enrolled successfully."));
						} else {
							echo CJSON::encode(array("success"=> "false", "reason"=> "Error: In saving the enrollment."));
						}
					} catch(CException $ex) {
						echo CJSON::encode(array("success"=> "false", "reason"=> "Error: In enrolling the player."));
						return;
					}
				} else {
					echo CJSON::encode(array("success"=> "false", "reason"=> "Error: The player's gender does not match the gender of category."));
					return;
				}
			}
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Enrollment is allowed for categories with draw Not-Prepared."));
			return;
		}
	}
	
	/*
	 * Web-service to enrol a player for a tournament-category. The input comes as GET ULR parameters like -
	* 		?username={username}&tour={tour_id}&category={category}
	*/
	public function actionLeave()
	{
		header('Content-type:application/json');
	
		if(isset($_GET['username'])){
			$username = $_GET['username'];
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Username is missing."));
			return;
		}
		if(isset($_GET['category'])){
			$category = $_GET['category'];
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Category is missing."));
			return;
		}
		if(isset($_GET['tour'])){
			$tour_id = $_GET['tour'];
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Tour ID is missing."));
			return;
		}
		$categoryModel = Category::model()->findByAttributes(array('tour_id'=>$tour_id, 'category'=>$category));
		if($categoryModel == null){
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid category: This category does not exist for the selected tournament."));
			return;
		}
		
		if($categoryModel->draw_status != Category::STATUS_NOT_PREPARED){
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Leaving is allowed for categories with draw Not-Prepared."));
			return;
		}

		$user = YumUser::model()->findByAttributes(array('username'=>$username));
		if($user == null){
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: User does not exist."));
			return;
		} 
		if($user->type != YumUser::TYPE_PLAYER ){
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: User is not a player."));
			return;
		} 
		
		// Check existence of enrollment
		$participant = Participant::model()->findByAttributes(array('tour_id'=>$tour_id,
				'category'=>$category, 'player_id'=> $user->player->id));
		if($participant == null){
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Data not found: The player is not enrolled for this tour-category."));
			return;
		}
		try {
			if($participant->delete()){
				echo CJSON::encode(array("success"=> "true", "reason"=> "", "message"=>"The player has left the category of this tournament successfully."));
			} else {
				echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Enrollment could not be deleted."));
			}
		} catch(CException $ex) {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Enrollment deletion faced an unusual error. Contact admin@tallyho.in."));
		}
	
	}
	
	//Specially made for JSON output
	public function actionName($id)
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