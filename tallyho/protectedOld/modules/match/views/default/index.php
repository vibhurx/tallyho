<?php
$this->breadcrumbs=array(
	'Matches'=>array('index'),
);

$this->menu=array(
//	array('label'=>'Start Match', 'url'=>array('index'), 'visible'=>$isUserScorer),
// 	array('label'=>'Update Match', 'url'=>array('update', 'id'=>$match->id)),
 	array('label'=>'Back to Tour', 'url'=>array('/tour/default/view/', 'id'=>$tourId)),
);

$this->header01 = $isQual ? 'Qualifying Matches' : 'Main Draw Matches';
$this->backLink = $this->createUrl('/category/default/index', array('tid' =>$tourId));

 ?>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'columns'=>array(
 				array('name' => 'Round', 'value' => '$data->level', 'htmlOptions' => array('style'=>'text-align:center')),
 				array('name' => 'start_date', 'value' => '$data->start_date == 0? "-": date("d/m/Y h:i A",strtotime($data->start_date))', 'htmlOptions' => array('style'=>'text-align:center')),
				array('name' => 'player11', 
						'value' => 'isset($data->player11)?$data->participant11->player->fullName:""',
						'cssClassExpression' => '$data->winner==1?"cssMatchWinner":""'),
				array('name' => 'player21', 
						'value' => 'isset($data->player21)?$data->participant21->player->fullName:""',
						'cssClassExpression' => '$data->winner==2?"cssMatchWinner":""'),
 				array('name' => 'court_no', 'value' => '$data->court_no', 'htmlOptions'=>array('style'=>'text-align:center')),
				array('name' => 'Status', 
						'value' => 'isset($data->winner)?"Finished":(isset($data->scorer)?"Ongoing":"Not Started")',
						'cssClassExpression' => 'isset($data->winner)?"cssMatchFinished":(isset($data->scorer)?"cssMatchOngoing": "")',
						'htmlOptions' => array('style'=>'text-align:center')),
 				array('name' => 'scorer', 'value' => 'isset($data->scorer)?Contact::model()->findByPk($data->scorer)->fullName:""'),
				array('name' => 'Action', 'type' => 'raw', 'value' => 'CHtml::link(isset($data->winner)?"Scoreboard":"Score this", array("score", "id"=>$data->id))',
						'visible' => $isTourOwner),
				array('name' => 'Action', 'type' => 'raw', 'value' => 'CHtml::link("Scoreboard", array("score", "id"=>$data->id))',
						'visible' => !$isTourOwner),
 		),
));
?>
<script>
<!--
function scorer_confirmation(href, id){
	if(confirm("Are you ready to score this match?")){
		location.href = href + id;
	} else {
		return false;
	}
}
-->
</script>
