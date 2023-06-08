<style>
	td, th {
		border-bottom: 1px solid grey;
		padding-top: 20px;
		padding-bottom: 20px;
	}
	td.action {
		width: 200px;
		font-weight: bold
	}
</style>

<h1>Player Enrolling in a Tournament (Category)</h1>

<table>
	<tr><th>Action</th><th>Description</th></tr>

	<tr><td class="action">Select a Tournament</td>
		<td>A player can select a tournament from the home page she wants to enrol. </td>
	</tr>
	
	<tr><td class="action">Select a category</td>
		<td>The player can select the category she wants to enrol. If the player is not logged in then the login page appears. <br/>
		</td>
	</tr>
	
	<tr><td class="action"> Enrol for the Tournament</td>
		<td>This step merely requires the user confirmation. The required data is prefilled - tournament, category & player.
		There are business rules that apply -
		<ul>
			<li>Players cannot enrol for opposite gender categories. The action will result in an error.</li>
			<li>Players cannot enrol more than once. The action will result in an error.</li>
			<li>Players cannot enrol for lower age category.</li>
		</ul></td>
	</tr>
	
	<tr><td class="action">Make the Payment</td>
		<td>The enrolment process leads to payment. The fees include AITA prescribed amount of Rs 250 for a registered player, and Rs 500 for a
			for those who are not-registered. There is a convenience fee of Rs 25 charged by Tallyho (might change from time to time). 
			The payment can be made using one of the RBI approved payment gateway. <br/>
			The player has a choice not to make payment and proceed. Those cases will be marked and "unpaid" and will not be considered
			for the draws.
		</td>
	</tr>
	
	
</table>

<?php echo CHtml::link("Back to scenarios list","../page?view=scenarios" )?>