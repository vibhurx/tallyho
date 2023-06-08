<?php
/* @var $this ParticipantController */
/* @var $data Participant */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('player_id')); ?>:</b>
	<?php echo CHtml::encode($data->player_id); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('seed')); ?>:</b>
	<?php echo CHtml::encode($data->seed); 
	// @todo Please check the todo tag working or not ?>
	<br />
	
</div>