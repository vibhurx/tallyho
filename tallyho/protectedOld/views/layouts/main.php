<?php Yii::app()->clientScript->registerCoreScript('jquery');?>
<?php $this->renderPartial('webroot.protected.views.layouts.header'); ?>

<body data-spy="scroll" data-target=".scroller-spy" data-twttr-rendered="true">

<!--START MAIN-WRAPPER--> 
<div class="main-wrapper">
<!--START MAIN-WRAPPER--> 

<!-- TOP SECTION-->
<section class="section-1" id="slogan-section-1" style="padding:0">
	<?php $this->renderPartial('webroot.protected.views.layouts.menu'); ?>

	<!-- START OF CANVAS -->
	<div class="container">
		<div class="row-fluid">
			<div class="span12">
				<header class="" >
					<div class="page-header">
						<h3><?php 
							if(isset($this->headers[0]))
								echo $this->headers[0];	?></h3>
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
		<div class="row-fluid">
			<div class="span9">
				<div>
				
<!-- ####################-->
<!--  START MAIN CONTENT -->
<!-- ####################-->
			
<?php echo $content; ?>

<!-- ####################-->
<!--   END MAIN CONTENT  -->
<!-- ####################-->
				</div>
			</div>
			<div class="span3">
				<?php
					$this->widget('zii.widgets.CMenu', array(
						'items'=>$this->menu,
						'htmlOptions'=>array('class'=>'operations'),
						));
//					$this->endWidget();
				?>
			</div>
		</div>
	</div>
	
	<div class="bg parallax-point-event">
	
	</div>
	<div style='min-height:50px'></div>	
</section><!--/ TOP SECTION-->


</div>
<!-- END: MAIN-WRAPPER-->


<?php $this->renderPartial('webroot.protected.views.layouts.footer'); ?>