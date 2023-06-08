<?php

/**
 * This is the model class for table "enrolment".
 *
 * The followings are the available columns in table 'enrolment':
 * @property integer $id	//a running number (auto increment)
 * @property integer $category	//the unique category ID across all the tournaments
 * @property string $player_id
 *
 * The followings are the available model relations:
 * @property Match $category
 * @property Player $player
 * @property Seed $seed
 * @property Wildcard $wild_card
 */
class Enrolment extends CActiveRecord
{
	const MAX_POSSIBLE_SEED = 999;
	const MAX_POSSIBLE_POINTS = 9999999999; //100 billion - 1 large enough for practical purposes
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'enrolment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, category, player_id', 'required'),
			array('event_id, category, player_id, seed, wild_card', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_id, category, player_id, seed, wild_card', 'safe', 'on'=>'search'),
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
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'player' => array(self::BELONGS_TO, 'Player', 'player_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category' => 'Category',
			'player_id' => 'Player ID',
			'event_id' => 'Tournament ID',
			'seed' => 'Seed',
			'wild_card' => 'Wildcard',
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

		$criteria->compare('id', $this->id);
		$criteria->compare('event_id', $this->event_id);
		$criteria->compare('category', $this->category);
		$criteria->compare('player_id',	$this->player_id, true);
		$criteria->compare('wild_card',	$this->wild_card, true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Enrolment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
