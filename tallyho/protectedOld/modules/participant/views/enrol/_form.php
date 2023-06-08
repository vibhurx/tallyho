<?php
/* @var $this ParticipantController */
/* @var $model Participant */
/* @var $form CActiveForm */
?>
<!-- TODO:
	Currently there is some sort of constraint between participant and match object (why? donno).
	Moreover the foreign key reference is inconsitent for the player id. Some place it in int(11)
	to be filled by an auto-incremented number and some places it is email ID. I guess it needs
	to be changed to email ID everywhere.
-->
<h2 style='width:100%;background: steelblue; color:white'>Enrol </h2>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'participant-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p> Check the Tournament & Category information before confirming
		
<table>
	<tr>
		<td>
		<?php echo $form->labelEx($tour,'location'); ?>
		</td><td><?php echo $form->hiddenField($model,'tour_id'); ?>
		<?php echo $tour->location;?>
		</td>
</tr>
	<tr>	
		<td>
		<?php echo $form->labelEx($tour,'start_date'); ?>
		</td><td><?php echo date_format(date_create($tour->start_date), 'd M Y');?>
		</td>
	</tr>
	<tr>		
		<td>
			<?php echo $form->hiddenField($model,'seed');	?>
				
			<?php echo $form->labelEx($model,'category'); ?>
			</td><td><?php echo $form->hiddenField($model,'category'); ?>
			<?php echo Lookup::item('AgeGroup', $model->category)?>
			<?php echo $form->error($model,'category'); ?>
		</td>
</tr>
	<tr>		<td>
			<?php echo $form->labelEx($model,'player_id'); ?>
			</td><td><?php echo $form->hiddenField($model,'player_id'); ?>
			<?php echo Yii::app()->user->data()->username; ?>
			<?php echo $form->error($model,'player_id'); ?>
		</td>
	</tr>
	<tr>
		<td colspan=2><br>
			<?php echo CHtml::submitButton('Confirm & Save', array('style' => 'width:100%;')); ?>
		</td>
	</tr>
</table>
<?php $this->endWidget(); ?>
</div><!-- form -->