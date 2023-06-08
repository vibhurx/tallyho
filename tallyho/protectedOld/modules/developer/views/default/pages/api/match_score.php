<div class='api_title' onclick="toggleVisibility('4a',0)">
	<h4>Match Score  <div class='method_get'>GET</div></h4>
	To fetch the complete match score - sets & game for the given match ID
</div>
<br>
<div id='api4a' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	http://tallyho.in/apps/index.php/match/api/score/id/{match ID}</pre>
	Output: -
		<ul><li>id (match id)</li>
			<li>set: Array of set-scores</li>
			<ul>
				<li>id: set ID</li>
				<li>match_id: Parent ID</li>
				<li>team1: Set points for team 1</li>
				<li>team2: Set points for team 2</li>
			</ul>
			<li>game: Game specific points</li>
			<ul>
				<li>game_score1: game score for the player 1</li>
				<li>game_score2: game score for the player 2</li>
				<li>tie_break1: tie break score for the player 1, if any</li>
				<li>tie_break2: tie break score for the player 2, if any</li>
				<li>winner: if null, the match is ongoing else it is eithe 1 or 2 (team no.)</li>
			</ul>
			
		</ul>
<div class='api_example' onclick="toggleVisibility('4a',1)">Example:</div>
<div id='api4aex' class='api_example_detail'>
	Call:
		<pre>	http://tallyho.in/apps/index.php/match/api/score/id/1</pre>
		Result:
<pre>{
	"id":"1",
	"set":[
		{"id":"1","match_id":"1","team1":"6","team2":"3"},
		{"id":"2","match_id":"1","team1":"2","team2":"6"},
		{"id":"3","match_id":"1","team1":"3","team2":"3"}
	],
	"game":[
		{
			"id":"1",
			"game_score1":"30",
			"game_score2":"30",
			"tie_break1":"0",
			"tie_break2":"0",
			"winner":"2"
		}
	]
}</pre>
In the above case the game is over with the player 2 declared as the winner.
</div>
</div>
<br>
</div>