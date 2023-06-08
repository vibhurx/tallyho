<style>
<!--
table.detail-view th
{
/*     text-align: right; */
/*     width: 260px; */
/*     height: 30px; */
}

table.detail-view tr.odd
{
 /*	background:#E5F1F4; */
}

table.detail-view tr.even
{
	background:#F8F8F8;
}
-->
</style>
<?php
if(!$profile = $model->profile)
	$profile = new YumProfile;


$this->pageTitle = Yum::t('Profile');
$this->title = CHtml::activeLabel($model,'username');
$this->breadcrumbs = array(Yum::t('Profile'), $model->username);
Yum::renderFlash();
?>

<?php 
	$this->headers[0] = "Profile Information ";
	
	$this->menu=array(
			array('label'=>'Back', 'url'=>Yii::app()->user->returnUrl),
			//array('label'=>'Manage Player', 'url'=>array('admin')),
	);
?>
<div class='row-fluid'>
	<div class='span4'>
		<span style='color:#888;font-size:12pt'> Gravatar</span>
		<div style='min-height:10px'></div>
		<?php
			echo $model->getAvatar();
			if(!Yii::app()->user->isGuest && Yii::app()->user->id == $model->id){
				echo '<br>';
				echo CHtml::link(Yum::t('Upload avatar image'), array('//avatar/avatar/editAvatar'));
			}
		?>
	</div>
	<div class='span6'>
		<span style='color:#888;font-size:12pt'> Basic</span>
		<div style='min-height:10px'></div>
		<?php $this->renderPartial(Yum::module('profile')->publicFieldsView, array(
			'profile' => $model->profile)); ?>
	</div>
</div>
<br />
<div class='row-fluid'>
<?php
if(Yum::hasModule('friendship'))
$this->renderPartial(
		'application.modules.friendship.views.friendship.friends', array(
			'model' => $model)); ?>
<br />
<?php
if(@Yum::module('message')->messageSystem != 0)
$this->renderPartial('/message/write_a_message', array(
			'model' => $model)); ?>
<br />
<?php
if(Yum::module('profile')->enableProfileComments
		&& Yii::app()->controller->action->id != 'update'
		&& isset($model->profile))
	$this->renderPartial(Yum::module('profile')->profileCommentIndexView, array(
			 'model' => $model->profile)); ?>
 
<?php
	if(!Yii::app()->user->isGuest && Yii::app()->user->id == $model->id) {
		echo CHtml::link(Yum::t('Edit profile'), array('//profile/profile/update'));
	}

?>

</div>