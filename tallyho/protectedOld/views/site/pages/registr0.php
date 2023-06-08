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
<h1>Registration (Player)</h1>
<table>
	<tr><th>Action</th><th>Description</th></tr>
	<tr><td class="action">Signup on Homepage</td>
		<td>Signup link is available to a user through out the application as long as she does not login. Selecting this link 
		provides an option to signing up as an 'organizer' or a 'player'.</td>
	</tr>
	
	<tr><td class="action">Select to Signup as a Player</td>
		<td>The signup form requires the user to provide the essential personal information like username, given name, family name (or other names),
		date of birth, AITA registration no, gender, state represented, email and mobile phone no. etc. Player can also provide her AITA points
		accummulated so far. <i><b>Note: </b>Player will be required to update the points from time to time. The application cannot keep it updated.</i>
		<br/><br/>
		Registration for the player is free of cost and governed by a series of business rules -
		<ul>
			<li>Email address & AITA no used to avoid duplicacy</li>
			<li>Mobile no is used for warning duplicacy. It is still allowed for 2 players to have the same mobile (children using parent's mobile no).</li>
			<li>Username should be unique across the application</li>
			<li>Password must be minimum 8 characters, mix of alphanumeric - capital/small letters, no space or special characters.
		</ul></td>
	</tr>
	
	<tr><td class="action">Email Confirmation</td>
		<td>Signing up process would send an email to the registered email address. To complete the process the player must select the 
			link sent to the email address. Once the confirmation is complete in the browser, player can login as a registered player.</td>
	</tr>
			
</table>

<?php echo CHtml::link("Back to scenarios list","../page?view=scenarios" )?>