<?php
/* @var $this PlayerController */
/* @var $dataProvider CActiveDataProvider */
/* @var $this DefaultController */

$this->pageTitle='Events';
$this->breadcrumbs=array(
	'Events',
);
$this->information = "The list of the tournaments which are currently running or upcoming. A player can enroll in these tournaments
				as long as their status shows as <i>'Inviting'</i>.<br/>
				Follow the hyperlink to view the details of the tournament.";
?>
<?php
	$this->menu=array(
			array('label'=>'Create Event', 'url'=>array('create'),),
	);
?>

<h4><?php echo $this->pageTitle ?></h4>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'columns'=>array(
			array('name'=> 'location',
				'type'=>'raw', 
				'value'=>'CHtml::link($data->location, array("event/view", "id"=>$data->id))',),
			array(	'name' => 'Level', 'value' => 'Lookup::item("EventLevel", $data->level)'),
			array(	'name'=>'start_date', 'value'=>'date("d M Y", strtotime($data->start_date))'),
			array(	'name'=>'enrolby_date', 'value'=>'date("d M Y", strtotime($data->enrolby_date))'),
			array(	'name' => 'court_type', 'value' => 'Lookup::item("CourtType", $data->court_type)'),
			array(	'name' => 'status', 'value' => 'Lookup::item("EventStatus", $data->status)'),
			array( 'name' => 'Organized by', 'value' => '$data->organizer->name'),
		),
));
?>
