<div class='api_title' onclick="toggleVisibility(8,0)">
	<h4> Item Lookup <div class='method_get'>GET</div></h4>
	Gets short description for a numerical code value for a given type of data.
</div>
<br>
<div id='api8' style='display:block'>
<div class='api_detail'>
	Input format: 
	<pre>	/lookup/item/type/{type-value}/code/{code-value} </pre>
	Output: -
		<ul><li>type-value: category or type of lookup data</li>
			<li>code-value: the numerical code</li>
		</ul>
<div class='api_example' onclick="toggleVisibility(8,1)">Example:</div>
<div id='api8ex' class='api_example_detail'>
	Call:
		<pre>	http://tallyho.in/apps/index.php/lookup/item/type/AgeGroup/code/16 </pre>
		Result:
<pre>	"Under 18 Girls Doubles"
</pre>

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
