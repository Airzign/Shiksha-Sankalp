<?php
   include "headerinner.php";
   include "admin/config.php";
?>
<div id="content">
  <div id="main_content">
	<div class="news_segment">
      <h1>
		<img src="images/impact.jpg" />
	  </h1>
	  <?php
		 $q = "SELECT * FROM impact ORDER BY tm DESC LIMIT 50";
		 $entry_displayk="";
		 $r = mysql_query($q);
		 if ( $r !== false && mysql_num_rows($r) > 0 ) {
			 while ( $a = mysql_fetch_assoc($r) ) {
				 $small_desc = stripslashes($a['small_desc']);
				 $description = substr(nl2br($a['description']),0,100);
				 $smallimg = $a['smallimgurl'];
				 $id = $a['id'];
				 $entry_displayk .=<<<ENTRY_DISPLAYk
					 <a href="impact_expand.php?id=$id">		
					   <div class="news_item_big">
						 <div class="news_item_img_big">
						   <img src="images/impact/$smallimg " width="100%" />
						 </div>
						 <div class="news_item_matter_big">$small_desc</div>
						 <div>$description</div>
					   </div>
					 </a>
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
	?>
  </div>
  <?php
	 include "footer.php";
  ?>
