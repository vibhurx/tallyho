<?php $this->renderPartial('webroot.protected.views.layouts.header'); ?>

<body data-spy="scroll" data-target=".scroller-spy" data-twttr-rendered="true">
<style>           
img.not-yet {
	content: url('css/img/gr_blank.png');
	width: 20px;
}

img.all-done {
	content: url('css/img/gr_tick.png');
	width: 20px;
}
</style>
<!--START MAIN-WRAPPER--> 
<div class="main-wrapper">
<!--START MAIN-WRAPPER--> 

<!-- TOP SECTION-->
<section class="headertop needhead" id="header-section">

	<?php $this->renderPartial('webroot.protected.views.layouts.menu'); ?>
	<!-- END HEADER headertop NAV -->

	<!-- HEADER MARKETING SLOGAN container-->
	<header class="container"  style="text-align:right;border:0px solid">
		<div class="row-fluid">
	
			<div class="wrap-hero" style="top: 60px;">
				<div class="hero-unit" style="text-align: left;">
					<!--LOGO-->
					<header class="left" ><div class="page-header">
					<h3>
						Current Events
					</h3></div></header>
					<!--/ LOGO-->
					<div class="thisIsHowContainer">
						<div class="thisIsHow" style="border:0px solid">
						   <div style="padding:10px">
							<span style="text-align:left;font-size:16pt;width:98%">This is how it works !</span><br/>
							<p>These are the Tennis tournaments conducted by clubs, organizations and sports academies 
							in and around your cities.</p>
							<p>Select one of the events to find more information. If you are a player and wish to participate
							in one of the tournaments then go to the Players section.</p>
						  </div>
						</div>
						<div class="thisIsHow">
							<div style="padding:0px">
								<?php echo $content; ?>
							</div>
						</div>
					</div>
					<!--<hr class="half">-->
					<span class="gobottom" id="nav2">
						<a href="#slogan-section-1" title="">
							<i class="fa-icon-chevron-down fa-icon-large"></i>
						</a>
					</span>
				</div>
			</div><!-- / HERO UNIT-->
		</div><!-- / HERO WRAP-->
	</header><!-- / HEADER MARKETING SLOGAN container-->
</section><!--/ TOP SECTION-->


<!-- SLOGAN SECTION 2 -->
<section class="section-1" id="slogan-section-1">
	<div class="bg parallax-point-event">
		<div class="container">
		
			<!--  BADGE FEATURED-->
			<div class="row-fluid">
				<div class="span12 text-center">
					<div class="featured-badge orange">
						This is how it works !
					</div>
					<div>
						<p style="color:#797">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
							Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
							Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
							Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</p>
					</div>
				</div>
			</div><!-- / BADGE FEATURED-->
			<!-- BUTTON GO BOTTOM -->
			<div class="row-fluid">
				<div class="span12 text-center">
					<span class="goprice active" id="nav3">
					<a href="#services-section" title="">
						<i class="fa-icon-double-angle-down fa-icon-large"></i>
					</a>
				</span></div>
			</div><!-- / BUTTON GO BOTTOM -->
		</div><!-- /container-->
</section> <!--/SLOGAN SECTION 2-->



<!-- SERVICES SECTION-->			
<section class="section-1" id="services-section">

	<div class="bg-wraper parallax-point-event">
	  <!-- SERVICES CONTAINER -->
	  <div class="container">
		<div class="row-fluid">
			<!-- SERVICES HEADER-->
			<header class="" >
				<div class="text-center page-header">
					<h3 class="">
						<span class="white"><!-- WHITE SPACE-->
							Our <span class="main-color">Services</span> 
						</span>	
					</h3>
				</div>
			</header><!-- /SERVICES HEADER-->
		</div>
	  </div><!-- /SERVICES CONTAINER -->
	
	  <!-- FEATURES CONTAINER -->
	  <div class="container">
					
			<div class="row-fluid">
				<div class="well">
					<div class="well-wrapp">
						<p class="lead"> <!-- text-large text-center -->
							<span class="main-color"> 
								Tallyho&trade; is available to its users, guests and players, entirely free of cost to use. Apart from be able to watch matches, a player
								can also enrol in an event entirely free of cost; of course, once you have agreed to our terms and conditions of use.
								
							</span>
						</p>
					</div>
				</div>
			</div><!-- /row-fluid-->
	  </div><!-- /FEATURES CONTAINER -->
	</div><!-- / BG WRAPER-->

</section><!-- /SERVICES section-->
	
<!-- SLOGAN SECTION 3 -->
<section class="section-3" id="slogan-section-3">
	<div class="bg parallax-point-event">
		<div class="container">
		
			<!--  BADGE FEATURED-->
			<div class="row-fluid">
				<div class="span12 text-center">
					<div class="featured-badge orange">
						App Screenshots
					</div>
				</div>
			</div><!-- / BADGE FEATURED-->
			
			<!--  FEATURED ITEMS -->
<!-- 			<div class="browser-shot-2"> -->
<!-- 				<div class="browser-header"></div> -->
<!-- 				<img src="images/SnapShot1.png" alt=""/> -->
				<!-- PLACE YOUR IMAGE HERE -->
<!-- 			</div> -->
<!-- 			<div class="browser-shot-1"> -->
<!-- 				<div class="browser-header"></div> -->
<!-- 				<img src="images/SnapShot2.png" alt=""/> -->
<!-- 			</div> -->
<!-- 			<div class="browser-shot-3"> -->
<!-- 				<div class="browser-header"></div> -->
<!-- 				<img src="images/SnapShot3.png" alt=""/> -->
<!-- 			</div> -->
			<!-- /FEATURED ITEMS -->
			
		</div><!-- /container-->
		
			<!-- BUTTON GO BOTTOM -->
			<div class="row-fluid">
				<div class="span12 text-center">
					<span class="goprice active" id="nav4">
					<a href="#players-section" title="">
						<i class="fa-icon-double-angle-down fa-icon-large"></i>
					</a>
				</span></div>
			</div><!-- / BUTTON GO BOTTOM -->	
	</div><!-- /row-->
	
</section> <!--/SLOGAN SECTION 3-->





<!-- PLAYERS SECTION  -->	
<section id="players-section">
	<div class="container">
		<!-- header for Recent works -->
		<div class="container">
			<div class="row">	
			<!-- PORTFOLIO  HEADER -->
				<div class="text-center">
					<header>
						<div class="span12 text-center page-header">
							<h3><span class="white">
								PLAYER'S <span class="main-color"> CORNER</span>
							</span></h3>
						</div>
					</header><!-- / PORTFOLIO SECTION HEADER-->
				</div><!-- /text center-->
			</div><!--/ROW-->
		</div><!--/CONTAINER-->
		
		<!-- Line items -->
		<div class="row">
			<!-- portfolio item -->
			<div class="span3  project-item graphics box" style="width:336px;border:0px solid red">
				<div class="caption">
					<span class="btn-box" >	
            <?php if(Yii::app()->user->isGuest) { ?>
						<a href="<?php echo $this->createUrl('/user')?>"
							class="btn btn-icon-large  btn-large  btn-block-third" >
							<i class="fa-icon-signin fa-icon-large"></i> 
							Sign in
						</a>
            <?php } else { ?>
            		<a href="<?php echo $this->createUrl('/user/user/logout')?>"
							class="btn btn-icon-large  btn-large  btn-block-third"
            				style="background-color: darkred">
						<i class="fa-icon-signout fa-icon-large"></i> 
						Log out
					</a>
            <?php } ?>
					</span>
					<!-- More Featured work -->
					<p>
			<?php if(Yii::app()->user->isGuest) { ?>
					  <span style="font-size: 12pt; color: #AAA; text-align:left ">
							First time users can sign up today and starting participating around your location.
						</span>
						<h3><span class="white">
							SIGN UP
							<a href="<?php echo $this->createUrl('/registration/registration')?>">
								<span class="main-color">TODAY</span>
							</a>
						</span></h3>
		    
		    <?php } elseif(isset(Yii::app()->user->data()->player)) { ?>
		            <div class="caption">
						<h4 class="">User Details</h4>
	            		<span>Name: <?php echo Yii::app()->user->data()->profile->firstname ?></span>
	            		<span><?php echo Yii::app()->user->data()->profile->lastname ?></span>
	            		<span>(<?php echo Lookup::item('Gender',Yii::app()->user->data()->player->gender) ?>)</span><br>
	            		<span>About:<?php echo Yii::app()->user->data()->profile->about ?></span><br>
	            		<span>From: <?php echo Yii::app()->user->data()->profile->city ?></span><br>
	            		<span>Email: <?php echo Yii::app()->user->data()->profile->email ?></span>
            		</div>
            <?php } else { ?>
           			<div class="caption">
						<h4 class="">Let <span class="main-color">Tallyho&trade;</span> know that you are a Player</h4>
							<ul>
								<li><?php echo CHtml::link('Provide Basic Information', array('/profile/profile/update')); 	?></li>
								<li><?php echo CHtml::link('Provide Player Information', array('/player/player/create')); 	?></li>
							</ul>
					</div>
            		 
            <?php } ?>
					</p>
					<!-- /text center-->								
				</div>
			</div>
			<!-- END: portfolio item -->
		
			<!-- portfolio item
				<div class="span3  project-item graphics box" style="width:250px;border:1px solid red">
	 					<div class="caption"> -->
<!-- 						<h4 class=""></h4> -->
<!-- 						<p class="caption-descr"> </p>	 -->
<!-- 					</div> -->
<!-- 				</div> -->
				<!-- END: portfolio item -->
				<!-- portfolio item -->
				<div class="span3 project-item graphics box" style="width:336px;border:0px solid red">
					<div class="caption">
						<h4 class="">Subscription & Alerts</h4>
						<p class="caption-descr">
							As a player who plays regularly, you should be able to subscribe to alerts on the events
							in your city or other cities. You can also get alerts on the events that you are already
							participating. 
						</p>
<!-- 						<p> -->
<!-- 							There are events where you might have to pay a fee. You have make payment arrangements with  -->
<!-- 							the organizers directly. Soon we will bring out a direct payment method for a small convenience -->
<!-- 							fee. -->
<!-- 						</p> -->
					</div>
				</div>
				<!-- END: portfolio item -->				  
				<!-- portfolio item -->
				<div class="span3 project-item graphics box" style="width:336px;border:0px solid red">
					<div class="caption">
						<h4 class="">Tallyho&trade; helps track better</h4>
						<p class="caption-descr">
							Tallyho&trade; keeps you updated on the proceedings of the event - venue and schedule of 
							upcoming matches, scores etc.
						</p>
						<p>
							Your family and friends can keep up with the your match results and scores.
						</p>
					</div>
				</div>
				<!-- END: portfolio item -->
		  
		</div><!--/innner folio row-->
	</div>
	
	<!-- More Featured work -->
	<div class="container">		
		<!-- Header -->
<!-- 		<div class="container"> -->
<!-- 			<div class="row">	 -->
				<!-- PORTFOLIO  HEADER -->
<!-- 				<div class="text-center"> -->
<!-- 					<header> -->
<!-- 						<div class="span12 text-center page-header"> -->
<!-- 							<h3><span class="white"> -->
<!-- 								SIGN UP <a><span class="main-color">TODAY</span></a> -->
<!-- 							</span></h3> -->
<!-- 						</div> -->
<!-- 					</header> -->
					<!-- / PORTFOLIO SECTION HEADER-->
<!-- 				</div> -->
				<!-- /text center-->
<!-- 			</div> -->
			<!--/ROW-->
<!-- 		</div> -->
		<!--/CONTAINER-->
			
		<!-- Line items -->
		<div class="row">
			<!-- portfolio item -->
<!-- 		<div class="span3  project-item graphics box"> -->
<!-- 			<div class="thumbnail" > -->
				<!-- IMAGE CONTAINER-- >
<!-- 				<a rel="prettyPhoto[gallery]" href="images/buttons.jpg" title="portfolio image"> -->
<!-- 					<img src="images/buttons.jpg" alt="iPhonegraphy" />  -->
<!-- 				</a> -->
<!-- 				END IMAGE CONTAINER -->
				<!-- CAPTION -- > 
<!-- 				<div class="caption"> -->
<!-- 					<h4 class="">15 custom buttons</h4> -->
<!-- 					<p class="caption-descr"> -->
<!-- 						This project presents beautiful style graphic &amp; design. Scroll&amp;Strap provides modern features  -->
<!-- 					</p>	 -->
<!-- 				</div>END CAPTION -- > 
<!-- 			</div><!-- END: THUMBNAIL -- > -->
<!-- 		</div> -->
			<!-- END: portfolio item -->
			<!-- Repeat Portfolio for more sections -->
			
		</div><!--/innner folio row-->
	</div><!--CONTAINER-->
</section><!--/PLAYERS SECTION-->




<!-- /SLOGAN SECTION 3 -->
<section class="" id="slogan-section-4">
	<div class="bg">
		<div class="container">
			<div class="row-fluid" style="text-align:center">
				<span>
					<a href="#" title="Scroll&amp;Strap">
						<img src="css/img/breve_tr.gif">
					</a>
				</span>
					
				<div class="span12 text-center">
					<span class="large-slogan main-color">
						Brevity solutions are no-nonsense, concise and direct. Our solutions are based on open-source technologies
						to retain high value and low cost of ownership.
					</span>
				</div><!-- /span12-->	
			</div><!-- /row-fluid-->
	
			<!-- BUTTON GO BOTTOM -->
			<div class="row-fluid">
				<div class="span12 text-center">
					<span class="goprice active" id="nav5">
						<a href="#organizers-section" title="">
							<i class="fa-icon-double-angle-down fa-icon-large"></i>
						</a>
					</span>
				</div>
			</div><!-- / BUTTON GO BOTTOM -->		
		</div><!-- /container-->
	</div><!-- BG-->
</section><!--/SLOGAN SECTION 3-->



<!-- ORGANIZERS SECTION  -->	
<section id="organizers-section">
	<div class="container">
		<!-- header for Recent works -->
		<div class="container">
			<div class="row">	
			<!-- PORTFOLIO  HEADER -->
				<div class="text-center">
					<header>
						<div class="span12 text-center page-header">
							<h3><span class="white">
								ORGANIZER'S <span class="main-color"> CORNER</span>
							</span></h3>
						</div>
					</header><!-- / PORTFOLIO SECTION HEADER-->
				</div><!-- /text center-->
			</div><!--/ROW-->
		</div><!--/CONTAINER-->
		
		<!-- Line items -->
		<div class="row">
			<!-- portfolio item -->
			<div class="span3  project-item graphics box" style="width:500px;border:0px solid red">
				<div class="caption">
					<span class="btn-box" >				
            <?php if(Yii::app()->user->isGuest) { ?>
						<a href="<?php echo $this->createUrl('/user')?>"
							class="btn btn-icon-large  btn-large  btn-block-third" style="width:300px">
							<i class="fa-icon-signin fa-icon-large"></i> 
							Sign in
						</a>
            <?php } else { ?>
            <a href="<?php echo $this->createUrl('/user/user/logout')?>"
							class="btn btn-icon-large  btn-large  btn-block-third"
              style="background-color: darkred;width:300px">
							<i class="fa-icon-signout fa-icon-large"></i> 
							Log out
						</a>
            <?php } ?>
					</span>
					<!-- More Featured work -->
					<p>
          <?php if(Yii::app()->user->isGuest) { ?>
						
						<span style="font-size: 12pt; color: #AAA; text-align:left ">
							Event organizers, club management and school sports departments can register themselves for Free
							and enjoy first 2 events for free!!!
						</span>
						<h3><span class="white">
							SIGN UP
							<a href="<?php echo $this->createUrl('/registration/registration?userType=2')?>">
								<span class="main-color">TODAY</span>
							</a>
						</span></h3>
            
          <?php } elseif(isset(Yii::app()->user->data()->contact)) { ?>
		            <div class="caption">
						<h4 class="">User Details</h4>
	            		<span>Name: <?php echo Yii::app()->user->data()->profile->firstname ?></span>
	            		<span><?php echo Yii::app()->user->data()->profile->lastname ?></span>
	            		<span>About:<?php echo Yii::app()->user->data()->profile->about ?></span><br>
	            		<span>From: <?php echo Yii::app()->user->data()->profile->city ?></span><br>
	            		<span>Email: <?php echo Yii::app()->user->data()->profile->email ?></span>
            		</div>
           <?php } else { ?>
           			<div class="caption">
						<h4 class="">Setup your Organization in <span class="main-color">Tallyho&trade;</span></h4>
						  	<table><tr><td>
								<img class='<?php echo isset(Yii::app()->user->profile)? "all-done" :"not-yet"?>' >
								<?php echo CHtml::link('Provide Basic Information', array('/profile/profile/update')); 	?>
							</td></tr><tr><td>
								<img class='<?php echo isset(Yii::app()->user->profile)? "all-done" :"not-yet" ?>'>
								<?php echo CHtml::link('Provide Organization/Club Details', array('/organization/default/create')); 	?>
							</td></tr></table>
					</div>
            
           <?php } ?>
					</p>	
				</div>
				
			</div>
			<!-- END: portfolio item -->
		
			<!-- portfolio item -->
			<div class="span3 project-item graphics box" style="width:250px;border:0px solid red">
				<div class="caption">
					<h4 class="">Tallyho&trade; is Cost-Effective</h4>
					<p class="caption-descr">
						Tallyho&trade; keeps your event logistics much simpler and easier to manage than making
						using additional hands to run the event. Communication flow between your organization, your
						members & players. Think of hundreds phone calls, hand-written score-sheets and draw-brackets.
						Tallyho&trade; handles those all by itself.  
						upcoming matches, scores etc.
					</p>
					
				</div>
			</div>
			<!-- END: portfolio item -->
			<!-- portfolio item -->
			<div class="span3 project-item graphics box" style="width:250px;border:0px solid red">
				<div class="caption">
					<h4 class="">Your data is safe with us</h4>
					<p class="caption-descr">
						Tallyho&trade; runs on IBM's Bluemix platform (Cloud) where your data never gets lost. They 
						are safe and backed-up several times in a day. You can access your data in raw form or as reports.
						
					</p>
					<p>
						Only public information about your event and participants are shared on our application. 
						Other organizers, players or a public user, cannot view personal data of the participants
						or reports from your events.
						
					</p>
				</div>
			</div>
			<!-- END: portfolio item -->				  
			
			
			
		</div><!--/innner folio row-->
	</div>
	
	<!-- More Featured work -->
	<div class="container">		
		<!-- Header -->
		<div class="container">
			<div class="row">	
				<!-- PORTFOLIO  HEADER -->
				<div class="text-center">
					<header>
						<div class="span12 text-center page-header">
							<p>
								You can set up a new tournament in easy 4-step process -
							</p>
							<div style="display:table-cell;min-height:50px;background-color:lightgray;width:200px">
								<i class="fa-icon-calendar fa-icon-large"></i><br>
								Create an Event(tournament)</div>
							<div  style="display:table-cell;min-height:50px;width:100px;font-size:32px;padding-top:20px">
								<i class="fa-icon-chevron-right fa-icon-large"></i>
							</div>
							<div style="display:table-cell;min-height:50px;background-color:lightgray;width:200px">
								<i class="fa-icon-random fa-icon-large"></i><br>
								Create its Tracks(Categories)</div>
							<div  style="display:table-cell;min-height:50px;width:100px;font-size:32px;padding-top:20px">
								<i class="fa-icon-chevron-right fa-icon-large"></i>
							</div>
							<div style="display:table-cell;min-height:50px;background-color:lightgray;width:200px">
								<i class="fa-icon-bullhorn fa-icon-large"></i><br>
								Invite or Enrol Players</div>
							<div  style="display:table-cell;min-height:50px;width:100px;font-size:32px;padding-top:20px">
								<i class="fa-icon-chevron-right fa-icon-large"></i>
							</div>
							<div style="display:table-cell;min-height:50px;background-color:lightgray;width:200px">
								<img src="images/bracket.png"><br>
								Generate Draw-Brackets</div>
						</div>
					</header><!-- / PORTFOLIO SECTION HEADER-->
				</div><!-- /text center-->
			</div><!--/ROW-->
		</div><!--/CONTAINER-->
			
		<!-- Line items -->
		<div class="row">
			<!-- portfolio item -->
			<!--div class="span3  project-item graphics box">
			<div class="thumbnail" >
				<!-- IMAGE CONTAINER-- >
				<a rel="prettyPhoto[gallery]" href="images/buttons.jpg" title="portfolio image">
					<img src="images/buttons.jpg" alt="iPhonegraphy" /> 
				</a>
				<!--END IMAGE CONTAINER-->
				<!-- CAPTION -- > 
				<div class="caption">
					<h4 class="">15 custom buttons</h4>
						<p class="caption-descr">
						This project presents beautiful style graphic &amp; design. Scroll&amp;Strap provides modern features 
						</p>	
				</div><!--END CAPTION -- > 
			</div><!-- END: THUMBNAIL -- >
		</div --><!-- END: portfolio item -->
		
		<!-- Repeat Portfolio for more sections -->
		</div><!--/innner folio row-->
	</div><!--CONTAINER-->
</section><!--/ORGANIZERS SECTION-->

<!-- /SLOGAN SECTION 3 -->
<section class="" id="slogan-section-4">
	<div class="bg">
		<div class="container">
			<div class="row-fluid" style="text-align:center">
				<span>
					<a href="#" title="Scroll&amp;Strap">
						<h3>
							Want to run Tallyho&trade; on your App
						</h3>
					</a>
				</span>
					
				<div class="span12">
					<span class="large-slogan main-color text-left">
						Coming soon, the REST-ful APIs (Application Programming Interfaces) which can be used in
						your own web or mobile applications and integrate with Tallyho&trade; Event Engine. You
						get immediate reach to 1000s of players and powerful engines without having to setup your
						own infrastructure.
					</span>
				</div><!-- /span12-->	
			</div><!-- /row-fluid-->
	
			<!-- BUTTON GO BOTTOM -->
<!-- 			<div class="row-fluid"> -->
<!-- 				<div class="span12 text-center"> -->
<!-- 					<span class="goprice active" id="nav5"> -->
<!-- 						<a href="#organizers-section" title=""> -->
<!-- 							<i class="fa-icon-double-angle-down fa-icon-large"></i> -->
<!-- 						</a> -->
<!-- 					</span> -->
<!-- 				</div> -->
<!-- 			</div> -->
			<!-- / BUTTON GO BOTTOM -->		
		</div><!-- /container-->
	</div><!-- BG-->
</section><!--/SLOGAN SECTION 3-->




<!-- DEVELOPERS SECTION  -->	
<section id="developers-section">
	<div class="container">
		<!-- header for Recent works -->
		<div class="container">
			<div class="row">	
			<!-- PORTFOLIO  HEADER -->
				<div class="text-center">
					<header>
						<div class="span12 text-center page-header">
							<h3><span class="white">
								DEVELOPER'S <span class="main-color"> CORNER</span>
							</span></h3>
						</div>
					</header><!-- / PORTFOLIO SECTION HEADER-->
				</div><!-- /text center-->
			</div><!--/ROW-->
		</div><!--/CONTAINER-->
		
		<!-- Line items -->
		<div class="row">
			<!-- portfolio item -->
			<div class="span3  project-item graphics box" style="width:250px;border:0px solid red">
				<div class="caption">
					<h4 class="">Migrate a PHP Application to IBM Bluemix</h4>
					<p class="caption-descr">IBM makes their latest cloud based DevOps offering in the form of Bluemix. The objective being
					easy development and maintenace of applications (esp. cloud-based). Bluemix offers a wide range of web and mobile platforms for commercial applications. Find out the first hand experience of the platform and the ease of use.
						. <a href="http://tallyho.in/blog/php-ibm-bluemix/"> Read more ...</a>
					</p>	
				</div>
				Read more blog posts on <a href="http://tallyho.in/blog">Brevity Blog site </a>.
			</div>
			<!-- END: portfolio item -->
		
			<!-- portfolio item -->
				<div class="span3  project-item graphics box" style="width:250px;border:0px solid red">
					<div class="caption">
						<h4 class="">Build Visualization on SAP HANA</h4>
						<p class="caption-descr">
							SAP HANA is a powerful in-memory platform capable of doing more than analytics. Traditionally SAP products
							have attracted only the large enterprise world, which are intergrated with other SAP solutions upstream and/or
							downstrem. It made little sense for those who do not dig SAP to venture out in this area. It is not the case anymore.
							<a href="http://brevity.ie/blog/technical-articles/hana-visual-intro/"> Read more ...</a>
						</p>	
					</div>
				</div>
				<!-- END: portfolio item -->
				<!-- portfolio item -->
				<div class="span3 project-item graphics box" style="width:250px;border:0px solid red">
					<div class="caption">
						<h4 class="">MapReduce in R using RMR2 on AWS</h4>
						<p class="caption-descr">
							R is by far the most popular statistical and analytical tool amongst the academia, open-source lovers and SMB players.
							The power comes from 1000s of contributors who keep adding features to the package. For BigData analyses, R can be coupled
							with Hadoop and MapReduce easily. Learn to use R and MapReduce on AWS EMR.
							<a href="http://brevity.ie/blog/rhadoop01"> Read more ...</a>
						</p>	
					</div>
				</div>
				<!-- END: portfolio item -->				  
				<!-- portfolio item -->
				<div class="span3 project-item graphics box" style="width:250px;border:0px solid red">
					<div class="caption">
						<h4 class="">Visualization of a Tree-Graph using D3.js</h4>
						<p class="caption-descr">
							D3.js is a powerful micro-framework for building interactive and complex visualization which are rendered as SVG and HTML5 pages. One of our projects implemented a reverse-binary tree which is programmatically built and offers high level of interactivity. In this blog, you will find a link to a demo page along with its source code.
							<a href="http://tallyho.in/blog/tree-d3-js/"> Read more ...</a>
						</p>	
					</div>
				</div>
				<!-- END: portfolio item -->
		  
		</div><!--/innner folio row-->
	</div>
	
	<!-- More Featured work -->
	<div class="container">		
		<!-- Header -->
		<div class="container">
			<div class="row">	
				<!-- PORTFOLIO  HEADER -->
				<div class="text-center">
					<header>
						<div class="span12 text-center page-header">
							<h3><span class="white">
								SIGN UP <a><span class="main-color">TODAY</span></a>
							</span></h3>
						</div>
					</header><!-- / PORTFOLIO SECTION HEADER-->
				</div><!-- /text center-->
			</div><!--/ROW-->
		</div><!--/CONTAINER-->
			
		<!-- Line items -->
		<div class="row">
			<!-- portfolio item -->
			<!--div class="span3  project-item graphics box">
			<div class="thumbnail" >
				<!-- IMAGE CONTAINER-- >
				<a rel="prettyPhoto[gallery]" href="images/buttons.jpg" title="portfolio image">
					<img src="images/buttons.jpg" alt="iPhonegraphy" /> 
				</a>
				<!--END IMAGE CONTAINER-->
				<!-- CAPTION -- > 
				<div class="caption">
					<h4 class="">15 custom buttons</h4>
						<p class="caption-descr">
						This project presents beautiful style graphic &amp; design. Scroll&amp;Strap provides modern features 
						</p>	
				</div><!--END CAPTION -- > 
			</div><!-- END: THUMBNAIL -- >
		</div --><!-- END: portfolio item -->
		
		<!-- Repeat Portfolio for more sections -->
		</div><!--/innner folio row-->
	</div><!--CONTAINER-->
</section><!--/DEVELOPERS SECTION-->




<!-- /SLOGAN SECTION 4 -->
<section class="" id="slogan-section-1">
	<div class="bg">
		<div class="container">
			<div class="row-fluid" style="text-align:center">
				<span>
					<a href="#" title="Scroll&amp;Strap">
						<img src="css/img/breve_tr.gif">
					</a>
				</span>
					
				<div class="span12 text-center">
					<span class="large-slogan main-color">
						Brevity solutions are no-nonsense, concise and direct. Our solutions are based on open-source technologies
						to retain high value and low cost of ownership.
					</span>
				</div><!-- /span12-->	
			</div><!-- /row-fluid-->
	
			<!-- BUTTON GO BOTTOM -->
			<div class="row-fluid">
				<div class="span12 text-center">
					<span class="goprice active" id="nav6">
					<a href="#team-section" title="">
						<i class="fa-icon-double-angle-down fa-icon-large"></i>
					</a>
				</span></div>
			</div><!-- / BUTTON GO BOTTOM -->			
		</div><!-- /container-->
	</div><!-- BG-->
</section><!--/SLOGAN SECTION 4-->


<!-- ABOUT SECTION-->			
<section class="" id="team-section">
	<!-- ABOUT HEADER CONTAINER -->
	<div class="container">
		<div class="row">
			<header class="" >
				<div class=" text-center page-header">
					<h3>
						<span class="white"> WHO<span class="main-color"> WE </span>ARE	</span>
					</h3>
				</div>
			</header>
		</div>
	</div><!-- /ABOUT HEADER CONTAINER -->
	
	<!-- ABOUT ITEMS CONTAINER -->
	<div class="container">	
		<div class="row-fluid">
			<!-- ABOUT ITEM-->
			<div class="span8">
            
				<!-- IMAGE CONTAINER-->
            
				<h3 class="main-color-line">About us</h3>
				<p class="">
					We are a team of creative members who are <span class="main-color"> constantly innovating </span>products and services we offer. We have, in our team, 
					application architects, business analysts, data-scientists, hospitality wannabes, well-trained programmer and event managers;  
					who seek challenge in our client's problems. We are dedicated to developing long-term, honest, effective relationships with
					each of our clients. 
				</p>
				
				<h3 class="main-color-line">Our vision</h3>
				<p class="">
					We strive to exploit pervasive technologies in building <span class="main-color">simple, smart &amp; powerful </span>applications
					addressing the small business challenges. We use Internet and personal smart devices based solutions to make our solutions
					highly usable and affordable.
				</p>
				
				<h3 class="main-color-line">Our experience</h3>
				<p class="">
					The combination of Internet, smart personal devices and open-source technologies create a highly resourceful platform to 
					carry out business for small players. It is lot more easier to build and use customized applications but it will be even more
					viable to use common business tools.
				</p>
				<!--END IMAGE CONTAINER-->
			 	<!-- CAPTION -->	
			</div><!-- / ABOUT ITEM-->

			<!-- ABOUT ITEM-->
			<div class="thumbnail span3">
				<!-- IMAGE CONTAINER-->
<!-- 	            <div class="sample project-item-image-container"> -->
<!-- 					<img src="images/mukul.jpg" alt=""> -->
<!-- 				</div> -->
				<!-- /IMAGE CONTAINER-->
			 
		 		<!-- CAPTION -->
				<div class="caption">
<!-- 					<div class="transit-to-top"> -->
<!-- 						<p class="caption-descr"> -->
<!-- 							<i class="fa-icon-quote-left main-color"></i> -->
<!-- 							We are proud of our technologies but your business success is our bigger passion. -->
<!-- 							<i class="fa-icon-quote-right main-color"></i> -->
<!-- 						</p> -->
<!-- 						<h4 class=""> -->
<!-- 							<strong>Mukul Biswas</strong> - <small>Founder &amp; Principal</small> -->
<!-- 						</h4> -->
<!-- 						<div class="widget_nav_menu">  -->
<!-- 							<ul class="social-bottom"> -->
<!-- 								<li><span class="badge badge-warning"><a href="http://www.github.com/mukulbiswas" title=""><i class="fa-icon-github-alt"></i></a></span></li> -->
<!-- 								<li><span class="badge badge-warning"><a href="http://plus.google.com/+MukulBiswas" title=""><i class="fa-icon-google-plus"></i></a></span></li> -->
<!-- 								<li><span class="badge badge-warning"><a href="http://ie.linkedin.com/pub/mukul-biswas/0/63a/898" title=""><i class="fa-icon-linkedin"></i></a></span></li> -->
<!-- 							</ul>			 -->
<!-- 						</div> -->
<!-- 					</div> -->
					<!-- /TRANSIT TO TOP -->
				</div> <!-- /CAPTION -->
			</div><!-- ABOUT ITEM-->
		</div><!--/ROW FLUID--> 
		
		
	</div><!--/ABOUT ITEMS CONTAINER-->
</section><!-- /ABOUT SECTION-->	


<?php $this->renderPartial('webroot.protected.views.layouts.footer'); ?>
