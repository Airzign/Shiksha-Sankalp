<?php
   include "headerinner.php";
   include "admin/config.php";
   ?>
<div id="content">
  <div id="main_content">
    <div class="innertitle">Annual Reports</div>
    <table style="width:100%;" cellspacing="5px">
      <tr style="border-bottom:2px solid;">
        <th style="width:500px;font-weight:bold;">Organization</th>
        <th style="width:300px;font-weight:bold;">Annual Report</th>
        <th style="width:100px;font-weight:bold;">File Link</th>
      </tr>
      <?php
	 $upload_dir = 'files/annual_reports/';
	 $results = mysql_query("select * from annual_reports");
	 if(!$results)
	   echo 'An Error occured. Error code:SKRSSAR1.';
         else while($row = mysql_fetch_assoc($results)) {
         ?>
      <tr>
        <td><?php echo $row['organization']; ?></td>
        <td style="padding-right:20px;"><?php echo $row['title']; ?></td>
        <td>
          <a href="<?php echo $upload_dir,$row['file']; ?>">Click Here</a>
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
