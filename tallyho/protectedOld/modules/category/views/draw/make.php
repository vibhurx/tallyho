<?php
/* @var $this category/DrawController */

$this->breadcrumbs=array(
	'Participants',
);

$this->menu=array(
	array('label'=>'Step 3: Save Draw', 'url'=> "javascript: postDrawData()",
			'visible'=> $isTourOwner),
	array('label'=>'Back to Previous Step', 'url'=>array('//participant/draw/index', 'cid'=>$id),
			'visible'=> $isTourOwner),
			);

?>

<h1>Draw Preparation: Step 2 - Draw and Shuffle</h1>
<h2><b><?php echo Lookup::item("AgeGroup", $category->category)?> - <?php echo $tourLocation ?> </b></h2>

<?php 
	// Before the form is called, let the initial values be intelligently set.
	$category->mdraw_size = $totalEnroled <= 8 ? 8 : $totalEnroled <= 16 ? 16 : 32 ;
	$category->qdraw_levels = 1; //typically all the tournaments have 1 qualifying
	$category->mdraw_direct = $totalEnroled % 2 == 0? $totalEnroled /2 : ($totalEnroled + 1)/2; //@todo: check the logic with Yathiraj 
	$category->qdraw_size = $totalEnroled - $category->mdraw_direct;
	
	$this->renderPartial("_formDraw", array(
		'category'=>$category, 
		'totalEnroled'=>$totalEnroled,
		'id' => $id,
		//'showPlayers' => $showPlayers,
	));
?>

<?php 
	//1. Include d3.js framework
	$d3File = Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../d3/d3.js');
	$d3minFile = Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../d3/d3.min.js');
	Yii::app()->clientScript->registerScriptFile($d3File);
	Yii::app()->clientScript->registerScriptFile($d3minFile);
	
	//2.Load the javascript file
	$cssFile=Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../css/drawControl.css');
	$jsFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/drawControl.js');
	Yii::app()->clientScript->registerCssFile($cssFile);
	Yii::app()->clientScript->registerScriptFile($jsFile);
?>

<?php 
/*** HTML part for placing the draw controls - 2 in this case: main-draw and qualifying-draw.				***/
?>

<div style='font-family: Arial; font-weight:bold; color: #0066AA; font-size: 13pt'> Main Draw</div>
<div class="main_draw">	</div>

<div style='font-family: Arial; font-weight:bold; color: #0066AA; font-size: 13pt'>Qualifying Draw</div>
<div class="qual_draw"> </div>

<div id='jsonPlayers' style='display: none'>
<?php //The format is {"141":{"seed":"11","shortName":"Suryashikha B."},"142":{"seed":"13","shortName":"Olivia P."}, ... }
	echo CJSON::encode($participants);
?>
</div>

<script>
	var isTourOwner = <?php echo $isTourOwner? 'true' : 'false'; ?>;

	// Note that the following function uses form-fields of the form attached. Be careful if used in another scenario
	initForDesignTime("main_draw", "qual_draw");
	assignPlayers(true);
</script>
<div id="playerPositions"></div>
<script>
function postDrawData(){
	$("#jsonForPlayerPositions").val(getPlayerPosition());
	$("#mdraw_size").val($("#Category_mdraw_size").val());
	$("#qdraw_size").val($("#Category_qdraw_size").val());
	$("#mdraw_direct").val($("#Category_mdraw_direct").val());
	$("#qdraw_levels").val($("#Category_qdraw_levels").val());
	
	$('a#fb_save').click();
}

function proceed(){
	alert('user wants to proceed');
}

function cancel(){
	alert('user does not want to proceed');
	return false;
}
</script>

<div style='display:none'><div id='savewarning' style='text-align:center'>
<h1>! Caution !</h1>
	You are going to finalize the draw. Any changes to this draw bracket<br> 
	would need you to delete the draw and start all over again. <br><br>
	Press Esc key or select Cancel button if not sure.<br><br><br>
<?php 
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'player-position-form',
	));
	echo CHtml::hiddenField('jsonForPlayerPositions', 'empty');
	echo CHtml::hiddenField('mdraw_size');
	echo CHtml::hiddenField('qdraw_size');
	echo CHtml::hiddenField('qdraw_levels');
	echo CHtml::hiddenField('mdraw_direct');
?> 
	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
		<?php echo CHtml::button('Cancel', array('onclick'=>'parent.$.fancybox.close();')); ?>
	</div>
<?php $this->endWidget(); ?>
</div></div>



<?php 
echo CHtml::link("Fancy link for Posting Draw/Shuffle changes",
	'#savewarning',
	array('title'=>'Save the draw',
		  'style'=>'display:none', 'id'=>'fb_save'));

//Fancybox for Enrol-a-Player
$this->widget(
	'application.extensions.fancybox.EFancyBox',
	array('target'=> '#fb_save',
		  'config'=>array('scrolling' => 'no',
						  'titleShow' => true,
						  'padding'=>40,
						 )));
?>