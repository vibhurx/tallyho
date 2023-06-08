<?php
/* @var $this CommonController */
/* @var $model Organization */
/* @var $dataProvider Contact */

$this->breadcrumbs=array(
	'Tour',
	'Category',
	$model->id,
);
//$this->backLink = $this->createUrl('/category/default/index', array('tid'=>$model->tour->id));
$this->headers[0] = 'Track: ' . Lookup::item("AgeGroup",$model->category);

$this->menu=array(
	array('label'=>'Edit', 'url'=>array('update', 'id'=>$model->id), 'visible'=>$isTourOwner),
	array('label'=>'Bracket', 'url'=>array('/category/draw/view', 'id'=>$model->id)),
	array('label'=>'Enrol', 'url'=>array('/participant/enrol/create', 'cid'=>$model->id, 'src'=>1)),
	array('label'=>'Back', 'url'=>array('/category/default/index', 'tid'=>$model->tour->id)),
);
?>
<div class='row-fluid'>
	<div class='span6'>
		<span style='color:#888;font-size:12pt'> Basic</span>
		<div style='min-height:10px'></div>
		<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array('name'=>'location', 'value'=>$model->tour->location),
			array('name'=>'start_date', 'value'=>date_format(date_create_from_format('Y-m-d H:i:s', $model->start_date), 'd M Y H:i')),
			array('name'=>'draw_status', 'value'=>Lookup::item("DrawStatus",$model->draw_status)),
		),
		)); ?>
		<div class='clear' style='min-height:30px'></div>
	
		<span style='color:#888;font-size:12pt'> Additional information</span>
		<div style='min-height:10px'></div>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'mdraw_size',
				'qdraw_size',
				'qdraw_levels',
				'mdraw_direct',
			),
		)); ?>
	</div>
	<!-- Second Column -->
	<div class='span6' style='border: 0px solid gray;min-height:490px'>
		<span style='color:#888;font-size:12pt'> Regulation </span>
		<div style='min-height:10px'></div>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				array('name'=> 'is_aita', 'value'=>$model->is_aita?'Yes':'No'),
				array('name'=> 'score_type', 'value'=>Lookup::item('ScoringRule', $model->score_type)),
				array('name'=> 'tie_breaker', 'value'=>Lookup::item('TieBreakerRule', $model->tie_breaker)),
			),
		)); ?>
		<div class='clear' style='min-height:30px'></div>
		
		<span style='color:#888;font-size:12pt'> Fees </span>
		<div style='min-height:10px'></div>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				array('name'=> 'is_paid', 'value'=>$model->is_paid?'Yes': 'No'),
				array('name'=> 'member_fee', 'value'=>$model->member_fee, 'visible'=>$model->is_paid),
				array('name'=> 'others_fee', 'value'=>$model->others_fee, 'visible'=>$model->is_paid),
			),
		)); ?>
	
	</div>
</div>
