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
				$description = substr(nl2br($a['description']),0,300);
				$smallimg = $a['smallimgurl'];
				$link = $a['link'];
				$entry_displayk .=<<<ENTRY_DISPLAYk
				  <div class="news_item_list" title="$heading" href="$link" rel="prettyPhoto">
					<a>
					  <div class="news_item_list_inner">
						<img src="images/video/$smallimg" class="video_image" />
				        <div>
						  <div class="bold_heading">$heading</div>
						  <div class="small">$description</div>
					      <div style="clear:both"></div>
				        </div>
					  </div>
					</a>
				  </div>
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
