<?php
  include "headerinner.php";
  include "admin/config.php";
  $openid=-1;
  if(array_key_exists('id',$_GET))
	$openid = $_GET['id'];
?>
  <script type="text/javascript" src="js/jquery.createFaq.js"></script>
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
			  $title = $a['title'];
			  $id = $a['id'];
		?>
					   <div class="event_big">
						 <h3 class="question <?php if($openid == $id) echo 'initial_open_question'; ?>">
						  <?php echo $event_date,'&nbsp;',$title;?>
						 </h3>
						  <div class="answer <?php if($openid == $id) echo 'initial_open_answer'; ?>">
						  <?php echo $description; ?>
						 </div>
					   </div>
					 <div style="clear:both"></div>
		<?php
			}
	      }
	    ?>
	  </div>
	</div>
    <div id="extra_content">
	  <?php
		include "dynamic.php";
		echo "</div>";
		include "footer.php";
	  ?>
