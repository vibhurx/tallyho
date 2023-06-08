<div class='api_title' onclick="toggleVisibility(13,0)">
	<h4>Register (Player)<div class='method_post'>POST</div></h4>
	User registration as a player and a app user.
</div>
<br>
<div id='api13' style='display:block'>
<div class='api_detail'>
A new user can register himself or herself as a player by providing simple details like username, email etc.
	The API call would return a "success" message upon successful creation of a user and a player. It would
	return a "success=false" for errors along with a error message.<br>
	Input format: 
		<pre>	/registration/registration/wsRegistration </pre>
		<ul>
			<li>username: User name, unique across the application</li>
			<li>email: An email address, unique across the application</li>
			<li>given_name: The given name of the player, typically the first name.</li>
			<li>family_name: Names other than the given name, typically the surname or the initials</li>
			<li>gender: Boy or Girl</li>
			<li>date_of_birth: Date of birth of the player</li>
			<li>password: Initial password supplied by the player.
				<ul><li><i> The caller app must perform retype password validation at its end before calling this API</i></li></ul>
			</li>
		</ul>
	
	Output: -
		<ul><li>success: true or false</li>
			<li>result: if success = true</li>
			<li>error: if success = false</li>
			<li>result: A success message, which can be overridden by the calling app.</li>
		</ul>
<div class='api_example' onclick='toggleVisibility(13,1)'>Example:</div> 
<div id='api13ex' class='api_example_detail'>
	Call with POST data:
		<pre>	{
		"username": "spitfiery007",
		"email": "oliver.guest@tallylabs.com",
		"given_name": "Oliver",
		"family_name": "Kravitz",
		"gender": "1",
		"date_of_birth": "2003-09-23",
		"password": "my1niti@lPwd"
	} </pre>
		Result:
<pre>	{"success":"false","reason":"Error: Duplicate email. This email is already registered with us."}</pre> or 
<pre>	{"success":"true","result": "You are successfully registered with Tallyho as a player" }</pre>
</div>

<div class='api_example' onclick="toggleVisibility(13,2)">Try it:</div>
<div id='api13tr' class='api_example_detail'>
<table><tr><td width="50%">
<form method='POST' id='YumRegistrationForm'>

	<textarea id='api13data' rows="10" cols="50">{
	"username": "spitfiery007",
	"email": "oliver.guest@tallylabs.com",
	"given_name": "Oliver",
	"family_name": "Kravitz",
	"gender": "1",
	"date_of_birth": "2003-09-23",
	"password": "my1niti@lPwd"	
}</textarea>
	
	<input type='button' value='Post it' 
		onclick='ajaxCall(13,"<?php echo CController::createUrl('/registration/registration/wsRegistration') ?>")'>

</form>
</td><td>
<div id='api13result'>See your results here</div>
</td></tr>
</table>
</div>
</div>
<br>
</div>