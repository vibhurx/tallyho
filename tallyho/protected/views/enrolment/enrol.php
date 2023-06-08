<?php
/* @var $this ParticipantController */
/* @var $enrolment Participant */
/* @var $form CActiveForm */
?>
<!-- TODO:
	Currently there is some sort of constraint between Enrolment and match object (why? donno).
	Moreover the foreign key reference is inconsitent for the player id. Some place it in int(11)
	to be filled by an auto-incremented number and some places it is email ID. I guess it needs
	to be changed to email ID everywhere.
-->

<?php 
	//$this->headers[0] = "Enrol";
	
	// $this->menu=array(
	// 	array('label'=>'Back to Tour', 'url'=>array('/category/default/index', 'tid'=>$enrolment->event_id)),
	// );

	$this->breadcrumbs=array(
		'Events'=>array('//event/index'),
		'Event Name, Location',
		'Category Name',
		'Enrolments'
	);
?>

<div>
<h3>Check the Tournament & Category information before confirming</h3>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'enrolment-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>
		
	<table>
		<tr>
			<td>
				<?php echo $form->labelEx($event,'location'); ?>
			</td><td>
				<?php echo $form->hiddenField($enrolment,'event_id'); ?>
				<?php echo $event->location;?>
			</td>
		</tr>
		<tr>	
			<td>
				<?php echo $form->labelEx($event,'start_date'); ?>
			</td><td>
				<?php echo date_format(date_create($event->start_date), 'd M Y');?>
			</td>
		</tr>
		<tr>		
			<td>
				<?php echo $form->hiddenField($enrolment,'seed');	?>
				<?php echo $form->labelEx($enrolment,'category'); ?>
			</td><td>
				<?php echo $form->hiddenField($enrolment,'category'); ?>
				<?php echo Lookup::item('AgeGroup', $enrolment->category)?>
				<?php echo $form->error($enrolment,'category'); ?>
			</td>
	</tr>
		<tr>
			<td>
				<?php echo $form->labelEx($enrolment,'player_id'); ?>
			</td><td>
				<?php echo $form->hiddenField($enrolment,'player_id'); ?>
				<?php echo Yii::app()->user->data()->username; ?>
				<?php echo $form->error($enrolment,'player_id'); ?>
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
</div>