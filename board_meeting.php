<?php
   include "headerinner.php";
   include "admin/config.php";
?>
<div id="content">
  <div id="main_content">
    <!-- the content goes here -->
	<div class="innertitle" style="font-size:48px;">MINUTES OF BOARD MEETINGS</div>
	<?php
	   $countries = mysql_query("select distinct country from board_meeting order by country");
	   $board_meeting_file_dir='../files/board_meetings/';
	   while($country = mysql_fetch_assoc($countries)) {
	     $country = $country['country'];
	     if ($country == 0) {?>
	<div class="innersubheading">Shiksha Sankalp Incorporated, USA</div>
	<?php } else if($country == 1) {?>
	<div class="innersubheading">Shiksha Sankalp Foundation, India</div>
	<?php
	      }
	      $results = mysql_query("select * from board_meeting where country=$country order by meeting_date desc");
	      if($results && mysql_num_rows($results)>0) {
	?>
	<table style="width:100%;" cellspacing="5px">
	  <tr style="border-bottom:2px solid;">
		<th style="width:100px;font-weight:bold;">Date</th>
		<th style="width:500px;font-weight:bold;">Key Decisions</th>
		<th style="width:100px;font-weight:bold;">File Link</th>
	  </tr>
	  <?php
		 while($row = mysql_fetch_assoc($results)) {
		   $exploded_date=explode('-',$row['meeting_date']);
		   $meeting_date = date("M j, Y",mktime(0,0,0,$exploded_date[1],$exploded_date[2],$exploded_date[0]));
	  ?>
	  <tr>
		<td><?php echo $meeting_date; ?></td>
		<td style="padding-right:20px;"><?php echo $row['key_decisions']; ?></td>
		<td>
		   <a href="<?php echo $board_meeting_file_dir,$row['file_link']; ?>">Click Here</a>
		</td>
	  </tr>
	  <?php
		 }
	  ?>
	</table>
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
