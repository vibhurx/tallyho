/*** JavaScript & D3.js functions for drawing the tree control 				***/


/*	----------------------------------------------------------------------------------------------------	*
 *	The main tree meta data structure, initialized		
 *	----------------------------------------------------------------------------------------------------	*/
var struct_main = {"positions": [],"linkpaths": []},
	struct_qualifying = {"positions": [],"linkpaths": []},
	drawSize,
	totalEnroled,
	mainEntries,
	qualEntries,
	qualRounds,
	svgm, svgq;


/*	----------------------------------------------------------------------------------------------------	*
 *	To update the qualification draw size determined from the total enroled and updated main-direct entries		
 *	----------------------------------------------------------------------------------------------------	*/
//function updateQualDrawSize(){
//	
//	totalEnroled = Number($('#totalEnroled').text());
//	mainEntries = Number($('#Category_mdraw_direct').val());
//	
//}

/*	----------------------------------------------------------------------------------------------------	*
 *	To initialize the values coming from PHP logic		
 *	----------------------------------------------------------------------------------------------------	*/
function initForDesignTime(pMainDrawAchor, pQualifyingDrawAchor){
	
	if(!isTourOwner)
		$('#main_draw').text("<h1> You do not have access to view the draw until it is published. </h1>");
	
		drawSize = Number($('#Category_mdraw_size').val());
	totalEnroled = Number($('#totalEnroled').text());
	 mainEntries = Number($('#Category_mdraw_direct').val());
	
	if(mainEntries > drawSize) { 
		mainEntries = drawSize;
		$('#Category_mdraw_direct').val(mainEntries);
	}
	
	qualEntries = totalEnroled - mainEntries;
	qualRounds  = Number($('#Category_qdraw_levels').val());
	if(qualRounds == 0){
		qualEntries = 0;
		mainEntries = totalEnroled;
		$("#Category_mdraw_direct").attr("disabled", true);
	} else {
		$("#Category_mdraw_direct").attr("disabled", false);
	}
	$("#Category_qdraw_size").val(qualEntries);
	
	//Populate the draw structure on the basis of the draw size.
	struct_main["positions"] = treeStructureData(drawSize, true, 0);	//Params are: 	1. No of top-level leaves 
																		//				2. Is binary tree complete
																		//				3. No of branch levels, if not a complete tree (ignored otherwise)
	if(Object.keys(struct_main["positions"]).length == 0){
		console.log('Tree structure data could not be generated for the parameters passed. Cannot proceed.');
		return false;
	}
	
	struct_main["linkpaths"] = treeStructureLinksData(drawSize, true, 0);

	//Clean up the previous trees, if any (design time only)
	d3.select("svg.main").remove();
	drawTreeLayout(struct_main, pMainDrawAchor, 'main', true);	//Main draw

	
	/*
	 * 	Qualifying Draw section
	 */
	//---	Whether or not earlier qualifying tree there, it will try to remove it before it paints again.
	d3.select("svg.qualifying").remove();

	if(qualEntries > 0){
		struct_qualifying["positions"] = treeStructureData(qualEntries, false, qualRounds);
		if(Object.keys(struct_qualifying["positions"]).length == 0){
			console.log('Tree structure data could not be generated for the parameters passed. Cannot proceed.');
			return false;
		}
		struct_qualifying["linkpaths"] = treeStructureLinksData(qualEntries, false, qualRounds);
		drawTreeLayout(struct_qualifying, pQualifyingDrawAchor, 'qualifying', true);
	}
	
	
	//misc settings
	$('#scalelevel').val(scaleFactor);
}	


/*	----------------------------------------------------------------------------------------------------	*
 *	To initialize the values coming from PHP logic		
 *	----------------------------------------------------------------------------------------------------	*/
function initForViewTime(pMainDrawAchor, pQualifyingDrawAchor){ //, pDrawSize, pQualEntries, pQualRounds){

		drawSize = Number($('#Category_mdraw_size').val());
	  qualRounds = Number($('#Category_qdraw_levels').val());
	 mainEntries = Number($('#Category_mdraw_direct').val());
	 qualEntries = Number($('#Category_qdraw_size').val());
	totalEnroled = mainEntries + qualEntries;
	
	//Populate the draw structure on the basis of the draw size.
	struct_main["positions"] = treeStructureData(drawSize, true, 0);	//Params are: 	1. No of top-level leaves 
																		//				2. Is binary tree complete
																		//				3. No of branch levels, if not a complete tree (ignored otherwise)
	if(Object.keys(struct_main["positions"]).length == 0){
		console.log('Tree structure data could not be generated for the parameters passed. Cannot proceed.');
		return false;
	}
	
	struct_main["linkpaths"] = treeStructureLinksData(drawSize, true, 0);

	drawTreeLayout(struct_main, pMainDrawAchor, 'main', false);	//Main draw: the last parameter is to enable drag-drop

	
	/*	Qualifying Draw section	 
	**		Whether or not earlier qualifying tree there, it will try to remove it before it paints again.
	*/
	if(qualEntries > 0){
		struct_qualifying["positions"] = treeStructureData(qualEntries, false, qualRounds);
		if(Object.keys(struct_qualifying["positions"]).length == 0){
			console.log('Tree structure data could not be generated for the parameters passed. Cannot proceed.');
			return false;
		}
		struct_qualifying["linkpaths"] = treeStructureLinksData(qualEntries, false, qualRounds);
		drawTreeLayout(struct_qualifying, pQualifyingDrawAchor, 'qualifying', false);
	}
	
	//misc settings
	$('#scalelevel').val(scaleFactor);
}	

/*	----------------------------------------------------------------------------------------------------	*
 *	SVG drawing parameters			
 *	----------------------------------------------------------------------------------------------------	*/
	var	 scaleFactor = 25,							// Initial scale of the draw tree
			 offsetX = scaleFactor * 0.5,			// Horizontal offset of the entire draw tree
			 offsetY = scaleFactor * 0.5,			// Vertical offset of the entire draw tree
			   rectX = scaleFactor * 4,				// Width of each player-name rect box
			   rectY = scaleFactor * 0.5,			// Height of the player-name rect box
			rectGapY = scaleFactor * 0.1,			// Vertical gap between 2 players in a mtach
		positionGapY = scaleFactor * 0.5,			// Vertical gap between 2 matches
			  matchY = 2 * rectY + rectGapY;		// Vertical space a match rect box would take
		 

/*** This data structure helps in positioning seeded players in their appropriate slots of the main draw 	***/
	var mMap = {
		32: {
				 1:{'pos': "1_1"},   2:{'pos': "16_2"},  3:{'pos': "9_1"},   4:{'pos': "8_2"},   5:{'pos': "5_1"},
				 6:{'pos': "12_2"},  7:{'pos': "13_1"},  8:{'pos': "4_2"},   9:{'pos': "3_1"},  10:{'pos': "14_2"},
				11:{'pos': "11_1"}, 12:{'pos': "6_2"},  13:{'pos': "7_1"},  14:{'pos': "10_2"}, 15:{'pos': "15_1"},
				16:{'pos': "2_2"},  17:{'pos': "2_1"},  18:{'pos': "15_2"}, 19:{'pos': "10_1"}, 20:{'pos': "7_2"},
				21:{'pos': "6_1"},  22:{'pos': "11_2"}, 23:{'pos': "14_1"}, 24:{'pos': "3_2"},  25:{'pos': "4_1"},
				26:{'pos': "13_2"}, 27:{'pos': "12_1"}, 28:{'pos': "5_2"},  29:{'pos': "8_1"},  30:{'pos': "9_2"},
				31:{'pos': "16_1"}, 32:{'pos': "1_2"}
			},
		16: {
				 1:{'pos':"1_1"},  2:{'pos':"8_2"},  3:{'pos':"5_1"},  4:{'pos':"4_2"},  5:{'pos':"3_1"},
				 6:{'pos':"6_2"},  7:{'pos':"7_1"},  8:{'pos':"2_2"},  9:{'pos':"2_1"}, 10:{'pos':"7_2"},
				11:{'pos':"6_1"}, 12:{'pos':"3_2"}, 13:{'pos':"4_1"}, 14:{'pos':"5_2"}, 15:{'pos':"8_1"},
				16:{'pos':"1_2"}
			},
		8: {
				1:{'pos':"1_1"}, 2:{'pos':"4_2"}, 3:{'pos':"3_1"}, 4:{'pos':"2_2"}, 5:{'pos':"2_1"},
				6:{'pos':"3_2"}, 7:{'pos':"4_1"}, 8:{'pos':"1_2"}
			},
		4: {
			1:{'pos':"1_1"}, 2:{'pos':"2_2"}, 3:{'pos':"2_1"}, 4:{'pos':"1_2"}
		},
		2: {
			1:{'pos':"1_1"}, 2:{'pos':"1_2"}
		}
	};
	




/*	----------------------------------------------------------------------------------------------------	*
 *	Creates the tree data-structure for a draw size
 *	Format:  * 	{{seq1, x1, y1}, {seq2, x2, y2}, .. {seqn, xn, yn}}
 *	----------------------------------------------------------------------------------------------------	*/
function treeStructureData(pNoOfTopLeaves, pIsCompleteTree, pNoOfBranchLevels){
	
	var evenNoOfTopLeaves = Number(pNoOfTopLeaves)+Number(pNoOfTopLeaves)%2 ; 	//In case of incomplete tree, we still need an even top level
	var json_positions = [];
	var seq = 1;
	var noOfBranchLevels = pIsCompleteTree ? Math.log(pNoOfTopLeaves)/Math.log(2) : pNoOfBranchLevels;
	
	for(var i=0; i<=noOfBranchLevels; i++){			//0,1,2,3 because of <= condition one-extra level is added
		var freq = Math.pow(2, i); 					//1,2,4,8
			
		for(var plyrPos=0; plyrPos<evenNoOfTopLeaves; plyrPos+=freq){	//[0,1,2,..,7]
			var json_position = {};
			
			json_position["seq"] = (seq + seq++%2)/2;
			json_position["x"]   = scaleFactor * 6 * i; 		//6 is merely a distance between levels, change if you need to
			json_position["y"]   = scaleFactor * series_sum(plyrPos, (plyrPos+freq-1))/freq;
			json_position["lev"] = i+1;
			
			json_positions.push(json_position);
		}
	}
	return json_positions;
}


/*	----------------------------------------------------------------------------------------------------	*
 *	Creates the data-structure for the links connecting matches
 *	Works for qualifying as well as main draws.
 *	----------------------------------------------------------------------------------------------------	*/
function treeStructureLinksData(pNoOfTopLeaves, pIsCompleteTree, pNoOfBranchLevels){
	var jsonLinks = [];
	var lNoOfTopLeaves = Number(pNoOfTopLeaves);					//Numerify
	
	var evenNoOfTopLeaves = lNoOfTopLeaves + lNoOfTopLeaves%2;		//make it even for the 1st round
	var lNoOfBranchLevels =  Number(pNoOfBranchLevels);				//Numerify
	
	totalNoOfLeaves =  pIsCompleteTree ? 2*evenNoOfTopLeaves-1 : 2*evenNoOfTopLeaves*(1-Math.pow(0.5, lNoOfBranchLevels))+1;
	
	for(var plyrPos=1; plyrPos<totalNoOfLeaves; plyrPos++){			//[0,1,2,..,7]
		var jsonLink = {};
		jsonLink["source"] = plyrPos;
		jsonLink["target"] = evenNoOfTopLeaves + Math.ceil(plyrPos/2);
		jsonLinks.push(jsonLink);
	}
	return jsonLinks;
}


/*	----------------------------------------------------------------------------------------------------	*
 *	parameters:	jsonData: the tree elements and links between them
 *				 element: the class attribute of the div or the td tag where the draw should be placed.
 *	----------------------------------------------------------------------------------------------------	*/
function drawTreeLayout(pJsonData, pElement, pElemClass, isDraggable){
	var startxy, sourceRectElem, sourceTextElem, drag;

	if(isDraggable){
		drag = d3.behavior.drag()

		/* on-drag-start */		
			.on("dragstart", function(d){

				startxy = [d.x, d.y];		//the selected player's match x-y position
			    sourceTextElem = d3.select(this);  
		        sourceRectElem = d3.select("#" + sourceTextElem.attr("id") + 'r');
		        
		    })
		    
		/* on-draging action */		
		    .on("drag", function(d){
		    	d.x += Number(d3.event.dx);
		        d.y += Number(d3.event.dy);
		        
		        sourceRectElem.attr("transform", function(d,i){
		        	//console.log("translate(" + [ d.x-startxy[0], d.y-startxy[1]] + ")");
		            return "translate(" + [ d.x-startxy[0], d.y-startxy[1]] + ")";
		        });
		        
		        sourceTextElem.attr("transform", function(d,i){
		            return "translate(" + [ d.x-startxy[0], d.y-startxy[1] ] + ")";
		          });
		    })
		    
		
		/* on-drag-end   */		
		    .on("dragend", function(d){
		    	var rect1Id, rect2Id, flag = false, foundCount = 0;
		    	
		    	d3.selectAll('rect.edges').each(function(_d){
		    		if((d.y > _d.y-5 && d.y < _d.y+rectY+5) && (d.x > _d.x-5 && d.x < _d.x+rectX+5)){
				    	if(flag){
				    		rect1Id = d3.select(this).attr('id');
				    		foundCount++;
				    		//console.log("Me found 1 - what about you?");
				    	} else {
				    		rect2Id = d3.select(this).attr('id');
				    		foundCount++;
				    		//console.log("Me found too - er two");
				    	}
				    	flag = !flag;		//It is set to true when the 1st rectable is found.
			    	}
		    	});
		    	if(foundCount == 2){					//	When the dragged rectangle is dropped on another one, the event finds
		    											//	both the rectangles at the drop position. We need to sort them out
		    		//console.log("two rectangles found! now what?");
		    		var gNodeId = rect1Id.replace('e', 'g');
		    		
			    	d3.select('#'+ gNodeId).append(function(){ 
			    		return d3.select('#'+ rect2Id.replace('e', 'r'))
			    			.attr('id', rect1Id.replace('e', 'r'))[0][0];
			    		});
			    	
			    	d3.select('#'+ gNodeId).append(function(){ 
			    		return d3.select('#'+ rect2Id.replace('e', ''))
			    			.attr('id', rect1Id.replace('e', ''))[0][0];
			    		});
			    	
			    	gNodeId = rect2Id.replace('e', 'g');
		    		
			    	d3.select('#'+ gNodeId).append(function(){ 
			    		return d3.select('#'+ rect1Id.replace('e', 'r'))
			    			.attr('id', rect2Id.replace('e', 'r'))[0][0];
			    		});
			    	
			    	d3.select('#'+ gNodeId).append(function(){ 
			    		return d3.select('#'+ rect1Id.replace('e', ''))
			    			.attr('id', rect2Id.replace('e', ''))[0][0];
			    		});
		    	}
		    	sourceRectElem.attr("transform", function(d,i){
		            return "translate(" + [0, 0] + ")";
		        });
		    	sourceTextElem.attr("transform", function(d,i){
		    		 return "translate(" + [0, 0] + ")";
		    	 });
		    	d.x = startxy[0];
		    	d.y = startxy[1]
		    });
	}
	
	
	
	var height = Object.keys(pJsonData.positions).length/2;
	
	svgm = d3.select("." + pElement)
	    .append("svg")
	    	.attr("class", pElemClass)
	        .attr("id", pElemClass)
	        .attr("width", 910)
	        .attr("height", (height*(positionGapY+rectY)+80))
	        .style("background-color", "#EEE");

	var position = svgm.selectAll(".position")
		.data(pJsonData.positions)
		.enter().append("g")	
			.attr("transform", function(d, i){
				return "translate(" + (d.x+offsetX) + "," + (d.y+offsetY) + ")"; })
			.attr("class", "position")
			.attr("id", function(d,i){ return pElemClass + "_" + d.seq + "_" + (i%2+1) + "g";});
			//.attr("level", function(d,i){ return d.lev; });
		
	// the border part to stay behind when the box is being dragged
	position.append("rect")
		.attr("class", "edges")
		.attr("width", rectX+2)	//slightly bigger
		.attr("height", rectY+2)
		.attr("x", -1)
		.attr("y", -1)
		.attr("id", function(d,i){ return pElemClass+ "_" + d.seq + "_" + (i%2+1) + "e";});

	position.append("rect")
		.attr("id", function(d,i){ return pElemClass+ "_" + d.seq + "_" + (i%2+1) + "r";})
		.attr("oldId", function(d,i){ return pElemClass + "_" + d.seq + "_" + (i%2+1) + "r";})
		.attr("y", 0)
		.attr("class", "box")
		.attr("width", rectX)
		.attr("height", rectY);

	position.append("text")
		.attr("id", function(d,i){ return pElemClass+ "_" + d.seq + "_" + (i%2+1);})
		.attr("oldId", function(d,i){ return pElemClass+ "_" + d.seq + "_" + (i%2+1);})
		.attr("class", "textLabel")
		.attr("x", 3)
		.attr("y", 1*rectY/2)
		.attr("dy", ".35em")
		.style("font-size", "8pt")
		.style("font-family", "Arial")
		.attr("level", function(d,i){ return d.lev; });
	
	if(isDraggable){
		svgm.selectAll('.textLabel')
			.call(drag)
			.style("cursor", "move");		
	}
		
	svgm.selectAll(".link")
		.data(pJsonData.linkpaths)
//		.enter().append("line")		Old straight link lines
//			.attr("x1", function(d) { return pJsonData.positions[d.source-1].x + rectX + offsetX + 1; })	//the array is accessed by index
//			.attr("y1", function(d) { return pJsonData.positions[d.source-1].y + rectY/2 + offsetY; })
//			.attr("x2", function(d) { return pJsonData.positions[d.target-1].x + offsetX - 1; })
//			.attr("y2", function(d) { return pJsonData.positions[d.target-1].y + rectY/2+offsetY; })
//			.attr("class", "link");
		.enter().append("path")		//Curvy Bezier links
			.attr("d", function(d){ return 	"M " + (pJsonData.positions[d.source-1].x + rectX + offsetX + 1) + " " +
					(pJsonData.positions[d.source-1].y + rectY/2 + offsetY) + 
					"Q " +  (pJsonData.positions[d.source-1].x + rectX + offsetX + 30) + " " + 
					(pJsonData.positions[d.source-1].y + rectY/2 + offsetY) + " " +
					(pJsonData.positions[d.target-1].x + offsetX - 1) + " " +
					(pJsonData.positions[d.target-1].y + rectY/2 + offsetY) ;
				})
			.attr("class", "link");
	
}


/*	----------------------------------------------------------------------------------------------------	*
 * 
 *	----------------------------------------------------------------------------------------------------	*/
var transferPopupShowing = false;
function transferPopup(id, name){
    d3.event.preventDefault();
    if (transferPopupShowing) {
        d3.select(".popup").remove();
    } else {
        canvas = d3.select(".canvas");
        mousePosition = d3.mouse(canvas.node());
        
        href = $('#transferUrl').val();
        
        popup = canvas.append("div")
            .attr("class", "popup")
            .style("text-align", "center")
            .style("left",  mousePosition[0] + "px")
            .style("top",   mousePosition[1] + "px");
        
        popup.append("a")
        	.text("Transfer " + name + " to the main draw")
        	.attr("href",href + "/pid/" + id);
        popup.append("p");
	    popup.append("input")
	    	.attr("type", "button")
	    	.attr("value", "Cancel")
	    	.on("click", function(){
	    		transferPopupShowing = false;
	    		d3.select(".popup").remove();
	    	});
	    
        popup.on('click', function(){
        	transferPopupShowing = false;
        	d3.select(".popup").remove();
        });
    }
    transferPopupShowing = !transferPopupShowing;
}


/*	----------------------------------------------------------------------------------------------------	*
 * 
 *	----------------------------------------------------------------------------------------------------	*/
var setScoreShowing = false;
function setScorePopup(d, jsonScores){
    d3.event.preventDefault();
    if (setScoreShowing) {
        d3.select(".popup").remove();
    } else {
        canvas = d3.select(".canvas");
        mousePosition = d3.mouse(canvas.node());
        
        popup = canvas.append("div")
            .attr("class", "popup")
            .style("text-align", "center")
            .style("font-size", "14px")
            .style("left",  mousePosition[0] + "px")
            .style("top",   mousePosition[1] + "px");
        
        var retval = '';
    	var setScores = jsonScores[d.seq].score;
    	for(var i=0; i<Object.keys(setScores).length; i++){
    		retval += setScores[i].points[0] + '-' + setScores[i].points[1] + '   ';
    	}
    	
        popup.append("p")
        	.text(retval);
        
	    popup.append("input")
	    	.attr("type", "button")
	    	.attr("value", "Close")
	    	.on("click", function(){
	    		setScoreShowing = false;
	    		d3.select(".popup").remove();
	    	});
        popup.on('click', function(){
        	setScoreShowing = false;
        	d3.select(".popup").remove();
        });
    }
    setScoreShowing = !setScoreShowing;
}



/*	----------------------------------------------------------------------------------------------------	*
 * Call this method after the draw-tree has been rendered. This method makes use of the tree 
 * elements and populate them.
 * 		@param pIsDesign: If the players are assigned from Match entities. False would use Participants
 * 
 *	----------------------------------------------------------------------------------------------------	*/
function assignPlayers(pIsDesign){
	//	Randomize an array for random assignment of the qualifying players
	var qualifiers =  totalEnroled - mainEntries,
		lMap = null,
		svgText = null,
		svgRect = null;
	
	
	//	Read the data-island with the participants information
	var jsonData = JSON.parse($('#jsonPlayers').text());
	if(!pIsDesign)
		var jsonScores = JSON.parse($('#jsonScores').text());
	var count = Object.keys(jsonData).length;
	var array = [];
	
	if(pIsDesign){
		if(qualifiers > 0){
			qualifiers += qualifiers % 2 ;					//add 1 if odd
			for(var i=0; i<qualifiers; i++)
				array.push("");								//initialize with empty strings
				
			for(var i=0; i<qualifiers/2; i++){				//it will work for odd nos as well.
				array[i] = (i+1) + "_1";
				array[(qualifiers-i-1)] = (i+1) + "_2";
			}
		}
		//Select the right tree to put the players' names
		lMap = drawSize==2? mMap[2]:drawSize==4? mMap[4]: drawSize==8? mMap[8]: drawSize==16? mMap[16]: mMap[32];
	}

	
	for(var i=0; i<count; i++){
		var player = jsonData[Object.keys(jsonData)[i]],
			position = '',		//e.g., 13_1, 15_2, 0_1 etc.
			participantId = '',
			winner=false;
		
		if(pIsDesign){
			position = Number(mainEntries) >= Number(player.seed) ? 
					"main_" + lMap[player.seed].pos : "qualifying_" + array[player.seed - mainEntries - 1];
			participantId =  player.id;
		} else {
			winner =  player.winner;
			position = player.drawType + '_' + player.seq;
			participantId =  player.id;
		}
		
		svgText = d3.select('#'+position);
		
		//assign the player to the element
		if(svgText != null){
			svgText
				.text(player.shortName + '(' + player.seed + ')')
				.attr('participantId', participantId);
			
			if(winner){
				svgRect = d3.select('#'+position+'r');
				svgRect
					.style('stroke', '#EE99EE')
					.style('fill', '#EE99EE')
					.on('click', function(d){ setScorePopup(d, jsonScores); });
			}
			
			if(player.final){
				svgRect = d3.select('#'+position+'r');
				svgRect
					.style('stroke', 'LightGreen')
					.style('fill', 'LightGreen');
				if(isTourOwner)
					svgRect
						.on('click', function(){ transferPopup(player.id, player.shortName); });
			}
			
				
		} else
			console.log("Could not find svg-text-box for the position " + position);
	}
}


/*	----------------------------------------------------------------------------------------------------	*
 * 
 *	----------------------------------------------------------------------------------------------------	*/
function scoreTip(d, jsonScores) { 
	var retval = '';
	var setScores = jsonScores[d.seq].score;
	for(var i=0; i<Object.keys(setScores).length; i++){
		retval += setScores[i].points[0] + '-' + setScores[i].points[1] + '   ';
	}
	return retval;
}



/*	----------------------------------------------------------------------------------------------------	*
 * 
 *	----------------------------------------------------------------------------------------------------	*/
function getPlayerPosition(){
	var jsondata = [];
	
	d3.selectAll('text').each(function(d,i){
		//split id by underscores
		var tokens = d3.select(this).attr("id").split('_');			//	Format is: qualifying_2_2 or main_9_1
		var participantId = d3.select(this).attr("participantId");
		var level =  d3.select(this).attr("level");
		//mark 1st as draw-type, 2nd as match-seq and 3rd as player-seq
		
		jsondata.push({'type': tokens[0], 'matchSeq': tokens[1], 'level': level,  'playerSeq': tokens[2], 'participantId': participantId});
	});
	
	return JSON.stringify(jsondata);
}

/*	------------------------------------------------------------------------------------------------	*
 * 		Utility functions
 *	------------------------------------------------------------------------------------------------	*/

/*** Returns the sum of the numbers between start_num and last_num.	***/
function series_sum(start_num, last_num){
	return 0.5 * ((last_num * (last_num+1) - start_num * (start_num-1)));
}
