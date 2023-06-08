<div class='submenu'>
	<table><tr><td>
		<?php if($this->backLink !== null):?>
		<a href='<?php echo $this->backLink ?>'>
			<img src='<?php echo Yii::app()->baseUrl ?>/images/back.png' style='width:30px; height:30px'></img>
		</a>
		<?php else: ?>
			<div style='width:32px'></div>
		<?php endif ?>
	</td><td>
		<div style='color:white;text-align:center;font-size:2em;'>
			<?php echo $this->header01; ?>
		</div>
	</td><td>
		<ul class='myMenu' style='float:right;position:relative'>
			<li>
			<div id='submenu_sidemenu'>
			<?php
				$this->widget('zii.widgets.CMenu', array(
					'items'=>$this->menu,
					'htmlOptions'=>array('style'=>'margin:30px -270px;width:300px;border:0px solid')
				));
			?></div>
			</li>
		</ul>
	</td></tr></table>
</div>