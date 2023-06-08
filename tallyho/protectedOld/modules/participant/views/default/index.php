<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>

<h1>My Enrollments</h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns' => array(
						array('name' => 'Location',
							  'type' => 'raw',
							  'value' => 'CHtml::link(Tour::model()->findByPk($data->tour_id)->location, array("/tour/default/view", "id"=>$data->tour_id))',
						),
						array('name' => 'Starting on', 'value' => 'Tour::model()->findByPk($data->tour_id)->start_date'),
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
