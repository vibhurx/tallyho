<?php
/* @var $this DrawController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Back', 'url'=>array('view', 'id'=>$model->id)),	
);
?>

<h1><?php echo $model->tour->location ?>(<?php echo Lookup::item("AgeGroup",$model->category); ?>)</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

<?php 
//Regular date-picker is not working on a fancybox popup
$jsFile = Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/datetimepicker/jquery.datetimepicker.js');
$csFile = Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/datetimepicker/jquery.datetimepicker.css');
Yii::app()->clientScript->registerScriptFile($jsFile);
Yii::app()->clientScript->registerCssFile($csFile);

?>