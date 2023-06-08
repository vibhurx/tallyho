<?php $this->headers[0] = 'Registration'; ?>

<?php $this->breadcrumbs = array(Yum::t('Registration')); ?>

<div class='row-fluid'>
	<div class="span6" style='border:0px solid red'></div>
	<div class="span6" style='border:0px solid green'>
		<?php $activeform = $this->beginWidget('CActiveForm', array(
					'id'=>'registration-form',
					'enableAjaxValidation'=>false,
					'focus'=>array($profile,'email'),
					));
		?>
		
		<?php //echo Yum::requiredFieldNote(); ?>
		<?php echo CHtml::errorSummary($profile); ?>
		
		<div class="span4" style='border:0px solid'> 
		<?php
			echo $activeform->labelEx($profile,'email');
			echo $activeform->textField($profile,'email');
		?> 
		
		
		<?php if(extension_loaded('gd') && Yum::module('registration')->enableCaptcha): ?>
			<div class="row">
		    	<div class="span12">
					<?php echo CHtml::activeLabelEx($form,'verifyCode'); ?>
					<div>
						<?php $this->widget('CCaptcha'); ?>
						<?php echo CHtml::activeTextField($form,'verifyCode'); ?>
					</div>
					<p class="hint">
						<?php echo Yum::t('Please enter the letters as they are shown in the image above.'); ?>
						<br/><?php echo Yum::t('Letters are not case-sensitive.'); ?>
					</p>
				</div>
			</div>
		<?php endif; ?>
	
			<div style='min-height:20px'></div>
		
			<div style='border:0px solid'>
				<?php echo CHtml::submitButton(Yum::t('Registration')); ?>
				<?php //echo CHtml::link('Cancel', array('/'))?>
			</div>
		</div>  
		
		<?php $this->endWidget(); ?>
	
	</div>
</div>