<?php
/* @var $this PlayerController */
/* @var $model Player */

$this->breadcrumbs=array(
	'Players'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Player', 'url'=>array('index')),
	array('label'=>'Manage Player', 'url'=>array('admin')),
);
?>

<h1>Create your profile</h1>
<b>Todo:</b><br/>
<li>- Disable the prefilled field.</li>
<li>- Calendar control for date of birth</li>
<li>- Player ID is auto generated - so prefill and hide it.</li>
<br/>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>