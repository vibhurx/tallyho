<?php
// This page can later be used for making an attractive landing page http://tallyho.in
	CController::forward("tour/default/index");
/* @var $this PlayerController */
/* @var $dataProvider CActiveDataProvider */
/* @var $this DefaultController */

$this->pageTitle=Yii::app()->name . ' - Home';
$this->breadcrumbs=array(
	'Tournaments',
);
?>
<h1>Tournaments</h1>
	<!-- p> <b> Temporary Shortcuts</b> - 
		<a href="http://localhost:8080/tallyho.in/index.php/organization">Organizations </a>,
		<a href="http://localhost:8080/tallyho.in/index.php/user/user">Users </a>,
		<a href="http://localhost:8080/tallyho.in/index.php/tour/category">Categories </a>,
		<a href="http://localhost:8080/tallyho.in/index.php/participant/participant">Participants </a>,
		<a href="http://localhost:8080/tallyho.in/index.php/player/player">Players </a>
	</p -->
<?php

$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){location.href= "' . $this->createUrl('tour/tour/view') . 	'/id/"+$.fn.yiiGridView.getSelection(id);}',
	
	'columns'=>array(
		'id',
		'location',
		array(	'name' => 'level', 'value' => 'Lookup::item("TourLevel", $data->level)'),
		array(	'name'=>'startDate', 'value'=>'date("M d, Y", strtotime($data->start_date))',),
		array(  'name'=>'enrol_by_date', 'value'=>'date("M d, Y", strtotime($data->enrol_by_date))',),
		array(	'name' => 'court_type', 'value' => 'Lookup::item("CourtType", $data->court_type)'),
		array(	'name' => 'status',    'value' => 'Lookup::item("TourStatus", $data->status)'),
		array(	'name' => 'org_id', 'value' => '$data->organization->name'),
	),
));
?>

<b>Status legend </b>: <i>Inviting</i> - available for enrolment, <i>Upcoming</i> - enrolment closed, <i>Ongoing</i> - in progress.
