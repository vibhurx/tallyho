/*
 * Works for match.court_no and match.start_date. May work for other fields!!
 * Making use of a Match web-service API which updates one or more fields - match/api/update
 * Depends on the caller to prepare the API url to be called, matchUpdateUrl in this case.
 */
function updateMatchField(id, field_name, old_value, new_value){
//	console.log(id);
//	console.log(field_name);
//	console.log(old_value);
//	console.log(new_value);
//	console.log(matchUpdateUrl);
	
	if(old_value != new_value){
		
		data = {};
		data[field_name] = new_value;
//		console.log(JSON.stringify(data));
		$.ajax({
			type : 'POST',
			data : {"id": id, "data": data},
			 url : matchUpdateUrl, //'http://localhost:8080/apps/index.php/match/api/update',
			 success : function(data){},
			 complete: function(data){
				 	if(data.statusText != 'OK' || data.responseText != 'OK'){
						$('#error_box').text('There is an error in updating the data. ' + data.responseText);
						$('#fb_error').click();
//						console.log("Result: " + data.responseText);
				 	}
				 },
			 error: function(){
					$('#error_box').text('2.There is an error in updating the data. ' + data.responseText);
					$('#fb_error').click();
					return null;
			},
			 dataType: 'json',
		});

	}

	return new_value;
}
/*
 * id - match id
 */
function onCourtSelection(id){
	old_court_no = $(old_court_no).val();
	new_court_no = $(court_no).val();
	
	retval = updateMatchField(id, "court_no", old_court_no, new_court_no);
	
	parent.$("#court_"+id).val(retval);
	
	parent.$.fancybox.close();
}
