<?php
   include "headerinner.php";
   include "admin/config.php";
   ?>
<div id="content">
  <div id="main_content">
    <!-- the content goes here -->
	<div class="innertitle">Our Team</div>
	<p class="innertext">
	  The business and affairs of Shiksha Sankalp Incorporated are governed by
	  its Board of Directors and office bearers.
	</p>
	<?php
	   $member_file_dir='images/team/';
       $categories = array('Board of Directors of Shiksha Sankalp Incorporated, USA',
                           'Office Bearers of Shiksha Sankalp USA',
                           'Advisors',
                           'Board of Directors of Shiksha Sankalp Foundation, India');
	   $i=0;
	   while($i<4) {
	 ?>
	 <div class="innersubheading"><?php echo $categories[$i]; ?></div>
	 <?php
	      $results = mysql_query("select * from team where category=$i order by position");
	      ++$i;
	      while($row = mysql_fetch_assoc($results)) {
	 ?>
	 <div>
	   <?php if($row['picture']!== '' ) { ?>
	   <img src="<?php echo $member_file_dir,$row['picture']; ?>" class="team_img"/>
	   <?php } ?>
	   <p class="innertext">
		 <b><?php echo $row['name']; ?></b>
		 -
		 <?php echo $row['post']; ?>
	   </p>
	   <p class="innertext">
		 <?php echo $row['description']; ?>
	   </p>
	 </div>
	 <div style="clear:both;"></div>
	 <?php
		  }
	   }
	 ?>
  </div>
  <div id="extra_content">
	<?php
	   include "dynamic.php";
       echo "</div>";
	   include "footer.php";
	   ?>
