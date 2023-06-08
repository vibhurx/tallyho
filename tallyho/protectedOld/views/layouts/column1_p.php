<?php $this->renderPartial('webroot.protected.views.layouts.header'); ?>

<body data-spy="scroll" data-target=".scroller-spy" data-twttr-rendered="true">

<!--START MAIN-WRAPPER--> 
<div class="main-wrapper">
<!--START MAIN-WRAPPER--> 

<!-- TOP SECTION-->
<section class="headertop needhead" id="slogan-section-1" style="padding-top:0px">
	<?php $this->renderPartial('webroot.protected.views.layouts.menu'); ?>

	<div class="container">
		<div class="row-fluid">
			<div class="span12">
				<header class="" >
					<div class="page-header">
						<h3>User Login</h3>
					</div>
				</header>
				<?php if(Yii::app()->user->hasFlash('error')):?>
				    <div class="flash-error">
				        <?php echo Yii::app()->user->getFlash('error'); ?>
				    </div>
				<?php elseif(Yii::app()->user->hasFlash('warning')): ?>
					<div class="flash-warning">
				        <?php echo Yii::app()->user->getFlash('warning'); ?>
				    </div>
				<?php elseif(Yii::app()->user->hasFlash('notice')): ?>
					<div class="flash-notice">
				        <?php echo Yii::app()->user->getFlash('notice'); ?>
				    </div>
				<?php endif; ?>
			</div>
		</div>
		<div class="row-fluid" style='border:0px solid'>
			<div class="span3"></div>
			<div class="span6">
				<div>
					<?php echo $content; ?>
				</div>
			</div>
		</div>
	
</section><!--/ TOP SECTION-->

<?php $this->renderPartial('webroot.protected.views.layouts.footer'); ?>