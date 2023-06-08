<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);

$this->menu=array(
		array('label'=>'Payment History', 'url'=>array('paymentHistory')),
		//array('label'=>'Manage Player', 'url'=>array('admin')),
);
?>


<h1>My Payments</h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$payments,
	'columns' => array(
// 		array('name' => 'Location',
// 			  'type' => 'raw',
// 			  'value' => '$data->participant->tour->location',
			//'value' => 'CHtml::link(Tour::model()->findByPk($data->tour_id)->location, array("/tour/default/view", "id"=>$data->tour_id))',
// 		),
		array('name' => 'entry_date', 'value' => 'date_format(date_create($data->entry_date), "d-M-Y - H:i")',
				'htmlOptions' => array('style' => 'text-align:center')),
		array('name' => 'amount', 'value' => '$data->amount',
				'htmlOptions' => array('style' => 'text-align:center')
		),
		array('name' => 'direction', 'value' => '$data->direction?"Paid":"Refund"',
				'htmlOptions' => array('style' => 'text-align:center')
		),
		array('name' => 'free_text', 'value' => '$data->free_text', 
				'htmlOptions' => array('style' => 'min-width:120px')
			),
		)
	));

 ?>


