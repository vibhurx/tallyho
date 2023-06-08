<?php
/* @var $this ParticipantController */
/* @var $model Participant */

$this->breadcrumbs=array(
	'Participants'=>array('index'),
//	$model->id,
);

$this->menu=array(
);
?>

<h1>Draw for <b><?php echo $tour_name ?> </b>under category <b><?php echo $category_name?></b> </h1>
<p></p>
<h2>Todo List</h2>
<ul>
	<li>Join table with Player profile and show player's name</li>
</ul>

<?php 
	$this->widget('ext.htmlTableUi.htmlTableUi', array(
			'ajaxUrl'=>'site/handleHtmlTable',
			//$this->widget('zii.widgets.grid.CGridView', array(
			'arProvider'=>$dataProvider,
		 	'columns'=>array(
		 		//'id',
				'seed', 
				array('name'=>'player.givenName', 'value'=>'$data->player->givenName'),
				array('name'=>'player.familyName', 'value'=>'$data->player->familyName'),
				//array('header' => 'editMe', 'name' => 'editable_row', 'class' => 'CEditableColumn'),
 			),
			'sortColumn' => '1',
			'sortOrder' => 'ASC',
			'editable' => true,
	)); ?>
