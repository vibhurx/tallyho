<div class='api_title' onclick="toggleVisibility('7a',0)">
	<h4>Adjust Score  <div class='method_post'>POST</div></h4>
	Make corrections to the score points (restricted to the current set and the game-points).
</div>
<br>
<div id='api7a' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/apps/index.php/match/api/adjustScore </pre>
	<ul>
		<li>id</li>
		<li>scores
		<ul>
			<li>set: an array of 2 items</li>
			<li>game: an array of 2 items</li>
			<li>tie-break: an array of 2 items</li>
		</ul>
		</li>
		<li>scorer: username of the score-keeper</li>
		
	</ul>
	Last parameter refers to the team/player index who go the last point.<br>
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
	
<div class='api_example' onclick="toggleVisibility('7a',1)">Example:</div>
<div id='api7aex' class='api_example_detail'>
	Call:
		<pre>	http://tallyho.in/apps/index.php/match/api/adjustScore </pre>
	Post:
		<pre>{
	"id": "1",
	"scores": {
		"set": [3,3],
		"game": [30,30],
		"tie-break" :[0,0]
	},
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
<div class='api_example' onclick="toggleVisibility('7a',2)">Try it:</div>
<div id='api7atr' class='api_example_detail'>
<table><tr><td width="50%">
<form method='POST' id='api7aform'>

	<textarea id='api7adata' rows="8" cols="50">{
	"id": "1",
	"scores": {
		"set": [3,3],
		"game": [30,30],
		"tie-break" :[0,0]
	},
	"scorer": "kylebishop"
}</textarea>
	
	<input type='button' value='Post it' onclick='ajaxCall("7a","<?php echo CController::createUrl('/match/api/adjustScore') ?>")'>

	</form>
</td><td>
	<div id='api7aresult'>See your results here</div>
</td></tr></table>
Try the variant HuR:
<table><tr><td width="50%">
<form method='POST' id='api7bform'>

	<textarea id='api7bdata' rows="8" cols="50">{
	"id": "7",
	"set1": "3",
	"set2": "4",
	"game1": "30",
	"game2": "40",
	"tie-break1": 0,
	"tie-break2" :0,
	"scorer": "hamsaseshan"
}</textarea>
	
	<input type='button' value='Post it' onclick='ajaxCall("7b","<?php echo CController::createUrl('/match/api/adjustScoreHuR') ?>")'>

	</form>
</td><td>
	<div id='api7bresult'>See your results here</div>
</td></tr></table>

</div>
</div>
<br>
</div>
