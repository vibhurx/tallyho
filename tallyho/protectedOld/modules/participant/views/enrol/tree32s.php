<?php
/* @var $this ParticipantController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Participants',
);


$this->menu=array(
	array('label'=>'View Participant List', 'url'=>array('draw/index/id/' . $tour_id)),
);
?>

<h1>Draw for a category in tree format </h1>
<b>Design notes: </b>
<li>This view is available only after a draw has been prepared. Until then only participants are regsitered for a category.</li>
<li>The draw should not be initiated until enough participants are registered. Well... technically it should be allowed. </li>
<li>The entries in the table Match would be created as a part of the draw preparation. </li>
<li>When a draw is deleted then all the match entries for the category should be deleted from the Match table</li>
<li>An appropriate draw template should be picked depending on the number of participants</li>
<br/>
<b>TODO:</b>
<li>Prepare templates similar to this for the draws of 64 singles, 32 doubles, 16 doubles etc.</li>
<li>Find out how to laod dataprovider records into the div tags of tree.

<style>
	td {
		width:150px; 
		height:16px;
		padding:0 6px 0 6px;
		border:none;
		background: #EEF;
		font-size: 11px;
	}
</style>
<div class=Section1> 
<table border=0 cellspacing=0 cellpadding=0 style='width:910px;border-collapse:collapse;'>
	<tr><td style='border-bottom:solid 1px'><div name='pos_1_1'>-</div></td> 
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px'><div name='pos_17_1'>-</div></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_1_2'>-</div></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
		<td></td>
  		<td></td>
  		<td></td>
   	</tr>
  	<tr>
  		<td></td>
  		<td style='border-right:solid 1px'> </td>
  		<td style='border-bottom:solid 1px'><div name='pos_25_1'></div></td>
  		<td></td>
  		<td></td>
  		<td></td>
  	</tr> 
  	<tr> 
  		<td style='border-bottom:solid 1px'><div name='pos_2_1'>- </div></td>
  		<td style='border-right:solid 1px'> </td>
  		<td style='border-right:solid 1px'> </td> 
  		<td></td>
  		<td></td>
  		<td></td>
  	</tr>
 	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_17_2'></div></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
  		<td></td>
		<td></td>
  	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_2_2'>-</div></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
  		<td></td>
  		<td></td>
  	</tr>
  	<tr>
  		<td></td>
  		<td></td>
  		<td style='border-right:solid 1px'></td>
  		<td style='border-bottom:solid 1px'><div name='pos_29_1'></div></td>
  		<td></td>
  		<td></td>
  	</tr>  		
	<tr><td style='border-bottom:solid 1px'><div name='pos_3_1'>-</div></td> 
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
		<td></td>
	</tr>
	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px;'><div name='pos_18_1'></div></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
		<td></td>
	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_3_2'>-</div></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
  		<td></td>
  		<td></td>
   	</tr>
  	<tr>
  		<td></td>
  		<td style='border-right:solid 1px'> </td>
  		<td style='border-right:solid 1px;border-bottom:solid 1px'><div name='pos_25_2'></div></td>
  		<td style='border-right:solid 1px'></td>
  		<td></td>
  		<td></td>
  	</tr> 
  	<tr> 
  		<td style='border-bottom:solid 1px'><div name='pos_4_1'>- </div></td>
  		<td style='border-right:solid 1px'> </td>
  		<td> </td> 
  		<td style='border-right:solid 1px'></td>
  		<td></td>
  		<td></td>
  	</tr>
 	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_18_2'></div></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
  		<td></td>
		<td></td>
  	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_4_2'>-</div></td>
		<td></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
  		<td></td>
  		<td></td>
  	</tr>
  	<tr>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td style='border-right:solid 1px'></td>
  		<td style='border-bottom:solid 1px'><div name='pos_31_1'></div></td>
  		<td></td>
  	</tr>  		
  		<tr><td style='border-bottom:solid 1px'><div name='pos_5_1'>-</div></td> 
		<td></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
	</tr>
	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px;'><div name='pos_19_1'></div></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_5_2'>-</div></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
  		<td style='border-right:solid 1px'></td>
  		<td></td>
   	</tr>
  	<tr>
  		<td></td>
  		<td style='border-right:solid 1px'> </td>
  		<td style='border-bottom:solid 1px'><div name='pos_26_1'></div></td>
  		<td style='border-right:solid 1px'></td>
  		<td style='border-right:solid 1px'></td>
  		<td></td>
  		
  	</tr> 
  	<tr> 
  		<td style='border-bottom:solid 1px'><div name='pos_6_1'>-</div> </td>
  		<td style='border-right:solid 1px'> </td>
  		<td style='border-right:solid 1px'> </td> 
  		<td style='border-right:solid 1px'></td>
  		<td style='border-right:solid 1px'></td>
  		<td></td>
  	</tr>
 	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_19_2'></div></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
  		<td style='border-right:solid 1px'></td>
		<td></td>
  	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_6_2'>-</div></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
  		<td style='border-right:solid 1px'></td>
  		<td></td>
  	</tr>
  	<tr>
  		<td></td>
  		<td></td>
  		<td style='border-right:solid 1px'></td>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_29_2'></div></td>
  		<td style='border-right:solid 1px'></td>
  		<td></td>
  	</tr>  		
	<tr><td style='border-bottom:solid 1px'><div name='pos_7_1'>-</div></td> 
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
	</tr>
	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px'><div name='pos_20_1'></div></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_7_2'>-</div></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
  		<td style='border-right:solid 1px'></td>
  		<td></td>
   	</tr>
  	<tr>
  		<td></td>
  		<td style='border-right:solid 1px'> </td>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_26_2'></div></td>
  		<td></td>
  		<td style='border-right:solid 1px'></td>
  		<td></td>
  	</tr> 
  	<tr> 
  		<td style='border-bottom:solid 1px'><div name='pos_8_1'>- </div></td>
  		<td style='border-right:solid 1px'> </td>
  		<td> </td> 
  		<td></td>
  		<td style='border-right:solid 1px'></td>
  		<td></td>
  	</tr>
 	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_20_2'></div></td>
		<td></td>
		<td></td>
  		<td style='border-right:solid 1px'></td>
		<td></td>
  	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_8_2'>-</div></td>
		<td></td>
		<td></td>
		<td></td>
  		<td style='border-right:solid 1px'></td>
  		<td></td>
  	</tr>
  	<tr>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td style='border-right:solid 1px'></td>
  		<td style='border-bottom:solid 1px'><div name='pos_32_1'>Winner</td>
  	</tr>  		
  		<tr><td style='border-bottom:solid 1px'><div name='pos_9_1'>-</div></td> 
		<td></td>
		<td></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
	</tr>
	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px'><div name='pos_21_1'></div></td>
		<td></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_9_2'>-</div></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
		<td></td>
  		<td style='border-right:solid 1px'></td>
		<td></td>
   	</tr>
  	<tr>
  		<td></td>
  		<td style='border-right:solid 1px'> </td>
  		<td style='border-bottom:solid 1px'><div name='pos_27_1'></div></td>
  		<td></td>
  		<td style='border-right:solid 1px'></td>
		<td></td>
  	</tr> 
  	<tr> 
  		<td style='border-bottom:solid 1px'><div name='pos_10_1'> </div></td>
  		<td style='border-right:solid 1px'> </td>
  		<td style='border-right:solid 1px'> </td> 
  		<td></td>
  		<td style='border-right:solid 1px'></td>
		<td></td>
  	</tr>
 	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_21_2'></div></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
  		<td style='border-right:solid 1px'></td>
		<td></td>
  	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_10_2'></div></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
  		<td style='border-right:solid 1px'></td>
		<td></td>
  	</tr>
  	<tr>
  		<td></td>
  		<td></td>
  		<td style='border-right:solid 1px'></td>
  		<td style='border-bottom:solid 1px'><div name='pos_30_1'></div></td>
  		<td style='border-right:solid 1px'></td>
		<td></td>
  	</tr>  		
	<tr><td style='border-bottom:solid 1px'><div name='pos_11_1'></div></td> 
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
	</tr>
	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px'><div name='pos_22_1'></div></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_11_2'></div></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
  		<td style='border-right:solid 1px'></td>
		<td></td>
   	</tr>
  	<tr>
  		<td></td>
  		<td style='border-right:solid 1px'> </td>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_27_2'></div></td>
  		<td style='border-right:solid 1px'></td>
  		<td style='border-right:solid 1px'></td>
		<td></td>
  	</tr> 
  	<tr> 
  		<td style='border-bottom:solid 1px'><div name='pos_12_1'> </div></td>
  		<td style='border-right:solid 1px'> </td>
  		<td> </td> 
  		<td style='border-right:solid 1px'></td>
  		<td style='border-right:solid 1px'></td>
		<td></td>
  	</tr>
 	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_22_2'></div></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
  		<td style='border-right:solid 1px'></td>
		<td></td>
  	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_12_2'></div></td>
		<td></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
  		<td style='border-right:solid 1px'></td>
		<td></td>
  	</tr>
  	<tr>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td style='border-right:solid 1px;'></td>
  		<td style='border-bottom:solid 1px;border-right:solid 1px;'><div name='pos_31_2'></div></td>
  		<td></td>
  	</tr>  		
  		<tr><td style='border-bottom:solid 1px'><div name='pos_13_1'></div></td> 
		<td></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
		<td></td>
	</tr>
	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px'><div name='pos_23_1'></div></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
  		<td></td>
	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_13_2'></div></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
  		<td></td>
  		<td></td>
   	</tr>
  	<tr>
  		<td></td>
  		<td style='border-right:solid 1px'> </td>
  		<td style='border-bottom:solid 1px'><div name='pos_28_1'></div></td>
  		<td style='border-right:solid 1px'></td>
  		<td></td>
  		<td></td>  		
  	</tr> 
  	<tr> 
  		<td style='border-bottom:solid 1px'><div name='pos_14_1'></div> </td>
  		<td style='border-right:solid 1px'> </td>
  		<td style='border-right:solid 1px'> </td> 
  		<td style='border-right:solid 1px'></td>
  		<td></td>
  		<td></td>
  	</tr>
 	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_23_2'></div></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
  		<td></td>
  		<td></td>
  	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_14_2'></div></td>
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
  		<td></td>
  		<td></td>
  	</tr>
  	<tr>
  		<td></td>
  		<td></td>
  		<td style='border-right:solid 1px'></td>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_30_2'></div></td>
  		<td></td>
  		<td></td>
  	</tr>  		
	<tr><td style='border-bottom:solid 1px'><div name='pos_15_1'></div></td> 
		<td></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
		<td></td>
  		<td></td>
	</tr>
	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px'><div name='pos_24_1'></div></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
		<td></td>
  		<td></td>
	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_15_2'>-</div></td>
		<td style='border-right:solid 1px'></td>
		<td style='border-right:solid 1px'></td>
		<td></td>
  		<td></td>
  		<td></td>
   	</tr>
  	<tr>
  		<td></td>
  		<td style='border-right:solid 1px'> </td>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_28_2'></div></td>
  		<td></td>
  		<td></td>
  		<td></td>
  		
  	</tr> 
  	<tr> 
  		<td style='border-bottom:solid 1px'><div name='pos_16_1'> </div></td>
  		<td style='border-right:solid 1px'> </td>
  		<td> </td> 
  		<td></td>
  		<td></td>
  		<td></td>
  	</tr>
 	<tr> <td style='border-right:solid 1px'></td>
		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_24_2'></div></td>
		<td></td>
		<td></td>
  		<td></td>
  		<td></td>
  	</tr>
  	<tr>
  		<td style='border-bottom:solid 1px;border-right:solid 1px'><div name='pos_16_2'></div></td>
		<td></td>
		<td></td>
		<td></td>
  		<td></td>
  		<td></td>
  	</tr>
  	<tr>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td></td>
  	</tr>
</table>
</div>
<script>
var temp;
</script>
<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView' => '_branch',
		'enablePagination' => false,
	));
?>
