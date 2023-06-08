<?php
/* @var $this MembershipController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Memberships',
);

$this->menu=array(
	array('label'=>'Create Membership', 'url'=>array('create', 'org_id'=>$org_id)),
	array('label'=>'Back to Organization', 'url'=>array('/organization/default/view', 'id'=>$org_id)),
);
?>

<h1>Member Players</h1>

<?php
//$this->widget('zii.widgets.CListView', array(
//	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
//));
?>

<?php

$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns' => array(
		'regn_no',
		array('name'=>'Given Name', 'value'=>'$data->player->given_name'),
		array('name'=>'Family Name', 'value'=>'$data->player->family_name'),
		array('class'=>'CButtonColumn'),
	)
));  ?>
