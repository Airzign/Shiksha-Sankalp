<?php
    require_once('admin/config.php');
    include "headerinner.php";
    $id=mysql_real_escape_string($_GET['id']);
    $q = "SELECT * FROM impact WHERE id=$id";
    $r = mysql_query($q);
    $entry_display='';
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		$a = mysql_fetch_assoc($r);
		$small_desc = stripslashes($a['small_desc']);
		$description = nl2br(stripslashes($a['description']));
		$image = stripslashes($a['largeimgurl']);
		$timestamp = stripslashes($a['tm']);
		$heading = $a['heading'];
		$large_img_desc = $a['large_img_desc'];
?>
		    <div id="content">
			  <div id="main_content">
			    <div>
			      <span>
			        <a href="impact.php">
			          <img src="images/impact.jpg" />
			        </a>
			      </span>
			      <span style="float:right;">
			        <a href="impact.php">
			          <p align="right" class="expand_link">More Stories ....</p>
			        </a>
			      </span>
			    </div>
				<h2 class="innersubheading">
				   <b><?php echo $heading; ?></b>
				</h2>
				<div class="image_template">
			    <?php if($image != '') {?>
				  <img src="images/impact/<?php echo $image; ?>"/>
                <?php } ?>
		          <div><?php echo $large_img_desc; ?></div>
				</div>
				<br />
                <p class="answer"><?php echo $description ; ?></p>
			  </div>
<?php
	}
	else {
		$entry_display .= <<<ENTRY_DISPLAY
			<div id="content">
			  <div id="main_content">
				The page you have requested does not exist.
				<br />
				<br />
				<br />
			  </div>
ENTRY_DISPLAY;
	}
    echo $entry_display;
    echo '<div id="extra_content">';
    include "dynamic.php";
    echo '</div>';
    include "footer.php";
?>
