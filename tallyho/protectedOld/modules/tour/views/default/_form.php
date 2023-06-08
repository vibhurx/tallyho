<?php
/* @var $this TourController */
/* @var $model Tour */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tour-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<!-- 	<p class="note">Fields with <span class="required">*</span> are required.</p> -->

	<?php echo $form->errorSummary($model); ?>

	<table class='detail-view'>
		<tr class='odd'><td>
			<?php echo $form->labelEx($model,'location'); ?>
			</td><td><?php echo $form->textField($model,'location',array('size'=>45,'maxlength'=>45)); ?>
			<?php echo $form->error($model,'location'); ?>
		</td></tr>
	
		<tr class='even'><td>
			<?php echo $form->labelEx($model,'level'); ?>
			</td><td><?php echo $form->dropDownList($model, 'level', Lookup::items('TourLevel'));?>
			<?php echo $form->error($model,'level'); ?>
		</td></tr>
	
		<tr class='odd'><td>
			<?php echo $form->labelEx($model,'start_date'); ?>
			</td><td><?php 
// 				$this->widget('zii.widgets.jui.CJuiDatePicker', array('name'=>'start_date',
// 					'attribute'=>'start_date',
// 					'model'=>$model,
// 					'options'=>array('showAnim'=>'fold', 'dateFormat'=> 'yy-mm-dd'),
// 				));
				echo $form->textField($model,'start_date',
						array('style'=>'width:180px;', 'readonly'=>'readonly'));
			?>
			<?php echo $form->error($model,'start_date'); ?>
		</td></tr>
	
		<tr class='even'><td>
			<?php echo $form->labelEx($model,'is_aita'); ?>
			</td><td><?php echo $form->dropDownList($model, 'is_aita', array(false=>'No', true=>'Yes'));
			?>
			<?php echo $form->error($model,'is_aita'); ?>
		</td></tr>
	
		<tr class='odd'><td>
			<?php echo $form->labelEx($model,'enrolby_date'); ?>
			</td><td><?php 
// 				$this->widget('zii.widgets.jui.CJuiDatePicker', array('name'=>'enrolby_date',
// 					'attribute'=>'enrolby_date',
// 					'model'=>$model,
// 					'options'=>array('showAnim'=>'fold', 'dateFormat'=> 'yy-mm-dd'),
// 				));
				echo $form->textField($model,'enrolby_date',
					array('style'=>'width:180px;text-align:center', 'readonly'=>'readonly'));
			?>
			<?php echo $form->error($model,'enrolby_date'); ?>
		</td></tr>
		
		<tr class='even'><td>
			<?php echo $form->labelEx($model,'referee'); ?>
			</td><td><?php echo $form->textField($model,'referee',array('size'=>45,'maxlength'=>45)); ?>
			<?php echo $form->error($model,'referee'); ?>
		</td></tr>
	
		<tr class='odd'><td>
			<?php echo $form->labelEx($model,'court_type'); ?>
			</td><td><?php echo $form->dropDownList($model, 'court_type', Lookup::items('CourtType'));?>
			<?php echo $form->error($model,'court_type'); ?>
		</td></tr>
	
		<tr class='even'><td>
			<?php $courtArr = array();
					for($i=1; $i<=$model->organization->no_courts; $i++)
						$courtArr[$i] = $i; 
			?>
			<?php echo $form->labelEx($model,'no_courts'); ?>
			</td><td><?php echo $form->dropDownList($model, 'no_courts', $courtArr);?><span class=hint>Dedicated to the tour</span>
			<?php echo $form->error($model,'no_courts'); ?>
		</td></tr>
	
		<tr class='odd'><td>
			<?php echo $form->labelEx($model,'status'); ?>
			</td><td><?php echo $form->dropDownList($model, 'status', Lookup::items('TourStatus'), array('readonly'=>true));
				//echo $form->hiddenField($model, 'status');
			?>
			<?php echo $form->error($model,'status'); ?>
		</td></tr>
	
		<tr class='even'><td>
			<?php echo $form->labelEx($model,'type'); ?>
			</td><td><?php echo $form->dropDownList($model, 'type', Lookup::items('TourType'));?>
			<?php echo $form->error($model,'type'); ?>
		</td></tr>
			
		<tr class='odd'><td>
			<!--?php echo $form->labelEx($model,'org_id'); ?-->
			</td><td><?php echo $form->hiddenField($model,'org_id'); ?>
			<?php echo $form->error($model,'org_id'); ?>
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
	$('#Tour_start_date').datetimepicker({
		timepicker: false,
		dayOfWeekStart: 1,
		lang: 'en',
		format: 'd/m/Y',
		closeOnDateSelect: true,
	});
	$('#Tour_enrolby_date').datetimepicker({
		timepicker: false,
		dayOfWeekStart : 1,
		lang:'en',
		format: 'd/m/Y',
		closeOnDateSelect: true,
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