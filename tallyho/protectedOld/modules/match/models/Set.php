<?php

/**
 * This is the model class for table "set".
 *
 * The followings are the available columns in table 'set':
 * @property integer $id
 * @property integer $set_no
 * @property integer team1
 * @property integer team2
 * @property integer $match_id
 *
 * The followings are the available model relations:
 * @property Match $match
 */
class Set extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'set';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('set_no, match_id', 'required'),
			array('set_no, team1, team2, match_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, set_no, team1, team2, match_id', 'safe', 'on'=>'search'),
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
			'match' => array(self::BELONGS_TO, 'Match', 'match_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'set_no' => 'Set No',
			'team1' => 'Score Team1',
			'team2' => 'Score Team2',
			'match_id' => 'Match',
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
		$criteria->compare('set_no',$this->set_no);
		$criteria->compare('team1',$this->team1);
		$criteria->compare('team2',$this->team2);
		$criteria->compare('match_id',$this->match_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Set the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
