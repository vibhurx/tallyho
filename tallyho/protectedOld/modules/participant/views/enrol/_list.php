
<h1>List of Enrolled Players</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns' => array(
			array('name' => 'Given name', 'value' => '$data->player->given_name'),
			array('name' => 'Family name', 'value' => '$data->player->family_name'),
			array('name' => 'AITA No', 'value' => '$data->player->aita_no'),
			array('name' => 'AITA Pts', 'value' => '$data->player->aita_points'),
			'seed',
	),
)); ?>
