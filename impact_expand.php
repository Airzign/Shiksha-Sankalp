<?php
    require_once('admin/config.php');
    include "headerinner.php";
    $id=mysql_real_escape_string($_GET['id']);
    $q = "SELECT * FROM impact WHERE id=$id";
    $r = mysql_query($q);
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		$a = mysql_fetch_assoc($r);
		$small_desc = stripslashes($a['small_desc']);
		$description = nl2br(stripslashes($a['description']));
		$image = stripslashes($a['largeimgurl']);
		$timestamp = stripslashes($a['tm']);
		$entry_display .= <<<ENTRY_DISPLAY
			<div id="content">
			  <div id="main_content">
				<div id="image_template">
				  <img src="images/news/$image" />
				</div>
				<h2>
				  <b>$small_desc</b>
				</h2>
				<br />
				<p class="answer">$description</p>
			  </div>
			ENTRY_DISPLAY;
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
    include "extra_content.php";
    include "footer.php";
?>
