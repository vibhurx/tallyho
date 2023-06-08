<div class='api_title' onclick="toggleVisibility(7,0)">
	<h4>Update score  <div class='method_post'>POST</div></h4>
	To update score on the given match where ID is given. Typically, it is the 1-upping the score for a given player.
</div>
<br>
<div id='api7' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/apps/index.php/match/api/updateScore </pre>
	Input: The input is JSON formated with the following information structure.<br>
	<ul>
		<li>id: the match ID</li>
		<li>team: the index of the team which won the last point</li>
		<li>scorer: the user-name of the scorer</li>
	</ul>
	<br>	
	Output: JSON format for the updated score of the last game. In case the last game is over then update last set - <br>
	If the current game is not over
		<ul>
			<li>Tournament ID</li>
			<li>Match ID</li>
			<li>Game points for team 1</li>
			<li>Game points for team 2</li>
			<li>Tie-break points for team 1, if any</li>
			<li>Tie-break points for team 2, if any</li>
		</ul>
	If the current game is over
		<ul>
			<li>Tournament ID</li>
			<li>Match ID</li>
			<li>Updated set score for team 1</li>
			<li>Updated set score for team 2</li>
			<li>Winner, non-zero if the match is over. 1 for team-1 and 2 for team-2</li>
			<li></li>
		</ul>
	
<div class='api_example' onclick="toggleVisibility(7,1)">Example:</div>
<div id='api7ex' class='api_example_detail'>
	Call by posting the following:
	<pre>{
	"id": "1",
	"team": "1",
	"scorer": "kylebishop"
}</pre>
		Result: when game is not over
<pre>[
	{
		"id":"1",
		"match_id":"4",
		"game1":"15",
		"game2":"40",
	}
]</pre>
	Result: when game is not over and tie-break is on
<pre>[
	{
		"id":"1",
		"match_id":"4",
		"game1":"40",
		"game2":"40",
		"tie-break1":"3",
		"tie-break1":"5"
	}
]</pre>
	Result: when a game is over
<pre>[
	{
		"id":"1",
		"match_id":"4",
		"set1":"2",
		"set2":"5"
		"winner":"0",
	}
]</pre>
</div>
<div class='api_example' onclick="toggleVisibility(7,2)">Try it:</div>
<div id='api7tr' class='api_example_detail'>
<table><tr><td width="50%">
<form method='POST' id='api7form'>

	<textarea id='api7data' rows="5" cols="50">{
	"id": "1",
	"team": "1",
	"scorer": "kylebishop"
}</textarea>
	
	<input type='button' value='Post it' onclick='ajaxCall(7,"<?php echo CController::createUrl('/match/api/updateScore') ?>")'>

	</form>
</td><td>
	<div id='api7result'>See your results here</div>
</td></tr></table>
</div>

</div>
<br>
</div>