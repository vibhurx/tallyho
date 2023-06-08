<?php
/* @var $this CommonController */
/* @var $model Organization */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'organization-form',
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
			<?php echo $form->labelEx($model,'name'); ?>
			</th><td><?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
			<?php echo $form->error($model,'name'); ?>
		</td></tr>
	
		<tr><th>
			<?php echo $form->labelEx($model,'address_line_1'); ?>
			</th><td><?php echo $form->textField($model,'address_line_1',array('size'=>45,'maxlength'=>45)); ?>
			<?php echo $form->error($model,'address_line_1'); ?>
		</td></tr>
	
		<tr><th>
			<?php echo $form->labelEx($model,'address_line_2'); ?>
			</th><td><?php echo $form->textField($model,'address_line_2',array('size'=>45,'maxlength'=>45)); ?>
			<?php echo $form->error($model,'address_line_2'); ?>
		</td></tr>
	
		<tr><th>
			<?php echo $form->labelEx($model,'city'); ?>
			</th><td><?php echo $form->textField($model,'city',array('size'=>45,'maxlength'=>45)); ?>
			<?php echo $form->error($model,'city'); ?>
		</td></tr>
	
		<tr><th>
			<?php echo $form->labelEx($model,'state'); ?>
			</th><td><?php echo $form->dropDownList($model,
				    			'state', 
				    			Lookup::items('State'),
								array('prompt'=>'Select')
				    	  );
			?>
			<?php //echo $form->textField($model,'state'); ?>
			<?php echo $form->error($model,'state'); ?>
		</td></tr>
	
		<tr><th>
			<?php echo $form->labelEx($model,'postal_code'); ?>
			</th><td><?php echo $form->textField($model,'postal_code'); ?>
			<?php echo $form->error($model,'postal_code'); ?>
		</td></tr>
			
		<tr><th>
			<?php echo $form->labelEx($model,'telephone'); ?>
			</th><td><?php echo $form->textField($model,'telephone'); ?>
			<?php echo $form->error($model,'telephone'); ?>
		</td></tr>
		
		<tr><td colspan=2>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</td></tr>
	</table>

<?php $this->endWidget(); ?>

</div><!-- form -->
