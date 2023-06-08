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

<h1>Scoring</h1>

<table class="action">
	<tr><th>Action</th><th>Description</th></tr>
	
	<tr><td class="topic">Launch the Tallyho app</td>
		<td>Considering that the user has already set the login credentials in the setting, the home screen shows all the tournaments 
			which are <i>ongoing</i>, <i>upcoming</i> or <i>inviting</i>. The tournaments which belongs to the user organization would
			appear in blue color. The tournaments are identified by the location and the organizer name.
		</td>
	</tr>

	<tr><td class="topic">Select a Tournament</td>
		<td>The user can select the tournament for which she has to perform the scoring.
		</td>
	</tr>

	<tr><td class="topic">Select a Category</td>
		<td>The user can go on to select a category which she want to score.
		</td>
	</tr>
	
	<tr><td class="topic">Select a Match</td>
		<td>The user can select the match which she is assigned for scoring. A match is identified by its position on the draw tree or
			it can also be identified by the player names.
		</td>
	</tr>
	
	<tr><td class="topic">Update the score</td>
		<td>The match screen has 2 parts, each for one team. Tapping on the part would update the score in steps like 0-15, 0-30 or 15-15
			and so on. Once the game point is over, the set score is updated. Like wise, once the set if over a new set starts. The user 
			just needs to tap in the correct section. <i>Undo</i> feature would revert the last action or actions.<br/><br/>
			
			It is understood that the scoring pattern for different categories are different. U-10 categories have best of 15 games where 
			the set/game is considered over once a player completes 8 games. U-12 has 3 sets of 4 winning games, which means the set is over
			when a player reaches 4 games with a difference of 2 from the opponent. 4-2, 4-1, 5-3, 6-4 are the valid scores. U-14, U16 have 3
			standard sets. The app supports all the patterns which are also customizable at the time of creating the tournament. 
		</td>
	</tr>
	
	<tr><td class="topic">Mobile app</td>
		<td><i><b>Note:</b> That the mobile app and the web app behave in the same way as far as the functionality is concern. Web may
			additionally have visible menu bar, title bar and sub-menu bar which would be missing from the mobile app. <br/><br/>
			
			</i>
		</td>
	</tr>
	
</table>

<?php echo CHtml::link("Back to scenarios list","../page?view=scenarios" )?>