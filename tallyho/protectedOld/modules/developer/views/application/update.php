<?php
/* @var $this ApplicationController */
/* @var $model Application */

$this->breadcrumbs=array(
	'Applications'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Cancel Update', 'url'=>array('/developer')),
// 	array('label'=>'Create Application', 'url'=>array('create')),
// 	array('label'=>'View Application', 'url'=>array('view', 'id'=>$model->id)),
// 	array('label'=>'Manage Application', 'url'=>array('admin')),
);
?>

<h1>Update Application <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>