<?php
/* @var $this TourController */
/* @var $model Tour */

// $this->breadcrumbs=array(
// 	'Tours'=>array('index'),
// 	'Create',
// );

$this->menu=array(
	array('label'=>'Back to List', 
				'url'=>array('/tour/default/index/')),
);

$this->header01 = 'Create Tour';
$this->backLink = $this->createUrl('/tour/default/index/');
?>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>