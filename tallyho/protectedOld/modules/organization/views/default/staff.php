<?php
/* @var $this CommonController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Organizations',
);

//$userType = Yii::app()->user->data()->type;

$this->menu=array(
	array('label'=>'Add Staff',
			'url'=>array('admin'),
			'visible'=>Yii::app()->user->id==$model->admin_id),
);
?>

<h1>Staff</h1>


<?php 

	
// 	foreach ($staff as $value) {
// 		echo $value->id;
// 		echo '|';
// 		echo $value->username;
// 		echo '|';
// 		echo $value->profile->firstname;
// 		echo '|';
// 		echo $value->profile->lastname;
// 		echo '<br>';
// 	}

	//$model = new Organization();

	$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns' => array(
		array('name' => 'Username', 'value' => '$data->username'),
		array('name' => 'First Name', 'value' => '$data->profile->firstname'),
		array('name' => 'Last Name', 'value' => '$data->profile->lastname'),
		array('name' => 'Manager', 'value' => function($data, $row) use ($model){
                return $data->id==$model->admin_id?"Yes":"No";
            },)
      )
	));
?>
