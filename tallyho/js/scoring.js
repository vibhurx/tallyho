/**
 * Class: Scoreboard
 * Defines JavaScript class for Scoreboard. This class holds all the data and its HTML/SVG display functions.
 * 		The class is singleton with one instance called 'scoreboard'.
 * 		Player indices - 0: player1, 1: player2
 */
var 
TIE_BREAK_RULE_SINGLE =		0, 		//0: single point, 1: 6 + diff of 2
TIE_BREAK_RULE_REGULAR=		1,
  SCORE_RULE_15_GAMES =		1,
SCORE_RULE_3_MINISETS =		2,
	SCORE_RULE_3_SETS =		3,
    SCORE_RULE_5_SETS =		4,
    	WINNING_POINT =		40,
    		 GAME_WON =		-1,		//Any arbitrary no (not 0, 15,30,40)
    		 	 LOVE =		0,
	 		POINT_WON =		0,
	 		 GAME_WON =		1,
	 		  SET_WON =		2,
	 		MATCH_WON =		4;


var match = {
			  players :		[],
			setScores :		[],
			 lastGame :		[],
			 tieBreak :		[],
	
	tieBreakCondition :		false,
			 gameOver :		false,
			  setOver :		false,
			matchOver :		false,
	
		  gamesPerSet :		0,					//	typically 6; 4 in a mini-set & 8 in best of 15 games 
		    setsToWin :		0,
		 tieBreakRule :		TIE_BREAK_RULE_SINGLE,		
	
	   		 readonly :		false,

	initialize: function(pJsonPlayers, pJsonTheScores, pScoreRule, pTieBreakRule, pIsUserScorer, pWinner){
		var me = match;
		me.players		= pJsonPlayers;
		me.setScores	= pJsonTheScores.setScores;
		me.lastGame		= pJsonTheScores.lastGame;
		me.tieBreak		= pJsonTheScores.tieBreak;
		me.scoreRule	= Number(pScoreRule);
		me.gamesPerSet	= pScoreRule == SCORE_RULE_15_GAMES ? 8 
							: pScoreRule == SCORE_RULE_3_MINISETS ? 4 
									: 6;
		me.setsToWin	= pScoreRule == SCORE_RULE_15_GAMES ? 1 
								: pScoreRule == SCORE_RULE_3_MINISETS ? 2 
									: pScoreRule == SCORE_RULE_3_SETS ? 2 : 3;
	    me.tieBreakRule	= pTieBreakRule; 	//i.e., single-point tie-breaker
	    me.matchOver	= pWinner == 0 || pWinner == 1? true : false;
		
		me.readonly		= me.matchOver || !pIsUserScorer; //me.matchOver ? true : pIsUserScorer ? false : true;
		//console.log('value of pWinner is ' + pWinner);
		//console.log('value of me.matchOver is ' + me.matchOver);
		//console.log('value of me.readonly is ' + me.readonly);
		if(me.lastGame[0] == WINNING_POINT && me.lastGame[1] == WINNING_POINT)
			me.tieBreakCondition = true;
		
		
		if(!me.matchOver){
			var len =  Object.keys(me.setScores).length;
			if((me.setScores[len-1].set[0] >= me.gamesPerSet || me.setScores[len-1].set[1] >= me.gamesPerSet) &&
					Math.abs(me.setScores[len-1].set[0] - me.setScores[len-1].set[1]) >= 2){
				me.setScores.push({"set":[0,0]});
			} 
		}
	},
		
	updateGame: function(d, i){	//i is the player who won the point
		var me = match;
		if(me.readonly) return;
		if(me.matchOver) {
			return;	
		}

		
		var nThisGamePoints = Number(me.lastGame[i]);
		var nThatGamePoints = Number(me.lastGame[(1-i)%2]);

		
		if(me.tieBreakCondition){
		
			var nThisTieBreakPoints = Number(me.tieBreak[i]);
			var nThatTieBreakPoints = Number(me.tieBreak[(1-i)%2]);
			
			me.tieBreak[i] = ++nThisTieBreakPoints;
			
			if((me.tieBreakRule == TIE_BREAK_RULE_SINGLE) 
					|| (nThisTieBreakPoints > 6 && (nThisTieBreakPoints-nThatTieBreakPoints) >= 2))
				me.gameOver = true;	
				
		} else {
				//	award a point
			nThisGamePoints = nThisGamePoints==LOVE ?
					15 : nThisGamePoints==15 ?
							30 : nThisGamePoints==30 ? 
									WINNING_POINT : GAME_WON;
			
			//	Check if tie-break condition is met
			if(nThisGamePoints == WINNING_POINT && nThatGamePoints == WINNING_POINT){
				me.tieBreakCondition = true;
				me.lastGame[i] = WINNING_POINT;				//	Reset it to the winning point (40)
			} else if (nThisGamePoints == GAME_WON){		//	Check if game is won
				me.gameOver = true;
			} else {
				me.lastGame[i] = nThisGamePoints;			//	Update the score data-structure
			}
		}
		
		var nLastSet, gameWinner = -1;
		
		//	If game is over then update the cache
		if(me.gameOver) {
			gameWinner = i;
			var nSetCount = Object.keys(me.setScores).length;	//<<<< this is where the next set no is obtained when a set is freshly added. but this does not work for just-refreshed case
			    nLastSet  = nSetCount - 1;		//0-indexed sequence
			
			//	Update set-score
			var nThisSetPoints = Number(me.setScores[nLastSet].set[i]);
			me.setScores[nLastSet].set[i] = ++nThisSetPoints;					//increment
			
			//	reset last-game score and tie-break score
			me.lastGame = [LOVE, LOVE];
			me.tieBreak = [LOVE, LOVE];


			//	check if setOver condition is met
			var nThatSetPoints = Number(me.setScores[nLastSet].set[(1-i)%2]);	//need opponent's score also
			
			if(me.scoreRule == SCORE_RULE_15_GAMES && nThisSetPoints == me.gamesPerSet) {	//special case best of 15
				me.setOver = true;
				me.matchOver = true;
			} else if((nThisSetPoints >= me.gamesPerSet) && (nThisSetPoints - nThatSetPoints >= 2)){
				me.setOver = true;
				
				// Compare the set scores to find how many set have this player's point more than the opponent's.
				//var len =  Object.keys(me.setScores).length;
				var thisSetsWon = 0, thatSetsWon = 0;
					
				for(var j=0; j<nSetCount; j++){
					if(Number(me.setScores[j].set[i]) > Number(me.setScores[j].set[(1-i)%2]))
						thisSetsWon++;
					else
						thatSetsWon++;
				}
				
				if(thisSetsWon >= me.setsToWin){	//no of winning sets is equal to me.setsToWin
					me.matchOver = true;
				} else {
					me.matchOver = false;
				}
			}
			
			if(me.setOver && !me.matchOver){
				me.setScores.push({"set":[0,0]});
			}
		}
		
		//	Update the display
		scoreboard.refreshDisplay(
				false,								//	Name of the players 
				true, 								//	Update game score, practically applicable every time
				me.tieBreakCondition,				//	Show tie-breaking section when this is true
				(POINT_WON + me.gameOver + 2*me.setOver + 4*me.matchOver),
				gameWinner); 
		
		
		//	Data-saving in the db
		if(me.gameOver){
			var jSet = me.setScores[nLastSet];
			jSet.set_no = nLastSet;					
			me.persist(jSet);						//<<< passing set_no to the webservice so that controller can save new sets
			me.persist({"lastGame": me.lastGame});
			if(me.matchOver){
				me.persist({"winner": (i+1)});
			}
		} else
			if(me.tieBreakCondition)
				me.persist({"lastGame": me.lastGame, "tieBreak": me.tieBreak});
			else
				me.persist({"lastGame": me.lastGame});
		
		//	Resetting the flags gameOver, tieBreakCondition, setOver, matchOver???
		if(me.gameOver){
			me.gameOver = false;
			if(me.setOver){
				me.setOver = false;
				if(me.matchOver){
					scoreboard.flashWinner(i);
				}
			} else {
				me.tieBreakCondition = false;
			}
		}
	},
	
	
	persist: function(scores){
		var data = {"id": matchId, "scores": scores}; 

		$.ajax({
			type: 		'POST',
			url:  		'/apps/index.php/match/default/ajaxupdate/id/' + matchId,
			data: 		data,
			success:	function(xhr){},
	        complete:	function(xhr,status){ console.log(xhr.responseText); },
	    	error:		function(xhr){},
			dataType:	'json'
		});
	}
};



/*	For the visual part of the scoreboard	*/
var scoreboard = {
		nameTagWidth: 300,
	   nameTagHeight: 48,
	   		   initY: 40,
				gapX: 10,
				gapY: 20,
	  scoreItemWidth: 48,
	
		createDisplay: function (pSvgElementId, pWidth, pHeight){
			var me = scoreboard;
			
			var svg = d3.select('#' + pSvgElementId)
				.append('svg')
					.attr("class", 'scoreboard')
			        .attr("width", pWidth)
			        .attr("height", pHeight)
			        .style("background-color", "#EEE");

		    var nameTag = svg.selectAll('.nameTag')
    			.data(match.players)
				.enter()
					.append('g')
						.attr('transform', function(d,i){ return 'translate(10, ' + (i*(me.nameTagHeight+me.gapY)+me.initY) + ')' ; })
						.attr('class', 'nameTag');
					
		    nameTag.append('rect')
				.attr('x', -1)
				.attr('y', -1)
				.attr('width', pWidth-48)
				.attr('height', '50px')
				.attr('id', function(d, i){ return 'rectPlayer_' + i; })
				.style('stroke', '#EEE')
				.style('fill', '#EEE');
			
			
		    nameTag.append('rect')
				.attr('x', 0)
				.attr('y', 0)
				.attr('width', me.nameTagWidth)
				.attr('height', me.nameTagHeight)
				.style('fill', 'lightblue');
			
			nameTag.append('text')
				.attr('x', 20)
				.attr('y', 36)
				.attr('id', function(d, i){ return 'nameTag_' + i; })
				.attr('class', 'textNameTag')
				.style('font-size', 36);
			
			if(!match.readonly)
				svg.selectAll('.textNameTag')
					.on("click", me.updateGame);
			
			if(match.setScores != null)	
				me.addSetScores();
			if(match.lastGame != null)
				me.addLastGame();	
			
			//After the scoreboard is drawn, fill the names and score
			me.refreshDisplay(true, true, match.tieBreakCondition, SET_WON, -1);	
			//Initially make it look like that a set is over. It carries minimum side-effect
		
		},

		updateGame: function(d, i){ //change the name to suitable one
			match.updateGame(d, i);
		},
		
		/*	This function updates the score figures by reading the match structure (cache).
		 * 	Only when tie-break condition is met, those rects are added else they are removed.
		 * 	Also when a new set is added in the cache the rects are added.
		 * 	Input params
		 * 		pWhatJustHappened	:	which event made this refresh scoreboard, point_won, game_won, set_won, match_won or nothing happened
		 */
		refreshDisplay: function(pNameTag, pLastGame, pShowTieBreaker, pWhatJustHappened, pWhoGotThePoint){
			var me = scoreboard;
			//Show player Names
			if(pNameTag)
				d3.selectAll('.textNameTag')
					.text(function(d,i){ return match.players[i].name; });

			if(Number(pWhatJustHappened) == POINT_WON+GAME_WON+SET_WON){
				d3.selectAll('.setScore').remove();	
				me.addSetScores();									//	It will refresh the existing sets and add if there is a new set added
			}

			if(Number(pWhatJustHappened) != POINT_WON){
				d3.selectAll('.textScoreItem')
						.text(function(d,i){return match.setScores[(i-i%2)/2].set[i%2];});
			}
			
			
			if(pLastGame){
				if(Number(pWhatJustHappened) == POINT_WON+GAME_WON+SET_WON)
					d3.selectAll('.lastGame')
						.attr('transform', function(d,i){ 
							return 'translate('
								+ (me.nameTagWidth + 10 + me.gapX + Object.keys(match.setScores).length * (me.scoreItemWidth + me.gapX) )
								+ ',' + (i%2 * (me.nameTagHeight + me.gapY) + me.initY) +')';}); 
				d3.selectAll('.textLastGame')
					.text(function(d,i){return match.lastGame[i];});
			}
			
			/*	 1 - load SVG elements with text
			 * 	>1 - load the text along
			 * 	 0 - delete the SVG elements		*/
			if(pShowTieBreaker)
				scoreboard.addTieBreaker();
			else 
				d3.selectAll('.tieBreak').remove();		// delete score items if present
			

			if(Number(pWhatJustHappened) != POINT_WON){	
				d3.select('#rectPlayer_' + pWhoGotThePoint)
					.style('stroke', 'red')
					.transition().duration(2000)
					.style('stroke', '#EEE');
			}
		},
		
		addSetScores: function(){
			
			var me = scoreboard;
			var svg = d3.select('.scoreboard');
			
			var gScoreSet = 
				svg.selectAll('.setScore')
					.data(match.setScores)
					.enter()
						.append('g')
							.attr('transform', function(d,i){ return 'translate(' 
									+  (me.nameTagWidth + 20 + i * (me.scoreItemWidth + me.gapX)) + ',' + me.initY + ')';})
							.attr('class', 'setScore');
			
			var gScoreItem = 
				gScoreSet.selectAll('.scoreItem')
					.data(function(d){return d.set;})
					.enter()
						.append('g')
							.attr('transform', function(d,i){ return 'translate(0,' + i%2 * (me.nameTagHeight + me.gapY)+ ')';})
							.attr('class', 'scoreItem');
			
			gScoreItem.append('rect')
				.attr('width', me.scoreItemWidth)
				.attr('height', me.nameTagHeight)
				.style('fill', 'lightgreen');

			gScoreItem.append('text')
				.attr('x', 18)
				.attr('y', 36)
				.attr('id', function(d,i){return 'setItem'+i;})
				.attr('class', 'textScoreItem')
				.style('font-size', 36);
		},
		
		addLastGame: function(){
			var me = scoreboard;
			var svg = d3.select('.scoreboard');
			
			var gLastGame = 
				svg.selectAll('.lastGame')
					.data(match.lastGame)
					.enter()
						.append('g')
							.attr('transform', function(d,i){ 
									return 'translate(' + (me.nameTagWidth + 10 + me.gapX + Object.keys(match.setScores).length * (me.scoreItemWidth + me.gapX)) 
										+ ',' + (i%2 * (me.nameTagHeight + me.gapY) + me.initY) +')';
								})
							.attr('class', 'lastGame');

			gLastGame.append('rect')
				.attr('width', me.scoreItemWidth + 20)
				.attr('height', me.nameTagHeight)
				.attr('class', 'rectLastGame')
				.attr('id', function(d,i){return 'lastGameRect' + i; })
				.style('fill', 'pink');

			gLastGame.append('text')
				.attr('x', 18)
				.attr('y', 36)
				.attr('id', function(d,i){ return 'lastGame' + i; })
				.attr('class', 'textLastGame')
				.style('font-size', 36);
		},
		
		addTieBreaker: function(){
			var me = scoreboard;
			var svg = d3.select('.scoreboard');
			
			var gTieBreaker = 
				svg.selectAll('.tieBreak')
					.data(match.tieBreak)
					.enter()
						.append('g')
							.attr('transform', function(d,i){ 
								return 'translate(' 
									+ (me.nameTagWidth + me.gapX + 40 + (Object.keys(match.setScores).length+1)* (me.scoreItemWidth + me.gapX)) 
									+ ',' + (i%2 * (me.nameTagHeight + me.gapY) + me.initY) +')';})
							.attr('class', 'tieBreak');
		
			gTieBreaker.append('rect')
				.attr('width', me.scoreItemWidth + 20)
				.attr('height', me.nameTagHeight)
				.style('fill', 'purple');
		
			gTieBreaker.append('text')
				.attr('x', 18)
				.attr('y', 36)
				.attr('id', function(d,i){ return 'tieBreak' + i; })
				.attr('class', 'textTieBreak')
				.style('font-size', 36)
				.text(function(d,i){return d;});
			
			/* This bit of code refreshes the values in case tie-breaker existed before this point */
			d3.selectAll('.textTieBreak')
				.text(function(i){return match.tieBreak[i];});
			
		},
		
		flashWinner: function(winner){
			if(winner != 0 && winner != 1) return;
			var svg = d3.select('.scoreboard');
			svg.append('g')
				.attr('transform', function(d,i){
					return 'translate(0, 0)';
				})
				.append('text')
					.attr('x', 100)
					.attr('y', 120)
					.style('font-size', 72)
					.style('fill', 'yellow')
					.style('stroke', 'red')
					.text('Match Complete');
			
			d3.select('#rectPlayer_' + winner)
					.style('stroke', 'red')
					.transition().duration(500)
					.style('stroke', '#EEE')
					.transition().duration(2000)
					.style('stroke', 'red');
				
		}
	};

/**	End of Class definition	*/


