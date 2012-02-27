<?php
  require_once('auth.php');
  include "config.php";
  include "utilities.php";
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
  $upload_dir = '../files/testing_materials/';
  if($action == 1) {
    $id=$_POST['id'];
    $date=mysql_real_escape_string($_POST['date']);
    $title=mysql_real_escape_string($_POST['title']);
    $msg = upload_file_to_dir($_FILES,$upload_dir,'doc',TESTING_MATERIALS_FILE_SIZE);
    if($msg['value'] == 1) {
      $old_file = mysql_query("select file from testing_materials where id = '$id'");
      $assoc = mysql_fetch_assoc($old_file);
      $old_file = $assoc['file'];
      $file = $msg['msg'];
      if(mysql_query("update testing_materials set title='$title', date='$date', file='$file' where id=$id")) {
	$message = 'The testing material was updated successfully.';
	if($old_file != '' && file_exists($upload_dir.$old_file))
	  unlink($upload_dir.$old_file);
      }
      else {
	$message = 'An error occured while updating the testing material. Error code:SKRSS11.';
	$is_message_error = true;
      }
    }
    else {
      if($msg['value'] == 0) {
	$message = $msg['msg'];
	$is_message_error = true;
      }
      if(mysql_query("update testing_materials set title='$title', date='$date' where id=$id"))
	$message .= 'The testing_materials was updated successfully.';
      else {
	$message .= 'An error occured while updating the testing material. Error code:SKRSS10.';
	$is_message_error = true;
      }
    }
  }
  if($action == 2) {
    $id=$_POST['id'];
    $old_file = mysql_query("select file from testing_materials where id = '$id'");
    $assoc = mysql_fetch_assoc($old_file);
    $old_file = $assoc['file'];
    if(mysql_query("delete from testing_materials where id=$id")) {
      $message = 'The testing material was deleted successfully.';
      if($old_file != '' && file_exists($upload_dir.$old_file))
	unlink($upload_dir.$old_file);
    }
    else {
      $message = 'An error occured while deleting the testing material. Error code:SKRSS7.';
      $is_message_error = true;
    }
  }
  if($action == 3) {
    $title=$_POST['title'];
    $date=$_POST['date'];
    $msg = upload_file_to_dir($_FILES,$upload_dir,'doc',TESTING_MATERIALS_FILE_SIZE);
    $file = $msg['msg'];
    if($msg['value'] == 0) {
      $file = '';
      $message = 'Cannot upload the file. An error occured. Error code:SKRSSRR2';
      $is_message_error = true;
    }
    if(mysql_query("insert into testing_materials(title,date,file) values('$title','$date','$file')"))
      $message .= 'The testing material was added successfully.';
    else {
      $message .= 'An error occured while creating the new testing material. Error code:SKRSS8.';
      $is_message_error = true;
    }
  }
  $testing_materials = mysql_query("select * from testing_materials");
  if($testing_materials == false) {
    echo 'An error occured.Error code : SKRSSRR3<br/>';
    return;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>SS Admin | Testing Materials</title>
    <link href="loginmodule.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
      function confirmDelete(id){
        var to_delete = window.confirm("Are you sure you want to delete this testing material?");
        if(to_delete) {
          document.forms["deletionform"].id.value=id;
          document.forms["deletionform"].submit();
        }
      }
    </script>
  </head>
  <body>
    <h1>Testing Material Admin </h1>
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
      <div class="admin_label"><label for="id_date">Date(YYYY-MM-DD):</label></div>
      <input type="text" name="date" id="id_date"/>
      <br />
      <div class="admin_label"><label for="id_doc">File:</label></div>
      <input type="file" name="doc" id="id_doc"/>
      <br/>
      <input type="submit" value="Add"/>
    </form>
    <?php if(mysql_num_rows($testing_materials)>0) {?>
      <h3>Edit an existing entry</h3>
      <form name="deletionform" method="post">
        <input type="hidden" name="action" value="2"/>
        <input type="hidden" name="id" value="0" id="id"/>
      </form>
      <table>
        <tr>
          <th>Document</th>
          <th>Replace Document with</th>
          <th>Date</th>
          <th>Title</th>
          <th>Update</th>
          <th>Delete</th>
        </tr>
        <?php while($row=mysql_fetch_assoc($testing_materials)) { ?>
        <tr>
          <form method="post" enctype="multipart/form-data">
	    <td>
	      <a href="<?php echo $upload_dir.$row['file']; ?>"><?php echo $row['file']; ?></a>
	    </td>
            <td>
              <input type="file" name="doc" />
            </td>
            <td>
              <input type="text" name="date" value="<?php echo $row['date']; ?>"/>
            </td>
            <td>
              <textarea name="title" style="width:200px;"><?php echo $row['title']; ?></textarea>
            </td>
            <td>
              <input type="submit" value="Update"/>
            </td>
            <input type="hidden" name="id" value="<?php echo $row['id'];?>"/>
            <input type="hidden" name="action" value="1"/>
            <td>
              <a href="javascript:void();" onclick="javascript:confirmDelete(<?php echo $row['id'] ?>);">Delete</a>
            </td>
          </form>
        </tr>
      <?php } ?>
      </table>
    <?php } ?>
  </body>
</html>
