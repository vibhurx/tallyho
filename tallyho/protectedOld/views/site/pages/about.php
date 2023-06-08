<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>About Tallyho</h1>

<p>Tallyho is an application to manage run junior circuit tennis tournaments prevalent in the country. Using this 
 application a player can enrol himself or herself to one of the tournaments published by the organizers and track them.
 Organizers on the other hand, can create and manage tournaments events. 
<p><p>
<b>Organizers:</b> 
 Some of the available features for the organizers
 are - 
<ul>
	<li>announcing the tournament with all the necessary details</li>
	<li>accepting nominations from the players and track payment</li>
	<li>generating and publishing the draws (as per international norms)</li>
	<li>keeping the scores as the matches progress</li>
	<li>keep updating the draw as the rounds progress</li>
</ul>
<p/>
<p/>
Create a profile for yourself. If you are an organizing manager, then you can create contacts for your organization for your
members. These members can manage the tournaments like editing details, keeping scores, enrolling players etc.
<p/>

<p/>
<p/>
<b>Players:</b>
Players can go through a brief presentation on the application and its features -
<a href="http://www.slideshare.net/MukulBiswas1/tallyho-aita-tournament-format" target="new">
follow this link </a> (SlideShare link).
<p/>
Read the website related 
<?php echo CHtml::link('Disclaimer', array('/site/page/view/disclaimer/src/about'))	?>, 
<?php echo CHtml::link('Terms of Use', array('/site/page/view/terms/src/about'))	?>, and our 
<?php echo CHtml::link('Privacy Policy', array('/site/page/view/privacy/src/about'))?>.
