<style>
a.actionButton {
	display:block;
	text-decoration:none;
	background-color:#09F;
	padding: 0.5em 2em;
	margin:0;
	border-right: 1px solid #fff;
	color:#FFF;
	font-weight:bold;
	font-size: 14pt;
}

</style>
<div>
	<h1> This match does not have a scorer</h1>
	<div style='width:600px; text-align: center'>
		<?php echo CHtml::link('Would you like to score this match?', array('', 'id'=>$match_id, 'new'=>'1'),
			array('class'=>'actionButton', 'style'=>'background:darkgreen')) ?>
		<br>
		<?php echo CHtml::link('Would you just view the scoreboard?', array('', 'id'=>$match_id, 'new'=>'0'),
			array('class'=>'actionButton', 'style'=>'background:red')) ?>
		
		<?php if($isUserMainContact){ ?>
		<br>
		<?php echo CHtml::link('Would you let someone else score this?', array('', 'id'=>$match_id, 'new'=>'0'),
			array('class'=>'actionButton', 'style'=>'background:blue')) ?>
		<?php } ?>
	</div>
</div>