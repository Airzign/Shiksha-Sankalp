<?php
  include "header.php";
  include "admin/config.php";
?>
<div id="slide">
  <div id="example">
	<div id="slides">
	  <map id="Map" name="Map">
		<area href="about.php" coords="720,0,958,407" shape="rect">
	  </map>
	  <div class="slides_container" height="305px">
		<img src="images/slider/1_03.jpg" alt="Slide 1" class="slider_image" usemap="#Map"/>
		<img src="images/slider/2_03.jpg" alt="Slide 2" class="slider_image" usemap="#Map"/>
		<img src="images/slider/3_03.jpg" alt="Slide 3" class="slider_image" usemap="#Map"/>
		<img src="images/slider/4_03.jpg" alt="Slide 4" class="slider_image" usemap="#Map"/>
		<img src="images/slider/5_03.jpg" alt="Slide 5" class="slider_image" usemap="#Map"/>
		<img src="images/slider/6_03.jpg" alt="Slide 6" class="slider_image" usemap="#Map"/>
	  </div>
	</div>
  </div>
  <style>
	#mygalone {
	  height: 390px;
	}
	.svw {
	  height: 390px;
	}
  </style>
</div>
<div id="donate">&nbsp;</div>
<!--
   <div id="quote">
	 <img src="images/Donation.png" />
   </div> -->
<div style="clear:both;"></div>
<div id="content">
  <?php
	 $news_count=4;
	 $impact_count=3;
	 $video_count=1;
	 include "dynamic.php";
	 include "footer.php";
  ?>
