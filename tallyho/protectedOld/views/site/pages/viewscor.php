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

<h1>View Matches and Scores</h1>

<table>
	<tr><th>Action</th><th>Description</th></tr>
	<tr><td class="action">Select a Tournament</td>
		<td>Any user can select a tournament from the home page for which she wants to check the matches if they are complete or yet to be played.
			She can also view the matches in progress. </td>
	</tr>
	
	<tr><td class="action">Select a category</td>
		<td>The user can select the category she wants to view.  <br/>
		</td>
	</tr>
	
	<tr><td class="action"> View the Category Draw</td>
		<td>This action will show the entire draw in a tree format. The matches will contain the information either shown in the box or
		when the mouse is hovered (may not work on mobile). The following information are shown - 
		<ul><li>Player names</li>
			<li>Status indicator (<i>played/ not yet started/in progress</i>)</li>
			<li>Scores, <i>if complete or in progress</i></li>
		</ul>
		</td>
	</tr>
</table>

<?php echo CHtml::link("Back to scenarios list","../page?view=scenarios" )?>