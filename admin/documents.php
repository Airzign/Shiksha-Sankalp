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
       $id = $_POST['id'];
   	   $new_title=$_POST['title'];
   	   $doc_type =$_POST['doc_type'];
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

   	   if(mysql_query("update documents set title='$new_title',doc_type=$doc_type,filename='$new_filename' where id=$id")) {
   	   	   $message='The document was updated successfully.';
   	   }
   }
   if($action==2) {
	   $id = $_GET['id'];
	   $query=mysql_query('select filename from documents where id='.$id);
	   $filename=mysql_fetch_assoc($query);
	   unlink($newsletter_dir.$filename['filename']);
	   if(mysql_query('delete from documents where id='.$id)) {
		   $message='The document was deleted successfully.';
	   }
   }
   if($action==3) {
	   $title=$_POST['title'];
	   $doc_type=$_POST['doc_type'];
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
		   if(mysql_query("insert into documents(filename,doc_type,title) values('$filename',$doc_type,'$title')")) {
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
	  <input type="hidden" value="3" name="action"/>
	  <label for="id_title">Title</label>
	  <input type="text" name="title" id="id_title"/>
	  <label for="id_file">File</label>
	  <input type="file" name="doc" id="id_file"/>
	  <label for="id_doc_type">Document Type</label>
	  <select name="doc_type" name="id_doc_type">
		<option value="0">Newsletter</option>
		<option value="1">Legal Document</option>
	  </select>
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
		  <th>Replace Document with</th>
		  <th>Type</th>
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
			  <input type="file" name="doc"/>
			</td>
			<td>
			  <select name="doc_type">
				<option value="0" <?php if($row['doc_type']==0) echo 'selected=selected'; ?> >Newsletter</option>
				<option value="1" <?php if($row['doc_type']==1) echo 'selected=selected'; ?> >Legal Document</option>
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
