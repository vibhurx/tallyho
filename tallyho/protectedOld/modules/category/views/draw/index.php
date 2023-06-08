<?php
/* @var $this DrawController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Categories',
);

$this->menu=array(
	array('label'=>'Back to Tour Details', 'url'=>array('../tour/view', 'id'=> $tourId)),
		
	//array('label'=>'Create Category', 'url'=>array('create')),
	//array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

<h1>Categories (deprecated)</h1>
<p> Todo: Display the Tournament name and dates <br/>
 Done: Filter list only for the selected tournament <br/>
Skip: The breadcrumb should show the complete path like Home >> Tours >> Enrol >> etc. (because this screen has to be a popup)<br/>
 <?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){location.href= "' . $this->createUrl('../../participant/draw/view') . '/cid/"+$.fn.yiiGridView.getSelection(id);}',
	'columns'=>array(
		'id',	
		'tour_id',
		array('name' => 'category', 'value' => 'Lookup::item("AgeGroup", $data->category)'),
		array('name'=>'draw_status', 
				'value'=>'Lookup::item("DrawStatus",$data->draw_status)',
				'visible' => !$isTourOwner),
		array('name'=>'draw_status',
				'type'=> 'raw',
				'value' => 'CHtml::link(Lookup::item("DrawStatus", $data->draw_status),
										array("//participant/draw/index/cid/" . $data->id))',
				'htmlOptions' => array('style' => 'text-align:center'),
				'visible' => $isTourOwner,
		),
// 		array( 'header'=>'Manage',
// 				'class'=>'CDataColumn',
// 				'type' => 'raw',
// 				'value' => 'CHtml::link("Enrollments", array("//participant/draw/index/cid/" . $data->id))',
// 				'visible'=>  $isTourOwner,
// 				'htmlOptions' => array('style' => 'text-align:center'),
// 		),
	))
); ?>
 <?php	if($isTourOwner){ ?>
			Select the links to manage the list of participants.<br/>
<?php 	} else { ?>
			Select a row to view the draw (if prepared).<br/>
<?php 	} ?>
