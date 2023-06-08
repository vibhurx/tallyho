<?php
/* @var $this PlayerController */
/* @var $player Player */
/* @var $form CActiveForm */
?>

<div class="form" id="playerDialogForm">

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'player-form',
		'enableAjaxValidation'=>true,
	)); 
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($player); ?>

	<div class="row">
		<?php echo $form->labelEx($player,'id'); ?>
		<?php //echo $player->id; ?>
		<?php //echo $form->textField($player,'id',array('size'=>10,'maxlength'=>10, 'hidden'=> 'true')); ?>
		<?php //echo $form->error($player,'id'); ?>
	</div>
	<br/>
	<div class="row">
		<?php 
			echo $form->labelEx($player,'user_id'); 
			echo $form->textField($player,'user_id',array('size'=>10,'maxlength'=>10)); 
			echo $form->error($player,'user_id');
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($player,'given_name'); ?>
		<?php echo $form->textField($player,'given_name',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($player,'given_name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($player,'family_name'); ?>
		<?php echo $form->textField($player,'family_name',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($player,'family_name'); ?>
	</div>
		
	<div class="row">
		<?php echo $form->labelEx($player,'aita_no'); ?>
		<?php echo $form->textField($player,'aita_no',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($player,'aita_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($player,'aita_points'); ?>
		<?php echo $form->textField($player,'aita_points'); ?>
		<?php echo $form->error($player,'aita_points'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($player,'state'); ?>
		<?php echo $form->dropDownList($player, 'state', Lookup::items('State')); ?>
		<?php echo $form->error($player,'state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($player,'gender'); ?>
		<?php echo $form->dropDownList($player, 'gender', Lookup::items('Gender'));?>
		<?php echo $form->error($player,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($player,'date_of_birth'); ?>
		<?php //echo $form->textField($player,'dateOfBirth'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array('name'=>'date_of_birth',
				'attribute'=>'date_of_birth',
				'model'=>$player,
				'options'=>array('showAnim'=>'fold',),
//				'htmlOptions'=>array('style'=>'height:16px;',),
			));
		?>
		<?php echo $form->error($player,'date_of_birth'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($player,'phone'); ?>
		<?php echo $form->textField($player,'phone',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($player,'phone'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Create New Player',
				CHtml::normalizeUrl(array('//player/default/addnew', 'render'=>false)),
				array('success'=>'js: function(data){
						$("#Participant_player_id").append(data);
						$("#playerDialog").dialog("close");
						alert(data);
					}'
				),
				array('id'=>'closePlayerDialog')
			);
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->