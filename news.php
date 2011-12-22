<?php
include "headerinner.php";
include "admin/config.php";
?>
  <div id="content">
  		<div id="main_content">
        	<!-- the content goes here -->
<div class="news_segment">
        	<h1><img src="images/news.jpg" /></h1>
<?php
$q = "SELECT * FROM news ORDER BY tm DESC LIMIT 50";
$entry_displayk="";
    $r = mysql_query($q);

    if ( $r !== false && mysql_num_rows($r) > 0 ) {
      while ( $a = mysql_fetch_assoc($r) ) {
        $heading = stripslashes($a['heading']);
		$description = nl2br($a['small_desc']);
		$large_desc = substr(nl2br($a['description']),0,300);
        $smallimg = $a['smallimgurl'];
		$id = $a['id'];
		$exploded_date = explode('-',$a['news_date']);
		$news_date = date("M j, Y",mktime(0,0,0,$exploded_date[1],$exploded_date[2],$exploded_date[0]));
		$entry_displayk .=<<<ENTRY_DISPLAYk
		  <div class="news_item_list">
		    <a href="news_expand.php?id=$id">
              <div class="news_item_list_inner">
		        <img src="images/news/$smallimg " style="float:left;"/>
		        <div>
		          <div class="bold_heading">$heading</div>
				  <div class="small">$description</div>
 		          <div class="small news_item_list_largedesc">$news_date : $large_desc</div>
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
		echo "</div>";
		include "footer.php";
		?>
