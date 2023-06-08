<div class="form" style='text-align: center'>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'participant-form',
	'enableAjaxValidation'=>false,
	//'htmlOptions' => array('onsubmit'=>'javascript: return checkEmpty()'),
	));
?>

<?php 
	$jsFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/participant.js');
	Yii::app()->clientScript->registerScriptFile($jsFile);
?>

<script type="text/javascript">
function checkEmpty(){
	if($('#Participant_player_id').val() == null || $('#Participant_player_id').val() == ''){ 
		alert('Select a player, will you.');
		return false;
	}
}

var ajax_save_url = "<?php echo $this->createUrl('enrol/ajaxSave');?>",
	ajax_search_player_url = "<?php echo $this->createUrl('searchPlayer') ?>",
	gender = <?php echo $categoryGender ?>;
</script>

	<?php echo $form->errorSummary($participant); ?>
	<?php echo $form->hiddenField($participant,'tour_id');?>
	<?php echo $form->hiddenField($participant,'category'); ?>

	<?php echo $form->labelEx($participant,'Enter player name'); ?>
	<?php

		echo CHtml::textField('searchName', '', 
				array('style'=>'width:120px',
					  'onkeyup'=>'ajaxSearchPlayers(ajax_search_player_url)',
					  'id' => 'searchName',  
					  ));

		echo "<br/><br/>";
		
		echo CHtml::activeListBox($participant, 'player_id', array(),
				array('id'=>'playerList',
						//'onchange'=>'ajaxEnrolSave(ajax_save_url);',
						'onchange'=>"$('#participant-form').submit()",
						'style'=>'width:320px;height:100px'));
	
		echo "<br/><br/>";
		
		if($is_popped_up)
			;//echo CHtml::Button('Save',array('onclick'=>'ajaxEnrolSave(ajax_save_url);'));
		else
			echo CHtml::submitButton($participant->isNewRecord ? 'Enrol' : 'Save');
	?>
	<i><?php
		//@todo: It is a bad design (spaghatti) to call js from another view. Straighten this up. 
		//echo CHtml::link("Player not there? Create","javascript:init_new_player()");	popup did not work
		echo CHtml::link("Player not there? Create new", array("/player/player/create", "cid"=>$categoryId)); 
		?>. </i><br/>
	
<?php $this->endWidget(); ?>
</div><!-- form -->

