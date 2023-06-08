<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property string $id
 * @property integer $category
 * @property integer $event_id
 * @property date start_date 	-- added on 03/06/2015
 * @property integer $draw_status
 * @property interger $tie_breaker	0-single-point, 1-regular
 * @property integer mdraw_size
 * @property integer mdraw_direct
 * @property integer qdraw_levels
 * @property integer score_type		1-best of 15, 2-best of 3 mini-sets, 3-best of 3 sets, 4-best of 5 sets
 * @property integer member_fee		//250 for AITA type
 * @property integer others_fee		//500 for AITA type
 *
 * The followings are the available model relations:
 * @property Event $event
 */
class Category extends CActiveRecord
{
	const STATUS_NOT_PREPARED = 0;
	const STATUS_SEEDED = 1;
	const STATUS_PREPARED = 2;
	const STATUS_FROZEN = 3;
	
	const MAX_WILD_CARD = 4;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category, event_id, start_date, is_paid, is_aita', 'required'),
			array('category, event_id, draw_status, mdraw_size, qdraw_levels, mdraw_direct, tie_breaker, 
					score_type, member_fee, others_fee', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, category, event_id, draw_status, mdraw_size, qdraw_levels', 'safe', 'on'=>'search'),
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
			'event_id' => 'Event',
			'start_date' => 'Start Date',
			'draw_status' => 'Draw Status',
			'mdraw_size' => 'Draw Size',
			'qdraw_levels' => 'No of Qualifying Rounds',
			'mdraw_direct' => 'Main\'s Entries',
			'score_type' => 'Scoring Rule',
			'tie_breaker' => 'Tie Breaker Rule',
			'member_fee' => 'Fee (members)',
			'others_fee' => 'Fee (others)',
			'is_paid' => 'Enrollment Fee?',
			'is_aita' => 'Is AITA Regulated?',
		);
	}

	private $cachedEventId, $cachedCategoryCode;
	
	public function beforeDelete()
	{
		$this->cachedEventId = $this->event_id;
		$this->cachedCategoryCode = $this->category;
		return parent::beforeDelete();
	}
	
	public function afterDelete()
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition("event_id=:event_id AND category=:category");
		$enrolments = Enrolment::model()->findAll(array(
				'condition' => 'event_id=:event_id AND category=:category',
				'params' => array(':event_id'=>$this->cachedEventId, ':category'=>$this->cachedCategoryCode)));
	
		foreach($enrolments as $enrolment){
			$enrolment->delete();
		}
	
		parent::afterDelete();
	}
	
	public function deleteMatches(){
		
		// $matches = Match::model()->findAllByAttributes(
		// 		array(),
		// 		$criteria = 'event_id=:event_id AND category=:category',
		// 		$params = array(':event_id'=>$this->event_id, ':category'=>$this->category),
		// 	);
			
		// foreach($matches as $item)
		// 	$item->delete($item->id);
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
		$criteria->compare('category',$this->category);
		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('draw_status',$this->draw_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
