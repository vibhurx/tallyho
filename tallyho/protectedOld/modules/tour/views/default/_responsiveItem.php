 <div class="tile view" onclick='document.location="<?php echo $this->createUrl("default/view", array("id"=>$data->id));?>"'>

	<table>
		<tr>
			<td style='width: 65%;color: blue; font-weight:bold' >
		 	    <?php echo $data->location ?>
			</td>
		</tr>
		<tr>
			<td style='color:#96E; text-decoration: italic'>
				Currently <?php echo Lookup::item("TourStatus", $data->status); ?>
			</td>
		</tr>
		<tr>
			<td>
				<hr>
				<?php echo Lookup::item("TourLevel", $data->level); ?>
			    <br />
			    Organized by
			    <?php echo $data->organization->name; ?>
			</td>
		</tr>
		<tr>
			<td>
				<hr>
				Starting on  <?php echo CHtml::encode(date("d M Y", strtotime($data->start_date))); ?>
				Enrol by &nbsp;&nbsp;&nbsp;&nbsp;<?php echo CHtml::encode(date("d M Y", strtotime($data->enrolby_date))); ?>
			</td>
		</tr>
		<tr>
			<td>
	
			</td>
		</tr>
	</table>
 </div>