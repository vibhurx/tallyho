<div class='api_title' onclick="toggleVisibility(6,0)">
	<h4>Set Scores  <div class='method_get'>GET</div></h4>
	To fetch the array of set scores for a match identified by the match-identifier.
</div>
<br>
<div id='api6' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/match/api/setScore/id/{ID} </pre>
	Output: an array of sets played so far in this match. Each set has the following info -
		<ul><li>id : (set id)</li>
			<li>match_id : the match ID</li>
			<li>team1 : set score point of the team 1</li>
			<li>team2 : set score point of the team 2</li>
			
		</ul>
<div class='api_example' onclick="toggleVisibility(6,1)">Example:</div>
<div id='api6ex' class='api_example_detail'>
	Call:
		<pre>	http://tallyho.in/apps/index.php/match/api/setScore/id/4 </pre>
	Result:
<pre>[
	{
		"id":"1",
		"match_id":"4",
		"team1":"2",
		"team2":"5"
	}
]</pre>

Note that the score is 2-5 in favour of team 2. Only one set.<br><br>
Or

<pre>[
	{
		"id":"1",
		"match_id":"4",
		"team1":"6",
		"team2":"4"
	},
	{
		"id":"2",
		"match_id":"4",
		"team1":"2",
		"team2":"5"
	},
]</pre>
	

</div>
</div>
<br>
</div>