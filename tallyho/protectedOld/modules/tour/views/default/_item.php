<div class="view" onclick='document.location="<?php echo $this->createUrl("default/view", array("id"=>$data->id));?>"'
style='border: 1px solid red; border-radius: 5px; margin:0px'>

	<table>
		<tr>
			<td style='width: 65%;color: blue; font-weight:bold' >
		 	    <?php echo $data->location ?>
			</td>
			<td style='text-align:right; color:#96E; text-decoration: italic'>
				Currently <?php echo Lookup::item("TourStatus", $data->status); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo Lookup::item("TourLevel", $data->level); ?>
			    <br />
			    Organized by
			    <?php echo $data->organization->name; ?>
			</td>
			<td style='text-align:right'>
			    Starting on
			    <?php echo CHtml::encode(date("d M Y", strtotime($data->start_date))); ?>
			    <br />
			    Enrol by
			    <?php echo CHtml::encode(date("d M Y", strtotime($data->enrolby_date))); ?>
			</td>
		</tr>
	</table>
</div>