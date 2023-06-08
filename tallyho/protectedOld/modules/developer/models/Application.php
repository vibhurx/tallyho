<?php

/**
 * This is the model class for table "application".
 *
 * The followings are the available columns in table 'application':
 * @property string $id
 * @property integer developer_id
 * @property string $description
 * @property string $secret_key
 * @property integer $type
 * @property string $start_date
 * @property string $end_date
 * @property integer $active_flag
 */
class Application extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'application';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, developer_id, description, secret_key, type, start_date', 'required'),
			array('developer_id, type, active_flag', 'numerical', 'integerOnly'=>true),
			array('id, secret_key', 'length', 'max'=>36),
			array('description', 'length', 'max'=>128),
			array('end_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, developer_id, description, secret_key, type, start_date, end_date, active_flag', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'developer_id' => 'Developer ID',
			'description' => 'Description',
			'secret_key' => 'Secret Key',
			'type' => 'Type',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'active_flag' => 'Active Flag',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('developer_id',$this->developer_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('secret_key',$this->secret_key,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('active_flag',$this->active_flag);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Application the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
