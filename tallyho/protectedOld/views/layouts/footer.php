<div class="container" id="social" style="min-height:20px;font-size:8pt">
<?php echo CHtml::link('About Tallyho&trade;',	array('//site/page/view/about'))?>	|
			<?php echo CHtml::link('About Us',				array('//site/page/view/brevity'))?>	|
			<?php echo CHtml::link('Developer API', 		array('//developer/default/page/view/api'))?>	| 
			<?php echo CHtml::link('How to Use',			array('//site/page/view/scenarios'))?>	
		
</div>
<div id="footer">
		
	Copyright &copy; <?php echo date('Y'); ?> Brevity Labs. Tallyho&trade; is a trademark of the Brevity Labs. 
	All Rights Reserved. <a href="<?php echo $this->createUrl("/")?>/site/page?view=disclaimer" id="disclaimer">Disclaimer </a><?php echo Yii::powered(); ?>
</div>