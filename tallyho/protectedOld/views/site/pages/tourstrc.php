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
<h1>Create Tournament Structure</h1>
<table>
	<tr><th>Action</th><th>Description</th></tr>
	<tr><td class="action">Login as an Organization-Contact</td>
		<td>One of the main responsibilities of an organizer is to create and publish tournaments. Select 'My Tours' after logging in. This
			option is available only to the organizers. The view lists the tournaments which are created for the organization 
			the currently logged in user belongs to.</td>
	</tr>
	
	<tr><td class="action">Select to Create Tournament</td>
		<td>The side menu list provide an item to create a new tournament. This opens up a web form to capture the essential information
			like location, date, tournament level, contact person and information etc. <br/><br/>
			The tournament is created with an initial status of 'draft'. Its status changes from 'draft' to 'inviting', 'upcoming' and 'ongoing'.
			Finally it is set as 'close' and archived. Some of these status is manually set and some of them are event-driven (automatic).
		</td>
	</tr>
	
	<tr><td class="action">Add Categories</td>
		<td>A tournament has multiple categories under which the players contest. Boys and girls have separate sets of categories which go by age-groups.
			For example - Boys Singles Under-12 or Girls Doubles Under-14 and so on. <br/><br/>
			Categories for a tournament is available as a list which can be accessed from within the Tournament detail view. 'Categories' view
			shows a popup-form to add more categories which is available only if the logged in user is a contact of the organization owning the
			tournament. Players and public cannot view the 'Add categories' form at all. 

		</td>
	</tr>
	<tr><td class="action">Add Additional Data (Not implemented)</td>
		<td>As per the current practice, the organizer provides information about the nearby hotels and guest houses, map view of the location etc.
			This feature should be available in the form of a view whose link is available in the 'Tournament Details' view.  
		</td>
	</tr>

</table>

<?php echo CHtml::link("Back to scenarios list","../page?view=scenarios" )?>