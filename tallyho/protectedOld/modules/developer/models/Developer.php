<?php

/**
 * This is the model class for table "developer".
 *
 * The followings are the available columns in table 'developer':
 * @property integer $id
 * @property integer $user_id
 * @property string $given_name
 * @property string $family_name
 * @property string $company_name
 * @property string $email
 * @property string $phone
 */
class Developer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'developer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, given_name, family_name, email', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('given_name, family_name', 'length', 'max'=>32),
			array('company_name', 'length', 'max'=>64),
			array('email', 'length', 'max'=>250),
			array('phone', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, given_name, family_name, company_name, email, phone', 'safe', 'on'=>'search'),
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
				'applications' => array(self::HAS_MANY, 'Application', 'developer_id'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'given_name' => 'Given Name',
			'family_name' => 'Family Name',
			'company_name' => 'Company Name',
			'email' => 'Email',
			'phone' => 'Phone',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('given_name',$this->given_name,true);
		$criteria->compare('family_name',$this->family_name,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Developer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getFullName() {
		return  $this->given_name . ' ' .  $this->family_name;
	}
	
	
}
