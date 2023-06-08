<h1> Test Page for Web-Services with POST</h1>
<h2> Currently being tested: <i>wsScoreUpdate</i></h2>
<?php
//$url_path = '/user/user/wsLogin';
$url_path = '/match/default/wsAdjustScore';

$form=$this->beginWidget('CActiveForm', array('id'=>'test-web-service-form', 'method'=>'POST', 'action'=> array($url_path)));
$template = '{
	"id": "1",
	"scores": {
		"set": [3,3],
		"game": [30,30],
		"tie-break":[0,0]
	}
}';

echo CHtml::textArea('data', $template, array('style' => 'height:150px;width:400px'));
?>
<br>
<?php 
echo CHtml::submitButton('Post it');
$this->endWidget();
?>
<br><hr>
<?php 
if (isset($result)){
	echo $result;
}
?>