<?php
   include "headerinner.php";
   include "admin/config.php";
?>
<div id="content">
  <div id="main_content">
    <!-- the content goes here -->
    <div class="innertitle">Operational Materials</div>
    <table class="info_table" cellspacing="5px">
      <tr>
        <th style="width:100px;">Upload Date</th>
        <th style="width:440px;">Operational Material</th>
        <th style="width:100px;">File Link</th>
      </tr>
      <?php
	 $results = mysql_query("select * from operational_materials order by date desc");
	 $upload_dir='files/operational_materials/';
	 while($row = mysql_fetch_assoc($results)) {
           $exploded_date=explode('-',$row['date']);
           $date = date("M j, Y",mktime(0,0,0,$exploded_date[1],$exploded_date[2],$exploded_date[0]));
      ?>
      <tr>
        <td><?php echo $date; ?></td>
        <td style="padding-right:20px;"><?php echo $row['title']; ?></td>
        <td>
           <a href="<?php echo $upload_dir,$row['file']; ?>" target="_blank">Click Here</a>
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
