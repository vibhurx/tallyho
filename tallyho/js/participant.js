/**	------------------------------------------------------------------------------------------------------ **/
/*	Currently the cellclass values supported are - "payment" and "points".
 * 	The corresponding popup forms are passed as a parameter. The values are - "formUpdatePaymentStatus" and
 * 		"formUpdatePoints".
 */
function beforeCellUpdate(cellclass, row, id){
	gRow = row;		//	gRow keeps track of the item being edited.
	
	gUrl = cellclass=='seed-points'?seed_pts_url:toggle_payment_status_url; //seed_pts_url points to draw/updateSeetPoints
	gCellClass = cellclass;
	
	var given_name = row.parents('tr').find('.given-name').text();
	var family_name = row.parents('tr').find('.family-name').text();
	var payment_status = row.parents('tr').find('.payment-status').text();

	$("#popupCommon").find("span.full-name").text(given_name + ' ' + family_name);
	
	if(cellclass == 'seed-points'){
		oldvalue = row.parents('tr').find('.'+cellclass).text();
		$("div#points").css("display", "block");
		$("div#points input#seed_points").val(oldvalue);
		$("div#points input#seed_points").focus();
		$("div#payment").css("display", "none");
	} else if(cellclass == 'payment-status'){
		$("div#points").css("display", "none");
		if(payment_status == 'Unpaid'){
			$("div#refund").css("display", "none");
			$("div#payment").css("display", "block");
		} else if(payment_status == 'Paid'){
			$("div#refund").css("display", "block");
			$("div#payment").css("display", "none");
		} else {
			return false;
		}
	} else {
		return false;
	}
	
	$("#participant_id").val(id);
	$('a#fb_common').click();
	
	return false;		//	False is return so that the URL action is suppressed.
}


/**	------------------------------------------------------------------------------------------------------ **/
function popupSeedPoints(row, id){
	gRow = row;		//	gRow keeps track of the item being edited.
	
	gUrl = seed_pts_url;
	
	var given_name = row.parents('tr').find('.given-name').text();
	var family_name = row.parents('tr').find('.family-name').text();
	
	$("#popupSeedPoints").find("span.full-name").text(given_name + ' ' + family_name);
	
	oldvalue = row.parents('tr').find('.seed-points').text();
	$("div#points input#seed_points").val(oldvalue);
	$("div#points input#seed_points").focus();
		
	$("div#points input#participant_id").val(id);
	$('a#fb_seed_points').click();
	
	return false;		//	False is return so that the URL action is suppressed.
}


/**	------------------------------------------------------------------------------------------------------ **/

function popupPaymentStatus(row, id){
	gRow = row;		//	gRow keeps track of the item being edited.
	
	gUrl = toggle_payment_status_url;
	
	var given_name = row.parents('tr').find('.given-name').text();
	var family_name = row.parents('tr').find('.family-name').text();
	var payment_status = row.parents('tr').find('.payment-status').text();

	$("#popupPaymentStatus").find("span.full-name").text(given_name + ' ' + family_name);
	
	if(payment_status == 'Unpaid'){
		$("div#refund").css("display", "none");
		$("div#payment").css("display", "block");
	} else if(payment_status == 'Paid'){
		$("div#refund").css("display", "block");
		$("div#payment").css("display", "none");
	} else {
		return false;
	}
		
	$("div#payment input#participant_id").val(id);
	$('a#fb_payment_status').click();
	
	return false;		//	False is return so that the URL action is suppressed.
}


/**	------------------------------------------------------------------------------------------------------ **/
function updateWildcard(me, id, val){
	var newval = val?0:1;
		
	var data = {'id': id, 'newval' : newval };	//toggle old val

	$.ajax({
		type : 'POST',
		data : data,
		 url : wildcard_url, //'http://localhost:8080/apps/index.php/participant/enrol/ajaxWildcardUpdate',
		 success : function(data){},
		 complete: function(data){
			 	  if(data.statusText != 'OK' || data.responseText != 'OK'){
					 $('#error_box').text('There is an error in updating the data. ' + data.responseText);
					 me.checked = (newval == 1)? false : true;
					 $('#fb_error').click();
				 }
			 },
		 error: function(){
			 console.log('error bole to - ' + data.responseText);
//				$('#error_box').text('2.There is an error in updating the data. ' + data.responseText);
//				me.checked = (newval == 1)? false : true;
//				 $('#fb_error').click();
		},
		 dataType: 'json',
	});
}


/**	------------------------------------------------------------------------------------------------------ **/
var gRow;
function ajaxPost(pFormName, url, cellClass){

	var data=$(pFormName).serialize();

	$.ajax({
		type	: 'POST',
		url		: url,
		data	: data,
		success	: function(data){
					//console.log("successful");
		      },
        complete: function(data){
        		if(data.statusText=='OK'){
        			objdata = JSON.parse(data.responseText);
        			if(objdata.payment_status != null){
        				status_text = objdata.payment_status ? 'Paid' : 'Unpaid';
        				gRow.parents('tr').find('.payment-status > a:first').text(status_text);
            			gRow.parents('tr').find('.fee-paid').text(objdata.fee_paid);		
            		} else if(objdata.seed_points != null){
            			gRow.parents('tr').find('.seed-points > a:first').text(objdata.seed_points);
            		}
            	}
    		},
        error	: function(data) { // if error occured
        		$('#error_box').text('There is an error in updating the data. Contact your admin.');
			},
		dataType: 'json'
	});
}


/**------------------------------------------------------------------------------------------------------
 * This function is called by the (pop-up) form action when the user changes the payment status from
 * "Unpaid" to "Paid", and vice-versa.
 * ------------------------------------------------------------------------------------------------------ **/
function ajaxUpdatePaymentStatus(pFormName){
	//console.log(update_payment_url);
	var data=$(pFormName).serialize();
	$.ajax({
		type: 'POST',
		url: toggle_payment_status_url,
		data: data,
		success:function(data){
		      },
        complete:function(data){
        		if(data.statusText=='OK'){
            		gRow.parents('tr').find('.payment-status > a:first').text(data.responseText);
            	}
        		//return true;
    		},
        error: function(data) { // if error occured
        		$('#error_box').text('There is an error in updating the data. Contact your admin.');
			},
		dataType:'json'
	});
	
	//	return false;
}

/**	------------------------------------------------------------------------------------------------------ **
 *	Functions from the "enrol for" popup up
 *	------------------------------------------------------------------------------------------------------ **/
// popup did not work
//function init_new_player(){
//	setTimeout(function(){ fb_create_player(); }, 500); 
//	//parent.$.fancybox.close();	// This line of code will close this popup before opening another one.
//									// Commenting this time opens the new dialog within the same popup.
//}

/**	------------------------------------------------------------------------------------------------------ **/
// popup did not work
//function fb_create_player(){
//	$('a#fb_create_player').click();
//}

/**	------------------------------------------------------------------------------------------------------ **/
//	This function is deprecated. @todo: Delete later.
function ajaxEnrolSave(pUrl){
	var data=$("#participant-form").serialize();
	$.ajax({
		type: 'POST',
		url: pUrl,
		data: data,
		success:function(data){
				//console.log("it is saving alright");
			},
        complete:function(data){
        		if(data.statusText=='OK'){
             		var json = JSON.parse(data.responseText);
             		var $table = $('#participant-grid table tbody');
         			var trElement = $table.find('tr:last');
         			var tr_class = trElement.attr('class') == 'odd'? 'even' : 'odd';
        			
         			var $jqCopy = trElement.clone(true);
         			
          			var wrapper = document.createElement('tr');
          			wrapper.innerHTML= $jqCopy.html();
 					var tdElems = wrapper.getElementsByTagName('td');

 					tdElems[0].innerHTML = json.id;
 					tdElems[1].innerHTML = json.given_name;
 					tdElems[2].innerHTML = json.family_name;
 					tdElems[3].innerHTML = json.aita_no == null? null: json.aita_no;
 					tdElems[4].innerHTML = '<a style="cursor: pointer; text-decoration: underline;" ' + 
 										'onclick="javascript: id=&#039;'+ json.id+'&#039;; updateAitaPoints($(this), id);">' +
 										json.aita_points + '</a>';
 					tdElems[5].innerHTML = '999';
 					tdElems[6].innerHTML = '<input onchange="javascript:updateWildcard(this,' + json.id + ', 0);" type="checkbox" value="1" name="0" id="0">';
 					tdElems[7].innerHTML = '<a href="/apps/index.php/participant/enrol/delete/id/'+ json.id+'">delete</a>';

 					$table.append('<tr class="' + tr_class + '">' + wrapper.innerHTML + '</tr>');
					parent.$.fancybox.close();
            	} else {
            		console.log(data.responseText);
            		alert('Player is already enrolled.');
            	}
    		},
        error: function(data) { // if error occured
        	if(data.status == 'OK')
        		console.log('OK?');
        	else
        		console.log('There is an error');
        	},
		dataType:'json'
	});
}

/**	------------------------------------------------------------------------------------------------------ **/
function ajaxSearchPlayers(pUrl){
		var textField = $("input#searchName");
		var term = textField.val();
	
		if(term.length < 2){
			$('#playerList option').remove();
			return;
		}
		
		$.ajax({
			type: 'POST',
			url: pUrl,
			data: {"term":term, "gen":gender},
			success:function(data){
					//console.log("ajax function called");
				},
	        complete:function(data){
	        		//console.log("ajax function complete");
	        		refreshList(data.responseText);
	   			 },
	   		error: function(){
	   			},
	   		dataType: 'json',
	   	});
}

/**	------------------------------------------------------------------------------------------------------ **/
function refreshList(data){
	$('#playerList option').remove();
	var jdata = JSON.parse(data);
	
	for(var i in jdata){
		$('#playerList').append('<option value="' + jdata[i].id + '">' + jdata[i].id + ', ' + jdata[i].given_name + ', ' + jdata[i].family_name + '</option>' );
	}
}

/**	------------------------------------------------------------------------------------------------------ **/
function selectPlayer(){
	parent.$.fancybox.close();
}