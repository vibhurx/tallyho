<div class='api_title' onclick="toggleVisibility(2,0)">
	<h4>List of Categories  <div class='method_get'>GET</div></h4>
	List of categories under the selected tournament.
</div>
<br>
<div id='api2' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/tour/api/view/id/{tour ID}</pre>
	Output: an array of categories with the following fields
		<ul><li>id (category id)</li>
			<li>tour_id (same as input param)</li>
			<li>category (category code)</li>
			<li>draw_status [0 | 1 | 2]</li>
		</ul>
<div class='api_example' onclick="toggleVisibility(2,1)">Example:</div>
<div id='api2ex' class='api_example_detail'>
	Call:
		<pre>	http://tallyho.in/apps/index.php/tour/api/view/id/1</pre>
		Result:
<pre>[
	  {
	    "id":"1",
	    "tour_id":"1",
	    "category":"1",
	    "draw_status":"2"
	  },
	  {
	    "id":"2",
	    "tour_id":"1",
	    "category":"2",
	    "draw_status":"0"
	  }
	]</pre>
</div>
</div>
<br>
</div>