$(document).ready(function() {    		
			var currentimgUri = $("div.smallimagewrap").find("span").find("img").attr("dest");
    		
    				//alert(currentimgUri);
            $("div.largeimagewrap span img").attr("src", currentimgUri);
                    	
        	$("div.smallimagewrap span").bind("click",function(e){
				var imgUri = $(this).find("img").attr("dest");
				
				$("div.smallimagewrap span").find("img").addClass("transparent_class");
				$(this).find("img").removeClass("transparent_class");
				
				$("div.smallimagewrap span").find("img").removeClass("currentimg");
				$(this).find("img").addClass("currentimg");
				
				//alert(imgUri);
				$("div.largeimagewrap span img").fadeOut("slow",  function() {
					$("div.largeimagewrap span img").attr("src", imgUri);
				  });
        		
        		$("div.largeimagewrap span img").fadeIn("slow");
				//alert($j(this).html());
				
        	});
});