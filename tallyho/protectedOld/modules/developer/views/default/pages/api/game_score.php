<div class='api_title' onclick="toggleVisibility(5,0)">
	<h4> Game Score  <div class='method_get'>GET</div></h4>
	To fetch the current game score for the given match ID
</div>
<br>
<div id='api5' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	http://tallyho.in/apps/index.php/match/api/gameScore/id/{match ID}</pre>
	Output: -
		<ul><li>id (match id)</li>
			<li>game_score1: game score for the player 1</li>
			<li>game_score2: game score for the player 2</li>
			<li>tie_break1: tie break score for the player 1, if any</li>
			<li>tie_break2: tie break score for the player 2, if any</li>
			<li>winner: if null, the match is ongoing else it is eithe 1 or 2 (team no.)</li>
		</ul>
<div class='api_example' onclick="toggleVisibility(5,1)">Example:</div>
<div id='api5ex' class='api_example_detail'>
	Call:
		<pre>	http://tallyho.in/apps/index.php/match/api/gameScore/id/2</pre>
		Result:
<pre>[
		{
			"id":"2",
			"game_score1":"0",
			"game_score2":"15",
			"tie_break1":null,
			"tie_break2":null,
			"winner":"2"
		}
	]</pre>
In the above case the game is over with the player 2 declared as the winner.
Note that set scores are not captured here (see next).
</div>
</div>
<br>
</div>