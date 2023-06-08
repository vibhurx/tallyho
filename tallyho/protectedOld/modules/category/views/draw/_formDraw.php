<?php
/* @var $this DrawController */
/* @var $category Category */
/* @var $form CActiveForm */

// This form is used for making changes in the draw and previewing it. On submit, it would create 
// multiple 'match' entries corresponding to the draws.
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'draw-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($category); ?>
	<?php $arrMainEntryList = array();
				  for($i=0; $i<$totalEnroled;$i++)
				  	$arrMainEntryList[$i+1] = $i+1;?>
	<table><tr>
		<td><?php echo $form->labelEx($category,'mdraw_size'); ?> : 
			<?php echo CHtml::activeDropDownList($category,'mdraw_size', 
					array(2=>"Just 1 match", 4=>"Draw of 4", 8=>"Draw of 8", 16=>"Draw of 16", 32=>"Draw of 32"),
					array('onchange'=> 'initForDesignTime("main_draw", "qual_draw"); assignPlayers(true);')); ?>
			<?php echo $form->error($category,'mdraw_size'); ?></td>
			
		<td><?php echo $form->labelEx($category,'qdraw_levels'); ?> : 
			<?php echo CHtml::activeDropDownList($category,'qdraw_levels',
					array(0=>"None",1=>"One",2=>"Two",3=>"Three"),
					array('onchange'=> 'initForDesignTime("main_draw", "qual_draw"); assignPlayers(true);')); ?>
			<?php echo $form->error($category,'qdraw_levels'); ?></td>
			
		<td><?php echo $form->labelEx($category,'mdraw_direct'); ?> : 
			<?php //echo $form->textField($category,'mdraw_direct',
					echo CHtml::activeDropDownList($category,'mdraw_direct',
					$arrMainEntryList,
					array('style'=>'width:50px', 'onchange'=> 'initForDesignTime("main_draw", "qual_draw"); assignPlayers(true);')); ?>
			<?php echo $form->error($category,'mdraw_direct'); ?></td>
		<!-- >td><?php //echo CHtml::submitButton('Refresh'); ?></td -->
	</tr>
	<tr><td colspan='2'>
				<b> Total Enroled:  
			<div style='display:inline' id='totalEnroled'><?php echo $totalEnroled;?></div>	</b>
			<i><?php if($totalEnroled <= 28 )
					echo "A draw of 16 is recommended.";
				  elseif($totalEnroled > 28 && $totalEnroled <= 55 ) 
					echo "A draw of 32 is recommended.";
				  elseif($totalEnroled > 55)
				  	echo "A draw of 64 is recommended.";
			?></i>	
		</td>
		
		<td><b>Zoom in/out : </b>
			<input type='button' value='+' id='zoomin' onclick='scaleFactor++; initForDesignTime("main_draw", "qual_draw");'>
			<input id='scalelevel' value='' style='width:30px' disabled>
			<input type='button' value='-' id='zoomout' onclick='scaleFactor--; initForDesignTime("main_draw", "qual_draw");'>
		</td>
	</tr></table>
	
	<?php  echo  $form->hiddenField($category, 'qdraw_size'); ?>
	<hr/>
	
<?php $this->endWidget(); ?>

</div><!-- form -->