<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<title><?php echo CHtml::encode(Yii::app()->name.": ".$this->pageTitle); ?></title>
</head>

<body>

	<div class="container" id="page">
		<div class="row-fluid">
			<!-- <div  class="span12" id="header"> -->
				<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
			<!-- </div>header -->

			<div id="mainmenu">
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>'Home', 'url'=>array('/site/index')),
						array('label'=>'Events', 'url'=>array('/event/index')),
						array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
						array('label'=>'Contact', 'url'=>array('/site/contact')),
						array('label'=>'Login', 'url'=>array('/user/auth'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
					),
				)); ?>
			</div><!-- mainmenu -->

			<div class="row-fluid" style='position:absolute;top:100px;left:30%'>
				<div class="span-12" style="display:inline-block;min-height:30px;text-align:center;border:1px solid white">	
					<?php if(Yii::app()->user->hasFlash('success')):?>
						<div class="flash-success">
							<?php echo Yii::app()->user->getFlash('success'); ?>
						</div>
					<?php endif; ?>
					<?php if(Yii::app()->user->hasFlash('error')):?>
						<div class="flash-error">
							<?php echo Yii::app()->user->getFlash('error'); ?>
						</div>
					<?php endif; ?>
					<?php if(Yii::app()->user->hasFlash('notice')):?>
						<div class="flash-notice">
							<?php echo Yii::app()->user->getFlash('notice'); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

			
			<!-- <div class="span12"> -->
				<?php if(isset($this->breadcrumbs)):?>
					<?php $this->widget('zii.widgets.CBreadcrumbs', array(
						'links'=>$this->breadcrumbs,
					)); ?><!-- breadcrumbs -->
				<?php endif?>
			<!-- </div> -->
		</div>

		
		
		<div class="row-fluid" style='display:inline-block;'>
			<div class="span-24">
				<!-- <div> -->
					<?php echo $content; ?>
				<!-- </div> -->
			</div>
			<!-- <div class="span-6">
				<div>
				<?php
					// $this->widget('zii.widgets.CMenu', array(
					// 	'items'=>$this->menu,
					// 	'htmlOptions'=>array('class'=>'operations'),
					// 	));
				?>
				</div>
			</div> -->
		</div>

		<div id="footer">
			Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
			All Rights Reserved.<br/>
			<?php echo Yii::powered(); ?>
		</div><!-- footer -->

	</div><!-- page -->
	
</body>
</html>
