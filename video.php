<?php
    include "headerinner.php";
    include "admin/config.php";
?>
<div id="content">
  <div id="main_content">
    <div class="news_segment">
      <h1>
		<img src="images/video2.jpg" />
	  </h1>
      <?php
		$q = "SELECT * FROM video ORDER BY tm DESC LIMIT 50";
        $entry_displayk="";
        $r = mysql_query($q);
        if ( $r !== false && mysql_num_rows($r) > 0 ) {
			while ( $a = mysql_fetch_assoc($r) ) {
				$heading = stripslashes($a['heading']);
				$description = substr(nl2br($a['description']),0,200);
				$smallimg = $a['smallimgurl'];
				$link = $a['link'];
				$entry_displayk .=<<<ENTRY_DISPLAYk
					<a href="$link" rel="prettyPhoto" title="">
					  <div class="news_item_big">
						<div class="news_item_img_big">
						  <img src="images/video/$smallimg " width="100%" />
						</div>
						<div class="news_item_matter_big">$heading</div>
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
