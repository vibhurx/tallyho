<?php

/**
 * This is the model class for table "player".
 *
 * The followings are the available columns in table 'player':
 * @property string $id
 * @property string $user_id
 * @property string $aita_no
 * @property integer $aita_points
 * @property integer $gender
 * @property string $date_of_birth
 *
 * The followings are the available model relations:
 * @property Participant[] $participants
 */
class Player extends CActiveRecord
{
// 	public $picture_file;
	
	//@todo - the user types should not be in the Player model. Remove it later.
// 	const TYPE_ADMIN=0; 
// 	const TYPE_PLAYER=1; 
// 	const TYPE_ORGANIZATION=2;
// 	const TYPE_EMPLOYEE=3;
	
	const GENDER_BOY=1;
	const GENDER_GIRL=2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'player';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gender, date_of_birth', 'required'),
			array('aita_points, gender', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>10),
			array('aita_no', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('picture_file', 'file', 'allowEmpty'=>true, 'types'=>'jpg, gif, png', 'safe' => false),
			array('id, user_id, aita_no, aita_points, state, gender, date_of_birth', 'safe', 'on'=>'search'),
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
			'participants' => array(self::HAS_MANY, 'Participant', 'player_id'),
			'user' => array(self::HAS_ONE, 'YumProfile', 'user_id'), //this.pk (id) == YumProfile.email
			'membership' => array(self::HAS_MANY, 'Membership', 'player_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Player ID',
			'user_id' => 'User ID',
			'aita_no' => 'Aita No',
			'aita_points' => 'Aita Points',
			'gender' => 'Gender',
			'date_of_birth' => 'Date Of Birth',
		);
	}

// 	public function getFullName() {
// 		return  $this->given_name . ' ' .  $this->family_name;
// 	}

// 	public function getShortName() {
// 		return $this->given_name . ' ' . substr($this->family_name, 0, 1) . '.' ;
// 	}
	
// 	public function getTruncName(){
// 		if((strlen($this->getFullName())) > 12)
// 			return substr($this->getFullName(),0,10) . '...';
// 		else
// 			return $this->getFullName();
// 	}
	
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
		$criteria->compare('aita_no',$this->aita_no,true);
		$criteria->compare('aita_points',$this->aita_points);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('date_of_birth',$this->date_of_birth,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

// 	protected function beforeSave(){
// // 		if(parent::beforeSave()) {
// // 			$this->date_of_birth = date_format(date_create_from_format('d/m/Y',$this->date_of_birth), 'Y-m-d');
// // 		}
// // 		return true;
// 	}
		
// 	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Player the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
