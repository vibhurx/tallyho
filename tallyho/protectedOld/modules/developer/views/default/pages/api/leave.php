<div class='api_title' onclick="toggleVisibility(15,0)">
	<h4>Leave <div class='method_get'>GET</div></h4>
	The logged in player leaves one of the categories which was enrolled earlier.
</div>
<br>
<div id='api15' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/participant/api/leave/username/{username}/tour/{tour_id}/category/{category} </pre>
	Output: -
		<ul><li>success: true or false</li>
			<li>message: if successful</li>
			<li>reason: if failed</li>
		</ul>
<div class='api_example' onclick='toggleVisibility(15,1)'>Example:</div> 
<div id='api15ex' class='api_example_detail'>
	<pre>http://tallyho.in/apps/index.php/participant/api/leave/username/suryashikha/tour/1/category/2</pre>
		Result:
<pre>	{"success":"false","reason":"Error: Enrollment is allowed for categories with draw Not-Prepared."}</pre> or 
<pre>	{"success":"false","reason":"Error: Invalid category: This category does not exist for the selected tournament."}</pre>
<pre>	{"success":"true","reason":"","message":"The player has been left the category successfully."}</pre>
</div>

</div>
<br>
</div>
