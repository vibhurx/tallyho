<?php
/* @var $this CommonController */
/* @var $model Organization */

$this->breadcrumbs=array(
	'Organizations',
	'Create',
);

$this->menu=array(
// 	array('label'=>'List Organization', 'url'=>array('index')),
// 	array('label'=>'Manage Organization', 'url'=>array('admin')),
);

$this->headers[0] = "Organization/Club Information ";

?>
<div class='row-fluid'>
	<div class='span6'>
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>