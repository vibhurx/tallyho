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
<h1>Tournament and its Categories</h1>
<table>
	<tr><th>Action</th><th>Description</th></tr>
	<tr><td class="action">Select a Tournament</td>
		<td>Home page or the tournament page contains the list of tournaments which are either currently inviting players, preparing draws or 
		ongoing.</td>
	</tr>
	
	<tr><td class="action">Select a category</td>
		<td>Each tournament contains some basic information like location, start date, contact person etc. Each tournament has several 
		categories on the basis of age groups and genders. The applicable categories can be viewed by selecting the link 'Categories'
		<br/>
		If the user is the owner of the tournament then she can add more categories. Other users can just view the list.</td>
	</tr>
			
</table>

<?php echo CHtml::link("Back to scenarios list","../page?view=scenarios" )?>