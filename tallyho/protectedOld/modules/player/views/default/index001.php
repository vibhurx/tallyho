<?php
/* @var $this DefaultController */

// $this->breadcrumbs=array(
// 	$this->module->id,
// );

$this->header01 = 'Players';
$this->backLink = 'javascript:history.back()';
$this->menu=array(
		array('label'=>'Payment History', 'url'=>array('paymentHistory')),
		//array('label'=>'Manage Player', 'url'=>array('admin')),
);
?>

<h1>My Enrolments</h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$enrolments,
	'columns' => array(
						array('name' => 'Location',
							  'type' => 'raw',
							  'value' => 'CHtml::link(Tour::model()->findByPk($data->tour_id)->location, array("/tour/default/view", "id"=>$data->tour_id))',
						),
						array('name' => 'Starting on', 'value' => 'date_format(date_create(Tour::model()->findByPk($data->tour_id)->start_date),"d M Y")'),
						array('name' => 'category', 'value' => 'Lookup::item("AgeGroup", $data->category)'),
						array('name' => 'seed', 'value' => '$data->seed', 'htmlOptions' => array('style' => 'text-align:center')),
						array( 'header'=>'Manage',
								'class'=>'CDataColumn',
								'type' => 'raw',
								'value' => 'CHtml::link("Delete", array("#"), array("submit"=>array("/participant/enrol/delete","id"=>$data->id),"confirm"=>"Are you sure you want to delete this item?"))',
								'htmlOptions' => array('style' => 'text-align:center'),
						),
				),
			));

?>


<h1>My Memberships</h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$memberships,
	'columns' => array(
		array('name' => 'Location',
			  'type' => 'raw',
			  'value' => '$data->organization->name',
		),
 		'since',
		'regn_no',
		'rank',
		'points'
		)
	));

?>
