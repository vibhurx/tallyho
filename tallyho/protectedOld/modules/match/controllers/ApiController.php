<?php

class ApiController extends Controller
{
	public $layout='//layouts/column2';
	
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
					'actions'=>array('index', 'score', 'setScore', 'gameScore', 
							'updateScore', 'adjustScore', 'walkover', 'adjustScoreHuR', 'ajaxMatchUpdate'),
					'users'=>array('*'),
			),
			array('allow',  // allow only the logged in users to perform 'index'
					'actions'=>array(),
					'users'=>array('@'),
			),
			array('deny',  // deny all users
					'users'=>array('*'),
			),
		);
	}
	
	/*	--------------------------------------------------------------------------------------------
	 *	This action is used for listing the matches for the user to select one.
	*	Method: GET (passed as a parameter)
	*	Return: Arrayed list of all the matches
	*	--------------------------------------------------------------------------------------------*/
	public function actionIndex()
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
	//@todo: status need to be determined for unscheduled matches.	
		$sql = "SELECT t.id,
		t.tour_id, t.category, t.winner, t.player11, t.player21,
		CONCAT(pp.given_name, ' ', pp.family_name) AS player_name11,
		CONCAT(qp.given_name, ' ', qp.family_name) AS player_name21,
		t.scorer,
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
	
		$modelAttributeNames = 'id, tour_id, category, winner, player11, player21, player_name11, player_name21, scorer, status';
		echo Yii::app()->common->renderJson($records, $modelAttributeNames );
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
	 *		{"success": "true", "set": [], "game": []} or {"success": "false", "reason": "reason text"}
	*	--------------------------------------------------------------------------------------------	*/
	public function actionAdjustScore(){
		header('Content-type:application/json');
		
		$point_loser = 0;		/*	Local variables	*/
		
		//try {
			/*	Input validaton	*/
			if(isset($_POST['id'])) {
				$id =  $_POST['id'];
			
				$match = Match::model()->findByPk($id);
				if($match == null){
					echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid Input - Match ID provided does not exist.")); return;
				}
				
				if(isset($_POST['scorer'])){
					$scorer = $_POST['scorer'];
					
					//If authorization fails then the program stops. It does not proceed beyond this point.
					$retval = $match->checkAuthorization($scorer);
					if($retval !== false){
						if($match->scorer == null || $match->scorer == 0){
							$match->scorer = $retval;
							$saveAttr[] = 'scorer';
						}
					} else {
						return;
					}
					
					if($match == null){
						echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Match does not exist for the ID."));
						return;
					} else {
						
						if(isset($_POST['scores'])){
						
							//$jScore = CJavaScript::jsonEncode($_POST['scores']);
							$jScore = json_encode($_POST['scores']);
							$arr = json_decode($jScore, true);
							$saveAttr = array();
							
							if(isset($arr['set'])){
							
								$sql = "SELECT MAX(set_no) as last_set FROM `set` WHERE match_id=$id";
								$command = Yii::app()->db->createCommand($sql);
								$last_set_record = $command->queryAll();
								 
								$set_no = $last_set_record[0]['last_set'];
								if ($set_no == null){	//rarely there will be a match without a set. redundant but safe.
									$set = new Set();
									$set->set_no = 1;
									$set->match_id = $id;
								} else {
									$set = Set::model()->findByAttributes(array('match_id'=>$id, 'set_no'=> $set_no));
								}
									
								try {
									$transaction=Yii::app()->getDb()->beginTransaction();
									if($set != null){
										$set->team1 = $arr['set'][0];
										$set->team2 = $arr['set'][1];
// 										$arr1 = $arr['set'];		//added by Hafizur
// 										$set->team1 = $arr1[0];
// 										$set->team2 = $arr1[1];
										
										$set->save();
										//echo CJSON::encode(array("line"=> "160", "value of set->id"=> $set->id)); return;
									}
									
									if($arr['game'] != null){
										$match->game_score1 = $arr['game'][0];
										$match->game_score2 = $arr['game'][1];
										
// 										$arr1 = $arr['game'];	//added by Hafizur											
// 										$match->game_score1 = $arr1[0];
// 										$match->game_score2 = $arr1[1];
										
										$saveAttr[] = 'game_score1';
										$saveAttr[] = 'game_score2';
										if($arr['tie-break'] !== null){
											$match->tie_break1 = $arr['tie-break'][0];
											$match->tie_break2 = $arr['tie-break'][1];
											
// 											$arr1 = $arr['tie-break'];	//added by Hafizur
// 											$match->game_score1 = $arr1[0];
// 											$match->game_score2 = $arr1[1];

											$saveAttr[] = 'tie_break1';
											$saveAttr[] = 'tie_break2';
										} else {
											$match->tie_break1 = 0;
											$match->tie_break2 = 0;
											$saveAttr[] = 'tie_break1';
											$saveAttr[] = 'tie_break2';
										}
										
										//Check if the match is over with the new adjusted score
										$match->save(false, $saveAttr);
									}
									$transaction->commit();
								} catch(Exception $ex){
									$transaction->rollback();
									echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Data save failed. Try again."));
									return;
								}
							} else {
								echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Set score points are missing from the input."));
								return;
							}
						} else {
							echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Score points are missing from the input."));
							return;
						}
					}
				} else {
					echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Scorer's username is missing."));
					return;
				}
			} else {
				echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Match ID is missing."));
				return;
			}
			//} catch(Exception $ex){
			//		echo CJSON::encode(array("success"=> "false", "reason"=> "Fatal Error: Exception in the code."));
			//}
			$score = $this->actionScore($id, true);
			echo CJSON::encode(array("success"=> "true", "score" => $score));
	}
	
	
	/*	--------------------------------------------------------------------------------------------
	 *	For Hafizur
	*	--------------------------------------------------------------------------------------------	*/
	public function actionAdjustScoreHuR(){
		header('Content-type:application/json');
	
		$point_loser = 0;		/*	Local variables	*/
	
		//try {
		/*	Input validaton	*/
		if(isset($_POST['id'])) {
			$id =  $_POST['id'];
				
			$match = Match::model()->findByPk($id);
			if($match == null){
				echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid Input - Match ID provided does not exist.")); return;
			}
	
			if(isset($_POST['scorer'])){
				$scorer = $_POST['scorer'];
					
				//If authorization fails then the program stops. It does not proceed beyond this point.
				$retval = $match->checkAuthorization($scorer);
				if($retval !== false){
					if($match->scorer == null || $match->scorer == 0){
						$match->scorer = $retval;
						$saveAttr[] = 'scorer';
					}
				} else {
					return;
				}
					
				if($match == null){
					echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Match does not exist for the ID."));
					return;
				} else {
	
					$saveAttr = array();
						
					if(isset($_POST['set1']) || isset($_POST['set2'])){
						
						$sql = "SELECT MAX(set_no) as last_set FROM `set` WHERE match_id=$id";
						$command = Yii::app()->db->createCommand($sql);
						$last_set_record = $command->queryAll();
							
						$set_no = $last_set_record[0]['last_set'];
						if ($set_no == null){	//rarely there will be a match without a set. redundant but safe.
							$set = new Set();
							$set->set_no = 1;
							$set->match_id = $id;
						} else {
							$set = Set::model()->findByAttributes(array('match_id'=>$id, 'set_no'=> $set_no));
						}
							
						try {
							$transaction=Yii::app()->getDb()->beginTransaction();
							if($set != null){
								$set->team1 = $_POST['set1'];
								$set->team2 = $_POST['set2'];
								$set->save();
								//echo CJSON::encode(array("line"=> "160", "value of set->id"=> $set->id)); return;
							}
								
							if(isset($_POST['game1']) || isset($_POST['game2'])){
								$match->game_score1 = $_POST['game1'];
								$match->game_score2 = $_POST['game2'];
								$saveAttr[] = 'game_score1';
								$saveAttr[] = 'game_score2';
								if(isset($_POST['tie-break1']) || isset($_POST['tie-break2'])){
									$match->tie_break1 = $_POST['tie-break1'];
									$match->tie_break2 = $_POST['tie-break2'];
									$saveAttr[] = 'tie_break1';
									$saveAttr[] = 'tie_break2';
								} else {
									$match->tie_break1 = 0;
									$match->tie_break2 = 0;
									$saveAttr[] = 'tie_break1';
									$saveAttr[] = 'tie_break2';
								}

								//Check if the match is over with the new adjusted score
								$match->save(false, $saveAttr);
							}
							$transaction->commit();
						} catch(Exception $ex){
							$transaction->rollback();
							echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Data save failed. Try again."));
							return;
						}
					} else {
						echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Score points are missing from the input."));
						return;
					}
				}
			} else {
				echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Scorer's username is missing."));
				return;
			}
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid input: Match ID is missing."));
			return;
		}
		//} catch(Exception $ex){
		//		echo CJSON::encode(array("success"=> "false", "reason"=> "Fatal Error: Exception in the code."));
		//}
		$score = $this->actionScore($id, true);
		echo CJSON::encode(array("success"=> "true", "score" => $score));
	}
	
	/*	--------------------------------------------------------------------------------------------
	 *	Update scores into the DB using this web-services. wsUpdateMatchScore
	*	--------------------------------------------------------------------------------------------	*/
	public function actionUpdateScore(){
		header('Content-type:application/json');
		
		/*	Local variables	*/
		$point_winner = 0;
		
		/*	Input validaton	*/
		if(isset($_POST['id'])){
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
		$retval = $match->checkAuthorization($scorer);
		if($retval !== false){
			if($match->scorer == null || $match->scorer == 0){
				$match->scorer = $retval;
			}
		} else {
			return;
		}
		$category = Category::model()->findByAttributes(array('tour_id'=>$match->tour_id, 'category'=>$match->category));
		
		
		/*	Up score by 1 for the player who got the point */
		if($match->game_score1 == 40 && $match->game_score2 == 40){	//tie-break
					
			if($point_winner == 1){
				$tie_break_diff =  $match->tie_break1 - $match->tie_break2;
				$winner_tie_break_points = $match->tie_break1;
			} else {
				$tie_break_diff =  $match->tie_break2 - $match->tie_break1;
				$winner_tie_break_points = $match->tie_break2;
			}

			if($category->tie_breaker == Match::TIE_BREAK_RULE_SINGLE)
				$max_tie_break_point = 0;
			else
				$max_tie_break_point = 6;
				$flag = ($tie_break_diff > 2) && ($winner_tie_break_points >= $max_tie_break_point);
		
			if(($tie_break_diff > 2) && ($winner_tie_break_points >= $max_tie_break_point)){
				$match->game_score1 = 0;				//	game over reset everything
				$match->game_score2 = 0;
				$match->tie_break1 = 0;
				$match->tie_break2 = 0;
				$game_over = true;
			} else {					
				if($point_winner == 1)			//	Update the tie-break score
					$match->tie_break1 = $match->tie_break1 + 1;
				else
					$match->tie_break2 = $match->tie_break2 + 1;
				
				$game_over = false;
			}

		} else {							// end of tie-break condition
			
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
		$last_set_no = Set::model()->count('match_id=:match_id', array(':match_id'=>$id));
			
		if ($last_set_no == 0){		//Initial condition
			try {
				$set = new Set();
				$set->match_id = $id;
				$set->set_no = 1;
				$set->team1 = 0;
				$set->team2 = 0;
				$set->save();
			} catch(Exception $ex){
				echo CJSON::encode(array("success"=> "false", "reason" => "Fatal Error: New set creation failed."));
				return;
			}
		} else {
			// fetch the last set
			$set = Set::model()->findByAttributes(array('match_id'=>$id, 'set_no'=> $last_set_no));		
		}
	

		//	Check the game end condition
		if($game_over){
			//	Keep the max set score ready (4 for mini-sets, 8 for best-of-15, 6 for regular sets)
			$max_set_score = $category->score_type == Match::SCORE_RULE_15_GAMES
								? 8 : (Match::SCORE_RULE_3_MINISETS
									? 4 : 6);
			
			
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
			
			if($set_over){
				try {
					$nset = new Set();
					$nset->match_id = $id;
					$nset->set_no = $set->set_no + 1;
					$nset->team1 = 0;
					$nset->team2 = 0;
					$nset->save();
				} catch(Exception $ex){
					echo CJSON::encode(array("success"=> "false", "reason" => "Fatal Error: New set creation failed."));
					return;
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
				$match->save(false, array('game_score1', 'game_score2', 'winner', 'tie_break1', 'tie_break2', 'scorer'));
			else
				$match->save(false, array('game_score1', 'game_score2', 'tie_break1', 'tie_break2', 'scorer'));
			
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

		$score = $this->actionScore($id, true);
		echo CJSON::encode(array("success"=> "true", "score" => $score));
		
	}


	/*	--------------------------------------------------------------------------------------------
	 *	Offer walkover to one of the players of user's choice
	 *	Input format in POST
	 *		{	"id": "id_value",	"winner": "winner_value"	}
	 *	Result
	 *		{"success": "true"} or {"success": "false", "reason": "reason text"}
	 *
	*	--------------------------------------------------------------------------------------------*/
	public function actionWalkover()
	{
		header('Content-type:application/json');
		
		if(isset($_POST['id'])){
			$id =  $_POST['id'];
			$match = Match::model()->findByPk($id);
		
			if($match != null){
				if($match->winner != 1 && $match->winner != 2){
					if(isset($_POST['winner'])){
						$winning_team =  $_POST['winner'];
						if($winning_team == 1 || $winning_team == 2) {
							$match->winner = $winning_team;
							$match->save(false, array('winner'));
							$match->promoteWinner();
							echo CJSON::encode(array("success"=> "true"));
						} else {
							echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Invalid team number. Should either be 1 or 2."));
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
		} else {
			echo CJSON::encode(array("success"=> "false", "reason" => "Input Error: Match ID has not been provided."));
		}
	}
	

	/*	--------------------------------------------------------------------------------------------
	 *	Displays a particular model. This view is for the owner role.
	 *		@param integer $id the ID of the model to be displayed
	 *	Input format: Match ID as GET param
	 *	Output format:
 	 *		[{ "id": "value", "match_id": "value", "team1": "value", "team2": "value" }, { .. }]
	 *	--------------------------------------------------------------------------------------------*/
	public function actionSetScore($id, $return = false)
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
		
		$modelAttributeNames = 'id, set_no, match_id, team1, team2';	
		if($return){
			return 	Yii::app()->common->renderJson($dataProvider->getData(), $modelAttributeNames );
		} else {
			header('Content-type:application/json');
			echo Yii::app()->common->renderJson($dataProvider->getData(), $modelAttributeNames );
		}
	}
	
	/*	--------------------------------------------------------------------------------------------
	 *	Specially made for JSON output
	 *	Input format: Match ID as GET param
	 *	Output format:
	 *		{ "id": "value", "match_id": "value", "team1": "value", "team2": "value" }
	 *	--------------------------------------------------------------------------------------------*/
	public function actionGameScore($id, $return = false)
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
	
	
	/*	--------------------------------------------------------------------------------------------
	 * 
	 */
	public function actionScore($id, $return = false){
		$set = json_decode($this->actionSetScore($id, true));
		$game = json_decode($this->actionGameScore($id, true));
		
		/* $retval = new stdClass();
		$retval->id = $id;
		$retval->set = $set;
		$retval->game = $game;
		*/
		
		$retval = array();
		$retval['id'] = $id;
		$retval['set'] = $set;
		$retval['game'] = $game;
		
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
		
		$target_match = $this->loadModel($target_id);	// @todo @risky
		
		if($target_match->player11 == null){
			$target_match->player11 = $pid;
		} else {
			$target_match->player11 = $pid;
		}
		$target_match->save(false, array('player11', 'player21'));

		$this->redirect(Yii::app()->request->urlReferrer);
	}
	
	/*
	 * 30/7/2015
	 * This function is called by ajax methods to update a named field of Match object
	 * Input format -  {"id":<match id>,
	 * 					"data": {<property1>:<value1>, ..., <propertyN>:<valueN>}
	 * 				   }
	 * Currently supported for start_date and court_no. 
	 */
	public function actionUpdate(){
		header('Content-type:application/json');
		
		if(isset($_POST['id'])){
			$id = $_POST['id'];
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Match identifier has not been supplied."));
			//echo "Match identifier has not been supplied";
			return;
		}
		
		$match = Match::model()->findByPk($id);
		if($match == null){
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error:Match ID supplied is invalid."));
			return;	
		} 
		
		if(isset($_POST['data'])){
			$field_names = array();
			foreach($_POST['data'] as $var=>$value) {
				if($match->hasAttribute($var)){
					$match->$var = $value;
					$field_names[] = $var;
				} else
					$this->_sendResponse(500,
							sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var,
									$_GET['model']) );
			}
			echo CJSON::encode(array("match start date is " . $match->start_date));
		} else {
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: There is nothing to update."));
			return;
		}
		
		$match->save(false, $field_names);
		
		if($match->errors){
			echo CJSON::encode(array("success"=> "false", "reason"=> "Error: Saving validation errors."));
		} else {
			echo CJSON::encode(array("success"=> "true", "message"=> "The match has been updated"));
		}
	}
	
// 	/*	--------------------------------------------------------------------------------------------
// 	* returns false if authorization fails. Else returns the contact->id of the pScorer 			*
// 	*	--------------------------------------------------------------------------------------------*/
// 	private function checkAuthorization($pMatch, $pScorer){
// 		try {
// 			$tour_organization = Tour::model()->findByPk($pMatch->tour_id)->org_id;
// 			$user = YumUser::model()->findByAttributes(array('username'=>$pScorer));
// 			if($user == null){
// 				echo CJSON::encode(array("success"=> "false", "reason" => "Input Error: The scorer's username is invalid."));
// 				return false;
// 			}
// 			$contact = Contact::model()->findByAttributes(array('user_id' => $user->id));
// 			$contact_organization = $contact->org_id;
// 			if($tour_organization != $contact_organization){
// 				echo CJSON::encode(array("success"=> "false", "reason" => "Error: Not authorized to modify the scores."));
// 				return false;
// 			} else {
// 				if($pMatch->scorer != null){
// 					if($contact->id != $pMatch->scorer) {
// 						echo CJSON::encode(array("success"=> "false", "reason" => "Error: This match is assigned to another colleague. You cannot keep score for it."));
// 						return false;
// 					} else {
// 						return $contact->id;
// 					}
// 				} else {
// 					return $contact->id;
// 				}
// 			}
	
// // 		if(!Yii::app()->user->isTourOwner($match->tour_id)){
// // 			echo 'Error: Unauthorized access. Match does not belong to the user organization.';
// // 			return;			//	Unauthorized access
// // 		}

// 		} catch (Exception $ex) {
// 			echo CJSON::encode(array("success"=> "false", "reason" => "Fatal Error: Data integrity problem. Please report to admin with error code 946700."));
// 			return false;
// 		}
//	}

}