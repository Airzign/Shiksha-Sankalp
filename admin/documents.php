<?php
   require_once('auth.php');
   include "config.php";
   /* get the action that we have to perform
	* 0 => Show the page only.
	* 1 => Update title and doc_type of the entry. Currently this is disabled.
	* 2 => Delete an entry.
	* 3 => Add a new entry.
	*/
   $action=0;
   $message='';
   $newsletter_dir='../files/newsletters/';
   if(array_key_exists('action',$_GET)) {
	   $action=$_GET['action'];

   }
   if(array_key_exists('action',$_POST)) {
	   $action=$_POST['action'];
   }
   /* if($action==1) { */
   /*      $id = $_GET['id']; */
   /* 	   $new_title=$_GET['title']; */
   /* 	   $doc_type =$_GET['doc_type']; */
   /* 	   if(mysql_query("update documents set title='$new_title',doc_type=$doc_type where id=$id")) { */
   /* 		   $message='The document was updated successfully.'; */
   /* 	   } */
   /* } */
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
    <?php echo $message ?>
    <p class="admin_link">
      <a href="edit_news.php">Add a New Entry</a>
    </p>
    <h3>Add a New Entry</h3>
	<form enctype="multipart/form-data" method="post">
	  <input type="hidden" value="3" name="action"/>
	  <label for="id_title">Title</label>
	  <input type="text" name="title" id="id_title"/>
	  <label for="id_file">File</label>
	  <input type="file" name="doc" id="id_file"/>
	  Document Type
	  <select name="doc_type">
		<option value="0">Newsletter</option>
		<option value="1">Legal Document</option>
	  </select>
	  <input type="submit" value="Upload"/>
	</form>
	<h3>Delete an existing entry</h3>
	<form name="deletionform">
	  <input type="hidden" name="action" value="2"/>
	  <input type="hidden" name="id" value="0" id="id"/>
	</form>
	<?php while($row=mysql_fetch_assoc($documents)) { ?>
	<p>
	  <a href="<?php echo $newsletter_dir.$row['filename'] ?>"><?php echo $row['title'] ?></a>
	  <a href="documents.php?action=2&id=<?php echo $row['id'] ?>">Delete</a>
	  <input type="button" value="Delete" onclick="confirmDelete('<?php echo $row['title'] ?>',<?php echo $row['id'] ?>);"/>
	</p>
	<?php } ?>
  </body>
</html>
