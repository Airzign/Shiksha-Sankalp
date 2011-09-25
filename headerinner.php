<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!-- Enter the meta tags here -->
<META http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META content="Shiksha Sankalp" name=title>
<META http-equiv="keywords" content="Shiksha, Sansthan ">
<META name="description" content=" Please write the description here">
<META NAME="ROBOTS" CONTENT="INDEX,FOLLOW"> 
<META NAME="DC.Title" CONTENT="Shiksha Sankalp Index">
<META NAME="DC.Creator" CONTENT="AirZign">
<META NAME="DC.Creator.Address" CONTENT="email id here">
<META NAME="DC.Subject.keyword" CONTENT=" ">
<META NAME="DC.Subject.Description" CONTENT=" ">
<META NAME="DC.Type" CONTENT="webpage">
<!-- Close the meta tags here -->

<!-- Stylesheet should be added here -->
<link rel="stylesheet" href="css/general_inner.css" />
<!-- Stylesheets should be ended here -->
<!-- The Site title is added here -->
<title>Shiksha Sankalp</title>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery_easing.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery-1.3.1.min.js"></script>	
	<script type="text/javascript" language="javascript" src="js/hoverIntent.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dropdown.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="http://gsgd.co.uk/sandbox/jquery/easing/jquery.easing.1.3.js"></script>

<script type="text/javascript">
	$(document).ready(function(){

	$("ul.subnav").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)

	$("ul.topnav li span").click(function() { //When trigger is clicked...

		//Following events are applied to the subnav itself (moving subnav up and down)
		$(this).parent().find("ul.subnav").slideDown('fast').show(); //Drop down the subnav on click

		$(this).parent().hover(function() {
		}, function(){
			$(this).parent().find("ul.subnav").slideUp('slow'); //When the mouse hovers out of the subnav, move it back up
		});

		//Following events are applied to the trigger (Hover events for the trigger)
		}).hover(function() {
			$(this).addClass("subhover"); //On hover over, add class "subhover"
		}, function(){	//On Hover Out
			$(this).removeClass("subhover"); //On hover out, remove class "subhover"
	});

});
</script>


<!-- Site title should be ended here -->

</head>
<body class="shadowBackground">

<div id="container">
	<div id="header">
	<a href="index.php"><div id="header_left">&nbsp;</div></a>
	<div id="header_right">
    	<div id="header_top">
        	<div id="header_top_logo">USERNAME &nbsp; <input type="text" class="width" /> &nbsp; &nbsp; PASSWORD &nbsp;<input type="text" class="width" />
            	<input type="image" src="images/login.jpg" align="top" /><br /><br /><p align="right"><img src="images/subscribe.png" /></p>
            </div>
            <div id="header_top_login"></div>
        </div>
        <div class="nav">
				<ul id="navigation">
			   		
			   		<li class="">
						<a href="about.php">
							<span class="menu-left"></span>
							<span class="menu-mid">About Us</span>
							<span class="menu-right"></span>
						</a>
	            	   	<div class="sub">
			   				<ul>
			   					<li>
									<a href="about.php">About Shiksha Sankalp</a>
								</li>
			   					<li>
									<a href="vision.php">Vision</a>
								</li>
			   					<li>
									<a href="team.php">Team</a>
								</li>
			   					<li>
									<a href="history.php">History</a>
								</li>
                                <li>
									<a href="moas.pdf">MoAs</a>
								</li>
			   				</ul>
			   				<div class="btm-bg"></div>
			   			</div>
					</li>
			   		<li class="">
						<a href="#">
							<span class="menu-left"></span>
							<span class="menu-mid">Resources</span>
							<span class="menu-right"></span>
						</a>
			   			<div class="sub">
			   				<ul>
			   					<li>
									<a href="data_education.php">Data on Education</a>
									</li>
			   					<li>
									<a href="relevant_research.php">Relevant Research</a>
								</li>
			   					<li>
									<a href="similar_projects.php">Similar Projects</a>
								</li>
                                <li>
									<a href="newsletters.php">Newsletter &amp;<br />Legal Documents</a>
								</li>
			   				</ul>
			   				<div class="btm-bg"></div>
			   			</div>
			   		</li>
			   		<li class="">
						<a href="modules.php">
							<span class="menu-left"></span>
							<span class="menu-mid">Modules</span>
							<span class="menu-right"></span>
						</a></li>
			   		<li class="">
						<a href="accountability.php">
							<span class="menu-left"></span>
							<span class="menu-mid">Accountability</span>
							<span class="menu-right"></span>
						</a>
	            	   	<div class="sub">
			   				<ul>
			   					<li>
									<a href="agg_statistics.php">Aggregate Statistics</a>
								</li>
			   					<li>
									<a href="module_statistics.php">Module Statistics</a>
								</li>
			   					<li>
									<a href="annual_report.php">Annual Report</a>
								</li>
                                <li>
									<a href="summary_financials.php">Summary Financials</a>
								</li>
			   				</ul>
			   				<div class="btm-bg"></div>
			   			</div>
					</li>
			   		<li class="">
						<a href="FAQ.php">
							<span class="menu-left"></span>
							<span class="menu-mid">FAQ's</span>
							<span class="menu-right"></span>
						</a></li>
			   		<li class="last">
						<a href="join_us.php">
							<span class="menu-left"></span>
							<span class="menu-mid">Join Us</span>
							<span class="menu-right"></span>
						</a>
                        <div class="sub">
			   				<ul>
			   					<li>
									<a href="donor_resp.php">Donor Responsibilities</a>
								</li>
			   					<li>
									<a href="volunteer_resp.php">Volunteer Responsibilities</a>
								</li>
                                </ul>
                                <div class="btm-bg"></div>
                                </div>
			   		</li>
			   	</ul>
			</div>
			<div class="nav-right"></div>
		</div>
    </div>

