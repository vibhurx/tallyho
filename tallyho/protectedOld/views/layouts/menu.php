
	<!-- ################-->
	<!-- START TOP MENU -->
	<!-- ################-->
	<nav class="nav-top">
		<div class="navbar navbar-static-top" id="topnavbar">
		<div style="background: white;min-height:18px;font-size:14px;padding:4px;text-align:right;">
				<?php echo 'Logged in as: <span style="color:steelblue;">';
					echo Yii::app()->user->loggedInAs();
					echo '</span>';
					if(Yii::app()->user->isGuest){
						echo ' (';
						//echo ' <span style="color:lightgray;"> | </span>';
						echo CHtml::link('Sign up', array('/registration/registration'));
						echo ' <span style="color:lightgray;"> | </span>';
						echo CHtml::link('Sign in', array('/user'));
						echo ')';
					} else {
						echo ' (';
						echo Yii::app()->user->data()->profile->firstname;
						if(strtolower(Yii::app()->user->data()->profile->lastname) !== 'not set'){
							echo ' ';
							echo Yii::app()->user->data()->profile->lastname;
						}
						echo ')';
						echo ' <span style="color:lightgray;"> | </span> ';
						echo CHtml::link(' logout', array('/user/user/logout'), array('style'=>'font-weight:normal'));
					}
				?>
		  </div><!-- White Bar --> 
	      <!-- navbar-fixed-top -->
	      <div class="navbar-inner" id="navbartop">
	        <div class="container"> <a class="brand" href="<?php echo Yii::app()->baseUrl?>"> 
			<span><i class="fa-icon-bullhorn" style="padding-right:12px"></i>Tallyho&trade;</span>
			<!--<img src="/tallyho/css/img/Logo.png" alt="Logo">--></a>
	          <div id="main-nav" class="scroller-spy">
	            <nav class="nav-collapse collapse" >
	              <ul class="nav" id="nav">
	              	<li class="active"><a href="<?php echo Yii::app()->baseUrl ?>#header-section">Events</a> </li>
	                <li><a href="<?php echo Yii::app()->baseUrl ?>#services-section">Services</a> </li>
	                <li><a href="<?php echo Yii::app()->baseUrl?>#players-section">Players</a> </li>
	                <li><a href="<?php echo Yii::app()->baseUrl?>#organizers-section">Organizers</a> </li>
	                <li><a href="<?php echo Yii::app()->baseUrl?>#developers-section">Developers</a> </li>
	                  <li><a href="<?php echo Yii::app()->baseUrl?>#team-section">About</a> </li>
	                <li><?php 
	                  if(!Yii::app()->user->isGuest){
	                    echo CHtml::link('Logout', array('/user/user/logout'));
	                  }?>
	                </li>
	              </ul>
	            </nav>
	          </div>
	        </div>
	      </div>
		  
		</div>	
	</nav>
	
	<!-- ################-->
	<!--   END TOP MENU  -->
	<!-- ################-->
	