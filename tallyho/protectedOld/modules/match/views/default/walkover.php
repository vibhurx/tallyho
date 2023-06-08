<h1>Select Winner</h1>
<svg class='scoreboard' width=350px height=140px style='background-color:#EEEEEE'>
	<g class='nameTag' transform='translate(20, 10)'>
		<rect width=300px height=48px x=0 y=0 fill=lightblue></rect>
		<text class='textNameTag' id='nameTag_0' x=20 y=36 font-size=36  font-family='Arial' onclick="postWinner(1);parent.$.fancybox.close()">
				<?php echo isset($match->participant11->player)?$match->participant11->player->fullName: ''?>
		</text>
	</g>
	<g class='nameTag' transform='translate(20, 80)'>
		<rect width=300px height=48px x=0 y=0 fill=lightblue></rect>
		<text class='textNameTag' id='nameTag_1' x=20 y=36 font-size=36px font-family='Arial' onclick="postWinner(2);parent.$.fancybox.close()">
			<?php echo isset($match->participant21->player)?$match->participant21->player->fullName: ''?>
		</text>
	</g>
</svg>

<script>
function postWinner(team){
	var matchId = <?php echo isset($match)?$match->id: 0 ?>;
	$.ajax({
		type: 'POST',
		url:   '<?php echo $this->createUrl('') ?>/id/' + matchId,
		data: {"id": matchId, "winner": team},
		success:function(xhr){
			console.log('success:' + xhr);
		},
        complete:function(xhr,status){
        		if(xhr.statusText=='OK'){
        			console.log('Complete: winner - ' + team);
        			//The matchOver status to be set
        			parent.match.matchOver = true;
        			//How about flashing the winner
        			parent.scoreboard.flashWinner(team-1); //zero-based @todo - standardize winner index
        		}
    		},
    	error:function(xhr){
    		console.log('Error' + xhr.statusText);
    	},
		dataType:'json'
	});
}
</script>