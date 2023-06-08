<?php
/* @var $this PlayerController */
/* @var $dataProvider CActiveDataProvider */

// $this->breadcrumbs=array(
// 	'Players',
// );
$this->headers[0] = 'Players';

$this->menu=array(
	array('label'=>'Create Player', 'url'=>array('create')),
	array('label'=>'Manage Player', 'url'=>array('admin')),
);
?>

<h1></h1>
<p>TODO: Remove it from the general viewing </p>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'selectionChanged'=>'function(id){location.href= "' . $this->createUrl('tour/view') . 	'/id/"+$.fn.yiiGridView.getSelection(id);}',

));
 ?>
