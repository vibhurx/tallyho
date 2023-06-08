<?php
// This page can later be used for making an attractive landing page http://tallyho.in
/* @var $this PlayerController */
/* @var $dataProvider CActiveDataProvider */
/* @var $this DefaultController */

$this->pageTitle=Yii::app()->name . ' - Home';
$this->breadcrumbs=array(
	'Site Administration',
);

$this->menu=array(
	array('label'=>Yum::t('List of Players', array(), 'admin'), 'url'=>array('/player/player')),
	array('label'=>Yum::t('List of Organizations', array(), 'admin'), 'url'=>array('/organization')),
 	array('label'=>'List of Users', 'url'=>array('/user/user'), 'template'=>' &nbsp; {menu}'),
	array('label'=>'Activate a User', 'url'=>array('/user/user/admin')),
	array('label'=>'Reset Test-Data', 'url'=>array('/site/cleanTestData')),
	array('label'=>'Insert Unreg. Players (Boys)', 'url'=>array('/site/addPlayers'), 'template'=>' &nbsp; {menu}'),
);
?>

<h1>Site Administration</h1>
<div>
<?php echo Yum::t($message, array(), 'admin'); ?>
<br>
<?php echo Yum::t('non-existent',  array(), 'admin'); ?>
<br>
<?php echo Yii::app()->language; ?>


</div>