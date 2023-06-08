<?php
/*	
 * 
 */
/* @var $this MatchController */
/* @var $match Match */

$this->breadcrumbs=array(
	'Matches'=>array('index'),
	$match->id,
);

$this->menu=array(
//	array('label'=>'Start Match', 'url'=>array('index'), 'visible'=>$isUserScorer),
 	array('label'=>'Declare Winner (Walkover)', 'url'=>'javascript:$("a#fb_walkover").click();', // controller/action:: default/walkover
		'visible'=>$isUserScorer && $match->winner == null),
// 	array('label'=>'Update Match', 'url'=>array('update', 'id'=>$match->id)),
 	array('label'=>'Back to Match List', 'url'=>array('index', 'cid'=>$categoryId, 'qual'=>$match->level>0?'0':'1')),
 	array('label'=>'Back to Tour', 'url'=>array('/tour/default/view/', 'id'=>$tourId)),
);
?>

<h1>Match Score <span id='match-status'></span> </h1>
<?php
	if($isUserScorer) {
		echo "<h2>Select players to award points</h2>";
	 }
?>
<div class="view">

	<table>
		<tr>
		
			<td><b>Score Rule:</b>
			<?php echo CHtml::encode(Lookup::item('ScoringRule', $score_rule)); ?>
			</td>
			
			<td><b>Tie-Break Rule:</b>
			<?php echo CHtml::encode(Lookup::item('TieBreakerRule', $tiebreak_rule)); ?>
			</td>
		
			<td><b><?php echo CHtml::encode($match->getAttributeLabel('level')); ?>:</b>
			<?php echo CHtml::encode($match->level > 0 ? 'Round ' . $match->level : 'Qualifying ' . -1*$match->level); ?>
			</td>
		
			<td><b><?php echo CHtml::encode($match->getAttributeLabel('sequence')); ?>:</b>
			<?php echo CHtml::encode($match->sequence); ?>
			</td>
			
		</tr>
	</table>
	<hr/>
<script>
	var gAjaxUpdateUrl = '<?php echo $this->createUrl("/match/default/ajaxupdate") ?>/id/';
</script>
	
<?php 
	//1. Include d3.js framework
	$d3File =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../d3/d3.js');
	$d3minFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../d3/d3.min.js');
	Yii::app()->clientScript->registerScriptFile($d3File);
	Yii::app()->clientScript->registerScriptFile($d3minFile);

	//2.Load the javascript file
	$jsFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/scoring.js');
	Yii::app()->clientScript->registerScriptFile($jsFile);
?>
	
	
	<div style='display:none' id='scoreboard'></div>
	<div id='scoreboardtest'></div>
	<div id='svgarea'></div>
	
	<script>
		var matchId = <?php echo $match->id?>;
		var players = [{"name": "<?php echo isset($match->participant11->player)?$match->participant11->player->fullName: ''?>"}, 
					   {"name": "<?php echo isset($match->participant21->player)?$match->participant21->player->fullName: ''?>"}],
			setScores 	= [],
			lastGame	= [],
			tieBreak	= [],
			empty		= true;

		var
			lastGame = [<?php echo isset($match->game_score1)?$match->game_score1: 0; ?>,
						<?php echo isset($match->game_score2)?$match->game_score2: 0; ?>],
			tieBreak = [<?php echo isset($match->tie_break1)?$match->tie_break1: 0; ?>,
						<?php echo isset($match->tie_break2)?$match->tie_break2: 0; ?>],
	
			theScores = {"setScores": setScores, "lastGame": lastGame, "tieBreak": tieBreak};

				
<?php	//Iterate over the set collection
		foreach($dataProvider->getData() as $record) {	?>
			scoreItem	=  {"set":[0,0]};
			scoreItem.set[0] = <?php echo $record->team1?>;
			scoreItem.set[1] = <?php echo $record->team2?>;
			setScores.push(scoreItem);
			empty = false;
<?php	}	?>
		//Push the 1st empty set if the match has just started
		if(empty) {
			setScores.push({"set":[0,0]});
		}

		$(document).ready(
 				match.initialize(players, theScores, 
				<?php echo isset($score_rule) ? $score_rule : Match::SCORE_RULE_15_GAMES?>,
				<?php echo isset($tiebreak_rule) ? $tiebreak_rule : Match::TIE_BREAK_RULE_SINGLE ?>,
				<?php echo $isUserScorer ? Match::USER_SCORER : Match::USER_VIEWER;?>,
				<?php echo $match->winner == 1 || $match->winner == 2 ? $match->winner-1 : -1 ?>),	
				scoreboard.createDisplay('svgarea', 685, 200),
				scoreboard.flashWinner(<?php echo $match->winner == 1 || $match->winner == 2 ? $match->winner-1 : -1 ?>)
			);
	</script>
	
</div>
<div style='display:none'>
<div id='somediv'>
<form>
	<input name='what'>
	
</form>
</div>
</div>
<?php 
echo CHtml::link("Hidden link for fancybox",
		array('/match/default/walkover', 'id'=>$match->id),
		array('title'=>'Add New Contact',
		  'style'=>'display:none', 'id'=>'fb_walkover'));


//FancyBox for adding category
$this->widget(
		'application.extensions.fancybox.EFancyBox',
		array('target'=> '#fb_walkover',
				'config'=>array('scrolling' => 'no',
						'titleShow' => true,
						'padding'=>40,)));
?>