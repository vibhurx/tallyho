<div class='api_title' onclick="toggleVisibility(3,0)">
	<h4>List of Matches  <div class='method_get'>GET</div></h4>
	To fetch all the matches in a tournament category for a given category ID and qualifying (qual)=false.
</div>
<br>
<div id='api3' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/match/api/index/cid/{category ID}/qual/{0|1}</pre>
	Output: an array of matches with the fields
		<ul><li>id (match id)</li>
			<li>tour_id</li>
			<li>category (code)</li>
			<li>winner (default null, value 1 or 2 depending on who won)</li>
			<li>player11 (Participant ID of player 1)</li>
			<li>player21 (Participant ID of player 2)</li>
			<li>player12 (in case of doubles)</li>
			<li>player22 (in case of doubles)</li>
		</ul>
<div class='api_example' onclick="toggleVisibility(3,1)">Example:</div>
<div id='api3ex' class='api_example_detail'>
	Call:
		<pre>	http://tallyho.in/apps/index.php/match/api/index/cid/1/qual/0 </pre>
		Result:
<pre>[
	  {"id":"1","tour_id":"1","category":"1","winner":"1","player11":"2","player21":null},
	  {"id":"2","tour_id":"1","category":"1","winner":"2","player11":"7","player21":"6"},
	  {"id":"3","tour_id":"1","category":"1","winner":"2","player11":"3","player21":"1"},
	  {"id":"4","tour_id":"1","category":"1","winner":"1","player11":"8","player21":"4"},
	  {"id":"5","tour_id":"1","category":"1","winner":"1","player11":"2","player21":"6"},
	  {"id":"6","tour_id":"1","category":"1","winner":"1","player11":"1","player21":"8"},
	  {"id":"7","tour_id":"1","category":"1","winner":"1","player11":"2","player21":"1"}
]</pre>
</div>
</div>
<br>
</div>