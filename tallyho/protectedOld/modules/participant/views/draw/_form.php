<?php
/* @var $this ParticipantController */
/* @var $model Participant */
/* @var $form CActiveForm */
?>
<!-- TODO:
	Currently there is some sort of constraint between participant and match object (why? donno).
	Moreover the foreign key reference is inconsitent for the player id. Some place it in int(11)
	to be filled by an auto-incremented number and some places it is email ID. I guess it needs
	to be changed to email ID everywhere.
-->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'participant-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); 
	$tour = Tour::model()->findByPK($_GET['id']); // id is the tour id... remember !!!
	
	$categories = $tour->categories ;
	
	if(isset(Yii::app()->user)){
		echo "You are registering as <span style='color:blue;font-weight:bold'> " . Yii::app()->user->name . 
				"</span> for the tournament in <span style='color:blue;font-weight:bold'>" .
				$tour->location . "</span> starting on <span style='color:blue;font-weight:bold'>" . 
				$tour->startDate . "</span>.";
				$model->player_id = Yii::app()->user->data()->player->id;
	} else {
		echo "Something is wrong with the player object";
		exit(0);
	}
	
	// Test-code:: echo "Player ID (should be email) " . $model->player_id;
	
	$lsCategories = array();
	foreach ($categories as $category){
		$lsCategories[$category->id] = Lookup::item('AgeGroup', $category->category);	
	}

	?>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo CHtml::activeDropDownList($model,'category_id', $lsCategories ); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'player_id'); ?>
		<?php echo $form->hiddenField($model,'player_id',array('size'=>10,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'player_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Enrol' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->