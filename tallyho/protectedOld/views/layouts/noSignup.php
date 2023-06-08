<?php /* @var $this Controller */ 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/legal.css" />
	
	<?php 
		//Why is this command here? Comment it.
		Yii::app()->clientScript->registerCoreScript('jquery');
	?>
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

		<table class="topmenu">
			<tr>
				<td style='width:300px'>
					<a href='<?php echo $this->createUrl('/site/index')?>'>
					<?php 
						$logo_src = Yii::app()->baseUrl . '/images/tallyho_beta.png';
						echo CHtml::imageButton($logo_src, array('class' => 'toplogobeta'));
					?>
					</a>
				</td>
				<td style='min-width:350px'></td>

				<td style='min-width:200px'>
				
				</td>
			</tr>
		</table>

	<script type="text/javascript">
		$(document).ready(function() {
			$('.myMenu > li').bind('mouseover', openSubMenu);
			$('.myMenu > li').bind('mouseout', closeSubMenu);
			
			function openSubMenu() {
				$(this).find('ul').css('visibility', 'visible');	
			};
			
			function closeSubMenu() {
				$(this).find('ul').css('visibility', 'hidden');	
			};
					   
		});
	</script>
	
	<div></div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

</div><!-- page -->

	<div class="container" id="social" style="min-height:20px;font-size:8pt">
			<?php echo CHtml::link('About Tallyho&trade;',	array('//site/page/view/about'))?>	|
			<?php echo CHtml::link('About Us',				array('//site/page/view/brevity'))?>	|
			<?php echo CHtml::link('Developer API', 		array('//developer/default/page/view/api'))?>	| 
			<?php echo CHtml::link('How to Use',			array('//site/page/view/scenarios'))?>	
		
	</div>
	<div id="footer">
		
		Copyright &copy; <?php echo date('Y'); ?> Brevity Labs. Tallyho&trade; is a trademark of the Brevity Labs. 
		All Rights Reserved. <a href="<?php echo $this->createUrl("/")?>/site/page?view=disclaimer" id="disclaimer">Disclaimer </a><?php echo Yii::powered(); ?>
	</div><!-- footer -->


</body>
</html>
