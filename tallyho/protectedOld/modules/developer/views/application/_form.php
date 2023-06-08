<?php
/* @var $this ApplicationController */
/* @var $model Application */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'application-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<table><tr><td>
			<?php echo $form->labelEx($model,'developer_id'); ?>
		</td><td>
			<?php echo $form->textField($model,'developer_id'); ?>
			<?php echo $form->error($model,'developer_id'); ?>
		</td></tr>
	<tr><td>
	
			<?php echo $form->labelEx($model,'description'); ?>
	</td><td>
			<?php echo $form->textField($model,'description',array('size'=>36,'maxlength'=>128)); ?>
			<?php echo $form->error($model,'description'); ?>
	
	</td></tr>
	<tr><td>
	
			<?php echo $form->labelEx($model,'id'); ?>
	</td><td>
			<?php echo $form->textField($model,'id',array('size'=>36,'maxlength'=>36, 'readonly'=>'readonly')); ?>
			<?php echo $form->error($model,'id'); ?>

	</td></tr>
	<tr><td>

		<?php echo $form->labelEx($model,'secret_key'); ?>
	</td><td>
		<?php echo $form->textField($model,'secret_key',array('size'=>36,'maxlength'=>36, 'readonly'=>'readonly')); ?>
		<?php echo $form->error($model,'secret_key'); ?>
	</td></tr>
	<tr><td>
			<?php echo "<label>Validity period</label>";//$form->labelEx($model,'start_date'); ?>
	</td><td>
			<?php echo $form->textField($model,'start_date',
						array('style'=>'width:100px;text-align:center',
							'readonly'=>'readonly',)); ?>
			<?php echo $form->error($model,'start_date'); ?>
			-
			<?php echo $form->textField($model,'end_date',
						array('style'=>'width:100px;text-align:center',
							'disabled'=>'disabled','readonly'=>'readonly')); ?>

	</td></tr>
	<tr><td>

			<?php echo $form->labelEx($model,'type'); ?>
	</td><td>
			<?php echo $form->dropDownList($model,'type',
					array('1'=>'30 days trial',
						  '2'=>'Unlimited',
						  '3'=>'Fixed period',
						  '4'=>'Fixed requests'),
					array('onchange'=>'jsOnTypeSelection()')); ?>
			<?php echo $form->error($model,'type'); ?>

	</td></tr>
	<tr><td>
		<div id="noRequests01" class="row" style='display:none;min-height:40px'>
			<?php echo $form->labelEx($model,'no_requests'); ?></div>
		</td><td>
		<div id="noRequests02" class="row" style='display:none;min-height:40px'>
			<?php echo $form->dropDownList($model,'no_requests',
						array('100000' => '1,00,000',
							'200000' => '2,00,000',
							'500000' => '5,00,000',
							'1000000' => '10,000,000',
							'2500000' => '25,00,000',),
						array('style'=>'width:100px;text-align:center',)); ?>
			<?php echo $form->error($model,'no_requests'); ?>
		</div>
	</td></tr>
	
</table>
	<?php echo $form->hiddenField($model,'active_flag'); ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
		
<script>
<!--
	if($("#Application_type").val() == 3){
		$("#Application_end_date").attr("disabled",false);
	}

	function jsOnTypeSelection(){
		var type = $("#Application_type").val();
		if(type == '1'){
			$("#noRequests01").hide();
			$("#noRequests02").hide();
			$("#Application_end_date").attr("disabled","disabled");
			jsSetEndDateByDays(30);
		} else if(type == '2') {
			$("#noRequests01").hide();
			$("#noRequests02").hide();
			$("#Application_end_date").attr("disabled","disabled");
			jsSetEndDateToMax();
		} else if(type =='3') {
			$("#noRequests01").hide();
			$("#noRequests02").hide();
			$("#Application_end_date").attr("disabled",false);
		} else if(type == '4') {
			$("#noRequests01").show();
			$("#noRequests02").show();
			$("#Application_end_date").attr("disabled","disabled");
			jsSetEndDateToMax();
			
		}
	}

	function jsSetEndDateByDays(no_days){
		var start_date = $("#Application_start_date").val();
		if(start_date !== ''){
			var date = start_date.substr(0,2);
			var month = Number(start_date.substr(3,2)); //1-12
			var year = start_date.substr(6,4);
			
			var d = new Date(year, month, date);
			
			$("#Application_end_date").val((no_days+d.getDate())+'/'+d.getMonth()+'/'+d.getFullYear());
		} else {
			$("#Application_end_date").val('');
		}
	}

	function jsSetEndDateToMax(){
		$("#Application_end_date").val('31/12/9999');
	}
-->
</script>
		
<script>
<!--
	$('#Application_end_date').datetimepicker({
		timepicker: false,
		dayOfWeekStart: 1,
		lang: 'en',
		format: 'd/m/Y',
		startDate:'0',
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