<?php
/* @var $this PlayerController */
/* @var $dataProvider CActiveDataProvider */
/* @var $this DefaultController */

$this->pageTitle=Yii::app()->name . ' - Our Tournaments';
$this->breadcrumbs=array(
	$this->module->id,
);
$this->information = "The list of the tournaments which are currently running or upcoming. A player can enroll in these tournaments
				as long as their status shows as <i>'Inviting'</i>.<br/>
				Follow the hyperlink to view the details of the tournament.";
?>
<?php
if(Yii::app()->user->data()->type == YumUser::TYPE_CONTACT){
	$this->menu=array(
			array('label'=>'Create Tournament', 'url'=>array('create'),),
			//array('label'=>'Create Tournament', 'url'=>array('create'),),
	);
}

$this->header01 = 'Our Tournaments';
$this->backLink = null;
?>

<?php
// $this->widget('zii.widgets.grid.CGridView', array(
// 		'dataProvider'=>$dataProvider,
// 		'columns'=>array(
// 			array('name'=> 'location',
// 				'type'=>'raw', 
// 				'value'=>'CHtml::link($data->location, array("default/view", "id"=>$data->id))',
// 				),
// 			array(	'name' => 'Level', 'value' => 'Lookup::item("TourLevel", $data->level)'),
// 			array(	'name'=>'start_date',
// 				'value'=>'date("d M Y", strtotime($data->start_date))',),
// 			array(	'name'=>'enrolby_date',
// 				'value'=>'date("d M Y", strtotime($data->enrolby_date))',),
// 			array(	'name' => 'court_type', 'value' => 'Lookup::item("CourtType", $data->court_type)'),
// 			array(	'name' => 'status', 'value' => 'Lookup::item("TourStatus", $data->status)'),
// 			array( 'header'=>'Manage', 
// 				'class'=>'CDataColumn',
// 				'type' => 'raw',
// 				'value' => 'Yii::app()->user->isTourOwner($data->id)?
// 						CHtml::link("Edit", array("default/update", "id"=>$data->id)) : ""',
// 				'htmlOptions' => array('style' => 'text-align:center'),),
// 			//array( 'name' => 'Organized by', 'value' => '$data->organization->name'),
// 		),
// ));
?>
<style>
.main{
    width:100%;
    border: 0px solid purple;
}

.main .inner{
    margin:10px;
    min-width: 300px; border: 0px solid purple;
}

.main .inner .tile{
    margin:10px;
    height: 265px;
    width: 265px;
    display: inline-block; border: 0px solid purple;
}

.main .inner .tile td{
	border:none;
}
</style>
<div class="main">
    <div class="inner">

<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_responsiveItem',
	))
?>
	
	</div>
</div>