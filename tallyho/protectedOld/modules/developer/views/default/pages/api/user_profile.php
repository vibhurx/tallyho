<div class='api_title' onclick="toggleVisibility(16,0)">
	<h4>User Profile <div class='method_get'>GET</div></h4>
	Gets profile data for the logged in user. It works for both a player or a contact.
</div>
<br>
<div id='api16' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	http://tallyho.in/apps/index.php/user/api/profile/username/{username} </pre>
		
	Output: JSON output with the following parameters-
		<ul><li>success: true or false</li>
			<li>reason: if success is false</li>
			<li>JSON output: if success is true</li>
			<ul><li>username: same as the input username</li>
				<li>lastvisit: unix date-time when the user last logged in</li>
				<li>id: player/contact ID in the database table</li>
				<li>user_id: ID of the table User</li>
				<li>given_name: The given name of the player or the contact</li>
				<li>family_name: The family or the last name of the player/contact</li>
				<li>email: Email address of the player or the contact</li>
				<li>[<i>Player only</i>] date_of_birth: Data of the birth of the player</li>
				<li>[<i>Player only</i>] aita_no: AITA registration no for those who have it</li>
				<li>[<i>Player only</i>] aita_points: AITA points accumulated</li>
				<li>[<i>Player only</i>] state: State no which the player belongs to</li>
				<li>[<i>Player only</i>] gender: Boy/Girl</li>
				<li>[<i>Player only</i>] date_of_birth: Date of Birth</li>
				<li>phone: Player's or guardian's or contact's mobile phone no.</li>
				<li>picture: Profile picture of the player/contact <i> (Must urldecode it)</i></li>
				
			</ul>
		</ul>
<div class='api_example' onclick='toggleVisibility(16,1)'>Example:</div> 
<div id='api16ex' class='api_example_detail'>
	URL
		<pre>	http://tallyho.in/apps/index.php/user/api/profile/username/ashakrishnan</pre>
		Result:
<pre>	{
		"success":"true",
		"username":"ashakrishnan",
		"lastvisit":"1437500983",
		"profile":{
			"id":"54",
			"user_id":"13",
			"given_name":"Asha",
			"family_name":"Krishnan",
			"email":"krish.xyz@gmail.com",
			"aita_no":null,
			"aita_points":"0",
			"state":null,
			"gender":"2",
			"date_of_birth":"2000-10-10",
			"phone":null,
			"picture": "images%2Fppic%2F1%2Fplayer.jpg"
		}
}</pre> or 
<pre>	{"success":"false","reason":"Error: Invalid input: User does not exist."}</pre> or
<pre>	{"success":"false","reason":"Error: Invalid input: Username is missing."}</pre> or for a contact
<pre>	{
		"success":"true",
		"username":"testmanager1",
		"lastvisit":"1444066199",
		"profile":{
			"id":"10",
			"user_id":"153",
			"org_id":"19",
			"given_name":"Babu",
			"family_name":"Lal",
			"email":"dishkypushky@gmail.com",
			"picture":"images%2Fcpic%2F10%2Fbabulal.jpg"
		},
	}</pre>
</div>
</div>
<br>
</div>