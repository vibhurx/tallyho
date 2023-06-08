<?php
/* @var $this ParticipantController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Participants',
);

$this->menu=array(
	array('label'=>'Create Participant', 'url'=>array('create')),
	array('label'=>'Manage Participant', 'url'=>array('admin')),
);
?>

<h1>Participants List for <b><?php echo $tour_name ?> </b>under category <b><?php echo $category_name?></b> </h1>

<p> TODO: Create and Manage is only for the organizer. Hide them for the logged in players or the visitors <br/>
</p>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'enablePagination' => false,
)); ?>
