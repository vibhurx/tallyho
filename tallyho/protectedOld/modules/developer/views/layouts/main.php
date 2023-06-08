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
	
	<title>Tallyho: Developer Portal</title>
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
				<td style='min-width:350px'><h1>Developer Portal</h1></td>

				<td style='min-width:300px'>
					
					<?php 
						if(Yii::app()->user->isGuest){
					?>
							<ul class="myMenu">
								<li><?php echo CHtml::link("Developer Sign up", 
										array('/registration/registration?userType=4'),
										array('style'=>'background:darkgreen;font-weight:normal;font-size:11pt',)); ?>
									
								</li>
								<li><?php echo CHtml::link("Sign in", array('/user/user/login'),
										array('style'=>'background:none;color:darkblue;font-weight:normal;font-size:11pt')); ?>
								</li>
							</ul>

					<?php 
						} else {
					?>
						<ul class="myMenu">
							<li><a href='#' style='background:none'>&nbsp;</a></li>
							<li><?php 
									if(Yii::app()->user->isAdmin()){
										$menu1 = CHtml::link('Admin Console', array('/site/admin'));
										$orgId = null;
										echo CHtml::link("Administrator", array('#'),array('onclick'=>'return false;', 'style'=>'font-weight:bold'));
									} else {
										if(Yii::app()->user->isContact()) {
											$contact = Contact::model()->findByAttributes(array('user_id'=>Yii::app()->user->data()->id));
											if($contact != null){
												$name = $contact->fullName;
											}

											if(Yii::app()->user->data()->contact->organization !== null){
												$orgId = Yii::app()->user->data()->contact->org_id;
												$organization = Organization::model()->findByPk($orgId);
												$menu1 = CHtml::link($organization->name, array('/organization/default/view/id/' . $orgId));
											} else {
												$menu1 = "<a href='#'>Organization Not Set</a>";
												$orgId = null;
											}
											
										} elseif(Yii::app()->user->isPlayer()) {
											$player = Player::model()->findByAttributes(array('user_id'=>Yii::app()->user->data()->id));
											if($player != null){
												$name = $player->fullName;
											}

											$menu1 = null;
											$orgId = null;
										} elseif(Yii::app()->user->isDeveloper()) {
											$developer = Developer::model()->findByAttributes(
												array('user_id'=>Yii::app()->user->data()->id));
											if($developer != null){
												$name = $developer->fullName;
											}

											$menu1 = null;
											$orgId = $developer->company_name;
										}
										echo CHtml::link($name, array('#'),
												array('onclick'=>'return false;',
															'style'=>'font-weight:bold'));

									}
								?>
								<ul>
									<li>
										<span><?php echo Yii::app()->user->name; ?></span>
									</li>
									<?php echo Yii::app()->user->isPlayer() ? "" : "<li>$menu1</li>"; ?>
									<li>
						        	<?php 
										if(Yii::app()->user->isPlayer()){
											echo CHtml::link('My Account', array('//player'));
										} elseif(Yii::app()->user->isAdmin()) {
											echo CHtml::link('My Account', array('/site/admin'));
										} elseif(Yii::app()->user->isContact()){
											echo CHtml::link('Our Activities', array('/tour/default/index'));
										} else {
											echo CHtml::link('My Account', array('//developer'));
										}
									?>
						        	</li><li>
						            <?php
							           // echo CHtml::link('View Profile', array('/user'));
						            ?>
						            </li><li>
						            <?php
						            	echo CHtml::link('Logout', array('/user/user/logout'));
									?>
									</li>
						        </ul>
							</li>
						</ul>
					<?php
					}
					?>
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
