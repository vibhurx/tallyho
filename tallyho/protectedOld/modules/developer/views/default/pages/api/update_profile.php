<div class='api_title' onclick="toggleVisibility(17,0)">
	<h4>Update Profile <div class='method_post'>POST</div></h4>
	A logged in player or a contact updates his/her profile. Email change is not allowed as yet.
</div>
<br>
<div id='api17' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	http://tallyho.in/apps/index.php/user/api/update </pre>
		<ul>
			<li>JSON structure (different for players and contacts)</li>
			<li>Complete list of fields</li>
			<ul>
				<li>username (mandatory)</li>
				<li>data</li>	
				<ul>
					<li>given_name</li>
					<li>family_name</li>
					<li>date_of_birth</li>
					<li>aita_no</li>
					<li>aita_points</li>
					<li>state</li>
					<li>gender</li>
				</ul>
				<li>password</li>
			</ul>
		</ul>
	Output: -
		<ul><li>success: true or false</li>
			<li>reason: if success is false</li>
			<li>message: if success is true</li>
		</ul>
		Any malformed JSON would have to be handled by the client only. Web-service is not able to handled any malformed JSON input.
<br><br>
<div class='api_example' onclick='toggleVisibility(17,1)'>Example:</div> 
<div id='api17ex' class='api_example_detail'>
	Call with POST data:
		<pre>	{
		"username":"kylebishop",
		"data": {
			"state":"17"
		},
		"password":"new_p@ssword"
	} </pre>
		Possible results:
	<pre>	{"success":"false","reason":"Error: username could not be found."}</pre>
or 
	<pre>	{"success":"false","reason":"Error: the data update could not be done."}</pre>
or 
	<pre>	{"success":"false","reason":"Error: the required pattern of the password missing."}</pre>
or 
	<pre>	{"success":"true","message":"The personal data and the password have been updated."}</pre>
</div>

<div class='api_example' onclick="toggleVisibility(17,2)">Try it:</div>
<div id='api17tr' class='api_example_detail'>
<table><tr><td width="50%">
<form method='POST' id='api17form' action="<?php echo CController::createUrl('user/api/update') ?>">

	<textarea id='api17data' rows="5" cols="50">{
	"username":"testplayer1",
	"data": {
		"given_name":"Rohit"
	}
}</textarea>
	
	<input type='button' value='Post it' onclick='ajaxCall(17,"<?php echo CController::createUrl('user/api/update') ?>")' >
	<!-- input type='submit' value='Submit'-->

	</form>
</td><td>
	<div id='api17result'>See your results here</div>
</td></tr></table>

</div>
</div>
<br>
</div>
