<?php 	
	echo $message === null? "<h2>There seems to be a problem in showing the error message. Contact the site admin.</h2>":"<h2>".$message."</h2>";
?> 

<?php

$this->menu=array(
	array('label'=>'Back', 'url'=>array('//tour/tour/view', 'id'=> $tourId)),
);

?>
