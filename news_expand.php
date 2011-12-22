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
		$exploded_date=explode('-',$a['news_date']);
		$news_date = date("M j, Y",mktime(0,0,0,$exploded_date[1],$exploded_date[2],$exploded_date[0]));
		$timestamp = stripslashes($a['tm']);
?>
			<div id="content">
			  <div id="main_content">
			    <div>
			      <span>
			        <a href="news.php">
			          <img src="images/news.jpg" />
			        </a>
			      </span>
			      <span style="float:right;">
			        <a href="news.php">
			          <p align="right" class="expand_link">More News ....</p>
			        </a>
			      </span>
			    </div>
				<h2 class="innersubheading">
				   <b><?php echo $heading; ?></b>
				</h2>
			    <div>
				  <?php echo $news_date; ?>
				</div>
				<div class="image_template">
			    <?php if($image != '') {?>
				  <img src="images/news/<?php echo $image; ?>"/>
                <?php } ?>
		          <div><?php echo $a['large_img_desc']; ?></div>
				</div>
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
