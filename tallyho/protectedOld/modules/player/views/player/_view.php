<?php
/* @var $this PlayerController */
/* @var $data Player */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('givenName')); ?>:</b>
	<?php echo CHtml::encode($data->givenName); ?>
	<br />

		<b><?php echo CHtml::encode($data->getAttributeLabel('familyName')); ?>:</b>
	<?php echo CHtml::encode($data->familyName); ?>
	<br />

		<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

		<b><?php echo CHtml::encode($data->getAttributeLabel('aitaNo')); ?>:</b>
	<?php echo CHtml::encode($data->aitaNo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aitaPoints')); ?>:</b>
	<?php echo CHtml::encode($data->aitaPoints); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
	<?php echo CHtml::encode($data->state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dateOfBirth')); ?>:</b>
	<?php echo CHtml::encode($data->dateOfBirth); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	*/ ?>

</div>