<?php
  include "headerinner.php";
  include "admin/config.php";
?>
  <div id="content">
  	<div id="main_content">
      <!-- the content goes here -->
	  <div class="news_segment">
        <h1><img src="images/events.jpg" /></h1>
		<?php
		  $q = "SELECT * FROM event ORDER BY event_date DESC";
		  $entry_displayk="";
		  $r = mysql_query($q);
		  if ( $r !== false && mysql_num_rows($r) > 0 ) {
		    while ( $a = mysql_fetch_assoc($r) ) {
		      $exploded_date=explode('-',$a['event_date']);
		      $event_date = date("M j, Y",mktime(0,0,0,$exploded_date[1],$exploded_date[2],$exploded_date[0]));
		      $description= $a['description'];
              $entry_displayk .=<<<ENTRY_DISPLAYk
					   <div class="event_big">
						 <div class="event_date_big">
						   $event_date
						 </div>
						 <div class="event_desc_big">
						   $description
						 </div>
					   </div>
					 <div style="clear:both"></div>
ENTRY_DISPLAYk;
			}
	      }
	      echo $entry_displayk;
	    ?>
	  </div>
	</div>
    <div id="extra_content">
	  <?php
		include "dynamic.php";
		echo "</div>";
		include "footer.php";
	  ?>
