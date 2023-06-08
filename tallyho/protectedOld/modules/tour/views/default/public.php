<?php
/* @var $this PlayerController */
/* @var $dataProvider CActiveDataProvider */
/* @var $this DefaultController */

$this->pageTitle=Yii::app()->name . ' - Events';
$this->header01 = "Events";
$this->backLink = null;
?>
<?php
// $this->widget('zii.widgets.grid.CGridView', array(
// 		'dataProvider'=>$dataProvider,
// 		'columns'=>array(
// 			array('name'=> 'location',
// 				'type'=>'raw', 
// 				'value'=>'CHtml::link($data->location, array("default/view", "id"=>$data->id))'),
// 			array(	'name' => 'Level', 'value' => 'Lookup::item("TourLevel", $data->level)'),
// 			array(	'name'=>'start_date',
// 				'value'=>'date("d M Y", strtotime($data->start_date))',),
// 			array(	'name'=>'enrolby_date',
// 				'value'=>'date("d M Y", strtotime($data->enrolby_date))',),
// 			array(	'name' => 'court_type', 'value' => 'Lookup::item("CourtType", $data->court_type)'),
// 			array(	'name' => 'status', 'value' => 'Lookup::item("TourStatus", $data->status)',
// 					'htmlOptions'=>array('onmouseover'=>"$('div#legendBox').show()", 'onmouseout'=>"$('div#legendBox').hide()")),
// 			array( 'name' => 'Organized by', 'value' => '$data->organization->name'),
// 		),
// ));
?>
<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_item',
	))
?>
