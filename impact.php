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
			     $heading = $a['heading'];
				 $small_desc = stripslashes($a['small_desc']);
				 $description = substr(nl2br($a['description']),0,300);
				 $smallimg = $a['smallimgurl'];
				 $id = $a['id'];
	   ?>
	   <div class="news_item_list">
		 <a href="impact_expand.php?id=<?php echo $id; ?>">
		   <div class="news_item_list_inner">
		     <img src="images/impact/<?php echo $smallimg; ?>" style="float:left" />
		     <div>
	           <div class="bold_heading"><?php echo $heading ;?></div>
			   <div class="small"><?php echo $small_desc; ?></div>
			   <div class="small news_item_list_largedesc"><?php echo $description;?></div>
		       <div style="clear:both"></div>
			 </div>
		   </div>
		 </a>
	   </div>
	  <?php
			 }
		 }
      ?>
	</div>
  </div>
  <div id="extra_content">
	<?php
	   $impact_count = 0;
	   include "dynamic.php";
	?>
  </div>
  <?php
	 include "footer.php";
  ?>
