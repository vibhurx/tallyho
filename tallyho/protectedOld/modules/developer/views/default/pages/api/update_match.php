<div class='api_title' onclick="toggleVisibility(18,0)">
	<h4>Update a Match <div class='method_post'>POST</div></h4>
	Update the properties of a Match identified by its identifier (Match.id).
</div>
<br>
<div id='api18' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/match/api/update</pre>
	With the following input structure -
	<ul>
		<li>id</li>
		<li>data</li>
		<ul>
			<li>level</li>
			<li>sequence</li>
			<li><i>... other fields from Match entity</i></li>
		</ul>
	</ul>
	Output: True or False.
		
<div class='api_example' onclick="toggleVisibility(18,1)">Example:</div>
<div id='api18ex' class='api_example_detail'>
	Call:
		<pre>	http://tallyho.in/apps/index.php/match/api/update </pre>
	With the following structure POSTed:
<pre>
	  {
	  	"id":"1",
	  	"data": {
	  		"level":"1",
	  		"sequence":"1",
	  		"player11":"2",
	  		"player21":null,
	  		"court_no":2
	  	}
	  }
</pre>
Or
<pre>
	  {
	  	"id":"67",
	  	"data": {
	  		"start_date":"2015-07-22 10:30:00"
	  	}
	  }
</pre>

</div>
</div>
<br>
</div>