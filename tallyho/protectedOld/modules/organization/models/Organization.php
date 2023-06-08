<?php
/**
 * This is the model class for table "organization".
 *
 * The followings are the available columns in table 'organization':
 * @property integer $id
 * @property string $name
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $city
 * @property integer $state
 * @property integer $postal_code
 * @property string telephone
 * @property string $logo
 * @property integer $admin_id
 * 
 * The followings are the available model relations:
 * @property Tour[] $tours
 */
class Organization extends CActiveRecord
{
	public $logo_file;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'organization';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address_line_1, address_line_2, city, state, postal_code, admin_id', 'required'),
			array('state, admin_id', 'numerical', 'integerOnly'=>true),
			array('name, address_line_1, address_line_2, city', 'length', 'max'=>45),
			array('telephone, postal_code', 'length', 'max'=>12),
			array('logo_file', 'file', 'allowEmpty'=>true, 'types'=>'jpg, gif, png', 'safe' => false),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, address_line_1, address_line_2, city, state, postal_code, main_contact, telephone, logo, admin_id',
						'safe', 'on'=>'search'),
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
			'tours' => array(self::HAS_MANY, 'Tour', 'org_id'),
			'staff' => array(self::MANY_MANY, 'YumUser', 'org_user(org_id, user_id)'),
			'members' => array(self::HAS_MANY, 'Membership', 'org_id'),
			'administrator' => array(self::BELONGS_TO, 'YumUser', 'admin_id')
		);
		
	}
	
// MUBI: Read about this method in a forum discussion. Does not work here. Throws CbException.
// 	public function defaultScope()
// 	{
// 		return array(
// 				'condition'=>'user_id='.Yii::app()->user->id,
// 		);
// 	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'address_line_1' => 'Address Line1',
			'address_line_2' => 'Address Line2',
			'city' => 'City',
			'state' => 'State',
			'postal_code' => 'Postal Code',
			'telephone' => 'Telephone',
			'admin_id' => 'Administrator',
			'logo' => 'Logo',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address_line_1',$this->address_line_1,true);
		$criteria->compare('address_line_2',$this->address_line_2,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('postal_code',$this->postal_code);
		$criteria->compare('telephone',$this->telephone);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Organization the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
