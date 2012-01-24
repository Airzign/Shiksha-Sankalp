<?php
   require_once('auth.php');
   include "config.php";
   /* get the action that we have to perform
	* 0 => Show the page only.
	* 1 => Update the entry.
	* 2 => Delete an entry.
	* 3 => Add a new entry.
	*/
   $action=0;
   $message='';
   $is_message_error=false;
   $newsletter_dir='../files/newsletters/';
   if(array_key_exists('action',$_GET)) {
	   $action=$_GET['action'];

   }
   if(array_key_exists('action',$_POST)) {
	   $action=$_POST['action'];
   }
   if($action==1) {
       $id = mysql_real_escape_string($_POST['id']);
   	   $new_title=mysql_real_escape_string($_POST['title']);
   	   $country =mysql_real_escape_string($_POST['country']);
	   $date = mysql_real_escape_string($_POST['date']);
	   $result = mysql_query("select filename from documents where id = '$id'");
	   $assoc = mysql_fetch_assoc($result);
	   $old_filename = $assoc['filename'];
	   $new_filename = $old_filename;
	   if($_FILES['doc']['name']!='') {
	   if($_FILES['doc']['error']>0) {
		   $message='There was an error in uploading the file.Error code:'.$_FILES['doc']['error'].'.Local error code:SKRSS3<br/>';
           $is_message_error = true;
	   } else {
		   if(!file_exists($newsletter_dir.$_FILES['doc']['name'])) {
			   $filename=$_FILES['doc']['name'];
		   } else {
			   $fileparts=explode('.',$_FILES['doc']['name']);
			   $extension='.'.array_pop($fileparts);
			   $name=implode('.',$fileparts).'_';
			   $filecount=0;
			   while(file_exists($newsletter_dir.$name.$filecount.$extension))
					 $filecount=$filecount+1;
			   $filename=$name.$filecount.$extension;
		   }
		   move_uploaded_file($_FILES['doc']['tmp_name'],$newsletter_dir.$filename);
		   $new_filename = $filename;
		   if(file_exists($newsletter_dir.$old_filename))
			   unlink($newsletter_dir.$old_filename);
	   }
	   }

   	   if(mysql_query("update documents set title='$new_title',country=$country,filename='$new_filename',doc_date='$date' where id=$id")) {
   	   	   $message='The document was updated successfully.';
   	   }
   }
   if($action==2) {
       $id = mysql_real_escape_string($_GET['id']);
	   $query=mysql_query('select filename from documents where id='.$id);
	   $filename=mysql_fetch_assoc($query);
	   unlink($newsletter_dir.$filename['filename']);
	   if(mysql_query('delete from documents where id='.$id)) {
		   $message='The document was deleted successfully.';
	   }
   }
   if($action==3) {
       $title=mysql_real_escape_string($_POST['title']);
       $country=mysql_real_escape_string($_POST['country']);
	   $date = mysql_real_escape_string($_POST['date']);
	   if($_FILES['doc']['error']>0) {
		   $message='There was an error in uploading the file.Error code:'.$_FILES['doc']['error'].'.Local error code:SKRSS3<br/>';
           $is_message_error = true;
	   } else {
		   if(!file_exists($newsletter_dir.$_FILES['doc']['name'])) {
			   $filename=$_FILES['doc']['name'];
		   } else {
			   $fileparts=explode('.',$_FILES['doc']['name']);
			   $extension='.'.array_pop($fileparts);
			   $name=implode('.',$fileparts).'_';
			   $filecount=0;
			   while(file_exists($newsletter_dir.$name.$filecount.$extension))
					 $filecount=$filecount+1;
			   $filename=$name.$filecount.$extension;
		   }
		   move_uploaded_file($_FILES['doc']['tmp_name'],$newsletter_dir.$filename);
		   /* the id field of documents is AUTO_INCREMENTing */
		   if(mysql_query("insert into documents(filename,country,title,doc_date) values('$filename',$country,'$title','$date')")) {
			   $message = 'The document with title \''.$title.'\' was uploaded successfully.';
		   } else {
			   unlink($newsletter_dir.$filename);
			   $message = 'An error occured.Error code:SKRSS4<br/>';
               $is_message_error = true;
		   }
	   }
   }
   /* get the documents */
   $documents=mysql_query("select * from documents");
   if($documents==false) {
	   echo "An error occured.Error : SKRSS5";
	   return;
   }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>SS Admin | Documents</title>
	<link href="loginmodule.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
      function confirmDelete(title,id){
        var to_delete = window.confirm("Are you sure you want to delete the document titled '"+title+"'?");
	    if(to_delete) {
	      document.forms["deletionform"].id.value=id;
	      document.forms["deletionform"].submit();
	    }
      }
	</script>
  </head>
  <body>
	<h1>Documents Admin </h1>
    <?php include('menu.php'); ?>
    <?php
      if($message != '')
        if(!$is_message_error)
	      echo '<div class="admin_message admin_success" style="margin-bottom:20px;">',$message,'</div>';
        else
          echo '<div class="admin_message admin_error" style="margin-bottom:20px;">',$message,'</div>';
    ?>
	<div style="clear:both"></div>
	<form enctype="multipart/form-data" method="post">
	  <style type="text/css">
		.doc_label { width:60px;float:left; }
		.doc_input { width:300px; float:left;}
	  </style>
	  <input type="hidden" value="3" name="action"/>
	  <div class="doc_label">
	  <label for="id_title">Title:</label>
	  </div>
	  <div class="doc_input">
	  <input type="text" name="title" id="id_title"/>
	  </div>
	  <label for="id_date">Date(YYYY-MM-DD):</label>
	  <input type="text" name="date" id="id_date"/>
	  <br/>
	  <div class="doc_label">
	  <label for="id_file">File:</label>
	  </div>
	  <div class="doc_input">
	  <input type="file" name="doc" id="id_file"/>
	  </div>
	  <div style="width:120px;float:left;">
	  <label for="id_country">Country:</label>
	  </div>
	  <select name="country" name="id_country" style="width:143px;">
		<option value="0">USA</option>
		<option value="1">India</option>
	  </select>
	  <br/><br/>
	  <input type="submit" value="Add"/>
	</form>
	<?php if(mysql_num_rows($documents)>0) {?>
	  <h3>Edit an existing entry</h3>
	  <form name="deletionform">
		<input type="hidden" name="action" value="2"/>
		<input type="hidden" name="id" value="0" id="id"/>
	  </form>
	  <table>
		<tr>
		  <th>Document</th>
		  <th>Date(YYYY-MM-DD)</th>
		  <th>Replace Document with</th>
		  <th>Country</th>
		  <th>Title</th>
		  <th>Update</th>
		  <th>Delete</th>
		</tr>
		<?php while($row=mysql_fetch_assoc($documents)) { ?>
		  <tr>
			<td>
			  <a href="<?php echo $newsletter_dir.$row['filename'] ?>"><?php echo $row['title'] ?></a>
			</td>
			<form enctype="multipart/form-data" method="POST">
			<td>
			  <input type="text" name="date" value="<?php echo $row['doc_date']; ?>"/>
			</td>
			<td>
			  <input type="file" name="doc"/>
			</td>
			<td>
			  <select name="country">
				<option value="0" <?php if($row['country']==0) echo 'selected=selected'; ?> >USA</option>
				<option value="1" <?php if($row['country']==1) echo 'selected=selected'; ?> >India</option>
			  </select>
			</td>
			<td>
			  <input type="text" name="title" value="<?php echo $row['title']; ?>"/>
			</td>
			<td>
			  <input type="submit" value="Update"/>
			</td>
			<input type="hidden" name="id" value="<?php echo $row['id'];?>"/>
			<input type="hidden" name="action" value="1"/>
			</form>
			<td>
			  <!--<input type="button" value="Delete" onclick="confirmDelete('<?php echo $row['title']; ?>',<?php echo $row['id'] ?>);"/>-->
			  <a href="javascript:void();" onclick="javascript:confirmDelete('<?php echo $row['title']; ?>',<?php echo $row['id'] ?>);">Delete</a>
			</td>
		  </tr>
	  <?php } ?>
	  </table>
	<?php } ?>
  </body>
</html>
