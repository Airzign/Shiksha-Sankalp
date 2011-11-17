<?php
    require_once('admin/config.php');
    include "headerinner.php";
    $id=mysql_real_escape_string($_GET['id']);
    $q = "SELECT * FROM news WHERE id=$id";
    $r = mysql_query($q);
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		$a = mysql_fetch_assoc($r);
		$heading = stripslashes($a['heading']);
		$description = nl2br(stripslashes($a['description']));
		$image = stripslashes($a['largeimgurl']);
		$timestamp = stripslashes($a['tm']);
?>
			<div id="content">
			  <div id="main_content">
			   <?php if($image != '') {?>
				 <div id="image_template">
				   <img src="images/news/$image" />
				 </div>
               <?php } ?>
				<h2 class="innersubheading">
				   <b><?php echo $heading; ?></b>
				</h2>
				<br />
                <p class="answer"><?php echo $description ; ?></p>
			  </div>
			  <div id="extra_content">
<?php
	}
	else {
?>
			<div id="content">
			  <div id="main_content">
				The page you have requested does not exist.
				<br />
				<br />
				<br />
			  </div>
<?php	}
    include "dynamic.php";
    echo '</div>';
    include "footer.php";
?>
