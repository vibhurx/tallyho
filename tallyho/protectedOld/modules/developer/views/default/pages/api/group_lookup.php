<div class='api_title' onclick="toggleVisibility(9,0)">
	<h4>Group Lookup <div class='method_get'>GET</div></h4>
	Gets short descriptions for all the items for a given category/type of data.
</div>
<br>
<div id='api9' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/lookup/items/type/{type-value}/code/{code-value} </pre>
	Output: -
		<ul><li>type-value: category or type of lookup data</li>
			<li>code-value: the numerical code</li>
		</ul>
<div class='api_example' onclick="toggleVisibility(9,1)">Example:</div>
<div id='api9ex' class='api_example_detail'>
	Call:
		<pre>	http://tallyho.in/apps/index.php/lookup/items/type/AgeGroup </pre>
		Result:
<pre>	{
		"1":"Under 12 Boys Singles",
		"2":"Under 12 Girls Singles",
		"3":"Under 14 Boys Singles",
		"4":"Under 14 Girls Singles",
		"5":"Under 16 Boys Singles",
		"6":"Under 16 Girls Singles",
		"7":"Under 18 Boys Singles",
		"8":"Under 18 Girls Singles",
		"9":"Under 12 Boys Doubles",
		"10":"Under 12 Girls Doubles",
		"11":"Under 14 Boys Doubles",
		"12":"Under 14 Girls Doubles",
		"13":"Under 16 Boys Doubles",
		"14":"Under 16 Girls Doubles",
		"15":"Under 18 Boys Doubles",
		"16":"Under 18 Girls Doubles"
	}</pre>
	
	The complete list of categories or types : 
	<pre>	- CourtType
	- TourStatus
	- TourLevel
	- UserType
	- AgeGroup
	- PaymentStatus
	- Gender
	- State
	- DrawStatus
	- TieBreakRule
	- ScoringRule
	</pre>
</div>
</div>
<br>
</div>