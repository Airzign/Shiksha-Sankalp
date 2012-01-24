<?php
  require_once('auth.php');
  require_once('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>SS Admin | Board Meetings</title>
	<link href="loginmodule.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
	  function confirmDelete(){
        return window.confirm('Are you sure you want to delete this?');
	  }
	</script>
  </head>
  <body>
	<h1> Board Meetings </h1>
	<?php include('menu.php'); ?>
	<div class="admin_link">
	  <a href="?action=4">Add a new entry</a>
	</div>
    <div style="clear:both"></div>
	<?php
	  /*
	   * Actions to be performed for various values of $action
	   * 0 => Show All the board meetings.
	   * 1 => Update the entry submitted.
	   * 2 => Delete the entry.
	   * 3 => Add a new entry.
       * 4 => Show the form to get details for new entry.
       * 5 => Show the form to edit an entry.
	   */
	  $action=0;
      $message='';
      $is_message_error=false;
      $board_meeting_file_dir='../files/board_meetings/';
      $allowed_file_types=array('image/gif','image/jpeg','image/pjpeg','image/png');
      if(array_key_exists('action',$_GET)) {
        $action=mysql_real_escape_string($_GET['action']);
      }
      if(array_key_exists('action',$_POST)) {
	    $action=mysql_real_escape_string($_POST['action']);
      }
      if($action == 1) {
		/* Update */
		$id = mysql_real_escape_string($_POST['id']);
        $meeting_date = mysql_real_escape_string($_POST['meeting_date']);
        $country = mysql_real_escape_string($_POST['country']);
        $key_decisions = mysql_real_escape_string($_POST['key_decisions']);
		$result = mysql_query("select file_link from board_meeting where id=$id");
		$assoc = mysql_fetch_assoc($result);
		$old_meeting_file = $assoc['file_link'];
		$new_meeting_filename = $old_meeting_file;
		$update_meeting_file = True;
		if(array_key_exists('file_link',$_FILES) && $_FILES['file_link']['name'] !== '') {
		  if($_FILES["file_link"]["size"] > MEETING_FILE_SIZE) {
		    $message .= 'The meeting file is larger than the maximum allowed size('.MEETING_FILE_SIZE/(1024*1024).'MB) so was not uploaded.<br/>';
            $is_message_error = true;
			$update_meeting_file = False;
	      } else {
			$allowed=false;
			foreach($allowed_file_types as $type)
			  if($_FILES['file_link']['type'] == $type)
				$allowed=true;
			if(!$allowed) {
				$message .= 'The meeting file is not valid. So was not uploaded..<br/>';
                $is_message_error = true;
				$update_meeting_file = False;
			} else {
			  if(!file_exists($board_meeting_file_dir.$_FILES['file_link']['name'])) {
				$meeting_file_filename=$_FILES['file_link']['name'];
			  } else {
				$fileparts=explode('.',$_FILES['file_link']['name']);
				$extension='.'.array_pop($fileparts);
				$name=implode('.',$fileparts).'_';
				$filecount=0;
				while(file_exists($board_meeting_file_dir.$name.$filecount.$extension))
				  $filecount=$filecount+1;
				$meeting_file_filename=$name.$filecount.$extension;
			  }
			}
			move_uploaded_file($_FILES['file_link']['tmp_name'],$board_meeting_file_dir.$meeting_file_filename);
		  }
		}
		if(array_key_exists('delete_old_file_link',$_POST) && isset($_POST['delete_old_file_link']))
		  if($old_meeting_file!='') {
			$new_meeting_filename = '';
			if(file_exists($board_meeting_file_dir.$old_meeting_file))
			  unlink($board_meeting_file_dir.$old_meeting_file);
		  }
		if(array_key_exists('file_link',$_FILES) && $_FILES['file_link']['name']!='' && $update_meeting_file) {
		  $new_meeting_filename = $meeting_file_filename;
		  if($old_meeting_file!='' && file_exists($board_meeting_file_dir.$old_meeting_file))
			  unlink($board_meeting_file_dir.$old_meeting_file);
		  }
        if(mysql_query("update board_meeting set country=$country,meeting_date='$meeting_date',file_link='$new_meeting_filename',key_decisions='$key_decisions' where id = $id"))
          $message .= 'The Board meeting was updated successfully.';
      }

      if($action == 2) {
		  /* Deletion */
		  $id=mysql_real_escape_string($_GET['id']);
          $query = mysql_query("select * from board_meeting where id=$id");
          $row=mysql_fetch_assoc($query);
          if($row['file_link'] !== null && $row['file_link'] !== '' && file_exists($board_meeting_file_dir.$row['file_link']))
            unlink($board_meeting_file_dir.$row['file_link']);
          if(mysql_query("delete from board_meeting where id=$id"))
            $message .= 'The Board meeting was deleted successfully.';
      }
      if($action == 3) {
		/* Addition */
        $meeting_date=stripslashes($_POST['meeting_date']);
		$country = stripslashes($_POST['country']);
        $key_decisions = stripslashes($_POST['key_decisions']);
        $meeting_file_filename = '';
		if($_FILES['file_link']['name'] !== '') {
		  if($_FILES["file_link"]["size"] > MEETING_FILE_SIZE) {
		    $message .= 'The meeting file is larger than the maximum allowed size so was not uploaded.<br/>';
            $is_message_error = true;
	      } else {
			$allowed=false;
			foreach($allowed_file_types as $type)
			  if($_FILES['file_link']['type'] == $type)
				$allowed=true;
			if(!$allowed) {
				$message .= 'The large image file is not valid. So was not uploaded..<br/>';
                $is_message_error = true;
			} else {
			  if(!file_exists($board_meeting_file_dir.$_FILES['file_link']['name'])) {
				$meeting_file_filename=$_FILES['file_link']['name'];
			  } else {
				$fileparts=explode('.',$_FILES['file_link']['name']);
				$extension='.'.array_pop($fileparts);
				$name=implode('.',$fileparts).'_';
				$filecount=0;
				while(file_exists($board_meeting_file_dir.$name.$filecount.$extension))
				  $filecount=$filecount+1;
				$meeting_file_filename=$name.$filecount.$extension;
			  }
			}
			move_uploaded_file($_FILES['file_link']['tmp_name'],$board_meeting_file_dir.$meeting_file_filename);
		  }
		}
		if(mysql_query("INSERT INTO board_meeting VALUES (default,'$meeting_date','$key_decisions','$meeting_file_filename',$country);"))
			$message .= 'New meeting created successfully.';
      }
      if($action == 4) {
		/* Blank form */
    ?>
	<form action="board_meeting.php" method="post" enctype="multipart/form-data">
	  <p>
		<div class="admin_label"><label for="id_meeting_date">Meeting Date(YYYY-MM-DD):</label></div>
		<input class="input_wide" id="id_meeting_date" type="text" name="meeting_date" />
	  </p>
	  <p>
		<div class="admin_label"><label for="id_country">Country:</label></div>
		<select name="country" id="id_country">
		  <option value="0">USA</option>
		  <option value="1">India</option>
		</select>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_key_decisions">Key Decisions:</label></div>
		<textarea name="key_decisions" id="id_key_decisions"></textarea>
	  </p>
      <p>
		<div class="admin_label"><label for="id_file_link">Meeting File:</label></div>
		<input type="file" name="file_link" id="id_file_link" />
		Only jpg/gif images of size less than <?php echo MEETING_FILE_SIZE/(1024*1024); ?>MB.
	  </p>
	  <input type="hidden" name="action" value="3" />
	  <input type="submit" value="Upload" />
	  <input type="button" value="Cancel" onclick="javascript:window.location='?';" />
	</form>
	<?php
      }
      if($action == 5) {
		/* Editing form */
        $id = $_GET['id'];
        $result = mysql_query("select * from board_meeting where id=$id");
        $row = mysql_fetch_assoc($result);
    ?>
	<form action="board_meeting.php" method="post" enctype="multipart/form-data">
	  <p>
		<div class="admin_label"><label for="id_meeting_date">Meeting Date(YYYY-MM-DD):</label></div>
		<input class="input_wide" id="id_meeting_date" type="text" name="meeting_date" value="<?php echo $row['meeting_date']; ?>"/>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_country">Country:</label></div>
		<select name="country" id="id_country">
		  <option value="0"<?php if($row['country']==0) echo ' selected="selected"'; ?>>USA</option>
		  <option value="1"<?php if($row['country']==1) echo ' selected="selected"'; ?>>India</option>
		</select>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_key_decisions">Key Decisions:</label></div>
		<textarea name="key_decisions" id="id_key_decisions"><?php echo $row['key_decisions']; ?></textarea>
	  </p>

	  <?php if($row['file_link']!='') { ?>
	  <p>Meeting File:
		<a href="<?php echo $board_meeting_file_dir,$row['file_link']; ?>">File link</a>
		<input type="checkbox" name="delete_old_file_link" value="Yes" id="id_delete_old_file_link"/><label for="id_delete_old_file_link">Delete</label>
		<input type="file" name="file_link"/>
		Only jpg/gif images of size less than <?php echo MEETING_FILE_SIZE/(1024*1024); ?>MB.
	  </p>
	  <?php } else { ?>
	  <p>
		<div class="admin_label"><label for="id_file_link">Meeting File:</label></div>
		<input type="file" name="file_link" id="id_file_link" />
		Only jpg/gif images of size less than <?php echo MEETING_FILE_SIZE/(1024*1024); ?>MB.
	  </p>
	  <?php } ?>

	  <input type="submit" value="Update" />
	  <input type="button" value="Cancel" onclick="javascript:window.location='?';" />
	  <input type="hidden" name="action" value="1"/>
	  <input type="hidden" name="id" value="<?php echo $id; ?>"/>
	</form>
	<?php
	  } /* End of actions */
      // Do not show the meeting if an entry form was displayed
      if($action != 4 && $action !=5) {
        $q = "SELECT * FROM board_meeting ORDER BY meeting_date DESC";
        $r = mysql_query($q);
		if($message != '')
          if(!$is_message_error)
		    echo '<div class="admin_message admin_success">',$message,'</div>';
          else
            echo '<div class="admin_message admin_error">',$message,'</div>';
        if ( $r == false || mysql_num_rows($r) == 0 ) {
    ?>
    <h4>No meetings to display</h4>
    <p>
      No entries have been made on this page.
      Please check back soon, or click the
      link below to add an entry!
	  <div class="admin_link" style="float:left">
		<a href="?action=4">Add a New Entry</a>
      </div>
      <div style="float:right">
        <a href="admin.php">Back to dashboard</a>
      </div>
      <div style="clear:both"></div>
    </p>
	<?php
        } else {
          while ( $a = mysql_fetch_assoc($r) ) {
            $id = stripslashes($a['id']);
    ?>
	<div class="admin_edit">
	  <a href="?action=5&id=<?php echo $id; ?>">
		<div class="admin_edit_inner">
		  <h3><?php echo stripslashes($a['meeting_date']); ?></h3>
		  <p>
			<?php echo nl2br(stripslashes($a['key_decisions'])); ?>
		  </p>
		</div>
	  </a>
	  <div class="admin_delete">
		<input type="button" value="Delete" onclick="javascript:if(confirmDelete())window.location='?action=2&id=<?php echo $id; ?>'"/>
	  </div>
	</div>
	<?php
        }
      }
    }
    ?>
</body>
</html>
