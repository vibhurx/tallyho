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
/* 	background:#E5F1F4; */
}

table.detail-view tr.even
{
	background:#F8F8F8;
}
-->
</style>

<?php
/* @var $this HostController */
/* @var $model Host */

// if($isTourOwner)
// 	$this->backLink = $this->createUrl("/tour");
// else
// 	$this->backLink = $this->createUrl("/site/index");

$userType = Yii::app()->user->isGuest? -1 : Yii::app()->user->data()->type;

if($isTourOwner){
	switch($model->status) {
		case Tour::STATUS_DRAFT:
			$label1 = 'Publish this Tour';
			$label2 = '';
			break;
		case Tour::STATUS_INVITING:
			$label1 = 'Hide this Tour';
			$label2 = 'Stop Enrolment';
			break;
		case Tour::STATUS_UPCOMING:
			$label1 = 'Hide this Tour';
			$label2 = 'Start Matches';
			break;
		case Tour::STATUS_ONGOING:
			$label1 = 'Hide this Tour';
			$label2 = 'Closedown this Tour';
			break;
		default:
			$label1 = '';
			$label2 = '';
	}

	
	if($label1 != '')
		$this->menu[] =
				array('label'=>$label1, 
						'url'=>$model->status == Tour::STATUS_DRAFT
								? array('/tour/default/publish/', 'id'=>$tourId)
								: array('/tour/default/unpublish/', 'id'=>$tourId));
	if($label2 != '')
		$this->menu[] = array('label'=>$label2, 'url'=>array('/tour/default/statusUpdate/', 'id'=>$tourId));
	$this->menu[] =	array('label'=>'Edit Tour Details', 'url'=>array('/tour/default/update/', 'id'=>$tourId));
	//$this->menu[] =	array('label'=>'Back to List', 'url'=>array('/tour/default/index'));

}// else {
	$this->menu[] =
		array('label'=>'Tracks',
			'url'=> array('/category/default/index/', 'tid'=>$tourId));
	$this->menu[] =
		array('label'=>'Back',
			'url'=> array('/'));
//}

$allowDrawModification = $isTourOwner;
$allowOwnerEnrol  = $model->status <= Tour::STATUS_INVITING && $isTourOwner;
$allowSelfEnrol = $model->status <= Tour::STATUS_INVITING && ($userType != YumUser::TYPE_CONTACT);


$this->headers[0] = "Events Details: " . $model->location;
//$this->headers[1] = "Events Details";

?>
<div class='row-fluid'>
	<div class='span6'>
		<span style='color:#888;font-size:12pt'> Basic</span>
		<div style='min-height:10px'></div>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				array('name' => 'Conducted by', 'value' => $model->organization->name),
				array('name' => 'level', 'value' => Lookup::item('TourLevel', $model->level)),
				'start_date',
				'enrolby_date'),
		)); 
		
		?>
	</div>
	<div class='span6'>
		<span style='color:#888;font-size:12pt'> Facilities </span>
		<div style='min-height:10px'></div>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				array('name' => 'Court Surface', 'value' => Lookup::item('CourtType', $model->court_type)),
				array('name' => 'No of Courts', 'value' => $model->no_courts),
				array('name' => 'status', 'value' => Lookup::item('TourStatus', $model->status) . $overdueMessage,
						'cssClass'=> $overdueMessage == ''? '': 'flash-error'),
				array('name' => 'Participation fee', 'value'=>Lookup::item('TourType', $model->type))
			),
		)); 
		
		?>
	</div>
	
</div>
<div class='clear' style='min-height:30px'></div>

<div class='row-fluid'>
	<div class='span6'>
		<span style='color:#888;font-size:12pt'> Miscellaneous </span>
		<div style='min-height:10px'></div>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				array('name' => 'is_aita', 'value' => $model->is_aita? 'Yes': 'No'),
				'referee'),
		)); 
		
		?>
	</div>
	<div class='span6'>
		<span style='color:#888;font-size:12pt'> Contact Information </span>
		<div style='min-height:10px'></div>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				array('name' => 'Event Manager', 
						'value' => $model->organization->administrator->profile->firstname . 
								' ' . $model->organization->administrator->profile->lastname ),
				array('name' => 'Phone', 'value' => $model->organization->telephone)	
			),
		)); 
		
		?>
	</div>
</div>