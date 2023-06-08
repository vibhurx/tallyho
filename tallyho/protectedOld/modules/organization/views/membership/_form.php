<?php
/* @var $this MembershipController */
/* @var $model Membership */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'membership-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<table>
		<tr><td>
			<?php echo $form->labelEx($model,'player_id'); ?>
		</td><td><?php echo $form->hiddenField($model,'player_id'); ?>
			<?php echo CHtml::textField('player_name', $player_name,
							array('onclick'=>'javascript: $("a#fb_enrol").click();')); ?>
			<?php echo $form->error($model,'player_id'); ?>
		</td></tr>
	
		<tr><td>
			<?php echo $form->labelEx($model,'org_id'); ?>
		</td><td><?php echo Organization::model()->findByPk($model->org_id)->name; ?>
			<?php echo $form->error($model,'org_id'); ?>
		</td></tr>
	
		<tr><td>
			<?php echo $form->labelEx($model,'regn_no'); ?>
		</td><td><?php echo $form->textField($model,'regn_no',array('size'=>12,'maxlength'=>12)); ?>
			<?php echo $form->error($model,'regn_no'); ?>
		</td></tr>
	
		<tr><td>
			<?php echo $form->labelEx($model,'rank'); ?>
		</td><td>	<?php echo $form->textField($model,'rank'); ?>
			<?php echo $form->error($model,'rank'); ?>
		</td></tr>
	
		<tr><td>
			<?php echo $form->labelEx($model,'points'); ?>
		</td><td>	<?php echo $form->textField($model,'points'); ?>
			<?php echo $form->error($model,'points'); ?>
		</td></tr>
	
		<tr><td>
			<?php echo $form->labelEx($model,'since'); ?>
		</td><td>	<?php echo $form->textField($model,'since',
				array('style'=>'width:80px;text-align:center', 'readonly'=>'readonly')); ?>
			<?php echo $form->error($model,'since'); ?>
		</td></tr>
	
		<tr><td>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</td><td>
		</td></tr>
	</table>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
<!--
	$('#Membership_since').datetimepicker({
		timepicker: false,
		dayOfWeekStart: 1,
		lang: 'en',
		format: 'd/m/Y',
		closeOnDateSelect: true
	});
-->
</script>
<?php 
	$jsFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/participant.js');
	Yii::app()->clientScript->registerScriptFile($jsFile);
?>
<?php 

echo CHtml::link("Fancy link for Enrol-a-Player",
		array('membership/selectPlayer'),	
		array('title'=>'Select a player',
		  'style'=>'display:none', 'id'=>'fb_enrol'));

//Fancybox for Enrol-a-Player
$this->widget(
		'application.extensions.fancybox.EFancyBox',
		array('target'=> '#fb_enrol',
		  'config'=>array('scrolling' => 'no',
		  		'titleShow' => true,
		  		'padding' => 40,
		  		'onCancel' => function(){return true;},
		  		'closeClick'=> true )));
?>

<?php 
	//Regular date-picker is not working on a fancybox popup
	$jsFile = Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/datetimepicker/jquery.datetimepicker.js');
	$csFile = Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/datetimepicker/jquery.datetimepicker.css');
	Yii::app()->clientScript->registerScriptFile($jsFile);
	Yii::app()->clientScript->registerCssFile($csFile);
?>