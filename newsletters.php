<?php
   include "headerinner.php";
   include "admin/config.php";
   /* get the newsletters */
   $newsletters=mysql_query("select * from documents where doc_type=0");
   if($newsletters==false) {
	   echo "An error occured.Error : SKRSS1";
	   return;
   }
   /* get the legal documents */
   $legal_documents=mysql_query("select * from documents where doc_type=1");
   if($legal_documents==false) {
	   echo "An error occured.Error : SKRSS2";
	   return;
   }
?>
<div id="content">
  <div id="main_content">
    <p> 
	  <div class="innertitleshortened">Newsletters and Legal Documents</div>
	  <div class="innersubheading"> Links related to : </div>
	  <ul>
		<li class="research"><div class="innersubheading"> Newsletters: </div>
          <ul>
	        <?php while($row=mysql_fetch_assoc($newsletters)) {?>
            <li class="research"><a href="files/newsletters/<?php echo $row['filename'] ?>"><?php echo $row['title'] ?></a></li>
			<?php } ?>
          </ul>
		</li>
		<br/>
		<li class="research"><div class="innersubheading">Legal Documents:</div>
		  <ul>
	        <?php while($row=mysql_fetch_assoc($legal_documents)) {?>
            <li class="research"><a href="files/newsletters/<?php echo $row['filename'] ?>"><?php echo $row['title'] ?></a></li>
			<?php } ?>
		  </ul>
		</li>
      </ul>
    </p>
  </div>
  <div id="extra_content">
	<?php
	   include "dynamic.php";
	   echo "</div>";
	   include "footer.php";
	?>
	
