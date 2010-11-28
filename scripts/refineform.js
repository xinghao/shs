	function changeCat2(id, value, uri)
	{
		//alert(id);
		//alert(value);
		
		$("select#cat3").html('');
		$.getJSON(uri + value, 
				{ ajax: 'true' },
				function(data){

					var options = '';
					
				    for (var i = 0; i < data.length; i++) {
				          options += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
				    }
			       $("select#cat3").html(options);
			       				
				});
		return true;	
		
	}
	
	
	function changeLocation(id, value, uri)
	{
		//alert(id);
		//alert(value);
		
		$("select#"+id).html('');
		$.getJSON(uri + value, 
				{ ajax: 'true' },
				function(data){

					var options = '';
					
				    for (var i = 0; i < data.length; i++) {
				          options += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
				    }
			       $("select#"+id).html(options);
			       				
				});
				
		return true;
	}	
	
	
	function setsearch(searchType)
	{
		$("input#searchtype").attr('value', searchType);
		return true;
	}