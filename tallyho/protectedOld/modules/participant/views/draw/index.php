<?php
/* @var $this ParticipantController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Participants',
);

// $this->information = "<p>If the name is not listed when enrolling a player, create the player first.</p>
// 		<p>Select <i> Aita Pts</i> link to update the latest points. You can ask the player him/herself to update that in
// 		 player's profile.</p>
// 		<p>A player's enrollment can be cancelled by selecting the <i>delete</i> link.</p>
// 		<p>Once the seeds are generated, the option for <i> Draw & Shuffle </i> would enable.</p>
// 		";

$this->menu=array(
	array('label'=>'Step 2: Draw & Shuffle', 'url'=> $status == Category::STATUS_SEEDED? array('//category/draw/make', 'id'=>$cid): null,
			'visible'=> $isTourOwner,),
// 	array('label'=>'Enrol a player', 'url'=> "javascript: $('a#fb_enrol').click();" ,
// 			'visible'=> $isTourOwner),
	array('label'=>'Enrol a player', 'url'=> array('//participant/enrol/createFor', 'cid'=>$cid) ,
			'visible'=> $isTourOwner),
	array('label'=>'Generate seeds', 
			'url'=>/*$status == Category::STATUS_NOT_PREPARED? */array('seed', 'cid'=>$cid) /*: null*/,
			'visible'=> $isTourOwner),
	array('label'=>'View draw', 'url'=>array('//category/draw/view', 'id'=>$cid),
			'visible'=> $isTourOwner && $status == Category::STATUS_PREPARED),
	array('label'=>'Back', 'url'=>array('//tour/default/view', 'id'=>$tourId),
			'visible'=> $isTourOwner),
);

?>
<?php $this->headers[0] = "Enrolled Players"; ?>

<h2><?php echo $categoryName?> - <?php echo $tourName ?> </h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'participant-grid',
	'dataProvider'=>$dataProvider,
	'columns' => array(
		'id',
		array('name' => 'Given name', 'value' => '$data->player->given_name',
				 'htmlOptions'=>array('class'=>'given-name')),
		array('name' => 'Family name', 'value' => '$data->player->family_name',
				'htmlOptions'=>array('class'=>'family-name')),
		array('name' => 'AITA Member', 'value' => '$data->player->aita_no != null?"Yes":"No"',
				'htmlOptions' => array('style' => 'text-align:center'),
				'visible' => $is_aita),
		array('name' => 'Member', 'value' => 'Membership::model()->isMember($data->tour->org_id,$data->player_id)',
				'htmlOptions' => array('style' => 'text-align:center'),
				'visible' => !$is_aita),
		array('name' => 'seed_pts',
				'type'=> 'raw',
				'value' => 'CHtml::link($data->seed_points, "",
								array("style"=>"cursor: pointer; text-decoration: underline;",
									  "onclick"=>"javascript:popupSeedPoints($(this),\'$data->id\');",))',
									// "onclick"=>"javascript: id=\'$data->id\'; beforeCellUpdate(\'seed-points\',$(this),id);",))',
				'htmlOptions' => array('class'=>'seed-points', 'style' => 'text-align:center')),
		array('name' => 'Seed', 'type'=> 'raw', 'value' => '$data->seed==999?"Unseeded":$data->seed',
				'htmlOptions' => array('style' => 'text-align:center')),
		array('name'=>'fee_paid', 'type'=>'raw', 'value'=>$is_paid?'$data->fee_paid':'"-"',
				'htmlOptions'=>array('class'=>'fee-paid','style'=>'text-align:center')),
		array('name'=>'Status',
				'type'=>'raw',
				'value' => $is_paid?'CHtml::link($data->payment_status?"Paid":"Unpaid", "",
								array("style"=>"cursor: pointer; text-decoration: underline;",
									"onclick"=>"javascript:popupPaymentStatus($(this),\'$data->id\');",))':'"-"',
									//	"onclick"=>"javascript: id=\'$data->id\'; beforeCellUpdate(\'payment-status\',$(this),id);",))':'"-"',
				'htmlOptions'=>array('class'=>'payment-status', "style"=>"text-align:center")),
		array('name' => 'Delete',
				'type'=>'raw',
				'value'=> 'CHtml::link("delete", array("enrol/delete", "id"=>$data->id))',
				'htmlOptions' => array('style' => 'text-align:center')))));
?>

<div id="section_info"></div>

<div style="display:none">
	<div id='popupCommon' style='text-align:center'>
		<?php $form=$this->beginWidget('CActiveForm', array(
			    'id'=>'common-form',
			    'enableAjaxValidation'=>false,
			    'htmlOptions'=>array('style'=>'border:0px solid red',
					'onsubmit'=>"return false;",	/* Disable normal form submit */
					'onkeypress'=>" if(event.keyCode==13){				
							ajaxPost('#common-form', gUrl, gCellClass);
			    			parent.$.fancybox.close();
						} " ))); 					/* Do ajax call when user presses enter key */ 
		?>
		
		<div id='points' style='display:none'>Provide the updated seed points for <span class='full-name' style="color:blue"> player name</span> and submit? <br><br><br>
			<?php echo CHtml::textField('seed_points',null,array('style'=>'width:75px;text-align:center')); ?></div>
		
		<div id='payment' style='display:none;text-align:left'>Are you sure to change the payment status of <span class='full-name' style="color:blue"> player name</span>?
			<br><br><br>
			<?php echo CHtml::radioButtonList("mode", 1, array("1"=>"Cash", "2"=>"Cheque", "3"=>"Online Transfer"), array("style"=>"text-align:left")); ?>
			<br><br>Payment remark: <?php echo CHtml::textField("remark", null) ?>
			<?php echo CHtml::hiddenField('direction',1); ?>
		</div>
		<div id='refund' style='display:none;text-align:left'>Are you sure to refund <span class='full-name' style="color:blue"> player name</span> the fee?<br>
			The player will not be included in the draw-bracket.
			<br><br><br>
			<?php echo CHtml::radioButtonList("mode", 1, array("1"=>"Cash", "2"=>"Cheque", "3"=>"Online Transfer"), array("style"=>"text-align:left")); ?>
			<br><br>Payment remark: <?php echo CHtml::textField("remark", null) ?>
			<?php echo CHtml::hiddenField('direction',-1); ?>
		</div>
		
		<?php echo CHtml::hiddenField('participant_id'); ?>
		
		<br/><br/>
		<?php 
// 			echo CHtml::Button('Submit',array(
// 				"onclick"=>"ajaxPost('#common-form', gUrl, gCellClass);
// 					parent.$.fancybox.close();")); 
			echo CHtml::Button('Submit',array(
					"onclick"=>"ajaxPost('#common-form', gUrl, gCellClass);
					parent.$.fancybox.close();"));
		?> 
		<br><br><br><i>Press ESC to cancel</i>
 		<?php $this->endWidget(); ?>
 	</div>
</div>

<div style="display:none">
	<div id='popupSeedPoints' style='text-align:center'>
		<?php
			$form=$this->beginWidget('CActiveForm', array(
			    'id'=>'seed-points-form',
			    'enableAjaxValidation'=>false,
			    'htmlOptions'=>array('style'=>'border:0px solid red')
			));
		?>
		
		<div id='points'>
			Provide the updated seed points for 
				<span class='full-name' style="color:blue">
					player name
				</span> and submit? <br><br><br>
			<?php echo CHtml::textField('seed_points',null,array('style'=>'width:75px;text-align:center')); ?>
			<?php echo CHtml::hiddenField('participant_id'); ?>
		</div>
		
		<br/><br/>
		<?php echo CHtml::submitButton(); ?> 
		<br><br><br><i>Press ESC to cancel</i>
 		<?php $this->endWidget(); ?>
 	</div>
</div>

<div style="display:none">
	<div id='popupPaymentStatus' style='text-align:center'>
		<?php $form=$this->beginWidget('CActiveForm', array(
			    'id'=>'payment-status-form',
			    'enableAjaxValidation'=>false,
			    'htmlOptions'=>array('style'=>'border:0px solid red',)));
		?>
		
		<div id='payment' style='display:none;text-align:left'>Are you sure to change the payment status of <span class='full-name' style="color:blue"> player name</span>?
			<br><br><br>
			<?php echo CHtml::radioButtonList("mode", "1", array("1"=>"Cash", "2"=>"Cheque", "3"=>"Online Transfer"), array("style"=>"text-align:left")); ?>
			<br><br>Payment remark: <?php echo CHtml::textField("remark", null) ?>
			<?php echo CHtml::hiddenField('direction',1); ?>
			<?php echo CHtml::hiddenField('participant_id'); ?>
		</div>
		<div id='refund' style='display:none;text-align:left'>Are you sure to refund <span class='full-name' style="color:blue"> player name</span> the fee?<br>
			The player will not be included in the draw-bracket.
			<br><br><br>
			<?php echo CHtml::radioButtonList("mode", "1", array("1"=>"Cash", "2"=>"Cheque", "3"=>"Online Transfer"), array("style"=>"text-align:left")); ?>
			<br><br>Payment remark: <?php echo CHtml::textField("remark", null) ?>
			<?php echo CHtml::hiddenField('direction',-1); ?>
		</div>
		
		<br/><br/>
		<?php 
// 			echo CHtml::Button('Submit',array(
// 				"onclick"=>"ajaxPost('#common-form', gUrl, gCellClass);
// 					parent.$.fancybox.close();")); 
			echo CHtml::submitButton();
		?> 
		<br><br><br><i>Press ESC to cancel</i>
 		<?php $this->endWidget(); ?>
 	</div>
</div>


<?php
/*
 * 	-------------------  Fancy box elements for the popup edit dialogs for the row values.  -------------------  *
 * 		- The fancy box uses the above form-section as the dialog.
 * 		- The above form-section calls ajaxPost() on submit.
 * 			- Check participant.js for the details. 
 */ 
echo CHtml::link("Fancy link for updating row values",
		"#popupCommon",
		array('title'=>'Update the Cell Value',
				'style'=>'display:none', 'id'=>'fb_common'));

$this->widget(
		'application.extensions.fancybox.EFancyBox',
		array('target'=> '#fb_common',
				'config'=>array('scrolling' => 'no',
						'titleShow' => true,
						'padding'=>40)));
/*	------------------------------------- End of Fancy Box Section --------------------------------------------  */
?>

<?php
/*
 * 	-------------------  Fancy box elements for the popup edit dialogs for the row values.  -------------------  *
 * 		- The fancy box uses the above form-section as the dialog.
 * 			- Check participant.js for the details. 
 */ 
echo CHtml::link("Fancy link for updating row values",
		"#popupSeedPoints",
		array('title'=>'Update the Cell Value',
				'style'=>'display:none', 'id'=>'fb_seed_points'));

$this->widget(
		'application.extensions.fancybox.EFancyBox',
		array('target'=> '#fb_seed_points',
				'config'=>array('scrolling' => 'no',
						'titleShow' => true,
						'padding'=>40)));
/*	------------------------------------- End of Fancy Box Section --------------------------------------------  */
?>

<?php
/*
 * 	-------------------  Fancy box elements for the popup edit dialogs for the row values.  -------------------  *
 * 		- The fancy box uses the above form-section as the dialog.
 * 			- Check participant.js for the details. 
 */ 
echo CHtml::link("Fancy link for updating row values",
		"#popupPaymentStatus",
		array('title'=>'Update the Cell Value',
				'style'=>'display:none', 'id'=>'fb_payment_status'));

$this->widget(
		'application.extensions.fancybox.EFancyBox',
		array('target'=> '#fb_payment_status',
				'config'=>array('scrolling' => 'no',
						'titleShow' => true,
						'padding'=>40)));
/*	------------------------------------- End of Fancy Box Section --------------------------------------------  */
?>


<?php 
echo CHtml::link("FancyBox link for creating a new (unregistered) player",
	//array("/player/player/create", 'cid'=>$cid), popup did not work
	array("/player/player/create", 'cid'=>$cid),
	array('title'=>'Add New Player',
		  'style'=>'display:none', 'id'=>'fb_create_player'));

//Fancybox for Enrol-a-Player
$this->widget(
	'application.extensions.fancybox.EFancyBox',
	array('target'=> '#fb_create_player',
		  'config'=>array('scrolling' => 'no',
						  'titleShow' => true,
						  'padding'=>40 )));
?>


<div style='display: none'><div id='error_box' style='color: red'> </div> </div>

<script type="text/javascript">
var gUrl, gCellClass;
var wildcard_url = '<?php echo $this->createUrl("enrol/ajaxWildcardUpdate") ?>';
var aita_pts_url = '<?php echo $this->createUrl('draw/updatePoints'); // . '/cid/' . $cid) ?>';
var seed_pts_url = '<?php echo $this->createUrl('draw/updateSeedPoints'); // . '/cid/' . $cid) ?>';
var toggle_payment_status_url = '<?php echo $this->createUrl('draw/togglePaymentStatus');//  . '/cid/' . $cid) ?>';
</script>

<?php 
echo CHtml::link("error message box",
	'#error_box',	
	array('title'=>'Input error',
		  'style'=>'display:none', 'id'=>'fb_error'));

$this->widget(
		'application.extensions.fancybox.EFancyBox',
		array('target'=> '#fb_error',
		  'config'=>array('scrolling' => 'no',
		  		'titleShow' => true,
		  		'padding'=>40)));

echo CHtml::link("Fancy link for Enrol-a-Player",
	array('enrol/createFor', 'cid'=>$cid),	//no ajax because it does not refresh the parent page
	array('title'=>'Enrol a player',
		  'style'=>'display:none', 'id'=>'fb_enrol'));

//Fancybox for Enrol-a-Player
$this->widget(
	'application.extensions.fancybox.EFancyBox',
	array('target'=> '#fb_enrol',
		  'config'=>array('scrolling' => 'no',
						  'titleShow' => true,
						  'padding' => 40,
						  'onCancel' => function(){return true;},
						  'closeClick'=> true )));

?>

<?php 
//Regular date-picker is not working on a fancybox popup
// More on the datetimepicker on http://xdsoft.net/jqplugins/datetimepicker/
$jsFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/datetimepicker/jquery.datetimepicker.js');
$csFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/datetimepicker/jquery.datetimepicker.css');
Yii::app()->clientScript->registerScriptFile($jsFile);
Yii::app()->clientScript->registerCssFile($csFile);

?>

