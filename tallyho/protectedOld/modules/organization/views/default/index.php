<?php
/* @var $this CommonController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Organizations',
);

$userType = Yii::app()->user->data()->type;

$this->menu=array(
// 	array('label'=>'Create Organization',
// 			'url'=>array('create'),
// 			'visible'=> $userType == YumUser::TYPE_CONTACT || $userType == YumUser::TYPE_ADMIN 
// 	),	Currently one user can have only one organization.
	array('label'=>'Manage Organization',
			'url'=>array('admin'),
			'visible'=>$userType == YumUser::TYPE_ADMIN),
);
?>

<h1>Organizations</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns' => array(
		'id',
		'name',
		'address_line_1',
		'address_line_2',
		'city',
		array('name'=>'state', 'value'=>'Lookup::item("State", $data->state)'),
		'postal_code',
	)
)); ?>
