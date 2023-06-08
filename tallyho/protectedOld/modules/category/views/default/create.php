 <?php 
 $this->headers[0] = "Create a New Track";
 
 $this->menu = array(
 		array('label'=>'Back', 'url'=> array('index', 'tid' =>$tourId))
 	);
 
 //$this->backLink = $this->createUrl("index", array("tid" => $tourId));
 ?>	
 <?php $this->renderPartial('_form', array('model'=>$model, 'validCategories'=>$validCategories)); ?>
 
 
 <?php 

$jsFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/datetimepicker/jquery.datetimepicker.js');
$csFile =Yii::app()->getAssetManager()->publish(Yii::app()->basePath.'/../js/datetimepicker/jquery.datetimepicker.css');
Yii::app()->clientScript->registerScriptFile($jsFile);
Yii::app()->clientScript->registerCssFile($csFile);

?>