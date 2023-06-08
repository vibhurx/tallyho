<?php
/* @var $this PlayerController */
/* @var $model Player */
//echo 'Mukul wuz here';
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
		'id'=>'playerDialog',
		'options'=>array(
			'title'=>'Create New Player',
			'autoOpen'=>true,
			'modal'=>'true',
			'width'=>'auto',
			'height'=>'auto',
		),
));

//TEMP: Remoev after testing
$player->aita_no = 999;
$player->aita_points = 99;
$player->date_of_birth = '11/26/1996';
$player->family_name = 'Manciano';
$player->gender = 0;
$player->given_name = 'Rocky';
$player->phone = '0894578115';
$player->state = 14;
//-------------
echo $this->renderPartial('_formDialog', array('player'=>$player));
?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
