<?php
/* @var $this DrawController */
/* @var $model Category */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenField($model,'tour_id');?>
	</div>
	<table>
		<tr><td style='width:200px'>
		<?php if($model->isNewRecord){ ?>
			<?php echo $form->labelEx($model,'category'); ?>
			</td><td><?php echo $form->dropDownList($model, 'category', $validCategories);?>
			<?php echo $form->error($model,'category'); ?>
		</td></tr>
	
		<tr><td>
		<?php } ?>
			<?php echo $form->labelEx($model,'start_date'); ?>
			</td><td>
			<?php echo $form->textField($model, 'start_date', 
					array('style'=>'width:140px;text-align:center', 'readonly'=>'readonly')); ?>
			<?php //echo $form->textField($model, 'start_time', array('style'=>'width:36px'));?>
			<?php echo $form->error($model,'category'); ?>
		</td></tr>
		
		<tr><td>
			<?php echo $form->labelEx($model,'is_aita'); ?>
			</td><td>
			<?php 
			if($model->is_aita){
				echo $form->dropDownList($model, 'is_aita', array(false=>'No', true=>'Yes'));
			} else {
				echo "No";
			}
			?>
			<?php echo $form->error($model,'is_aita'); ?>
		</td></tr>
			
		<tr><td>
			<?php echo $form->labelEx($model,'draw_status'); ?>
			</td><td><?php echo $form->dropDownList($model, 'draw_status', Lookup::items('DrawStatus'));?>
			<?php echo $form->error($model,'draw_status'); ?>
		</td></tr>
	
		<tr><td>
			<?php echo $form->labelEx($model,'score_type'); ?>
			</td><td><?php echo $form->dropDownList($model, 'score_type', Lookup::items('ScoringRule'));?>
			<?php echo $form->error($model,'score_type'); ?>
		</td></tr>
		
		<tr><td>
			<?php echo $form->labelEx($model,'tie_breaker'); ?>
			</td><td><?php echo $form->dropDownList($model, 'tie_breaker', Lookup::items('TieBreakerRule'));?>
			<?php echo $form->error($model,'tie_breaker'); ?>
		</td></tr>
	</table>
	
	<div style="border:1px solid lightgray;border-radius:4px;padding:10px">
		<?php if($model->tour->type == Tour::TYPE_SOME_FREE) { 
					echo $form->labelEx($model,'is_paid',array('style'=>'display:inline'));
					echo $form->checkBox($model, 'is_paid',
						array('style'=>'height:32px', 
								'onclick'=>'this.checked?$("#fees").show():$("#fees").hide()'));
			  } elseif($model->tour->type == Tour::TYPE_ALL_PAID){
					echo $form->labelEx($model,'is_paid', array('style'=>'display:inline'));
					echo " : ";
					echo $form->hiddenField($model, 'is_paid');//,
					echo CHtml::checkBox('Dumm', $model->is_paid,
						array('style'=>'height:52px', 
								'disabled'=>'disabled'));
			  }
		?>
	<div id="fees" style="display:<?php echo $model->is_paid?'block':'none'; ?>">
	<table>
		<tr><td style='width:200px'>
			<?php echo $form->labelEx($model,'member_fee'); ?>
			</td><td><?php echo $form->textField($model, 'member_fee', array('style'=>'width:50px'));?> in INR
			<?php echo $form->error($model,'member_fee'); ?>
		</td></tr>
		
		<tr><td>
			<?php echo $form->labelEx($model,'others_fee'); ?>
			</td><td><?php echo $form->textField($model, 'others_fee', array('style'=>'width:50px'));?> in INR
			<?php echo $form->error($model,'others_fee'); ?>
		</td></tr>
	</table>
	</div>
	</div>
	<br>
	<table>	
		<tr><td style='text-align:center'><?php
			echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'mainSubmitAction')); 
			?></td></tr>
	</table>
<?php $this->endWidget(); ?>

</div><!-- form -->

			
<!-- <script src="./jquery.datetimepicker.js"></script> -->
<script>
	$('#Category_start_date').datetimepicker({
		timepicker: true,
		dayOfWeekStart : 1,
		lang:'en',
		format: 'd/m/Y H:i',
		closeOnTimeSelect: true,
	});
// 	$('#Category_start_date').datetimepicker({value:'2015/04/15'});

// 	$('#Category_start_time').datetimepicker({
// 		datepicker: false,
// 		format:'H:i',
// 		lang:'en'
// 	});
// 	$('#Category_start_time').datetimepicker({value:'08:00'});
</script>