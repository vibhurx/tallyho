<?php

/**
 * This is the model class for table "tour".
 *
 * The followings are the available columns in table 'tour':
 * @property integer $id
 * @property string $location
 * @property integer $level
 * @property date $start_date
 * @property interger $type
 * @property date $enrolby_date
 * @property string $referee
 * @property integer $court_type
 * @property integer $status
 * @property integer $org_id
 * @property interger $no_courts
 * @property interger $type
 *
 *
 * The followings are the available model relations:
 * @property Category[] $categories
 * @property Organization $org
 */
class Tour extends CActiveRecord
{
	const STATUS_DRAFT = 1;
	const STATUS_INVITING = 2;
	const STATUS_UPCOMING = 3;
	const STATUS_ONGOING = 4;
	const STATUS_OVER = 5;
	
	const TYPE_ALL_PAID = 1;
	const TYPE_ALL_FREE = 2;
	const TYPE_SOME_FREE = 3;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tour';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('location, level, start_date, enrolby_date, court_type, org_id, type, is_aita', 'required'),
			array('level, court_type, org_id, status, no_courts, type', 'numerical', 'integerOnly'=>true),
			array('location, referee', 'length', 'max'=>45),
			//array('start_date, enrolby_date', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, location, level, start_date, enrolby_date, referee, court_type, org_id, type', 'safe', 'on'=>'search'),
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
			'categories' => array(self::HAS_MANY, 'Category', 'tour_id'),
			'organization' => array(self::BELONGS_TO, 'Organization', 'org_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'location' => 'Location',
			'level' => 'Level',
			'start_date' => 'Start Date',
			'is_aita' => 'Is AITA Regulated',
			'enrolby_date' => 'Enrol by Date',
			'referee' => 'Referee',
			'court_type' => 'Court Type',
			'no_courts' => 'No Courts',
			'org_id' => 'Organization ID',
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
		$criteria->compare('location',$this->location,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('enrolby_date',$this->enrolby_date,true);
		$criteria->compare('referee',$this->referee,true);
		$criteria->compare('court_type',$this->court_type);
		$criteria->compare('org_id',$this->org_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tour the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
// 	protected function afterConstruct() {
// 		if(parent::afterConstruct()) {
// 			$this->start_date = '16/01/1971';//date_format(date_create($this->start_date), 'd/m/Y');
// 			$this->enrolby_date = date_format(date_create($this->enrolby_date), 'd/m/Y');
// 		}
// 		return true;
// 	}
	
// 	protected function beforeSave(){
// 		if(parent::beforeSave()) {
// 			$this->start_date = date_format(date_create_from_format('d/m/Y',$this->start_date), 'Y-m-d');
// 			$this->enrolby_date = date_format(date_create_from_format('d/m/Y',$this->enrolby_date), 'Y-m-d');
// 		}
// 		return true;
// 	}
}
