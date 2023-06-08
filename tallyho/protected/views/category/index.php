<?php 
 //$this->headers[0] = "Event Tracks at " . $event->location;
 //$this->backLink = $this->createUrl("//event/default/view", array("id" => $event->id));

 $levelText = Lookup::item('EventLevel', $event->level);

$this->breadcrumbs=array(
	'Events'=>array('//event/index'),
	$levelText.'/'.$event->organizer->name.'/'.$event->location=>array('event/view','id'=>$event->id),
	'Categories'
);

// $this->menu = array(
// 	array('label'=>'Add a New Track',
// 			'url'=> array('create', 'tid' =>$event->id),
// 			'visible' => $isEventManager),
// 	array('label'=>'Back', 
// 			'url' => array("//event/default/view", 'id' => $event->id))); 

// $allowDrawModification = $isEventManager;
$allowOwnerEnrol  = $event->status <= Event::STATUS_INVITING;// &&; $isEventManager;
$allowSelfEnrol = $event->status <= Event::STATUS_INVITING;// && Yii::app()->user->hasRole('Organizer'); 
//($userType != YumUser::TYPE_CONTACT);
?>

<h3>Categories</h3>
<?php 		

	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
			'columns' => array(
				array('name' => 'category',
						'value' => 'Lookup::item("AgeGroup", $data->category)'),
				
				array('name' => 'Starting on',
						'value' => 'date_format(date_create(Event::model()->findByPk($data->event_id)->start_date),"d M Y")',
						'htmlOptions' => array('style' => 'text-align:center'),),
		
				array('name' => 'draw_status',
						'value' => 'Lookup::item("DrawStatus", $data->draw_status)',
						'htmlOptions' => array('style' => 'text-align:center'),),
				
				array('name' => 'is_paid',
						'value' => '$data->is_paid?"Yes":"No"',
						'htmlOptions' => array('style' => 'text-align:center'),),

				array( 'header'=>'Manage',
						'class'=>'CDataColumn',
						'type' => 'raw',
						'value' => 'CHtml::link("Enrol", array("/enrolment/enrol","cid"=>$data->id))',
						'htmlOptions' => array('style' => 'text-align:center'),),

				array('name' => 'Remarks',
						'value' => '$data->is_aita?"AITA Format":""',
						'htmlOptions' => array('style' => 'text-align:center')),
				
			),
			
	));
?>

<script type="text/javascript">
<!--
	var gCategoryId;
	confirmDeletion = function (id){
		if(confirm("Are you sure to delete the category no " + id + "? It will also delete all its related enrolments, matches and scores.")){
			var cHref = '<?php echo $this->createUrl("/category/default/delete")?>/id/'+id;
			location.href = cHref;
		}
	};

	function jsShowDraw(id){
		var cHref = '<?php echo $this->createUrl("//enrolment/draw/view") ?>';
		location.href =  cHref + '/cid/' + id;
		$('a#fb_disp_draw').click();
		location.href = cHref; //reset to the old value
	}

	//In this view the createFor alone is used. But the function is kept similar to that of the view /event/event/view for consistency.
	function jsEnrol(cid, self){
		var is_guest = <?php echo Yii::app()->user->isGuest? 'true' : 'false'; ?>;
		var cHref = $('a#fb_enrol').attr("href");
		
		if(is_guest){	//	Redirect to login (full) page
			location.href = cHref+"/event/default/restrictedView/id/" + <?php echo $event->id?> + "/cid/" + cid;
		} else {
			if(self)
				$('a#fb_enrol').attr("href", cHref+"/enrolment/enrol/create/cid/" + cid);
			else
				$('a#fb_enrol').attr("href", cHref+"/enrolment/enrol/createFor/cid/" + cid + "/aj/1");
			$('a#fb_enrol').click();
			$('a#fb_enrol').attr("href", cHref);
		}	
	}

-->
</script>

<?php if(isset($categoryId)){?>
<script>
	$( window ).load(function(){
				jsEnrol(<?php echo $categoryId?>, true);
			}
	);		
</script>
<?php } ?>

<?php
//Enrol popup target link
 echo CHtml::link("HIDDEN LINK FOR ENROL",
	array('/'),
	array('title'=>'Enrol for the Eventnament',
		  'style'=>'display:none', 'id'=>'fb_enrol'));
?>

<?php 
//Category popup target link
echo CHtml::link("HIDDEN LINK TO ADD CATEGORY",
	array('category/default/create', 'tid' =>$event->id),
	array('title'=>'Add a Category',
		  'style'=>'display:none', 'id'=>'fb_add_cat'));
 
//Message popup target link
echo CHtml::link("HIDDEN LINK TO SHOW A MESSAGE",
		'#message_box',
		array('title'=>'Information',
		  'style'=>'display:none', 'id'=>'fb_message'));
?>
<div style='display:none'><div id='message_box'>Please sign in before you enrol. [Press Esc]</div></div>
<?php 
//FancyBox for enrol popup
 $this->widget(
 	'application.extensions.fancybox.EFancyBox',
 	array('target'=> '#fb_enrol',
 		'config'=>array('scrolling' => 'no', 
				'titleShow' => true,
				'padding'=>40,))); 

//FancyBox for adding category
$this->widget(
		'application.extensions.fancybox.EFancyBox',
		array('target'=> '#fb_add_cat',
				'config'=>array('scrolling' => 'no',
						'titleShow' => true,
						'padding'=>40,)));

//FancyBox for adding category
$this->widget(
		'application.extensions.fancybox.EFancyBox',
		array('target'=> '#fb_message',
				'config'=>array('scrolling' => 'no',
						'titleShow' => true,
						'padding'=>40,)));

?>

<script type="text/javascript">
<!--
function jsScore(id, isQual, tourOwner){
	//console.log(id);
	var cHref = $('a#fb_score').attr('href');
	$('a#fb_score').attr('href', cHref + '/cid/' + id + '/qual/' + isQual);
	
	$('a#fb_score').click();
	$('a#fb_score').attr('href', cHref); //reset to the old value	
}
//-->
</script>

<?php 
//Score popup target link
echo CHtml::link("Hidden link for launching match-list for scoring",
		//$isEventManager ? array('/match/default/list') : array('/match/default/view'),
		array('/match/default/list'),
		array('title'=>'Select a Match', 'style'=>'display:none', 'id'=>'fb_score'));

//FancyBox for Score popup

$this->widget(
		'application.extensions.fancybox.EFancyBox',
		array('target'=> '#fb_score',
				'config'=>array('scrolling' => 'no',
						'titleShow' => true,
						'padding'=>40,)));


?>
<script type="text/javascript">
function init_self_enrol(){
	setTimeout(function(){ fb_self_enrol(); }, 3000); 
	parent.$.fancybox.close();
}
function fb_create_player(){
	$('a#fb_enrol').click();
}
</script>

<?php if(isset($categoryId)){?>
<script>
	//setTimeout(jsEnrol(<?php echo $categoryId?>, true), 5000);
	//window.jQuery(document).ready(function(){ jsEnrol(<?php echo $categoryId?>, true)});		
</script>
<?php } ?>

<?php 
echo CHtml::link("FancyBox link for creating a new (unregistered) player",
	array("/player/player/create"),
	array('title'=>'Add New Player',
		  'style'=>'display:none', 'id'=>'fb_create_player'));

//Fancybox for Enrol-a-Player
$this->widget(
	'application.extensions.fancybox.EFancyBox',
	array('target'=> '#fb_create_player',
		  'config'=>array('scrolling' => 'no',
						  'titleShow' => true,
						  'padding'=>40,
						 )));
?>

<?php 
//Regular date-picker is not working on a fancybox popup
// More on the datetimepicker on http://xdsoft.net/jqplugins/datetimepicker/
$jsFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/datetimepicker/jquery.datetimepicker.js');
$csFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/datetimepicker/jquery.datetimepicker.css');
Yii::app()->clientScript->registerScriptFile($jsFile);
Yii::app()->clientScript->registerCssFile($csFile);

?>
