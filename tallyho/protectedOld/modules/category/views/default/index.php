 <?php 
 $this->headers[0] = "Event Tracks at " . $tour->location;
 //$this->backLink = $this->createUrl("//tour/default/view", array("id" => $tour->id));
 $this->menu = array(
 		array('label'=>'Add a New Track',
 				'url'=> array('create', 'tid' =>$tour->id),
 				'visible' => $isTourOwner),
 		array('label'=>'Back', 
 				'url' => array("//tour/default/view", 'id' => $tour->id))); 

$allowDrawModification = $isTourOwner;
$allowOwnerEnrol  = $tour->status <= Tour::STATUS_INVITING && $isTourOwner;
$allowSelfEnrol = $tour->status <= Tour::STATUS_INVITING && Yii::app()->user->hasRole('Organizer'); 
	//($userType != YumUser::TYPE_CONTACT);
?>

<?php 		
//  $this->widget('zii.widgets.grid.CGridView', array(
// 	'dataProvider'=>$dataProvider,
// 	'columns'=>array(
// 		array('name' => 'category',		//should always open to view category (now there are more fields
//  				'type'=> 'raw',
// 				'value' => 'CHtml::link(Lookup::item("AgeGroup", $data->category),
// 									array("category/default/view/id/" . $data->id))',
// 				'visible' => $allowDrawModification),
// 		array('name' => 'category',		//For the players
// 				'type' => 'raw',
// 				'value' => 'Lookup::item("AgeGroup", $data->category)',
// 				'visible' => !$allowDrawModification),
// 		array('name'=>'draw_status',
// 				'type'=> 'raw',
// 				'value' => 'Lookup::item("DrawStatus", $data->draw_status)',
// 				'htmlOptions' => array('style' => 'text-align:center'),),
// 		array('name' => 'Bracket',		//For all
// 				'type' => 'raw',
// 				'value' => '$data->draw_status == Category::STATUS_PREPARED
// 									? CHtml::link("View",array("category/draw/view/id/" . $data->id)) : "-"',
// 				'htmlOptions' => array('style'=>'text-align:center')),
// 		array('name' =>'Action',
// 				'type' => 'raw',
// 				'value' => '$data->draw_status == 0? CHtml::link("Enrol", "javascript: jsEnrol($data->id, true)") : "-"',
// 				'htmlOptions' => array('style' => 'text-align:center'),
// 				'visible' => $allowSelfEnrol,),
// 		array('name' =>'Start Date',
// 				'type'=> 'raw',
// 				'value' => '$data->start_date == 0? "-": date("d M Y - h:i A",strtotime($data->start_date))',
// 				'htmlOptions' => array('style' => 'text-align:center'),),
// 		array( 'header' => $isTourOwner ? 'Score a match' : 'Watch a match',
// 				'class' => 'CDataColumn',
// 				'type' => 'raw',
// 				'value' => '$data->draw_status == Category::STATUS_PREPARED?"[".CHtml::link("Main", array("/match/default/index", "cid"=>"$data->id", "qual"=>"0"))."] [".CHtml::link("Qualifying", array("/match/default/index", "cid"=>"$data->id", "qual"=>"1"))."]":"-"',
// 				'htmlOptions' => array('style' => 'text-align:center'),),
// 		array( 'header' => 'Players List',
// 				'class' => 'CDataColumn',
// 				'type' => 'raw',
// 				'value' => 'CHtml::link("View", array("/participant/draw/index", "cid"=>"$data->id"))',
// 				'htmlOptions' => array('style' => 'text-align:center'),
// 				'visible' => $allowDrawModification),
// 		array( 'header' => 'Manage',
// 				'class' => 'CDataColumn',
// 				'type' => 'raw',
// 				'value' => 'CHtml::link("delete", "javascript: confirmDeletion(" . $data->id . ")")',
// 				'visible' =>  $isTourOwner,
// 				'htmlOptions' => array('style' => 'text-align:center'),),

// 	)));
?>

<?php
//  if($isTourOwner)
// 	$this->widget('zii.widgets.CListView', array(
// 		'dataProvider'=>$dataProvider,
// 		'itemView'=>'_editableItem',
// 	));
// else
// 	$this->widget('zii.widgets.CListView', array(
// 			'dataProvider'=>$dataProvider,
// 			'itemView'=>'_item',
// 	));

	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
			'columns' => array(
				array('name' => 'category',
						'value' => 'Lookup::item("AgeGroup", $data->category)'),
				
				array('name' => 'Starting on',
						'value' => 'date_format(date_create(Tour::model()->findByPk($data->tour_id)->start_date),"d M Y")',
						'htmlOptions' => array('style' => 'text-align:center'),),
		
				array('name' => 'draw_status',
						'value' => 'Lookup::item("DrawStatus", $data->draw_status)',
						'htmlOptions' => array('style' => 'text-align:center'),),
				
				array('name' => 'is_paid',
						//'type' => 'raw',
						'value' => '$data->is_paid?"Yes":"No"',
						'htmlOptions' => array('style' => 'text-align:center'),),
				
				array( 'header'=>'Manage',
						'class'=>'CDataColumn',
						'type' => 'raw',
						'value' => 'CHtml::link("Enrol", array("/participant/enrol/create","cid"=>$data->id))',
						'htmlOptions' => array('style' => 'text-align:center'),),
				array( 'header'=>'Manage',
						'class'=>'CDataColumn',
						'type' => 'raw',
						'value' => 'CHtml::link("Details", array("view","id"=>$data->id))', //. "|" . CHtml::link("Edit", array("update","id"=>$data->id))',
						//'visible' => $isTourOwner,
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
		var cHref = '<?php echo $this->createUrl("//participant/draw/view") ?>';
		location.href =  cHref + '/cid/' + id;
		$('a#fb_disp_draw').click();
		location.href = cHref; //reset to the old value
	}

	//In this view the createFor alone is used. But the function is kept similar to that of the view /tour/tour/view for consistency.
	function jsEnrol(cid, self){
		var is_guest = <?php echo Yii::app()->user->isGuest? 'true' : 'false'; ?>;
		var cHref = $('a#fb_enrol').attr("href");
		
		if(is_guest){	//	Redirect to login (full) page
			location.href = cHref+"/tour/default/restrictedView/id/" + <?php echo $tour->id?> + "/cid/" + cid;
		} else {
			if(self)
				$('a#fb_enrol').attr("href", cHref+"/participant/enrol/create/cid/" + cid);
			else
				$('a#fb_enrol').attr("href", cHref+"/participant/enrol/createFor/cid/" + cid + "/aj/1");
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
	array('title'=>'Enrol for the Tournament',
		  'style'=>'display:none', 'id'=>'fb_enrol'));
?>

<?php 
//Category popup target link
echo CHtml::link("HIDDEN LINK TO ADD CATEGORY",
	array('category/default/create', 'tid' =>$tour->id),
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
		//$isTourOwner ? array('/match/default/list') : array('/match/default/view'),
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
