<div class='api_title' onclick="toggleVisibility(11,0)">
	<h4>Walkover<div class='method_post'>POST</div></h4>
	Give walkover to one of the teams.
</div>
<br>
<div id='api11' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/match/api/walkover</pre>
	<ul>
		<li>id: Match ID</li>
		<li>winner: Participant ID</li>
	</ul>
	Output: -
		<ul>
			<li>success (= false)</li>
			<li>reason (for failure)</li>
		</ul>
		
<div class='api_example' onclick="toggleVisibility(11,1)">Example:</div>
<div id='api11ex' class='api_example_detail'>
	Call:
		<pre>{
	"id": "6",
	"winner": "2",
	"scorer": "kylebishop"
}
	 </pre>
		Result:
<pre>{"success":"false","reason":"Error: Match does not exist for the ID."}</pre> or <pre>{"success":"true","winner": "2"}</pre>
</div>
<div class='api_example' onclick="toggleVisibility(11,2)">Try it:</div>
<div id='api11tr' class='api_example_detail'>
<table><tr><td width="50%">
<form method='POST' id='api11form'>

	<textarea id='api11data' rows="5" cols="50">{
	"id": "6",
	"winner": "2",
	"scorer": "kylebishop"
}</textarea>
	
	<input type='button' value='Post it' onclick='ajaxCall(11,"<?php echo CController::createUrl('/match/api/walkover') ?>")'>

	</form>
</td><td>
	<div id='api11result'>See your results here</div>
</td></tr></table>
</div>
</div>
<br>
</div>