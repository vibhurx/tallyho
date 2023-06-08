<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);

$this->menu=array(
		array('label'=>'Add New Application', 'url'=>array('application/create', 'did'=>$developer->id)),
		//array('label'=>'Update Application', 'url'=>array('update', 'id'=>$model->id)),
);

?>
<h1>Developer Area</h1>

<h2>Developer Details</h2>
<div style='border:1px solid'>
<table>
	<tr><td>
		<label>Developer ID: </label><?php echo $developer->id?> 
	</td><td>
		<label>Name: </label><?php echo $developer->fullName?> 
	</td></tr>
	<tr><td>
		<label>User Name: </label><?php echo Yii::app()->user->data()->username?> 
	</td><td>
		<label>Company: </label><?php echo $developer->company_name; ?> 
	</td></tr>
</table>
</div>
<br>
<br>
<h2>My Applications</h2>
<div style='border:1px solid'>
<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	));
?>
</div>
</p>