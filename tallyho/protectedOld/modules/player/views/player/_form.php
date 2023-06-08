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

<style>
th {
	text-align:left;
	width:150px;
	}
</style>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<table>
	<tr><th>
		<?php echo $form->labelEx($model,'gender'); ?>
	</th><td>
		<?php echo $form->dropDownList($model, 'gender', Lookup::items('Gender'));?>
		<?php echo $form->error($model,'gender'); ?>
	</td></tr>

	<tr><th>
		<?php echo $form->labelEx($model,'date_of_birth'); ?>
	</th><td>
		<?php echo $form->textField($model,'date_of_birth', 
				array('style'=>'width:100px;text-align:center', 'readonly'=>'readonly')); ?>
		<?php echo $form->error($model,'date_of_birth'); ?>
	</td></tr>

	<tr><th>
		<?php echo $form->labelEx($model,'aita_no'); ?>
	</th><td>
		<?php echo $form->textField($model,'aita_no',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'aita_no'); ?>
	</td></tr>

	<tr><th>
		<?php echo $form->labelEx($model,'aita_points'); ?>
	</th><td>
		<?php echo $form->textField($model,'aita_points'); ?>
		<?php echo $form->error($model,'aita_points'); ?>
	</td></tr>	
	<tr><th>
	</th><td>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		<?php if(isset($categoryId))
				echo CHtml::link('Cancel', array('/participant/draw/index','cid'=>$categoryId)); ?>
	</td></tr>
	</table>

<?php $this->endWidget(); ?>

</div><!-- form -->
		
<script>
<!--
	$('#Player_date_of_birth').datetimepicker({
		timepicker: false,
		dayOfWeekStart: 1,
		lang: 'en',
		format: 'd/m/Y',
		//startDate: '01/01/1990',
		closeOnDateSelect: true
	});

-->
</script>
<?php 
	//Regular date-picker is not working on a fancybox popup
	$jsFile = Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/datetimepicker/jquery.datetimepicker.js');
	$csFile = Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/datetimepicker/jquery.datetimepicker.css');
	Yii::app()->clientScript->registerScriptFile($jsFile);
	Yii::app()->clientScript->registerCssFile($csFile);
?>