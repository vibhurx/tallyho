<div class="form" style='text-align: center'>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'player-selection-form',
	'enableAjaxValidation'=>false,
	));
?>
<script type="text/javascript">
function checkEmpty(){
	if($('#Participant_player_id').val() == null || $('#Participant_player_id').val() == ''){ 
		alert('Select a player, will you.');
		return false;
	}
}

var ajax_save_url = "<?php echo $this->createUrl('membership/ajaxSave');?>",
	ajax_search_player_url = "<?php echo $this->createUrl('/participant/enrol/searchPlayer') ?>";
	gender = null;
</script>

	<?php echo 'Enter player name' ?>
	<?php
		echo CHtml::textField('searchName', '', 
				array('style'=>'width:120px',
					  'onkeyup'=>'ajaxSearchPlayers(ajax_search_player_url)',
					  'id' => 'searchName',  
					  ));

		echo "<br/><br/>";
		
		echo CHtml::listBox('player_id', null, array(),
				array('id'=>'playerList',
						'onchange'=>"$('#Membership_player_id').val(this.value);
									 $('#player_name').val(this.options[this.selectedIndex].innerHTML);
									 parent.$.fancybox.close();",
						'style'=>'width:320px;height:100px'));
	
		echo "<br/><br/>";
		
	?>
<?php $this->endWidget(); ?>
</div><!-- form -->

