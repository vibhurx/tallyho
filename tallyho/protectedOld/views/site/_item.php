<div 
	onclick='document.location="<?php echo $this->createUrl("/tour/default/view", array("id"=>$data->id));?>"'
	style="min-height:80px; min-width:423px;float:right">
	<div style='border-radius:10px;margin:5px; overflow:auto;'>
		<div style='background-color:#EEE;width:79px;height:79px;float:left;padding:0px'>
			<?php
				if(isset($data->organization->logo)){
					$logoUrl = Yii::app()->baseUrl . "/images/olog/" . $data->org_id . "/" . $data->organization->logo;
				} else {
					$logoUrl = Yii::app()->baseUrl . "/images/organization.png";
				}
			?>
<!-- 			//if the image is no located then do not bother putting it. This can happen only when the image folders are missing. -->
			<?php // if(file_exists($logoUrl)): ?>
	 	    	<img src="<?php echo $logoUrl ?>" style='width:80px;height:80px;'>
	 	    <?php // else: ?>
	 	    <!-- 	<i class="fa-icon-home" style='font-size:48pt;padding:10px'></i>  -->
	 	    <?php // endif ?>
		</div>
		<div style='background-color:#EEE;width:250px;overflow:auto;float:left;min-height:80px;border:0px solid' >
			<div style='margin-left:5px;color: #444; font-weight:bold;'>
		 	    <span style="font-family:Arial,Helvetica;font-size: 12pt; font-weight: bold; color: #000; border: 0; line-height:inherit; margin:5px">
		 	    	 <?php echo $data->location ?>
		 	    </span><br>
		 	    <span style="font-size: 0.8em; color: #000; margin:5px">
					<?php echo Lookup::item("TourLevel", $data->level); ?>
				</span><br>
				<span style="font-size: 0.8em; color:#AAA; margin:5px">
					By <?php echo $data->organization->name; ?>
			    </span>
			</div>
		</div>
		<div style='background:#EEE url(css/img/stamp.png) no-repeat;width:80px;float:left;min-height:80px;border:0px solid;'>
			<span style="font-family:Arial,Helvetica; font-size: 14pt; font-weight: bold; width:90%; text-align:center; border: 0px solid; line-height:inherit; padding:5px">
				<?php echo CHtml::encode(date("M d", strtotime($data->start_date))); ?>
			</span>
			<span  style='text-align:center;width:90%'>
				<?php echo Lookup::item("TourStatus", $data->status); ?>
			</span>
			
		</div>
	</div>
</div>
