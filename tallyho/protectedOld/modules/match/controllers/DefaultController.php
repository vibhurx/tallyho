<?php

class DefaultController extends Controller
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
					'actions'=>array('index', 'score', 'wsScore', 'wsSetScores', 'wsGameScore', 
							'wsScoreUpdate', 'wsIndex', 'wsAdjustScore', 'wsWalkover', 'testWebServices'),
					'users'=>array('*'),
			),
			array('allow',  // allow only the logged in users to perform 'index'
					'actions'=>array('update', 'walkover', 'ajaxUpdate', 'transfer', 'scorer'),
					'users'=>array('@'),
			),
			array('deny',  // deny all users
					'users'=>array('*'),
			),
		);
	}
	
public function actionScorer($mid){
	$this->renderPartial('scorer',
					array('isUserMainContact' => true,
							'match_id' => $mid));
}
	/*	--------------------------------------------------------------------------------------------
	 *	Update scores into the DB using this web-services. 
	 *	--------------------------------------------------------------------------------------------	*/
	public function actionAjaxUpdate(){
		if(isset($_POST['id'])){
			$id =  $_POST['id'];
			
			$match = Match::model()->findByPk($id);
			
			if(isset($_POST['scores'])){
				//echo 'response at 2';
				$jScore = CJavaScript::jsonEncode($_POST['scores']);
				$arr = json_decode($jScore, true);
				$saveAttr = array();
			
				if(isset($arr['lastGame'])){
					$match->game_score1 = $arr['lastGame'][0];
					$match->game_score2 = $arr['lastGame'][1];
					$saveAttr[] = 'game_score1';
					$saveAttr[] = 'game_score2';
					if(isset($arr['tieBreak'])){
						$match->tie_break1 = $arr['tieBreak'][0];
						$match->tie_break2 = $arr['tieBreak'][1];
						$saveAttr[] = 'tie_break1';
						$saveAttr[] = 'tie_break2';
					}
					$match->save(false, $saveAttr);
				}
			
				if(isset($arr['set'])){
					if(isset($arr['set_no'])){
						$set_no = $arr['set_no'];
			
						$set = Set::model()->findByAttributes(array('match_id'=>$id, 'set_no'=> $set_no));
				 		
						if($set == null){
							$set = new Set();
							$set->match_id = $id;
							$set->set_no = $set_no;
						}
						$set->team1 = $arr['set'][0];
						$set->team2 = $arr['set'][1];
						$set->save();
					}
				}
			
				if(isset($arr['winner'])){
					$match->winner = $arr['winner'];
					$match->save(false, array('winner'));
						
					//@todo: throw an event to let the category know, it needs to promote the winner to the next round.
					$match->promoteWinner();//	Temporary arrangement
				}
			}
		}
	}

	/*	--------------------------------------------------------------------------------------------
	 *	Update scores into the DB using this web-services. wsUpdateMatchScore
	 *	Input format
	 *		{	"scores": {
	 *				"set": ["value", "value"],
	 *				"game": ["value", "value"],
	 *				"tie-break":["value", "value"] //optional
	 *			}
	 *		}
	 *	Result format
	 *		{"success": "true"} or {"success": "false", "reason": "reason text"}
	*	--------------------------------------------------------------------------------------------	*/
	public function actionWsAdjustScore(){
		header('Content-type:application/json');
		
		/*	Local variables	*/
		$point_loser = 0;
		
// 		if($_POST['id'] !== null){
// 			echo CJSON::encode(array("success"=> "true", "reason"=> "trial one"));
// 			return;
// 		}
		/*	Input validaton	*/
		if($_POST['id'] != null){
			$id =  $_POST['id'];
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Match ID is missing."));
			return;
		}
		
		$match = Match::model()->findByPk($id);
		if($match == null){
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Match does not exist for the ID."));
			return;
		}
		
		if($_POST['scores'] != null){
			$jScore = CJavaScript::jsonEncode($_POST['scores']);
			$arr = json_decode($jScore, true);
			$saveAttr = array();
		
			if($arr['set'] !== null){
			
				$sql = "SELECT MAX(set_no) as last_set FROM `set` WHERE match_id=$match->id";
				$command = Yii::app()->db->createCommand($sql);
				$last_set_record = $command->queryAll();
				 
				$set_no = $last_set_record[0]['last_set'];
				if ($set_no == null){
					echo CJSON::encode(array("success"=> "false", "reason"=> "Error: There are no sets found for this match."));
					return;
				}
				
				$set = Set::model()->findByAttributes(array('match_id'=>$id, 'set_no'=> $set_no));
				
				if($set == null){
					echo CJSON::encode(array("success"=> "false", "reason"=> "Error: There are no sets found for this match."));
					return;
				}
				
				try {
					$transaction=Yii::app()->getDb()->beginTransaction();
					if($set !== null){
						$set->team1 = $arr['set'][0];
						$set->team2 = $arr['set'][1];
						$set->save();
					}
					
					if($arr['game'] !== null){
						$match->game_score1 = $arr['game'][0];
						$match->game_score2 = $arr['game'][1];
						$saveAttr[] = 'game_score1';
						$saveAttr[] = 'game_score2';
						if($arr['tie-break'] !== null){
							$match->tie_break1 = $arr['tie-break'][0];
							$match->tie_break2 = $arr['tie-break'][1];
							$saveAttr[] = 'tie_break1';
							$saveAttr[] = 'tie_break2';
						}
						
						$match->save(false, $saveAttr);
					}
					$transaction->commit();
				} catch(Exception $ex){
					$transaction->rollback();
					echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Data save failed. Try again."));
				}
			
			} else {
				echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Set score points are missing from the input."));
			}
			
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Score points are missing from the input."));
		}
		
		//$this->actionWsScore($id);

		$score = $this->actionWsScore($id, true);
		echo CJSON::encode(array("success"=> "true", "score" => $score));
	}
	
	/*	--------------------------------------------------------------------------------------------
	 *	Update scores into the DB using this web-services. wsUpdateMatchScore
	*	--------------------------------------------------------------------------------------------	*/
	public function actionWsScoreUpdate(){
		//header('Content-type:application/json');
		
		/*	Local variables	*/
		$point_winner = 0;
		
		/*	Input validaton	*/
		if(isset($_POST['id'])){ // !== null){
			$id =  $_POST['id'];
			if(isset($_POST['team'])){
				$point_winner =  $_POST['team'];
				if(isset($_POST['scorer'])){
					$scorer =  $_POST['scorer'];
				} else {
					echo CJSON::encode(array("success"=> "false", "reason" => "Error: Invalid input: Scorer ID is missing"));
					return;			//	Invalid input: Scorer ID is missing
				}
			} else {
				echo CJSON::encode(array("success"=> "false", "reason" => "Error: Invalid input: winning team no. is missing"));
				return;			//	Invalid input: Scorer ID is missing
			}
		} else {
			echo CJSON::encode(array("success"=> "false", "reason" => "Error: Invalid input: Match ID is missing"));
			return;			//	Invalid input: Match ID is missing
		}
		
		$match = Match::model()->findByPk($id);
		if($match == null){
			echo CJSON::encode(array("success"=> "false", "reason" => "Error: Match does not exist for the ID."));
			return;
		}
		
		if($match->winner == 1 || $match->winner == 2){
			echo CJSON::encode(array("success"=> "false", "reason" => "Error: Cannot update score. Match is over."));
			return;			//	Match is over
		}
		
		//If authorization fails then the program stops. It does not proceed beyond this point.
		$retval = $match->checkAuthorization($match, $scorer);
		if($retval !== false){
			if($match->scorer == null || $match->scorer == 0){
				$match->scorer = $retval;
				//$saveAttr[] = 'scorer';
			}
		} else {
			return;
		}
		
		/*	Up score by 1 for the player who got the point */
		if($match->game_score1 == 40 && $match->game_score2 == 40){	//tie-break
					
			if($point_winner == 1){
				$tie_break_diff =  $match->tie_break1 - $match->tie_break2;
				$winner_tie_break_points = $match->tie_break1;
			} else {
				$tie_break_diff =  $match->tie_break2 - $match->tie_break1;
				$winner_tie_break_points = $match->tie_break2;
			}
			
			if($category->tie_break_rule == Match::TIE_BREAK_RULE_SINGLE)
				$max_tie_break_point = 0;
			else
				$max_tie_break_point = 6;
			
			if($tie_break_diff > 2 && $winner_tie_break_points == $max_tie_break_point){
				$match->game_score1 = 0;		//	game over reset everything
				$match->game_score2 = 0;
				$match->tie_break1 = 0;
				$match->tie_break2 = 0;
				$game_over = true;
			} else {
				echo CJSON::encode(array("success"=> "false", "point_winner" => $point_winner));
				return;
					
				if($point_winner == 1)			//	Update the tie-break score
					$match->tie_break1 = $match->tie_break1 + 1;
				else
					$match->tie_break2 = $match->tie_break2 + 1;
				
				$game_over = false;
			}
		} else {								// end of tie-break condition
			
			if($point_winner == 1){
				if($match->game_score1 == 40){
					$match->game_score1 = 0;
					$match->game_score2 = 0;
					$game_over = true;
				} else {
					$match->game_score1 = ($match->game_score1 == 0)? 15 : (($match->game_score1 == 15)? 30 : (($match->game_score1 == 30) ? 40 : 0));	//	Last one is dummy
					$game_over = false;
				}
			} else {
				if($match->game_score2 == 40){
					$match->game_score1 = 0;
					$match->game_score2 = 0;
					$game_over = true;
				} else {
					$match->game_score2 = ($match->game_score2 == 0)? 15 : (($match->game_score2 == 15)? 30 : (($match->game_score2 == 30) ? 40 : 0));	//	Last one is dummy
					$game_over = false;
				}
			}
		}
		
		$set_over = false;
		//	Check the game end condition
		if($game_over){
			//	Keep the max set score ready (4 for mini-sets, 8 for best-of-15, 6 for regular sets)
			$max_set_score = $category->score_type == Match::SCORE_RULE_15_GAMES
								? 8 : Match::SCORE_RULE_3_MINISETS
									? 4 : 6;
			
			//	Set score need to be updated.. fetch the last set
			$criteria = new CDbCriteria();
			$criteria->addCondition(array('match_id'=>$id));
			$last_set_no = Set::model()->count($criteria);
			$set = Set::model()->findByAttributes(array('match_id'=>$id, 'set_no'=> $last_set_no));
			
			if($point_winner == 1){
				$set->team1 = $set->team1 + 1;
				if($set->team1 - $set->team2 >= 2 && $set->team1 >= $max_set_score){
					$set_over = true;
				} else {
					$set_over = false;
				} 
			} else {
				$set->team2 = $set->team2 + 1;
				if($set->team2 - $set->team1 >= 2 && $set->team2 >= $max_set_score){
					$set_over = true;
				} else {
					$set_over = false;
				}
			}
			
		}	//Nothing is required on set score if the game is not over
		
		$match_over = false;			/*	Initialization	*/
		//	Check match end condition
		if($set_over){
			$criteria = new CDbCriteria();
			$criteria->addCondition(array('match_id'=>$id, 'winner'=>$point_winner));
			$sets_won = Set::model()->count($criteria); 
			
			if($category->score_type == Match::SCORE_RULE_15_GAMES){
				$match_over = true;
				$match->winner = $point_winner;
			} elseif(($category->score_type == Match::SCORE_RULE_3_MINISETS || $category->score_type == Match::SCORE_RULE_3_SETS) 
					&& $sets_won >= 1){
				$match_over = true;
				$match->winner = $point_winner;
			}  elseif($category->score_type == Match::SCORE_RULE_5_SETS && $sets_won >= 2){
				$match_over = true;
				$match->winner = $point_winner;
			} else {
				$next_set = new Set();
				$next_set->match_id = $id;
				$next_set->set_no = $sets_won + 1;
				$next_set->team1 = 0;
				$next_set->team2 = 0;
			}
		}
			
		//	Start transaction - Save match entity
		$transaction=Yii::app()->getDb()->beginTransaction();
			
		try {
				
			if($match_over)
				$match->save(false, array('game_score1', 'game_score2', 'winner', 'tie_break1', 'tie_break2'));
			else
				$match->save(false, array('game_score1', 'game_score2', 'tie_break1', 'tie_break2'));
			
			if($game_over){
				if($set_over){
					$set->save(false, array('team1','team2', 'winner'));
					if(!$match_over){
						$next_set->save();
					}
				} else {
					$set->save(false, array('team1','team2'));
				}
			}
				
		} catch (Exception $e) {
			$transaction->rollback();
			echo CJSON::encode(array("success"=> "false", "reason" => "Error: DB Error: Data could not be saved."));
			return;
		}
					
		$transaction->commit();			//	Save set entity - End transaction
		
		/*	Now it is time to respond to the called with the updated score	*/
		
		//$this->actionWsScore($id);

		$score = $this->actionWsScore($id, true);
		echo CJSON::encode(array("success"=> "true", "score" => $score));
		
	}

	
	/*	--------------------------------------------------------------------------------------------
	 *	Offer walkover to one of the players of user's choice
	 *	--------------------------------------------------------------------------------------------*/
	public function actionWalkover($id)
	{
		$match = $this->loadModel($id);
		
		if($match->winner != 1 && $match->winner != 2){
			if(isset($_POST['id'])){
				$id =  $_POST['id'];
	
				if(isset($_POST['winner'])){
					$match->winner =  $_POST['winner'];			
					$match->save(false, array('winner'));
					$match->promoteWinner();
				} else {
					echo "Are you sure you are in the right place !!";
				}
			} else {
				$this->renderPartial('walkover', array(
						'match'=>$match,));
			}
		} else {
			echo "The match is over!";
		}
	}

	/*	--------------------------------------------------------------------------------------------
	 *	Offer walkover to one of the players of user's choice
	 *	Input format in POST
	 *		{	"id": "id_value",	"winner": "winner_value"	}
	 *	Result
	 *		{"success": "true"} or {"success": "false", "reason": "reason text"}
	 *
	*	--------------------------------------------------------------------------------------------*/
	public function actionWsWalkover($id)
	{
		header('Content-type:application/json');
		$match = Match::model()->findByPk($id);
		
		if($match != null){
		
			if($match->winner != 1 && $match->winner != 2){
				if(isset($_GET['id'])){
					$id =  $_GET['id'];
			
					if(isset($_GET['team'])){
						$winning_team =  $_GET['team'];
						if($winning_team == 1 || $winning_team == 2) {
							$match->winner = $winning_team;
							$match->save(false, array('winner'));
							$match->promoteWinner();
							echo CJSON::encode(array("success"=> "true"));
						} else {
							echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid team number. Should either be 1 or 2."));
						}
					}
				} else {
					echo CJSON::encode(array("success"=> "false", "reason"=> "Error: input does not contain Match ID value."));
				}
			} else {
				echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Walk-over not possible because the match is already over."));
			}
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Match does not exist for the ID."));
		}
	}
	

	/*	--------------------------------------------------------------------------------------------
	 *	This action is used for listing the matches for the user to select one
	 *	--------------------------------------------------------------------------------------------*/
	public function actionIndex($cid, $qual)
	{
		$category = Category::model()->findByPk($cid);
		$categoryCode = $category->category;
		$tourId = $category->tour_id;
		
		$levelCondition = $qual? ' AND level <= 0' : ' AND level > 0';
		$dataProvider=new CActiveDataProvider('Match', array(
				'criteria' => array(
						'condition' => 'category=:category AND tour_id=:tourId' . $levelCondition,
						//'with' => array("sets"),
						'params'=>array(':category'=>$categoryCode, ':tourId'=>$tourId)),
				'pagination' => false,));

		
		if(isset($_GET['ctyp'])){
			if($_GET['ctyp'] == 'json'){
				$modelAttributeNames = 'id, tour_id, category, winner, player11, player21';
				echo Yii::app()->common->renderJson($dataProvider->getData(), $modelAttributeNames );
			}
		} else {
			$this->render('index',array(
					'dataProvider'=>$dataProvider,
					'isQual'=>$qual,
					'isTourOwner'=> Yii::app()->user->isTourOwner($tourId),
					'tourId' => $tourId,
			));
		}
	
	}
	
	/*	--------------------------------------------------------------------------------------------
	 *	This action is used for listing the matches for the user to select one.
	 *	Method: GET (passed as a parameter)
	 *	Return: Arrayed list of all the matches
	 *	--------------------------------------------------------------------------------------------*/
	public function actionWsIndex()
	{
		header('Content-type:application/json');
		
		if(isset($_GET['cid'])){
			$cid = $_GET['cid'];
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Category ID is missing."));
			return;
		}

		if(isset($_GET['qual'])){
			$qual = $_GET['qual'];
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Qualifier flag (whether main draw or qualifying) is missing."));
			return;
		}
		
		
		$category = Category::model()->findByPk($cid);
		
		if($category === null){
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Category ID is invalid. There is no such entry with us."));
			return;
		}

		$category_category = $category->category;
		$tour_id = $category->tour_id;
		
		$level_condition = $qual? ' AND level <= 0' : ' AND level > 0';
		
		$sql = "SELECT t.id,
			t.tour_id, t.category, t.winner, t.player11, t.player21, 
			CONCAT(pp.given_name, ' ', pp.family_name) AS player_name11,
			CONCAT(pp.given_name, ' ', qp.family_name) AS player_name21,
			IF(t.winner = 1 OR t.winner = 2, 2, IF(s.count = 0, 0, 1)) AS status
		FROM `match` t
			LEFT JOIN participant p ON t.player11=p.id
				LEFT JOIN player pp ON p.player_id = pp.id
			LEFT JOIN participant q ON t.player21=q.id
				LEFT JOIN player qp ON q.player_id = qp.id
			LEFT JOIN (SELECT match_id, count(1) as count FROM `set` ) s ON s.match_id = t.id
		WHERE t.tour_id=$tour_id  AND t.category=$category_category" . $level_condition;
		$command = Yii::app()->db->createCommand($sql);
		$records = $command->queryAll();
		
		$modelAttributeNames = 'id, tour_id, category, winner, player11, player21, player_name11, player_name21, status';
		echo Yii::app()->common->renderJson($records, $modelAttributeNames ); 
	}
	
	/*	--------------------------------------------------------------------------------------------
	 *	Displays a particular model. This view is for the owner role.
	 *		@param integer $id the ID of the model to be displayed
	 *	--------------------------------------------------------------------------------------------*/
	public function actionScore($id, $new = null)
	{
		$match = $this->loadModel($id);
		$category = Category::model()->findByAttributes(array('category'=>  $match->category,
					'tour_id'=> $match->tour_id ));
		
		$dataProvider=new CActiveDataProvider('Set', array(
				'criteria'=>array(
						'condition'=>'match_id=:matchId',
						'params'=>array(':matchId'=>$id),
						'order'=>'set_no',
				),
		));
		
		$isTourOwner = Yii::app()->user->isTourOwner($match->tour_id);
		$isUserMainContact = false;
		
		if($isTourOwner){
			$isUserScorer = $match->scorer == Yii::app()->user->data()->contact->id;
			$isUserMainContact = Yii::app()->user->data()->contact->id == Tour::model()->findByPk($match->tour_id)->organization->main_contact;
		} else {
			$isUserScorer = false;
		}
		
		if(isset($_GET['form_field'])){
			if($match->scorer == null){
				if($match->winner == null){
					//read to score?
					$match->scorer = Yii::app()->user->data()->contact->id;
					if($match->save())
						$isUserScorer = true;
					
				} else {
					//there is nothing to score. game is over just watch the score.
					$isUserScorer = false;	//redundant
				}
			} else {
				//someone scoring it alright !!
				//is that someone me?
				if($match->scorer == Yii::app()->user->data()->contact->id){
					//if me then I am back in business
					$isUserScorer = true;
				} else {
					$isUserScorer = false;	//redundant
				}
			}
		}
		
		if($new){
			$match->scorer = Yii::app()->user->data()->contact->id;
			if($match->save())
				$isUserScorer = true;
		}
		
		if($new == null && $isTourOwner && !$isUserScorer){
			$this->render('scorer', array(
				'match_id' => $match->id,
				'isUserMainContact' => $isUserMainContact,
				));
			return;
		}
		
		//	Lock the record
		$this->render('score', array(
				'match'=>$match,
				'isTourOwner' => $isTourOwner,
				'isUserMainContact' => $isUserMainContact,
				'isUserScorer'=> $isUserScorer,	//owner-cum-scorer gets to change the score for the rest, read-only
				'dataProvider'=>$dataProvider,
				'tourId'=>$match->tour_id,
				'tiebreak_rule' => $category->tie_breaker,
				'score_rule' => $category->score_type,
				'categoryId' => $category->id, 
		));
		
	}
	
	/*	--------------------------------------------------------------------------------------------
	 *	Displays a particular model. This view is for the owner role.
	 *		@param integer $id the ID of the model to be displayed
	 *	Input format: Match ID as GET param
	 *	Output format:
 	 *		[{ "id": "value", "match_id": "value", "team1": "value", "team2": "value" }, { .. }]
	 *	--------------------------------------------------------------------------------------------*/
	public function actionWsSetScores($id, $return = false)
	{
		$match = Match::model()->findByPk($id);
		if($match !== null){
			$category = Category::model()->findByAttributes(array('category'=>  $match->category,
				'tour_id'=> $match->tour_id ));
		} else {
			header('Content-type:application/json');
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Match does not exist for the input ID."));
			return;
		}
	
		$dataProvider=new CActiveDataProvider('Set', array(
				'criteria'=>array(
						'condition'=>'match_id=:matchId',
						'params'=>array(':matchId'=>$id),
						'order'=>'set_no',
				),
		));
		
		$modelAttributeNames = 'id, match_id, team1, team2';	
		if($return){
			return 	Yii::app()->common->renderJson($dataProvider->getData(), $modelAttributeNames );
		} else {
			echo Yii::app()->common->renderJson($dataProvider->getData(), $modelAttributeNames );
		}
	}
	
	/*	--------------------------------------------------------------------------------------------
	 *	Specially made for JSON output
	 *	Input format: Match ID as GET param
	 *	Output format:
	 *		{ "id": "value", "match_id": "value", "team1": "value", "team2": "value" }
	 *	--------------------------------------------------------------------------------------------*/
	public function actionWsGameScore($id, $return = false)
	{
		$match = Match::model()->findByPk($id);
		$matchArr[] = $match;
		
		$modelAttributeNames = 'id, game_score1, game_score2, tie_break1, tie_break2, winner';
		if($return){
			return Yii::app()->common->renderJson($matchArr, $modelAttributeNames);
		} else {
			echo Yii::app()->common->renderJson($matchArr, $modelAttributeNames);
		}
	}
	
	/** --------------------------------------------------------------------------------------------
	 * 
	 * @param unknown $id
	 *	--------------------------------------------------------------------------------------------*/
	public function actionWsScore($id, $return = false){
		$set = json_decode($this->actionWsSetScores($id, true));
		$game = json_decode($this->actionWsGameScore($id, true));
		$retval = new stdClass();
		$retval->id = $id;
		$retval->set = $set;
		$retval->game = $game;
		
		if($return)
			return $retval;
		else {
			header('Content-type:application/json');
			echo json_encode($retval);
		}
	}
	/*	--------------------------------------------------------------------------------------------
	 *	This action transfers a selected qualified participant to the main draw.
	 *	If the action finds the player already transferred to main then it returns.
	 *	--------------------------------------------------------------------------------------------*/
	public function actionTransfer($pid){
		
		$sql = "SELECT id, tour_id, category, level FROM `match` 
				WHERE (player11= $pid OR player21= $pid ) AND (level = 1 OR level = -1)";	//	Both qual as well as main
		$command = Yii::app()->db->createCommand($sql);	
		$matches = $command->queryAll();
		
		foreach($matches as $match){
			if($match['level'] == 1){		//If the player already there in the main draw!!! Return asap.
				
				$this->redirect(Yii::app()->request->urlReferrer);
				return;
				
			} elseif($match['level'] == -1){
				
				$id 	  = (int)$match["id"];
				$category = (int)$match["category"];
				$tour_id  = (int)$match["tour_id"];
			}
		}
		
		//	Find the last empty position to be filled
		$sql = "SELECT t.id,
					IF(ISNULL(player11), 'empty', player11) as player11,
					IF(ISNULL(player21), 'empty', player21) as player21,
					IF(ISNULL(player11), q.seed, p.seed) as seed
				FROM `match` t
					LEFT JOIN participant p ON t.player11=p.id
					LEFT JOIN participant q ON t.player21=q.id
				WHERE t.tour_id=$tour_id  AND t.category=$category 
					AND level = 1
					AND (ISNULL(t.player11) OR ISNULL(t.player21))
				ORDER BY seed DESC";
		$command = Yii::app()->db->createCommand($sql);
		$empty_places = $command->queryAll();
		
		$target_id = $empty_places[0];
		
		$target_match = $this->loadModel($target_id);
		
		if($target_match->player11 == null){
			$target_match->player11 = $pid;
		} else {
			$target_match->player11 = $pid;
		}
		$target_match->save(false, array('player11', 'player21'));

		$this->redirect(Yii::app()->request->urlReferrer);
	}
	
	/*	---------------------------------------------------------------------------------------------
	 * 	Promote the winning team to the next round. This is a temporary arrangement. Winning event
	* 	should be thrown and caught by the category object, which in turn, would make a db update
	* 	--------------------------------------------------------------------------------------------*/
// 	public function promoteWinner($pMatchId){
			
// 		$match = Match::model()->findByPk($pMatchId);
// 		if($match == null){
// 			return false;
// 		} elseif($match->winner == null || $match->winner == 0) {
// 			return false;
// 		}
			
// 		$category = Category::model()->findByAttributes(array('tour_id'=>$match->tour_id, 'category'=> $match->category));
// 		$category_mlevels = log($category->mdraw_size)/log(2);
// 		$max_level = $match->level > 0 ? log($category->mdraw_size)/log(2): $category->qlevels;
		
// 		if($match->level == $max_level)
// 			return true;			
			
// 		$draw_size = $match->level > 0 ? $category->mdraw_size : $category->qdraw_size;
			
// 		$new_seq = $draw_size/2 + ($match->sequence + $match->sequence%2)/2;	//Sequence is assigned per match, i.e, to every 2 players
			
// 		if($match->level > 0){
// 			$next_match = Match::model()->findByAttributes(array(
// 					'tour_id'=>$match->tour_id, 'category'=> $match->category, 'sequence'=>$new_seq));
// 		} elseif($match->level == 0) { //no round of qualifying left, and player must move to main draw so do nothing
// 			; //do nothing
// 		} elseif($match->level < 0){ //1 round of qualifying left, move to next round of qualifying
// 			$next_match = Match::model()->findByAttributes(array(
// 					'tour_id'=>$match->tour_id, 'category'=> $match->category, 'sequence'=>$new_seq, 'level'=>'0'));
// 		}
			
// 		if($match->sequence%2 == 1)
// 			$next_match->player11 = $match->winner == 1? $match->player11 : $match->player21;
// 		else
// 			$next_match->player21 = $match->winner == 1? $match->player11 : $match->player21;
			
// 		$next_match->save(false, array('player11', 'player21'));
			
// 		return true;
// 	}
	
	/*	--------------------------------------------------------------------------------------------
	 * 	Returns the data model based on the primary key given in the GET variable.
	 * 	If the data model is not found, an HTTP exception will be raised.
	 *		@param integer $id the ID of the model to be loaded
	 *		@return Tour the loaded model
	 *		@throws CHttpException
	 *	--------------------------------------------------------------------------------------------*/
	public function loadModel($id)
	{
		$model=Match::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	/*	--------------------------------------------------------------------------------------------
	
	*	--------------------------------------------------------------------------------------------*/
	public function actionTestWebServices(){
		
		if(isset($_POST['input_json'])){
			$input_string = $_POST['input_json'];
			$inputParams = CJSON::decode($input_string);
			
			
			$id = $inputParams['id'];
			$scorer = $inputParams['scorer'];
			$team = $inputParams['team'];
			
			$result = "The match with id - $id, is scored by $scorer and the point is awarded to $team. Happy?";
			$this->render('test', array('result'=> $result));
		} else {
			$this->render('test');
		}
	}
}