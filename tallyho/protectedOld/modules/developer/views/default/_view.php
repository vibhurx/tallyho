<?php
/* @var $this ApplicationController */
/* @var $data Application */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<b><?php echo  CHtml::link(CHtml::encode($data->description), array('application/update', 'id'=>$data->id)); ?></b>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::encode($data->id); ?>
	<br />

	<!-- 
	<b><?php echo CHtml::encode($data->getAttributeLabel('developer_id')); ?>:</b>
	<?php echo CHtml::encode($data->developer_id); ?>
	<br />
	 -->
	<b><?php echo CHtml::encode($data->getAttributeLabel('secret_key')); ?>:</b>
	<?php echo CHtml::encode($data->secret_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode(Lookup::item('ApplicationType', $data->type)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode(date_format(date_create($data->start_date), 'd M, Y')); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date')); ?>:</b>
	<?php echo CHtml::encode(date_format(date_create($data->end_date), 'd M, Y')); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('active_flag')); ?>:</b>
	<?php echo CHtml::encode($data->active_flag); ?>
	<br />
	*/ ?>
	<div style='text-align:right'>
	<?php echo CHtml::link('Remove this item', array('#'),
				array(
					'submit'=>array('/developer/application/delete','id'=>$data->id),
					'confirm'=>'Are you sure you want to delete this item?')
	); ?></div>

</div>