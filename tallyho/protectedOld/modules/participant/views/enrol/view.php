<?php
/* @var $this EnrolController */
/* @var $model Participant */

$this->breadcrumbs=array(
	'Participant'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Delete enrollment', 
			'url'=>'#', 
			'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),
									'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Participation</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array('name' => 'Location', 'value' => Tour::model()->findByPk($model->tour_id)->location),
		array('name' => 'Starting on', 'value' => Tour::model()->findByPk($model->tour_id)->start_date),
		array('name' => 'category', 'value' => Lookup::item("AgeGroup", $model->category)),
		'seed',
	),
)); ?>
