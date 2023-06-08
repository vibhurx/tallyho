<?php
/* @var $this CommonController */
/* @var $model Organization */
/* @var $dataProvider Contact */

$this->breadcrumbs=array(
	'Tour',
	'Error',
);

$this->menu=array(
	array('label'=>'Go back', 'url'=>$err_source),
);
?>

<h1>Error code : <?php echo $err_code?></h1>

<?php echo $err_message ?>