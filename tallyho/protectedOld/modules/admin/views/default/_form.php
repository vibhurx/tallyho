<?php
/* @var $this PlayerController */
/* @var $model Player */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'player-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php 
	
	?>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $model->id; ?>
		<?php echo $form->textField($model,'id',array('size'=>60,'maxlength'=>128, 'hidden'=> 'true')); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>
	<br/>
	<div class="row">
		<?php 
			echo $form->labelEx($model,'player_id'); 
			echo $form->textField($model,'player_id',array('size'=>10,'maxlength'=>10)); 
			echo $form->error($model,'player_id');
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'givenName'); ?>
		<?php echo $form->textField($model,'givenName',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'givenName'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'familyName'); ?>
		<?php echo $form->textField($model,'familyName',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'familyName'); ?>
	</div>
		
	<div class="row">
		<?php echo $form->labelEx($model,'aitaNo'); ?>
		<?php echo $form->textField($model,'aitaNo',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'aitaNo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'aitaPoints'); ?>
		<?php echo $form->textField($model,'aitaPoints'); ?>
		<?php echo $form->error($model,'aitaPoints'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state'); ?>
		<?php echo $form->dropDownList($model, 'state', Lookup::items('State')); ?>
		<?php echo $form->error($model,'state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->dropDownList($model, 'gender', Lookup::items('Gender'));?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dateOfBirth'); ?>
		<?php //echo $form->textField($model,'dateOfBirth'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array('name'=>'dateOfBirth',
				'attribute'=>'dateOfBirth',
				'model'=>$model,
				'options'=>array('showAnim'=>'fold',),
//	    		'htmlOptions'=>array('style'=>'height:16px;',),
			));
		?>
		<?php echo $form->error($model,'dateOfBirth'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->