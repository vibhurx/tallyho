<?php
/* @var $this HostController */
/* @var $model Host */

$this->breadcrumbs=array(
	'Tours'=>array('index'),
	$model->id,
);

$userType = Yii::app()->user->isGuest? -1 : Yii::app()->user->data()->type;

$this->menu=array();

$allowEnrol = $model->status <= Tour::STATUS_INVITING && Yii::app()->user->data()->type != YumUser::TYPE_CONTACT;
$allowEnrolFor = $isTourOwner;
$enrolOpen   = $model->status <= Tour::STATUS_INVITING;

?>

<h1>Tournament at <?php echo $model->location; ?></h1>

<?php 
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'location',
		array('name' => 'level', 'value' => Lookup::item('TourLevel', $model->level)),
		'start_date',
		'enrol_by_date',
		'referee',
		array('name' => 'court_type', 'value' => Lookup::item('CourtType', $model->court_type)),
		array('name' => 'status', 'value' => Lookup::item('TourStatus', $model->status)),
		array('name' => 'org_id', 'value' => $model->organization->name),
	),
)); 
?>

 <?php 
 $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
 	'selectableRows'=>1,
	'selectionChanged'=>'function(id){location.href= "' . $this->createUrl('../participant/draw/view') . '/cid/"+$.fn.yiiGridView.getSelection(id);}',
	'columns'=>array(
		//'id',	
		//'tour_id',
		array('name' => 'category', 'value' => 'Lookup::item("AgeGroup", $data->category)'),
		array('name'=>'draw_status', 
				'value'=>'Lookup::item("DrawStatus",$data->draw_status)',
				'visible' => !$isTourOwner),
		array('name'=>'draw_status',
				'type'=> 'raw',
				'value' => 'CHtml::link(Lookup::item("DrawStatus", $data->draw_status),
										array("//participant/draw/index/cid/" . $data->id))',
				'htmlOptions' => array('style' => 'text-align:center'),
				'visible' => $isTourOwner,),
		array('name'=>'Action',
				'type'=> 'raw',
				'value' => 'CHtml::link("Enrol", array("//participant/enrol/create/cid/" . $data->id))',
				'htmlOptions' => array('style' => 'text-align:center'),
				'visible' => $allowEnrol,),
		array('name'=>'Action',
				'type'=> 'raw',
				'value' => 'CHtml::link("Enrol For", array("//participant/enrol/createFor/cid/" . $data->id))',
				'htmlOptions' => array('style' => 'text-align:center'),
				'visible' => $allowEnrolFor,),
		array('name'=>'Info',
				'type' => 'raw',
				'value' => '"Enrolment closed"',
				'htmlOptions' => array('style' => 'text-align:center'),
				'visible'=> !$enrolOpen,),
// 		array( 'header'=>'Manage',
// 				'class'=>'CDataColumn',
// 				'type' => 'raw',
// 				'value' => 'CHtml::link("Enrollments", array("//participant/draw/index/cid/" . $data->id))',
// 				'visible'=>  $isTourOwner,
// 				'htmlOptions' => array('style' => 'text-align:center'),
// 		),
	),
)); 
?>
