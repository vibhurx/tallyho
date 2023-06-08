<div style='display:none;text-align:center'><div id="message_island" style='text-align:center'>
<?php
	echo $message === null 
		? "There seems to be a problem in showing the error message. Contact the site admin."
		: $message;
	echo "<br/><br/>";
	echo CHtml::link('Back to list', array('../tour/default/view', 'id'=> $tourId));
?> 


</div></div>

<?php

//Hidden link for invoking the fancy box dialog.
echo CHtml::link("Am I Hidden",
		'#message_island',
		array('title'=>'Error Message',
		  'style'=>'display:none', 'id'=>'fb_island'));

//The fancy box in which the message should come - Island
$this->widget(
		'application.extensions.fancybox.EFancyBox',
		array('target'=> '#fb_island',
				'config'=>array('scrolling' => 'no',
						'titleShow' => true,
						'padding'=>40,)));
?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#fb_island").fancybox().trigger('click');
    });
</script>