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
	   while($country = mysql_fetch_assoc($countries)) {
	     $country = $country['country'];
	     if ($country == 0) {?>
	<div class="innersubheading">Shiksha Sankalp Incorporated, USA</div>
	<?php } else if($country == 1) {?>
	<div class="innersubheading">Shiksha Sankalp Incorporated, India</div>
	<?php
	      }
	      $results = mysql_query("select * from board_meeting where country=$country order by meeting_date desc");
	      if($results && mysql_num_rows($results)>0) {
	?>
	<table style="width:100%;">
	  <tr style="border-bottom:2px solid;">
		<th>Date</th>
		<th>Key Decisions</th>
		<th>File Link</th>
	  </tr>
	  <?php
		 while($row = mysql_fetch_assoc($results)) {
	  ?>
	  <tr>
		<td><?php echo $row['meeting_date']; ?></td>
		<td><?php echo $row['key_decisions']; ?></td>
		<td><?php echo $row['file_link']; ?></td>
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
