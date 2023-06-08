<style>
	.action td, th {
		border-bottom: 1px solid grey;
		padding-top: 20px;
		padding-bottom: 20px;
	}
	td.topic {
		width: 200px;
		font-weight: bold
	}
	.inner td, .inner th {
		width: 200px;
		height: 11px; 
		border: 1px solid grey;
	}
	th.inner {
		text-align: center;
	}
</style>

<h1>Prepare & Publish a Draw</h1>

<table class="action">
	<tr><th>Action</th><th>Description</th></tr>
	<tr><td class="topic">Login as an Organization-Contact</td>
		<td>When all the players have enrolled themselves for different categories on or before the last enrolment date, the organizer can start
			preparing the draw. She	needs to select 'My Tours' after logging in. This option is available only to the organizers. The view lists 
			the tournaments which are created for the organization the currently logged in user belongs to.</td>
	</tr>
	
	<tr><td class="topic">Select a Tournament</td>
		<td>Organizer can select a tournament from 'My Tours' list for which the draw has to be prepared. Tour detail view appears with a menu item
			to view 'Categories'.</td>
	</tr>
	
	<tr><td class="topic">Select a category</td>
		<td>Organizer can select a category from the list of categories. 
			Note that tournament status should be 'inviting' for the draw to be prepared. After the draw is published the status changes to 'upcoming'.
			Draw can be prepared for only those categories whose draw-status is 'not prepared'. For categories with draw-status as 'prepared'
			would lead to a view showing draw tree when selected, else it will lead to draw generation view. <br/><br/>
			<ul>If the status is -
				<li>- <b>Draft</b> then the controller will over an <b>error</b> view </li>
				<li>- <b>Inviting</b> then the controller will over an <b>Draw Genration</b> view </li>
				<li>- <b>Upcoming </b>or <b> Ongoing</b> then the controller will over an <b>Draw in the tree format</b> view </li>
			</ul>
			<br/>
			
		</td>
	</tr>
	
	<tr><td class="topic">Draw Generation</td>
		<td> This view contains a list of all the participants who have enroled for the selected category. Organizer has a provision to 
			assign seeds to each player. This is automatically assigned on the basis of the points, which can be edited by the organizer.
			The seeding is done in reverse order of the points of the players. Those without any points are treated alike (unseeded).<br/><br/>
			
			Organizers can also select up to 4 wild-card entries, who are given direct entry to the main draw, irrespective of their seeding
			or points. <br/><br/>
			
			On click of a menu link (<i>Prepare draw</i>), the draw is prepared and displayed on the screen. It is possible to drag-and-drop players
			between the draw positions. Once the manual changes are made, it is possible to save the draw. This action is performed using a menu-link
			<i>Save draw</i>. Internally, matches corresponding to each item on the draw is created and stored in the DB. Any modification in the 
			draw would required scrapping the entire draw and start from the <i>Prepare draw</i> step.<br/><br/>
			
			The above action will also change the status of the category from <i>'Not prepared'</i> to <i>'Prepared'</i>. If all the categories draws are prepared,
			then the status of the tournament changes from 'Inviting' to 'Upcoming'. In case, the tournament status is manually set to 'Upcoming' then
			there is no visible change in the status.
			 
		</td>
	</tr>
	
	
	<tr><td class="topic">Publish the Draw</td>
		<td>Draw is automatically published once it is generated and saved. Note that draw is displayed only if its status is set to 
			<i>'Prepared'</i> which sets in the previous step. Scrapping a draw would reset the draw status to <i>'Not Prepared'</i>
		</td>
	</tr>


</table>

<?php echo CHtml::link("Back to scenarios list","../page?view=scenarios" )?>