<?php
/* @var $this DrawController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Categories',
);

$this->menu=array(
	array('label'=>'Back to Brackets', 'url'=>array('/category/draw/view', 'id'=> $id)),
);
?>

<?php 
	$jsFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/category.js');
	Yii::app()->clientScript->registerScriptFile($jsFile);
?>

<h1>Matches</h1>
<?php
if(isset($matches)){
	foreach ($matches as $match){
		echo "$match->sequence, $match->id, $match->player11, $match->player21";
		echo "<br>";
	}
} else {
?>
<script type="text/javascript">
<!--
var matchUpdateUrl = '<?php echo $this->createUrl("/match/api/update")?>';
//-->
</script>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
// 	'selectableRows'=>1,
// 	'selectionChanged'=>'function(id){location.href= "' . $this->createUrl('../../participant/draw/view') . '/cid/"+$.fn.yiiGridView.getSelection(id);}',
	'columns'=>array(
		array('name'=>'level', 'value'=>'$data->level',
			'htmlOptions'=>array('style'=>'text-align:center')),
		array('name'=>'sequence', 'value'=>'$data->sequence',
			'htmlOptions'=>array('style'=>'text-align:center')),
// 		'tour_id',
		array('name' => 'Player A', 'value' => '$data->player11==null?"":$data->participant11->player->given_name." ".$data->participant11->player->family_name'),
		array('name'=>'Vs', 'value'=>'"Vs"'),
		array('name' => 'Player B', 'value' => '$data->player21==null?"":$data->participant21->player->given_name." ".$data->participant21->player->family_name'),
		//'start_date',
		array('name'=>'Starting at',
				'type'=> 'raw',
				'value'=>'CHtml::button($data->start_date==null?"Schedule now":date_format(date_create($data->start_date),"Y-m-d H:i"),
					array(
						"onmousedown"=>"javascript:
							olddate=$(this).val();
							id=$data->id;
							$(this).datetimepicker({
								timepicker:true,
								format:\'Y-m-d H:i\',
								dayOfWeekStart:1,
								lang:\'en\',
								onSelectTime:function(dp, newdate){
									updateMatchField(id, \'start_date\', olddate+\':00\', newdate.val()+\':00\');	
								}
							})", "style"=>"width:120px"))',
				'htmlOptions'=> array("style"=>"text-align:center"),
		),
		array('name'=>'court_no', 'type'=> 'raw',
				'value'=>'CHtml::button($data->court_no,
					array("onclick"=>"javascript:$(match_id).val($data->id);$(old_court_no).val($data->court_no);$(fb_court_sel).click()",
						"style"=>"width:26px", "id"=>"court_$data->id", "name"=>"court_$data->id"))',
				'htmlOptions'=>array("style"=>"text-align:center"),)
	)
 )
);
} //end else
?>
<?php 
echo CHtml::link("Fancy-box link for court selection", "#court_sel_form_section",
		array('title'=>'Select Court','style'=>'display:none', 'id'=>'fb_court_sel'));

$this->widget('application.extensions.fancybox.EFancyBox',
		array(	'target'=> '#fb_court_sel', 'config'=>array('scrolling'=>'no',
						'titleShow' => true, 'padding'=>40)));
?>
<div style='display: none'>
<div id='court_sel_form_section'>
<form 'id'='court-selection-form'>
	Courts: <?php echo CHtml::dropDownList('court_no', null, array(1=>1,2=>2,3=>3,4=>4,5=>5));?>
	<?php echo CHtml::hiddenField('old_court_no',null)?>
	<?php echo CHtml::hiddenField('match_id',null)?>
	<br><br>
	<div style='text-align:center'>
		<input type='button' 
			onclick='javascript:onCourtSelection($(match_id).val());'
			value='Select'>
	</div>
</form>
</div>
</div>

<?php 
//Regular date-picker is not working on a fancybox popup
// More on the datetimepicker on http://xdsoft.net/jqplugins/datetimepicker/
$jsFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/datetimepicker/jquery.datetimepicker.js');
$csFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/datetimepicker/jquery.datetimepicker.css');
Yii::app()->clientScript->registerScriptFile($jsFile);
Yii::app()->clientScript->registerCssFile($csFile);

?>

