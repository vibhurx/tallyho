<!-- api #1 -->
<div class='api_title' onclick="toggleVisibility(1,0)">
	<h4>List of Tournaments <div class='method_get'>GET</div></h4>
	List of all the tournaments available for the public view.
</div>
<br>
<div id='api1' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/tour/api/index</pre>
	Output: an array structure with one, none or more of the following -
		<ul><li>id (tour id)</li>
			<li>location</li>
			<li>level</li>
			<li>start_date</li>
			<li>status [1 | 2 | 3 | 4]</li>
			<li>logo_url <i> (Must urldecode it)</i></li> 
		</ul>
</div>
</div>
<br>
<div class='api_example' onclick="toggleVisibility(1,1)">Example:</div>
<div id='api1ex' class='api_example_detail' >
	Call:
		<pre>	http://tallyho.in/apps/index.php/tour/api/index</pre>
		Result:
<pre>[
	{
		"id":"1",
		"location":"Stillorgan",
		"level":"1",
		"start_date":"2015-05-16",
		"status":"4",
		"org_id": "1",
		"logo_url":"images%2Folog%2F1%2Fmy_logo.jpg"
	}
]</pre>
</div>