<?php
/* @var $this PlayerController */
/* @var $model Player */

$this->breadcrumbs=array(
	'Players'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Player', 'url'=>array('index')),
	//array('label'=>'Create Player', 'url'=>array('create')),
	array('label'=>'Cancel update', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage Player', 'url'=>array('admin')),
);
?>

<h1>Player Information</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>