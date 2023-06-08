<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs=array(
	'Memberships'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Back to List', 'url'=>array('/organization/membership/index', 'id'=>$model->org_id)),
);
?>

<h1>Create Membership</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'player_name' => $player_name,)); ?>