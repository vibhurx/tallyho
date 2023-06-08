<?php
/* @var $this CommonController */
/* @var $model Organization */
/* @var $dataProvider Contact */

$this->breadcrumbs=array(
	'Organizations', //=>array('index'),
	$model->name,
);

$this->menu=array(
//	array('label'=>'List Organization', 'url'=>array('index')),
	array('label'=>'Update Organization', 'url'=>array('update', 'id'=>$model->id),'visible'=> $isOrgAdmin),
	//array('label'=>'Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Add Contact', 'url'=>array('/contact/contact/create')),
	array('label'=>'Staff', 'url'=>array('staff', 'id'=>$model->id), 'visible'=> $isOrgAdmin),
	//array('label'=>'Member Players', 'url'=>array('//organization/membership/index', 'id'=>$model->id),),
);
?>
<style>
th {
	text-align:left;
	width:150px;
	}
</style>
<?php
	$this->headers[0] = 'Organization Information';
?>
<div class='row-fluid'>
<div class='span6'>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'address_line_1',
		'address_line_2',
		'city',
		array('name' => 'state', 'value' =>Lookup::item('State', $model->state)),
		'postal_code',
		'telephone',
	),
)); ?>
</div>
<div class='span4'>
<?php
	if($model->logo == null){
		echo  CHtml::image(Yii::app()->request->baseUrl . '/images/organization.png', 'club-name',
			array('style'=>'width:200px;'));
	} else {
		echo CHtml::image(Yii::app()->request->baseUrl . '/images/olog/' . $model->id . '/' . $model->logo, 'club-name',
			array('style'=>'width:200px;'));
	}
?>
<?php 
	if(Yii::app()->user->isOrgContact($model->id)){
		echo CHtml::link("Change logo", "#upload_logo",
				array('title'=>'Select an image file', 'id'=>'fb_logo'));
		
		$this->widget('application.extensions.fancybox.EFancyBox',
				array(	'target'=> '#fb_logo', 'config'=>array('scrolling'=>'no',
						'titleShow' => true, 'padding'=>40)));
	}
?>
</div>

<!-- div style='width:100%;background:steelblue;color:white;font-size:12pt'>Tournaments</div>
<div style='border:1px solid steelblue' -->
<?php
// $this->widget('zii.widgets.grid.CGridView', array(
// 		'dataProvider'=>$tourProvider,
// 		'columns'=>array(
// 			array('name'=> 'location',
// 				'type'=>'raw', 
// 				'value'=>'CHtml::link($data->location, array("default/view", "id"=>$data->id))',
// 				),
// 			array(	'name' => 'Level', 'value' => 'Lookup::item("TourLevel", $data->level)'),
// 			array(	'name'=>'start_date',
// 				'value'=>'date("M d, Y", strtotime($data->start_date))',),
// 			array(	'name'=>'enrolby_date',
// 				'value'=>'date("M d, Y", strtotime($data->enrolby_date))',),
// 			array(	'name' => 'court_type', 'value' => 'Lookup::item("CourtType", $data->court_type)'),
// 			array(	'name' => 'status', 'value' => 'Lookup::item("TourStatus", $data->status)'),
// 			array( 'header'=>'Manage', 
// 				'class'=>'CDataColumn',
// 				'type' => 'raw',
// 				'value' => 'Yii::app()->user->isTourOwner($data->id)?
// 						CHtml::link("Edit", array("default/update", "id"=>$data->id)) : ""',
// 				'htmlOptions' => array('style' => 'text-align:center'),),
// 			//array( 'name' => 'Organized by', 'value' => '$data->organization->name'),
// 		),
// ));
// ?>
<!-- </div> -->

<?php
// 	$this->widget('zii.widgets.grid.CGridView', array(
// 	'dataProvider'=>$staffProvider,
// 	'columns' => array(
// 		array('name' => 'First Name', 'value' => '$data->organization->id'),

// 		'given_name',
// 		'family_name',
// 		'email',
// 		array( 'header' => 'Admin?',
// 				'class' => 'CDataColumn',
// 				'value' => '$data->user_id == $data->organization->admin_id?"Yes":""',
// 				'htmlOptions' => array('style' => 'text-align:center'),),
// 		array( 'header' => 'Active?',
// 				'class' => 'CDataColumn',
// 				'value' => '$data->user->status?"Yes":"No"',
// 				'htmlOptions' => array('style' => 'text-align:center'),),
// 		array( 'header' => 'Manage',
// 				'class' => 'CDataColumn',
// 				'type' => 'raw',
// 				'value' => '$data->user_id == $data->organization->admin_id?"":CHtml::link("Delete", "javascript:confirmDeletion(" . $data->user_id . ")")',
// 				'visible' => $isOrgAdmin,
// 				'htmlOptions' => array('style' => 'text-align:center'),),
// 	)
// )); ?>
</div>
<?php

//Category popup target link 
//Alternative approach - when contact herself creates the user and org-admin links her to the org
// echo CHtml::link("Hidden link for fancybox",
// 		array('/organization/org8nLink/create', 'oid' =>$model->id),
// 		array('title'=>'Add New Contact',
// 		  'style'=>'display:none', 'id'=>'fb_add_cont'));

//The main approach - when org-admin creates the contact and email is sent out to the contact with password change
//link (or confirmation change)
echo CHtml::link("Hidden link for fancybox",
		array('/registration/registration/contactRegistration'),
		array('title'=>'Add New Contact',
		  'style'=>'display:none', 'id'=>'fb_add_cont'));


//FancyBox for adding category
$this->widget(
		'application.extensions.fancybox.EFancyBox',
		array('target'=> '#fb_add_cont',
				'config'=>array('scrolling' => 'no',
						'titleShow' => true,
						'padding'=>40,)));

?>
			
<div style='display: none'>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'upload_logo',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<?php echo $form->labelEx($model, 'logo_file');?> : 
<?php echo $form->fileField($model, 'logo_file', null);?>
<?php echo CHtml::submitButton('Upload'); ?>

<?php $this->endWidget(); ?>
</div>

<script>
<!--
	confirmDeletion = function(id){
		if(confirm("Are you sure to delete the current employee from your list?")){
			var cHref = '<?php echo $this->createUrl("/contact/contact/delete")?>/id/' + id;
			location.href = cHref;
		}
	}
-->
</script>