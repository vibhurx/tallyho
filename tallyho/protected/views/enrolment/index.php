<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	'Events'=>array('//event/index'),
	'Event Name, Location',
	'Category Name',
	'Enrolments'
);

$this->pageTitle = 'Enrolments';

?>
<h4><?php echo $this->pageTitle ?></h4>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns' => array(
		array('name' => 'Location',
				'type' => 'raw',
				'value' => 'CHtml::link(Event::model()->findByPk($data->event_id)->location, array("/event/default/view", "id"=>$data->event_id))',
		),
		array('name' => 'Starting on', 'value' => 'Event::model()->findByPk($data->event_id)->start_date'),
		array('name' => 'category', 'value' => 'Lookup::item("AgeGroup", $data->category)'),
		array('name' => 'seed', 'value' => '$data->seed', 'htmlOptions' => array('style' => 'text-align:center')),
		array( 'header'=>'Manage',
				'class'=>'CDataColumn',
				'type' => 'raw',
				'value' => 'CHtml::link("Delete", array("#"),array("submit"=>array("enrol/delete","id"=>$data->id),"confirm"=>"Are you sure you want to delete this item?"))',
				'htmlOptions' => array('style' => 'text-align:center'),
		),
				),
			));

?>
