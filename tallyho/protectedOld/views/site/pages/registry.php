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
<h1>Registration (Organizer)</h1>
<table>
	<tr><th>Action</th><th>Description</th></tr>
	<tr><td class="action">Signup on Homepage</td>
		<td>Signup link is available to a user through out the application as long as she does not login. Selecting this link 
		provides an option to signing up as an 'organizer' or a 'player'.</td>
	</tr>
	
	<tr><td class="action">Select to Signup as an Organizer</td>
		<td>The signup form requires the user to provide the essential and bare minimal personal information like username, given name, family name (or other names), email and password. Organization information will be added later once the user is created and confirmed (via email).
		<br/><br/>
		Registration as an organizer is free of cost and governed by a series of business rules -
		<ul>
			<li>Email address used to avoid duplicacy</li>
			<li>Mobile no is used for avoid duplicacy. </li>
			<li>User id should be unique across the application</li>
			<li>Password must be minimum 8 characters, mix of alphanumeric - capital/small letters, no space or special characters.
		</ul></td>
	</tr>
	
	<tr><td class="action">Email Confirmation</td>
		<td>Signing up process would send an email to the registered email address. To complete the process the organizer must select the 
			link sent to the email address. Once the confirmation is complete in the browser, the organizer can login to the app to complete the process.</td>
	</tr>
	<tr><td class="action">Contact Creation</td>
		<td>The user creating a new organization is also marked as the 'main' contact for the organization. She can add more users as contacts of her organization. The 'other' (not 'main')</td>
	</tr>

</table>

<?php echo CHtml::link("Back to scenarios list","../page?view=scenarios" )?>