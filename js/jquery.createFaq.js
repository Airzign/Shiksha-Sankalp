$(document).ready(function(){
		//just some regular style sheets. change them as you see fit
		var styling =".question{font-size:14px; font-weight:bold; cursor:pointer;line-height:30px;font-size:21px;}" +
					  ".answer{display:block;}" +
					  ".opened{color:#649637;}" +
					  ".closed{color:#649637;}";
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
		$(".question").addClass("closed");
		//make sure first question is styled as open
	    //    $(".question:first").removeClass("closed").addClass("opened");
		$(".answer").hide(); //hide answers
		//$(".answer:first").show(); //show first answer
	    //make initial_open answer styled as open
	    $(".initial_open_question").removeClass("closed").addClass("opened");
	    $(".initial_open_answer").show();
		//question click
		$(".question").click(function() {
			$(".answer").slideUp("fast");
			$(".question").removeClass("opened").addClass("closed");

			if ($(this).next(".answer").is(":hidden")) {
				$(this).next(".answer").slideDown("fast");
				$(this).removeClass("closed").addClass("opened");
			}
		});
});
