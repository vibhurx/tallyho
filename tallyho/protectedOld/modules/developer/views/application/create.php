<?php
/* @var $this ApplicationController */
/* @var $model Application */

$this->breadcrumbs=array(
	'Applications'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Cancel Create', 'url'=>array('/developer')),
);
?>

<h1>Create Application</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>