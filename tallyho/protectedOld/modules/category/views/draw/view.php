<?php
/* @var $this ParticipantController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Brackets',
);

$label = array(true=>"Qualifying Draw", false=>"Main Draw");
$qual = false;
//$label = $qual?"Main Draw":"Qualifying Draw";
$this->menu=array(
 	array('label'=>'Schedule Matches', 'url'=>array('schedule', 'id'=>$category->id), 'visible'=>$isTourOwner), //Not working well
	array('label'=>'Remake Draw', 'url'=>array('remake', 'id'=>$category->id), 'visible'=>$isTourOwner), //Not working well
	array('label'=>'Back to Tour Details', 'url'=>array('//tour/default/view', 'id'=> $tourId)),
);
?>
<?php 
	$this->headers[0] = Lookup::item("AgeGroup", $category->category) . ' - ' . $tourLocation
?>

<?php 
	$d3File =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../d3/d3.js');
	$d3minFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../d3/d3.min.js');
	Yii::app()->clientScript->registerScriptFile($d3File);
	Yii::app()->clientScript->registerScriptFile($d3minFile);
	
	//2.Load the javascript file
	$cssFile=Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../css/drawControl.css');
	$jsFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/drawControl.js');
	Yii::app()->clientScript->registerCssFile($cssFile);
	Yii::app()->clientScript->registerScriptFile($jsFile);
?>

<?php 
	// Pick the draw-tree parameters and hide in the page for the client-side script to pick
	echo CHtml::hiddenField('Category_mdraw_size',   $category->mdraw_size);
	echo CHtml::hiddenField('Category_qdraw_size',   $category->qdraw_size);
	echo CHtml::hiddenField('Category_qdraw_levels', $category->qdraw_levels);
	echo CHtml::hiddenField('Category_mdraw_direct', $category->mdraw_direct);
?>

<div style='font-family: Arial; color: #0066AA; font-size: 13pt'> <b> Main Draw </b>(Select the winners to see the score)</div>
<div class="main_draw">	</div>

<div style='font-family: Arial; color: #0066AA; font-size: 13pt'><b>Qualifying Draw </b>
<?php if($isTourOwner){ ?>(Select the qualified players for more options) <?php } ?> </div> 
<div class="qual_draw"> </div>

<div class="canvas" style="text-align:center">
</div>

<input type='hidden' id='transferUrl' value='<?php echo $this->createUrl("/match/default/transfer") ?>' />


<div id='jsonPlayers' style='display: none'>
<?php //	The format is {part-id:{'seq': seq1_1, 'seed': seed1 'name': name11}, part-id2: {'seq': seq1_2, 'name': name21}, ... }
	  //	Make json format {"141":{"seed":"11","shortName":"Suryashikha B."},"142":{"seed":"13","shortName":"Olivia P."},...
	echo CJSON::encode($participants);		//@todo: standardize JSON calls.
?>
</div>
<div id='jsonScores' style='display: none'>
<?php 
	echo CJSON::encode($scores);		//@todo: standardize JSON calls.
?>
</div>

<script>
	var isTourOwner = <?php echo $isTourOwner? 'true' : 'false'; ?>;
	// Initialize the mapping arrays, transfer server-side params to the client side,  draw the trees
	// Note that the function below uses form-fields of _drawForm
	initForViewTime("main_draw", "qual_draw");
	assignPlayers(false);
</script>
