<?php
  include "headerinner.php";
  include "admin/config.php";
   ?>
<div id="content">
  <div id="main_content">
    <div class="innertitle">Interner Links</div>
    <table id="internet-links-table">
      <tr>
	<th>Title</th>
	<th>Description</th>
      </tr>
      <?php
	 $results = mysql_query("select * from internet_links");
	 if(!$results)
         echo 'An Error Occured. Error code:SKRSSIL1';
	 else while($row = mysql_fetch_assoc($results)) {
	 ?>
      <tr>
	<td class="internet-links-title">
	  <?php echo $row['title'];?>
	  Link :
	  <a href="<?php echo $row['link'];?>">
	    <?php echo $row['link'];?>
	  </a>
	</td>
	<td>
	  <?php echo $row['description'];?>
	</td>
      </tr>
      <?php
	 }
	 ?>
    </table>
  </div>
  <div id="extra_content">
    <?php
      include "dynamic.php";
      echo "</div>";
      include "footer.php";
    ?>
