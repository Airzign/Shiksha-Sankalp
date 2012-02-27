<?php
  require_once('auth.php');
  include "config.php";
  /* get the action that we have to perform
   * 0 => Show the page only.
   * 1 => Update the submitted entry.
   * 2 => Delete the entry.
   * 3 => Add a new entry.
   */
  $action=0;
  $message='';
  $is_message_error=false;
  if(array_key_exists('action',$_GET)) {
    $action=$_GET['action'];
  }
  if(array_key_exists('action',$_POST)) {
    $action=$_POST['action'];
  }
  if($action == 1) {
    $id=$_POST['id'];
    $description=mysql_real_escape_string($_POST['description']);
    $link =mysql_real_escape_string($_POST['link']);
	$title=mysql_real_escape_string($_POST['title']);
    if(mysql_query("update internet_links set title='$title', description='$description', link='$link' where id=$id"))
      $message = 'The internet link was updated successfully.';
    else {
      $message = 'An error accured while updating the inernet link. Error code:SKRSSIL1.';
      $is_message_error = true;
    }
  }
  if($action == 2) {
    $id=$_POST['id'];
    if(mysql_query("delete from internet_links where id=$id"))
      $message = 'The internet link was deleted successfully.';
    else {
      $message = 'An error occured while deleting the internet link. Error code:SKRSSIL2.';
      $is_message_error = true;
    }
  }
  if($action == 3) {
    $title=$_POST['title'];
    $description=$_POST['description'];
    $link =$_POST['link'];
    if(mysql_query("insert into internet_links(title,description,link) values('$title','$description','$link')"))
      $message = 'The internet link was added successfully.';
    else {
      $message = 'An error occured while creating the new internet link. Error code:SKRSSIL3.';
      $is_message_error = true;
    }
  }
  $internet_links = mysql_query("select * from internet_links");
  if($internet_links == false) {
    echo 'An error occured.Error code : SKRSSIL4<br/>';
    return;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>SS Admin | Intenret links</title>
	<link href="loginmodule.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
      function confirmDelete(id){
        var to_delete = window.confirm("Are you sure you want to delete this internet link?");
	    if(to_delete) {
	      document.forms["deletionform"].id.value=id;
	      document.forms["deletionform"].submit();
	    }
      }
	</script>
  </head>
  <body>
	<h1>Internet Links Admin </h1>
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
	  <div class="admin_label"><label for="id_title">Title:</label></div>
	  <textarea name="title" id="id_title" style="height:50px;"></textarea>
	  <br/>
	  <div class="admin_label"><label for="id_description">Description:</label></div>
	  <textarea name="description" id="id_description" style="height:70px;"></textarea>
	  <br />
	  <div class="admin_label"><label for="id_link">Link</label></div>
	  <input type="text" name="link" id="id_link"/>
	  <br/>
	  <input type="submit" value="Add"/>
	</form>
	<?php if(mysql_num_rows($internet_links)>0) {?>
	  <h3>Edit an existing entry</h3>
	  <form name="deletionform" method="post">
		<input type="hidden" name="action" value="2"/>
		<input type="hidden" name="id" value="0" id="id"/>
	  </form>
	  <table>
		<tr>
		  <th>Title</th>
		  <th>Description</th>
	     	  <th>Link</th>
		  <th>Update</th>
		  <th>Delete</th>
		</tr>
		<?php while($row=mysql_fetch_assoc($internet_links)) { ?>
		  <tr>
			<form method="post" enctype="multipart/form-data">
			<td>
			  <textarea name="title" style="width:200px;"><?php echo $row['title']; ?></textarea>
			</td>
			<td>
			  <textarea name="description"><?php echo $row['description']; ?></textarea>
			</td>
			<td>
			  <input type="text" name="link" value="<?php echo $row['link']; ?>"/>
			</td>
			<td>
			  <input type="submit" value="Update"/>
			</td>
			<input type="hidden" name="id" value="<?php echo $row['id'];?>"/>
			<input type="hidden" name="action" value="1"/>
			</form>
			<td>
			  <a href="javascript:void();" onclick="javascript:confirmDelete(<?php echo $row['id'] ?>);">Delete</a>
			</td>
		  </tr>
	  <?php } ?>
	  </table>
	<?php } ?>
  </body>
</html>
