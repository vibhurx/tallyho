	<table class="topmenu">
		<tr>
			<!-- td style='width:32px;min-width:32px'>
				<ul class='myMenu' style=''>
					<li>
						<div style='height:32px;width:32px;background:url(<?php echo Yii::app()->baseUrl ?>/images/topMenu.png) no-repeat;'>
							<?php 
// 								$this->widget('zii.widgets.CMenu', array(
// 										'activeCssClass'=>'active',
// 										'activateParents'=>true,
// 										'items'=>$mainmenu,
// 										'htmlOptions' => array('style'=>'margin: 30px -5px;width:250px;text-align:left')
// 								));
							?>
						</div>
					</li>
				</ul>
			</td -->
			<td style='width:186px'>
				<a href='<?php echo $this->createUrl('/site/index')?>'>
				<?php 
					echo CHtml::imageButton(
							Yii::app()->baseUrl . '/images/tallyhoBeta.png',
							array('class' => 'toplogobeta')
					);
				?>
				</a>
			</td>
			<!--  td style='min-width:250px;border:1px solid'></td -->
			<td style='min-width:162px'>
				
				<?php if(Yii::app()->user->isGuest): ?>
					<ul class='myMenu' style='float:right'>
						<li><?php echo CHtml::link("Sign up", array('#'),
										array('style'=>'background:orange;border:1px solid orange;',
										'onclick'=>'return false')); ?>
							<ul style='border:0px solid; width:200px;margin-left:-62px;'>
								<li>
									<?php 
										echo CHtml::link('As a '.Lookup::item('UserType', YumUser::TYPE_PLAYER),
											array('/registration/registration?userType=3'));
									?>
								</li>
								<li>
									<?php 
										echo CHtml::link('As an '.Lookup::item('UserType', YumUser::TYPE_CONTACT),
											array('/registration/registration?userType=2'));
									?>
								</li>
							</ul>
						</li>
						<li><?php echo CHtml::link("Sign in", array('/user/user/login'),
								array('style'=>'background:none;color:darkblue;border: 1px solid orange')); ?>
						</li>
					</ul>
				<?php else: ?>
					<ul class='myMenu' style='float:right'>
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
									echo CHtml::link('Welcome, '.$name, 'javascript:return false;');
									//echo '<span>Welcome, ' . $name . '</span>';

								}
							?>
							<ul class='myMenu' style='margin-left:-100px'>
								<li>
								<?php 
									echo CHtml::link(Yii::app()->user->name, Yii::app()->user->isPlayer()?array('//player'):array('/tour/default/index'),
											array('style'=>'font-weight:bold'));
								?>
									<!-- Span>Username - <?php echo Yii::app()->user->name; ?></span -->
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
				<?php endif ?>
			</td>
		</tr>
	</table>
