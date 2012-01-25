<?php
   include "headerinner.php";
   include "admin/config.php";
   ?>
<div id="content">
  <div id="main_content">
    <!-- the content goes here -->
	<div class="innertitle">LEGAL DOCUMENTS</div>
	<?php
	   $titles = array('Shiksha Sankalp Incorporated, USA',
	                  'Shiksha Sankalp Foundation, India');
	   $i=0;
	   $documents_dir='files/documents/';
	   while($i<2) {
	?>
	<div class="innersubheading"><?php echo $titles[$i]; ?></div>
	<?php
	     $results = mysql_query("select * from documents where country=$i order by doc_date desc");
	     while($row = mysql_fetch_assoc($results)) {
	       $exploded_date=explode('-',$row['doc_date']);
           $doc_date = date("M j, Y",mktime(0,0,0,$exploded_date[1],$exploded_date[2],$exploded_date[0]));
	?>
	<div class="documents_list">
	  <div style="float:left;width:100px;">
		<?php echo $doc_date; ?>
	  </div>
	  <div style="float:left;width:300px;">
		<?php echo $row['title']; ?>
	  </div>
	  <div style="float:left;width:100px;">
		<a href="<?php echo $documents_dir,$row['filename']; ?>">Click Here</a>
	  </div>
	  <div style="clear:both"></div>
	</div>
	<?php
	     }
	     ++$i;
	?>
	<hr/>
	<?php
	   }
	?>
	<div class="innersubheading">Legal Disclaimer</div>
	<p class="innertext">
	  <i>
		Shiksha Sankalp Incorporated (SSI) and Shiksha Sankalp Foundation (SSF)
		are independent organizations governed by their respective Boards of
		Directors. Currently, SSI and SSF are collaborating for a period of
		three years under a legal agreement that stipulates their respective
		roles. The agreement is in furtherance of their common objective of
		supporting the education of underprivileged children in developing
		countries.  Under the agreement, SSF is a partner NGO of SSI in India
		and deploys SSI funding in conformity with the Learning Rewards Model
		and other reporting/fiduciary requirements of SSI. Outside of this
		agreement, each organization raises and deploys funds without any
		commitment or obligation to the other.
	  </i>
	</p>
  </div>
  <div id="extra_content">
	<?php
	  include "dynamic.php";
      echo "</div>";
	  include "footer.php";
	?>
