<?php
/* @var $this DefaultControllerController */
/* @var $model Developer */

$this->breadcrumbs=array(
	'Developers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Developer', 'url'=>array('index')),
	array('label'=>'Create Developer', 'url'=>array('create')),
	array('label'=>'Update Developer', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Developer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage Developer', 'url'=>array('admin')),
);
?>

<h1>View Developer #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'given_name',
		'family_name',
		'company_name',
		'email',
		'phone',
	),
)); ?>
