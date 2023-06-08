<div class='api_title' onclick="toggleVisibility(10,0)">
	<h4>User Authentication <div class='method_post'>POST</div></h4>
	Login into Tallyho using user-name and password.
</div>
<br>
<div id='api10' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/user/user/wsLogin </pre>
		<ul><li>username</li><li>password</li>
		</ul>
	Output: -
		<ul><li>On success (</li>
			<ul>
				<li>success (= true)</li>
				<li>user-type (2 for organizer-contact, 3 for player)</li>
				<li>full-name ([given name] [family name]) </li>
			</ul>
		</ul>
		<ul><li>On failure (</li>
			<ul>
				<li>success (= false)</li>
				<li>reason (for failure)</li>
			</ul>
		</ul>
						Note that this authentication method is temporary. It would be further enhanced by API-key, API-ID.
<div class='api_example' onclick="toggleVisibility(10,1)">Example:</div>
<div id='api10ex' class='api_example_detail'>
	Call with POST data:
		<pre>	{
		"username":"kylebishop",
		"password":"pass123"
	} </pre>
		Result:
<pre>	{"success":"false","reason":"Error: Incorrect username or password."}</pre> or 
<pre>	{"success":"true","user-type":"3","full-name":"Mukul Biswas"}</pre>
</div>
<div class='api_example' onclick="toggleVisibility(10,2)">Try it:</div>
<div id='api10tr' class='api_example_detail'>
<table><tr><td width="50%">
<form method='POST' id='api10form'>

	<textarea id='api10data' rows="4" cols="50">{
	"username":"kylebishop",
	"password":"kylebishop"
}</textarea> <i>Don't know which user to use? Create an account.</i>
	
	<input type='button' value='Post it' onclick='ajaxCall(10,"<?php echo CController::createUrl('/user/user/wsLogin') ?>")'>

	</form>
</td><td>
	<div id='api10result'>See your results here</div>
</td></tr></table>
</div>
</div>
<br>
Currently the username and password are hard coded. Please contact the admin to get your own pair of the values.
</div>
