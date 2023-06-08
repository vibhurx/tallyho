<?php

/**
 * This is the model class for table "membership".
 *
 * The followings are the available columns in table 'membership':
 * @property integer $id
 * @property integer $player_id
 * @property integer $org_id
 * @property string $regn_no
 * @property integer $rank
 * @property integer $points
 * @property string $since
 */
class Membership extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'membership';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('player_id, org_id', 'required'),
			array('player_id, org_id, rank, points', 'numerical', 'integerOnly'=>true),
			array('regn_no', 'length', 'max'=>12),
			array('since', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, player_id, org_id, regn_no, rank, points, since', 'safe', 'on'=>'search'),
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
			'organization' => array(self::BELONGS_TO, 'Organization', 'org_id'),
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
			'player_id' => 'Player',
			'org_id' => 'Org',
			'regn_no' => 'Regn No',
			'rank' => 'Rank',
			'points' => 'Points',
			'since' => 'Since',
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
		$criteria->compare('player_id',$this->player_id);
		$criteria->compare('org_id',$this->org_id);
		$criteria->compare('regn_no',$this->regn_no,true);
		$criteria->compare('rank',$this->rank);
		$criteria->compare('points',$this->points);
		$criteria->compare('since',$this->since,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Membership the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function isMember($org_id, $player_id){
		$membership = Membership::model()->findByAttributes(array(
			'org_id' => $org_id,
			'player_id' => $player_id,
		));
		return ($membership != null);
	}
}
