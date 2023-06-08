<style>
<!--
h2, h3 {
	border:1px solid darkblue;background: darkgreen;color:lightgray;padding-left:10px;
}
h3 {
	background: darkred
}
div.api_title {
	border:1px solid lightblue;border-radius:5px;padding:10px;
}
div.api_title h3 {
	font-size: 14px;
	color: darkgreen;
	font-weight:bold;
}
div.api_title:hover {
    background-color:lightblue;
}
div.api_detail {
	border:1px solid lightgray;padding:10px;
	margin-top:-10px;
}
div.api_example {
	border:1px solid lightblue;border:1px solid lightblue;border-radius:5px;padding:10px;
}
div.api_example:hover {
    background-color:lightblue;
}
div.api_example_detail {
	border:1px solid lightblue;padding:10px;display:block;
}

div.method_get, .method_post{
	display: inline;border:1px solid purple;padding:2px;border-radius:4px;background:purple;color:white;
	font-weight:normal;font-size:10px;
}

div.method_post {
	border:1px solid blue;background:blue;
}

body {
	font-family : Arial;
	font-size: 12pt;
	font-weight: normal;
}

-->
</style>
<script type="text/javascript">
<!--
function toggleVisibility(id, level){
	var div_id;
	if(level == 0)
		div_id = '#api' + id;
	else if(level == 1)
		div_id = '#api' + id + 'ex';
	else if(level == 2)
		div_id = '#api' + id + 'tr';
	$(div_id).css('display')=='none'?$(div_id).show():$(div_id).hide();
	
}
//-->
</script>

<script type="text/javascript">
<!--
	ajaxCall = function(id, url){
		//console.log(url);
		pJsonData = $("#api"+ id +"data").val();
		//console.log(pJsonData);
		jQuery.ajax({
            url: url,
            type: "POST",
            data: JSON.parse(pJsonData),
            dataType: "json",
            error: function(xhr,tStatus,e){
	                if(!xhr){
	                	$("#api"+ id +"result").text("We have an error." + tStatus + " " + e.message);
	                }else{
		                $("#api"+ id +"result").text("else: " + e.message); // the great unknown
	                }
                },
            success: function(resp){
            	$("#api"+ id +"result").text(JSON.stringify(resp));  // deal with data returned
                }
            });
        };
//-->
</script>
<h1>Application Programming Interfaces (APIs)</h1>
<hr>
<?php 
if(isset($_GET['id']))
	$title = $_GET['id'];
else
	$title = 'api_home';

$this->menu = array(
		array('label'=>'API Home', 'url'=>'api'),
		array('label'=>'Base URL', 'url'=>'api?id=base_url'),
		array('label'=>'Tournaments', 'url'=>'api?id=tournaments'),
		array('label'=>'Categories', 'url'=>'api?id=categories'),
		array('label'=>'Enrolments', 'url'=>'api?id=enrolments'),
		array('label'=>'Matches', 'url'=>'api?id=matches'),
		array('label'=>'Update Match', 'url'=>'api?id=update_match'),
		array('label'=>'Match Score', 'url'=>'api?id=match_score'),
		array('label'=>'Game Score', 'url'=>'api?id=game_score'),
		array('label'=>'Set Score', 'url'=>'api?id=set_score'),
		array('label'=>'Update Score', 'url'=>'api?id=update_score'),
		array('label'=>'Adjust Score', 'url'=>'api?id=adjust_score'),
		array('label'=>'Walkover', 'url'=>'api?id=walkover'),
		array('label'=>'Item Lookup', 'url'=>'api?id=item_lookup'),
		array('label'=>'Group Lookup', 'url'=>'api?id=group_lookup'),
		array('label'=>'Participant', 'url'=>'api?id=participant'),
		array('label'=>'User Authentication', 'url'=>'api?id=user_authentication'),
		array('label'=>'User Signup', 'url'=>'api?id=user_signup'),
		array('label'=>'Enrol', 'url'=>'api?id=enrol'),
		array('label'=>'Leave', 'url'=>'api?id=leave'),
		array('label'=>'User Profile', 'url'=>'api?id=user_profile'),
		//array('label'=>'Contact\'s Employer', 'url'=>'api?id=contact_employer'),
		array('label'=>'Update Profile', 'url'=>'api?id=update_profile'),
		array('label'=>'Organization Logo', 'url'=>'api?id=organization_logo'),
);

$this->renderPartial('/default/pages/api/' . $title);
?>

