<?php
/* @var $this ParticipantController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Participants',
);

$this->menu=array(
//	array('label'=>'Draw of 32', 'url'=>array('create', 'cid'=> $cid, 'drawSize'=>'32')),
	array('label'=>'Generate Draw', 'url'=>array('generate', 'cid'=> $cid, 'drawSize'=>16), 'linkOptions' => array('onclick'=>'return getUserConfirmation()')),
);
?>

<h1>Prepare a Draw for <?php echo $tourLocation ?>, <?php echo $categoryName ?> </h1>
<?php $this->renderPartial("_formDraw", array(
		'category'=>$category, 
		'enroledParticipants'=>$dataProvider->totalItemCount
	));
?>

<?php $this->renderPartial("_drawControl", array(
		'dataProvider'=> $dataProvider,
		  'drawSize' => $drawSize,
		'mainEntries' => $category->mdraw_direct,
		 'qualLevels' => $category->qdraw_levels,
	   'totalEnroled' => $dataProvider->totalItemCount
	));
?>


<?php 
/*** HTML part for placing the draw controls - 2 in this case: main-draw and qualifying-draw.				***/
?>
	<h2> Main Draw</h2>
	<div class="main_draw">
		<script>drawMainDraw(struct_main, "main_draw");</script>
	</div>
	<h2>Qualifying Draw</h2>
	<div class="qual_draw">
		<script>drawQualifyingDraw(qualEntries, qualLevels, "qual_draw");</script>
	</div>
	
<?php 

/*** This is the server executable part (PHP)							***/

// Seed-to-Sequence mapping is required for finally placing the players in the approriate boxes.
if($drawSize == 32) {
	$map = array(
			1=> "0_1",  2=>"8_1",   3=>"12_1",  4=>"4_1",   5=>"6_1",  6=>"14_1",  7=>"10_1",  8=>"2_1",  9=>"3_1",  10=>"11_1",
			11=>"15_1", 12=>"7_1",  13=>"9_1",  14=>"13_1", 15=>"3_1", 16=>"1_1",  17=>"1_2",  18=>"9_2", 19=>"13_2", 20=>"5_2",
			21=>"7_2",  22=>"15_2", 23=>"11_2", 24=>"3_2",  25=>"2_2", 26=>"10_2", 27=>"14_2", 28=>"6_2", 29=>"4_2",  30=>"12_2",
			31=>"8_2",  32=>"0_2"
	);
} elseif($drawSize == 16){
	$map = array(
			1=>"0_1",  2=>"4_1",  3=>"6_1",  4=>"2_1",  5=>"3_1",  6=>"7_1",  7=>"5_1", 8=>"1_1",
			9=>"1_2", 10=>"5_2", 11=>"7_2", 12=>"3_2", 13=>"2_2", 14=>"6_2", 15=>"4_2", 16=>"0_2"
	);
} elseif($drawSize <= 8) {
	$map = array(
			1=>"0_1", 2=>"2_1", 3=>"3_1", 4=>"1_1", 5=>"1_2", 6=>"3_2", 7=>"2_2", 8=>"0_2"
	);
}



// @todo: the below temporary random pairing of opponents has to change to something more appropriate.
$arrQualifierIndices = array();
$noQualifiers =  $dataProvider->totalItemCount - $category->mdraw_direct;
for($i=0; $i<$noQualifiers/2; $i++){			//it will work for odd nos as well.
	$arrQualifierIndices[]= $i . "_0";			//push the no twice
	$arrQualifierIndices[]= $i . "_1";
}

// Randomize qualifiers
shuffle($arrQualifierIndices);


// List main and qualifying participants
	$this->widget('zii.widgets.CListView', array(
		 'dataProvider'=> $dataProvider,
			'itemView' => '_cbranch',
	'enablePagination' => false,
			'viewData' => array('mDrawDirect' => $mainEntries,
								 'qualifiers' => $arrQualifierIndices,
						 				 'map'=> $map),
		  
	));
?>
