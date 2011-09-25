$(document).ready(function(){
		//just some regular style sheets. change them as you see fit
		var styling =".innersubheading_team{font-size:18px; font-weight:bold; cursor:pointer;line-height:30px;}" +
					  ".innertext{display:block;}" +
					  ".opened{color:#649637;}" +
					  ".closed{color:#666;}";		
		//attach style to the page
		var style = document.createElement("style");
        style.type = "text/css";
        try {
            style.appendChild( document.createTextNode(styling) );
        } catch (e) {
            if ( style.styleSheet ) {
                style.styleSheet.cssText = styling;
            }
        }
        document.body.appendChild( style );
		//style all questions as closed
		$(".innersubheading_team").addClass("closed"); 
		//make sure first question is styled as open
	        $(".question:first").removeClass("closed").addClass("opened"); 
		$(".innertext").hide(); //hide innertexts
		$(".answer:first").show(); //show first answer
		//question click
		$(".innersubheading_team").click(function() {
			$(".innertext").slideUp("fast");
			$(".innersubheading_team").removeClass("opened").addClass("closed");
	
			if ($(this).next(".innertext").is(":hidden")) {
				$(this).next(".innertext").slideDown("fast");
				$(this).removeClass("closed").addClass("opened");
			} 			   
		});
});
