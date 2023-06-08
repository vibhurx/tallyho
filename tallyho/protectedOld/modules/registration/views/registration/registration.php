<?php $this->headers[0] = Yum::t('Registration'); ?>

<?php $this->breadcrumbs = array(Yum::t('Registration')); ?>

<div class="form">
<?php $activeform = $this->beginWidget('CActiveForm', array(
			'id'=>'registration-form',
			'enableAjaxValidation'=>true,
			'enableClientValidation'=>true,
			'focus'=>array($profile,'email'),
		));
?>

<?php 
// 	echo Yum::requiredFieldNote();
echo CHtml::errorSummary(array($form, $profile, $user));
?>
<?php Yum::renderFlash(); //Inserted by MUBI ?>
<div style='min-height: 20px'></div>

<div class="row-fluid">
<div class="span12">
<?php
	echo $activeform->labelEx($profile,'email');
	echo $activeform->textField($profile,'email');
?>
<!-- </div></div> -->

<!-- <div class="row"> -->
<!-- <div class="span12">  -->
<?php
// echo $activeform->labelEx($form,'username');
// echo $activeform->textField($form,'username');
?>
</div></div>

<!-- <div class="row"><div class="span12">  -->
<?php
// echo $activeform->labelEx($profile,'firstname');
// echo $activeform->textField($profile,'firstname');
?>
<!-- </div></div> -->

<!-- <div class="row"><div class="span12"> -->
<?php
// echo $activeform->labelEx($profile,'lastname');
// echo $activeform->textField($profile,'lastname');
?>
<!-- </div></div> -->

<!-- <div class="row"><div class="span12"> -->
<?php 
// echo $activeform->labelEx($form,'password');
// echo $activeform->passwordField($form,'password');
?>
<!-- </div></div> -->

<!-- <div class="row"><div class="span12"> -->
<?php 
// echo $activeform->labelEx($form,'verifyPassword');
// echo $activeform->passwordField($form,'verifyPassword');
?>
<!-- </div></div> -->

<?php if(extension_loaded('gd') 
			&& Yum::module('registration')->enableCaptcha): ?>
	<div class="row-fluid">
    	<div class="span12">
		<?php echo CHtml::activeLabelEx($form,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo CHtml::activeTextField($form,'verifyCode'); ?>
		</div>
		<p class="hint">
		<?php echo Yum::t('Please enter the letters as they are shown in the image above.'); ?>
		<br/><?php echo Yum::t('Letters are not case-sensitive.'); ?></p>
	</div></div>
	<?php endif; ?>
	
	<div class="row-fluid"><div class="span12">
	</div></div>
	
	<div class="row-fluid submit">
	    <div class="span12">
		<?php echo CHtml::submitButton(Yum::t('Registration'), array('class'=>'btn')); ?>
        </div>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
