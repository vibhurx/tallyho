<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h4>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h4>

<p>As a player, you can participate in any of the open events. Just login, pick the event and the category of
	your choice. You might have to pay a participation fee if the event is not a free one.
</p>

<p>You can also view how the events progress - date & time of the scheduled matches, players and scores of the 
	matches that are over or ongoing at the moment. Follow the menu titled <?php echo CHtml::link("Events",array("event/index"))?>.</p>

<p></p>

<p>As a visitor, you can view the progresses of the ongoing matches as well as the scores of the 
	completed ones. Follow the menu titled <?php echo CHtml::link("Events",array("event/index"))?>.</p> 

<?php if(Yii::app()->user->hasRole('Admin')){ //!Yii::app()->user->isGuest){
?>
Currently you are logged in as admin. You can manage the site and the users 
<?php echo CHtml::link("here ...",array("//user/user/admin"))?>.
<?php
}
?>