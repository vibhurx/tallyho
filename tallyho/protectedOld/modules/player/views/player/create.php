<?php
/* @var $this PlayerController */
/* @var $model Player */

$this->breadcrumbs=array(
	'Players'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Cancel', 'url'=>array('/')),
//	array('label'=>'Manage Player', 'url'=>array('admin')),
);
?>

<h1>Player Information</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>