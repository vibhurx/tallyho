<?php
/* @var $this DefaultControllerController */
/* @var $model Developer */

$this->breadcrumbs=array(
	'Developers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Developer', 'url'=>array('index')),
	array('label'=>'Create Developer', 'url'=>array('create')),
	array('label'=>'View Developer', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Developer', 'url'=>array('admin')),
);
?>

<h1>Update Developer <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>