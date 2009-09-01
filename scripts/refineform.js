	function changeCat2(id, value)
	{
		//alert(id);
		//alert(value);
		
		$("select#cat3").html('');
		$.getJSON("/ajax/jobs/changecat2/" + value, 
				{ ajax: 'true' },
				function(data){

					var options = '';
					
				    for (var i = 0; i < data.length; i++) {
				          options += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
				    }
			       $("select#cat3").html(options);
			       				
				});
				
		
	}
	
	
	function changeState(id, value)
	{
		//alert(id);
		//alert(value);
		
		$("select#"+id).html('');
		$.getJSON("/ajax/jobs/changestate/" + value, 
				{ ajax: 'true' },
				function(data){

					var options = '';
					
				    for (var i = 0; i < data.length; i++) {
				          options += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
				    }
			       $("select#"+id).html(options);
			       				
				});
				
		
	}	