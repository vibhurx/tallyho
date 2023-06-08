<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs=array(
	'Memberships'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'Cancel Update', 'url'=>array('index')),
	//array('label'=>'Create Membership', 'url'=>array('create')),
	array('label'=>'Cancel Update', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage Membership', 'url'=>array('admin')),
);
?>

<h1>Update Membership <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'player_name' => $player_name,)); ?>