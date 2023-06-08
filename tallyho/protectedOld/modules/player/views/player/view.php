<?php
/* @var $this PlayerController */
/* @var $model Player */

$this->breadcrumbs=array(
	'Players'=>array('index'),
	$model->id,
);

$this->menu=array(
	//array('label'=>'List Player', 'url'=>array('index')),
	array('label'=>'Update profile', 'url'=>array('update', 'id'=>$model->id),
		'visible' => Yii::app()->user->data()->id == $model->user_id),
	array('label'=>'Back', 'url'=>array('/user/user/')),
	//array('label'=>'Manage Player', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->fullName  ?> - Profile</h1>
<table>
<tr>
	<td>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
				'user_id',
				'given_name',
				'family_name',
				'aita_no',
				'aita_points',
				array('name' => 'state', 'value' => Lookup::item('State', $model->state)),
				array('name' => 'gender', 'value' => Lookup::item('Gender', $model->gender)),
				//array('name' => 'date_of_birth', 'value' => date_format(date_create($model->date_of_birth), 'd/m/Y')),
				array('name' => 'date_of_birth', 'value' => date_format(date_create($model->date_of_birth), 'd M Y')), 
		//			'value' =>Yii::app()->dateFormatter->format('dd/MM/yyyy',$model->date_of_birth)),
				'phone',
			),
		)); ?>
	</td>
	<td>
	<?php
		if($model->picture == null){
			echo  CHtml::image(Yii::app()->request->baseUrl . '/images/person.png', 'player',
				array('style'=>'width:200px;'));
		} else {
			echo CHtml::image(Yii::app()->request->baseUrl . '/images/ppic/' . $model->id . '/' . $model->picture, 'club-name',
				array('style'=>'width:200px;'));
		}
	?><br>
	<?php 
		if(Yii::app()->user->isPlayer())
			if($model->id == Yii::app()->user->data()->player->id){
				echo CHtml::link("Change logo", "#upload_logo",
						array('title'=>'Select an image file', 'id'=>'fb_logo'));
				
				$this->widget('application.extensions.fancybox.EFancyBox',
						array(	'target'=> '#fb_logo', 'config'=>array('scrolling'=>'no',
								'titleShow' => true, 'padding'=>40)));
			}
	?>
	</td>
</tr>
</table>	


<div style='display: none'>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'upload_logo',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<?php echo $form->labelEx($model, 'picture_file');?> : 
<?php echo $form->fileField($model, 'picture_file', null);?>
<?php echo CHtml::submitButton('Upload'); ?>

<?php $this->endWidget(); ?>
</div>
