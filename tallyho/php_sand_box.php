<?php
		$arr = array('10'=> 89, '1' => 79, '17' => 60, '5' => 100);
		echo "Original array: <br/>";
		print_r($arr);
		
		

		echo "<br/><br/>Array of the keys : <br/>" ;
		
		print_r(array_keys($arr));
		
		
		echo "<br/><br/>Comma-separated: <br/>" ;
		
		echo implode(",", array());
		
		
//		arsort($arr, SORT_NUMERIC); //descending
?>