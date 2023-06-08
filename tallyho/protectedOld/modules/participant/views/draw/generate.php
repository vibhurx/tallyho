<?php
/* @var $this ParticipantController */
/* @var $model Participant */

$this->breadcrumbs=array(
	'Participants'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Participant', 'url'=>array('index')),
	//array('label'=>'Manage Participant', 'url'=>array('admin')),
);
?>

<h1>Prepare Draw - Step 1 </h1>

<ul>
	<li>List of participants are available as a dataProvider</li>
	<li>Prpeare a draw of 5 rounds (32 players). Use all the draw logic.</li>
	<li>Give options to the use to reduce/increase the rounds, qualifying rounds are determined automatically</li>
	<li>Give an option of going back and change data.</li>
	<li></li>
	<li>"Save" button will create "Match" objects and draw status for the category will move to "PREPARED".</li>
</ul>

No of players are - <?php  echo $dataProvider->itemCount ?>