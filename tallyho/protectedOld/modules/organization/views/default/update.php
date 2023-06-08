<?php
/* @var $this CommonController */
/* @var $model Organization */

$this->breadcrumbs=array(
	'My Organization'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
// 	array('label'=>'List Organization', 'url'=>array('index')),
// 	array('label'=>'Create Organization', 'url'=>array('create')),
	array('label'=>'Cancel Update', 'url'=>array('view', 'id'=>$model->id)),
// 	array('label'=>'Manage Organization', 'url'=>array('admin')),
);
?>

<h1>Update Organization</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>