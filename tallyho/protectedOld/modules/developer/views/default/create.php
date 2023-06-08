<?php
/* @var $this DefaultControllerController */
/* @var $model Developer */

$this->breadcrumbs=array(
	'Developers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Developer', 'url'=>array('index')),
	array('label'=>'Manage Developer', 'url'=>array('admin')),
);
?>

<h1>Create Developer</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'user'=>$user)); ?>