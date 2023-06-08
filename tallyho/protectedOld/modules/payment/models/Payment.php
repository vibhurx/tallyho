<?php

/**
 * This is the model class for table "payment".
 *
 * The followings are the available columns in table 'payment':
 * @property integer $id
 * @property integer $player_id
 * @property integer $participant_id
 * @property string $entry_date
 * @property string $amount
 * @property integer $direction
 * @property integer $mode
 * @property string $free_text
 */
class Payment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('player_id, participant_id, entry_date, mode', 'required'),
			array('player_id, participant_id, direction, mode', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>6),
			array('free_text', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, player_id, participant_id, entry_date, amount, direction, mode, free_text', 'safe', 'on'=>'search'),
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
			'participant' => array(self::BELONGS_TO, 'Participant', 'participant_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'player_id' => 'Player ID',
			'participant_id' => 'Participation Ref',
			'entry_date' => 'Entry Date',
			'amount' => 'Amount (INR)',
			'mode' => 'Paid vide',
			'direction' => 'Cr/De',
			'free_text' => 'Notes'		);
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
		$criteria->compare('participant_id',$this->participant_id);
		$criteria->compare('entry_date',$this->entry_date,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('direction',$this->direction);
		$criteria->compare('mode',$this->mode);
		$criteria->compare('free_text',$this->free_text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Payment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
