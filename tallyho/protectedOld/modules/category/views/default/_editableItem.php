<div class="view">

	<table>
		<tr>
			<td style='width: 65%;color: blue; font-weight:bold' >
		 	    Title: <?php echo CHtml::link(Lookup::item("AgeGroup", $data->category),
 									array("default/view/id/" . $data->id)) ?>
 				<?php 
 					$image = CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png', '', array('style'=>'width:32px'));
 					echo CHtml::link($image, array('update','id'=>$data->id));
 					$image = CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png', '', array('style'=>'width:32px'));
 					echo CHtml::link($image, array('delete','id'=>$data->id),array('onclick'=>'return confirm("Delete it?")'));
 				?>		
			</td>
			<td style='text-align:right; color:#96E; text-decoration: italic'>
				Current Status: <?php echo Lookup::item("DrawStatus", $data->draw_status); ?>
			</td>
		</tr>
		<tr>
			<td>
			    Starting on
			    <?php echo $data->start_date == 0? "-": date("d M Y - h:i A",strtotime($data->start_date)); ?>
			    
			</td>
			<td style='text-align:right'>
				<?php echo $data->draw_status == Category::STATUS_PREPARED
					? CHtml::link("View Bracket",array("draw/view/id/" . $data->id)) 
 					: "Bracket is not available"; ?>
		   </td>
		</tr><tr>
		 	<td><?php echo $data->draw_status == 0? CHtml::link("Enrol a Player", array('/participant/enrol/createFor', 'cid'=>$data->id )) : ""; ?></td>
		 	<td style='text-align:right'>
			    <?php echo $data->draw_status == Category::STATUS_PREPARED
			    	? "[".CHtml::link("Scoreboard (Main)", array("/match/default/index", "cid"=>"$data->id", "qual"=>"0"))."] ["
						 .CHtml::link("Scoreboard (Qualifying)", array("/match/default/index", "cid"=>"$data->id", "qual"=>"1"))."]"
		 	    	:"Scoreboard is not available"; ?>
			</td>
		</tr>
	</table>
</div>