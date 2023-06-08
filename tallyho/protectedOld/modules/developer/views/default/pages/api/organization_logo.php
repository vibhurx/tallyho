<div class='api_title' onclick="toggleVisibility(14,0)">
	<h4>Organization Logo <div class='method_get'>GET</div></h4>
	Obtain the URL for the logo of a given organization.
</div>
<br>
<div id='api14' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/organization/api/logoUrl/id/{Org ID}</pre>
	Output: -
		<ul><li>success: true or false</li>
			<li>message: if successful</li>
			<li>reason: if failed</li>
			<li>data: array with URL</li>
		</ul>
<div class='api_example' onclick='toggleVisibility(14,1)'>Example:</div> 
<div id='api14ex' class='api_example_detail'>
	<pre>http://tallyho.in/apps/index.php/organization/api/logoUrl/id/1</pre>
		Result:
<pre>	{
		"success":"true",
		"message":"Info: Organization exists.",
		"data":{
			"url":"images%2Folog%2F1%2Ffinchley_logo.png"
		}
	}</pre> or 
<pre>	{"success":"false","reason":"Error: Invalid input: Organization does not exist."}</pre>
</div>

</div>
<br>
</div>
