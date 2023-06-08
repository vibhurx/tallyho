
<style>
<!--
form {
	width: 99%;
}

table.detail-view th
{
    text-align: right;
    width: 260px;
    height: 30px;
}

table.detail-view tr.odd
{
	background:#E5F1F4;
}

table.detail-view tr.even
{
	background:#F8F8F8;
}
-->
</style>
<?php
/* @var $this TourController */
/* @var $model Tour */

$this->breadcrumbs=array(
	'Tours'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Back', 'url'=>array('default/view', 'id'=>$model->id)),
	//array('label'=>'Back to List', 'url'=>array('default/index')),
);
?>

<?php $this->headers[0] = $model->location; ?>
<?php //$this->backLink = $this->createUrl('/tour/default/view', array('id'=> $model->id));?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>