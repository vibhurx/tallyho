<div class='api_title' onclick="toggleVisibility(12,0)">
	<h4>Enrollment List <div class='method_get'>GET</div></h4>
	The enrollments for the logged in user (player).
</div>
<br>
<div id='api12' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/participant/api/index/username/{username} </pre>
	Output: -
		<ul><li>success: true or false</li>
			<li>result: if successful</li>
			<li>reason: if failed</li>
			<li>result: an array of enrollments
				<ul>
					<li>location: the location of the tournament</li>
					<li>start_date</li>
					<li>category: 1 through 16 (under 12 boys, etc.</li>
					<li>seed: the seed of the player</li>
					<li>given_name: first name of the player</li>
					<li>family_name: last name of the player</li>
				</ul>
			</li>
		</ul>
<div class='api_example' onclick='toggleVisibility(12,1)'>Example:</div> 
<div id='api12ex' class='api_example_detail'>
	<pre>http://tallyho.in/apps/index.php/participant/api/index/username/suryashikha</pre>
		Result:
<pre>	{"success":"false","reason":"Error: Incorrect username or password."}</pre> or 
<pre>	{
		"success":"true",
		"result":[
			{
				"location":"Stillorgan (Demo)",
				"start_date":"2015-05-16",
				"category":"2",
				"seed":"999",
				"given_name":"Suryashikha",
				"family_name":"Biswas","tour_id":"1"
			}
		]
	}</pre>
</div>

</div>
<br>
</div>