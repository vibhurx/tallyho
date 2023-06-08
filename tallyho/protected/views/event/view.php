<?php
/* @var $this HostController */
/* @var $model Host */

$levelText = Lookup::item('EventLevel', $model->level);

$this->breadcrumbs=array(
	'Events'=>array('event/index'),
	$levelText.'/'.$model->organizer->name.'/'.$model->location,
);

//$userType = Yii::app()->user->isGuest? -1 : Yii::app()->user->data()->type;

$this->menu = array(
	array('label'=>'List Player', 'url'=>array('index')),
	array('label'=>'Manage Player', 'url'=>array('admin')),);

$allowEnrol = $model->status <= Event::STATUS_INVITING;
$allowEnrolFor = $isEventManager;
$enrolOpen   = $model->status <= Event::STATUS_INVITING;

?>

<h1><?php echo $model->organizer->name ?>, <?php echo $model->location; ?></h1>

<?php 
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'location',
		array('name' => 'level', 'type' => 'raw', 'value' => CHtml::link($levelText, array('//category/index','eid'=>$model->id))),
		'start_date',
		'enrolby_date',
		'referee',
		array('name' => 'court_type', 'value' => Lookup::item('CourtType', $model->court_type)),
		array('name' => 'status', 'value' =>  Lookup::item('EventStatus', $model->status) ),
		array('name' => 'org_id', 'value' => $model->organizer->name),

	),
)); 
?>

