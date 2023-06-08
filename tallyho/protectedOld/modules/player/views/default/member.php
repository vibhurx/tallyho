<?php

$this->header01 = "My Memberships";

$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$memberships,
	'columns' => array(
		array('name' => 'Location',
			  'type' => 'raw',
			  'value' => '$data->organization->name',
		),
 		'since',
		'regn_no',
		'rank',
		'points'
		)
	));

?>
