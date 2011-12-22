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
  if(array_key_exists('action',$_GET)) {
    $action=$_GET['action'];
  }
  if(array_key_exists('action',$_POST)) {
    $action=$_POST['action'];
  }
  if($action == 1) {
    $id=$_POST['id'];
    $description=$_POST['description'];
    $event_date =$_POST['event_date'];
    if(mysql_query("update event set description='$description', event_date='$event_date' where id=$id"))
      $message = 'The event is updated successfully.';
    else
      $message = 'An error accured while updating the event. Error code:SKRSS6.';
  }
  if($action == 2) {
    $id=$_POST['id'];
    if(mysql_query("delete from event where id=$id"))
      $message = 'The event is deleted successfully.';
    else
      $message = 'An error occured while deleting the event. Error code:SKRSS7.';
  }
  if($action == 3) {
    $description=$_POST['description'];
    $event_date =$_POST['event_date'];
    if(mysql_query("insert into event(description,event_date) values('$description','$event_date')"))
      $message = 'The event was added successfully.';
    else
      $message = 'An error occures while creating the new event. Error code:SKRSS8.';
  }
  $events = mysql_query("select * from event order by event_date desc, description asc");
  if($events == false) {
    echo 'An error occured.Error code : SKRSS6<br/>';
    return;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>SS Admin | Events</title>
	<link href="loginmodule.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
      function confirmDelete(id){
        var to_delete = window.confirm("Are you sure you want to delete this event?");
	    if(to_delete) {
	      document.forms["deletionform"].id.value=id;
	      document.forms["deletionform"].submit();
	    }
      }
	</script>
  </head>
  <body>
	<h1>Events Admin </h1>
    <?php include('menu.php'); ?>
    <?php echo $message ?>
	<div style="clear:both"></div>
	<form enctype="multipart/form-data" method="post">
	  <input type="hidden" value="3" name="action"/>
	  <label for="id_date">Date(YYYY-MM-DD):</label>
	  <input type="text" name="event_date" id="id_date"/>
	  <br/>
	  <label for="id_description">Description:</label>
	  <!--<input type="textarea" name="description" id="id_description"/>-->
	  <textarea name="description" id="id_description" style="height:70px;"></textarea>
	  <br />
	  <input type="submit" value="Add"/>
	</form>
	<?php if(mysql_num_rows($events)>0) {?>
	  <h3>Edit an existing entry</h3>
	  <form name="deletionform" method="post">
		<input type="hidden" name="action" value="2"/>
		<input type="hidden" name="id" value="0" id="id"/>
	  </form>
	  <table>
		<tr>
		  <th>Date(YYYY-MM-DD)</th>
		  <th>Description</th>
		  <th>Update</th>
		  <th>Delete</th>
		</tr>
		<?php while($row=mysql_fetch_assoc($events)) { ?>
		  <tr>
			<form method="post" enctype="multipart/form-data">
			<td>
			  <input type="text" name="event_date" value="<?php echo $row['event_date']; ?>"/>
			</td>
			<td>
			  <!--<input type="text" name="description" value="<?php echo $row['description']; ?>"/>-->
			  <textarea name="description"><?php echo $row['description']; ?></textarea>
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
