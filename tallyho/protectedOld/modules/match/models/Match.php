<?php

/**
 * This is the model class for table "match".
 *
 * The followings are the available columns in table 'match':
 * @property integer $id
 * @property integer $level
 * @property integer $sequence
 * @property integer $start_date
 * @property integer $player11
 * @property integer $player12
 * @property integer $player21
 * @property integer $player22
 * @property integer $winner
 * @property integer $tour_id
 * @property integer $category
 * @property integer $scorer => contact->id
 *
 * The followings are the available model relations:
 * @property Set[] $sets
 */
class Match extends CActiveRecord
{
	const USER_VIEWER = 0;
	const USER_SCORER = 1;
	
	const SCORE_RULE_15_GAMES = 1;
	const SCORE_RULE_3_MINISETS = 2;
	const SCORE_RULE_3_SETS = 3;
	const SCORE_RULE_5_SETS = 4;
	
	const TIE_BREAK_RULE_SINGLE = 0;
	const TIE_BREAK_RULE_REGULAR = 1;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'match';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('level, sequence, tour_id, category', 'required'),
			array('level, sequence, player11, player12, player21, player22, winner, tour_id, category', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, level, sequence, player11, player12, player21, player22, winner, tour_id, category', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'sets' => array(self::HAS_MANY, 'Set', 'match_id'),
			'participant11' => array(self::BELONGS_TO, 'Participant', 'player11'),
 			'participant21' => array(self::BELONGS_TO, 'Participant', 'player21'),
 			'participant12' => array(self::BELONGS_TO, 'Participant', 'player12'),
 			'participant22' => array(self::BELONGS_TO, 'Participant', 'player22'),
			'tour' => array(self::BELONGS_TO, 'Tour', 'tour_id'),
			//'umpire' => array(self::BELONGS_TO, 'Contact', 'scorer'),
					
// 			'category' => array(self::BELONGS_TO, 'Category', 'category'),
// 			'participants' => array(self::HAS_MANY, 'Participant', 'match_id'),
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'level' => 'Level',
			'sequence' => 'Sequence',
			'start_date' => 'Start Date/Time',
			'player11' => 'Team1 Player1',
			'player12' => 'Team1 Player2',
			'player21' => 'Team2 Player1',
			'player22' => 'Team2 Player2',
			'winner'   => 'Winner',
			'tour_id'  => 'Tour',
			'category' => 'Category',
			'scorer'   => 'Chair Umpire',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('level',$this->level);
		$criteria->compare('sequence',$this->sequence);
		$criteria->compare('player11',$this->player11);
		$criteria->compare('player12',$this->player12);
		$criteria->compare('player21',$this->player21);
		$criteria->compare('player22',$this->player22);
		$criteria->compare('winner',$this->winner);
		$criteria->compare('tour_id',$this->tour_id);
		$criteria->compare('category',$this->category);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Match the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getIsMatchOver(){
		return $this->winner >= 1 && $this->winner <= 2;
	}

	/**	----------------------------------------------------------------------------------------------
	 * Promote the winning team to the next round. This is a temporary arrangement. Winning event
	 * should be thrown and caught by the category object, which in turn, would make a db update
	 * 
	 * @param unknown $pMatchId
	 * @return boolean
	 *	----------------------------------------------------------------------------------------------*/
	public function promoteWinner(){
			
		if($this->winner == null || $this->winner == 0) {
			return false;
		}
			
		$category = Category::model()->findByAttributes(array('tour_id'=>$this->tour_id, 'category'=> $this->category));
		$category_mlevels = log($category->mdraw_size)/log(2);
		$max_level = $this->level > 0 ? log($category->mdraw_size)/log(2): $category->qlevels;
	
		if($this->level == $max_level)
			return true;
			
		$draw_size = $this->level > 0 ? $category->mdraw_size : $category->qdraw_size;
			
		$new_seq = $draw_size/2 + ($this->sequence + $this->sequence%2)/2;	//Sequence is assigned per match, i.e, to every 2 players
			
		if($this->level > 0){
			$next_match = Match::model()->findByAttributes(array(
					'tour_id'=>$this->tour_id, 'category'=> $this->category, 'sequence'=>$new_seq));
		} elseif($this->level == 0) { //no round of qualifying left, and player must move to main draw so do nothing
			; //do nothing
		} elseif($this->level < 0){ //1 round of qualifying left, move to next round of qualifying
			$next_match = Match::model()->findByAttributes(array(
					'tour_id'=>$this->tour_id, 'category'=> $this->category, 'sequence'=>$new_seq, 'level'=>'0'));
		}
			
		if($this->sequence%2 == 1)
			$next_match->player11 = $this->winner == 1? $this->player11 : $this->player21;
		else
			$next_match->player21 = $this->winner == 1? $this->player11 : $this->player21;
			
		$next_match->save(false, array('player11', 'player21'));
			
		return true;
	}


	/*	--------------------------------------------------------------------------------------------
	 * returns false if authorization fails. Else returns the contact->id of the pUsername 			*
	*	--------------------------------------------------------------------------------------------*/
	public function checkAuthorization($pUsername){
		try {
			$tour_organization = Tour::model()->findByPk($this->tour_id)->org_id;
			$user = YumUser::model()->findByAttributes(array('username'=>$pUsername));
			if($user == null){
				echo CJSON::encode(array("success"=> "false", "reason" => "Input Error: The scorer's username is invalid."));
				return false;
			}
			$contact = Contact::model()->findByAttributes(array('user_id' => $user->id));
			$contact_organization = $contact->org_id;
			if($tour_organization != $contact_organization){
				echo CJSON::encode(array("success"=> "false", "reason" => "Error: Not authorized to modify the scores."));
				return false;
			} else {
				if($this->scorer != null){
					if($contact->id != $this->scorer) {
						echo CJSON::encode(array("success"=> "false", "reason" => "Error: This match is assigned to another colleague. You cannot keep score for it."));
						return false;
					} else {
						return $contact->id;
					}
				} else {
					return $contact->id;
				}
			}
		} catch (Exception $ex) {
			echo CJSON::encode(array("success"=> "false", "reason" => "Fatal Error: Data integrity problem. Please report to admin with error code 946700."));
			return false;
		}
	}
}