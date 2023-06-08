<?php 
	$scenes = array(
		array('id'=>'viewtour', 'role'=>"public",	 'channel'=>'web, mobile',	'name'=>"View a tournament and its categories"),
		array('id'=>'viewscor', 'role'=>"public",	 'channel'=>'web, mobile',	'name'=>"View matches & scores"),
		array('id'=>'enroling', 'role'=>"player",	 'channel'=>'web, mobile',	'name'=>"Enrol for a tournament category"),
		array('id'=>'registr0', 'role'=>"player",	 'channel'=>'web, mobile',	'name'=>"Register"),
		array('id'=>'registry', 'role'=>"organizer", 'channel'=>'web',			'name'=>"Register"),
		array('id'=>'tourstrc', 'role'=>"organizer", 'channel'=>'web',			'name'=>"Create tournament structure"),
		array('id'=>'enrlothr', 'role'=>"organizer", 'channel'=>'web',			'name'=>"Enrol a player"),
		array('id'=>'drawpubl', 'role'=>"organizer", 'channel'=>'web',			'name'=>"Prepare & publish a draw"),
		array('id'=>'scoring1', 'role'=>"organizer", 'channel'=>'web, mobile',	'name'=>"Score a match"),
	);
?>
<h1>Scenarios</h1>
Select a row to view the details -
<?php 
	$scenesProvider = new CArrayDataProvider($scenes);
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$scenesProvider,
		'selectionChanged'=>'function(id){location.href= "' . $this->createUrl('site/page') . 	'/view/"+$.fn.yiiGridView.getSelection(id);}',
		'columns'=> array('name', 'role', 'channel'))
	);
?>