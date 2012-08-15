<?php
  include "headerinner.php";
  include "admin/config.php";
   ?>
<div id="content">
  <div id="main_content">
    <div class="innertitle">Research Papers</div>
    <?php
      $upload_dir='files/research_papers/';
      $results = mysql_query("select * from research_papers");
      if(!$results)
        echo 'An Error Occured. Error code:SKRSSRP1';
      else while($row = mysql_fetch_assoc($results)) {
       ?>
    <div class="innertext research_title">
      <a style="text-decoration:none;color:inherit;" href="<?php echo $upload_dir.$row['file'];?>" target="_blank">
        <?php echo $row['title'];?>
      </a>
    </div>
    <div class="innertext research_desc">
      <?php echo $row['description'];?>
    </div>
    <?php
      }
       ?>
  </div>
  <div id="extra_content">
    <?php
      include "dynamic.php";
      echo "</div>";
      include "footer.php";
    ?>
