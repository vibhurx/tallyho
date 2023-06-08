<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs=array(
	'Organization'=>array('/organization/membership/default/view', 'id'=>$model->id),
	'Memberships'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Back to List', 'url'=>array('index','id'=>$model->organization->id)),
	//array('label'=>'Create Membership', 'url'=>array('create')),
	array('label'=>'Update ', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage Membership', 'url'=>array('admin')),
);
?>

<h1>Membership Details: <?php echo $model->player->fullName ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'regn_no',
		//array('name' => 'Player', 'value' =>$model->player->fullName),
		array('name' => 'Org', 'value' =>$model->organization->name),
		'rank',
		'points',
		array('name'=>'since', 'value'=>date_format(date_create($model->since), 'd/m/Y'))
	),
)); ?>
