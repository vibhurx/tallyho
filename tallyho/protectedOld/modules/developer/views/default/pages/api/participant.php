<div class='api_title' onclick="toggleVisibility(4,0)">
	<h4>Participant <div class='method_get'>GET</div></h4>
	To fetch the given name, family name and the full name for a player identified by its participant Id
</div>
<br>
<div id='api4' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/participant/default/wsName/id/{participant ID}</pre>
	Output: -
		<ul><li>id: the participant ID</li>
			<li>given_name: the given name of the player</li>
			<li>family_name: the other names of the player</li>
			<li>fullName: the full name of the player</li>
			<li>shortName: the short name of the player</li>
		</ul>
<div class='api_example' onclick="toggleVisibility(4,1)">Example:</div>
<div id='api4ex' class='api_example_detail'>
	Call:
		<pre>	http://tallyho.in/apps/index.php/participant/default/wsName/id/1</pre>
		Result:
<pre>[
	  {
	    "id":"1",
	    "given_name":"Anirban",
	    "family_name":"Dastidar",
	    "fullName":"Anirban Dastidar"
	  }
	]</pre>
</div>
</div>
<br>
</div>