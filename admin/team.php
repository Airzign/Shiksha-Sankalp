<?php
  require_once('auth.php');
  require_once('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>SS Admin | Team</title>
	<link href="loginmodule.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
	  function confirmDelete(){
        return window.confirm('Are you sure you want to delete this?');
	  }
	</script>
  </head>
  <body>
	<h1> Team </h1>
	<?php include('menu.php'); ?>
	<div class="admin_link">
	  <a href="?action=4">Add a new entry</a>
	</div>
    <div style="clear:both"></div>
	<?php
	  /*
	   * Actions to be performed for various values of $action
	   * 0 => Show All the team members.
	   * 1 => Update the entry submitted.
	   * 2 => Delete the entry.
	   * 3 => Add a new entry.
       * 4 => Show the form to get details for new entry.
       * 5 => Show the form to edit an entry.
	   */
	  $action=0;
      $message='';
      $is_message_error=false;
      $member_file_dir='../images/team/';
      $categories = array('Board of Directors of Shiksha Sankalp Incorporated, USA',
                          'Office Bearers of Shiksha Sankalp USA',
                          'Advisors',
                          'Board of Directors of Shiksha Sankalp Foundation, India');
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
        $member_name = mysql_real_escape_string($_POST['name']);
        $post = mysql_real_escape_string($_POST['post']);
        $description = mysql_real_escape_string($_POST['description']);
        $category = mysql_real_escape_string($_POST['category']);
        $position = mysql_real_escape_string($_POST['position']);
		$result = mysql_query("select picture from team where id=$id");
		$assoc = mysql_fetch_assoc($result);
		$old_picture = $assoc['picture'];
		$new_picture = $old_picture;
		$update_picture = True;
		if(array_key_exists('picture',$_FILES) && $_FILES['picture']['name'] !== '') {
		  if($_FILES["picture"]["size"] > SMALL_IMG_FILE_SIZE) {
		    $message .= 'The picture is larger than the maximum allowed size('.SMALL_IMG_FILE_SIZE/(1024*1024).'MB) so was not uploaded.<br/>';
            $is_message_error = true;
			$update_picture = False;
	      } else {
			$allowed=false;
			foreach($allowed_file_types as $type)
			  if($_FILES['picture']['type'] == $type)
				$allowed=true;
			if(!$allowed) {
				$message .= 'The picture is not valid. So was not uploaded..<br/>';
                $is_message_error = true;
				$update_picture = False;
			} else {
			  if(!file_exists($member_file_dir.$_FILES['picture']['name'])) {
				$picture_filename=$_FILES['picture']['name'];
			  } else {
				$fileparts=explode('.',$_FILES['picture']['name']);
				$extension='.'.array_pop($fileparts);
				$name=implode('.',$fileparts).'_';
				$filecount=0;
				while(file_exists($member_file_dir.$name.$filecount.$extension))
				  $filecount=$filecount+1;
				$picture_filename=$name.$filecount.$extension;
			  }
			}
			move_uploaded_file($_FILES['picture']['tmp_name'],$member_file_dir.$picture_filename);
		  }
		}
		if(array_key_exists('delete_old_picture',$_POST) && isset($_POST['delete_old_picture']))
		  if($old_picture!='') {
			$new_picture = '';
			if(file_exists($member_file_dir.$old_picture))
			  unlink($member_file_dir.$old_picture);
		  }
		if(array_key_exists('picture',$_FILES) && $_FILES['picture']['name']!='' && $update_picture) {
		  $new_picture = $picture_filename;
		  if($old_picture!='' && file_exists($member_file_dir.$old_picture))
			  unlink($member_file_dir.$old_picture);
		  }
        if(mysql_query("update team set position='$position',post='$post',category=$category,name='$member_name',picture='$new_picture',description='$description' where id = $id"))
          $message .= 'The team member was updated successfully.';
      }

      if($action == 2) {
		  /* Deletion */
		  $id=mysql_real_escape_string($_GET['id']);
          $query = mysql_query("select * from team where id=$id");
          $row=mysql_fetch_assoc($query);
          if($row['picture'] !== null && $row['picture'] !== '' && file_exists($member_file_dir.$row['picture']))
            unlink($member_file_dir.$row['picture']);
          if(mysql_query("delete from team where id=$id"))
            $message .= 'The team member was deleted successfully.';
      }
      if($action == 3) {
		/* Addition */
        $member_name=stripslashes($_POST['name']);
		$post = stripslashes($_POST['post']);
        $description = stripslashes($_POST['description']);
        $category = stripslashes($_POST['category']);
        $position = mysql_real_escape_string($_POST['position']);
        $picture_filename = '';
		if($_FILES['picture']['name'] !== '') {
		  if($_FILES["picture"]["size"] > SMALL_IMG_FILE_SIZE) {
		    $message .= 'The picture is larger than the maximum allowed size so was not uploaded.<br/>';
            $is_message_error = true;
	      } else {
			$allowed=false;
			foreach($allowed_file_types as $type)
			  if($_FILES['picture']['type'] == $type)
				$allowed=true;
			if(!$allowed) {
				$message .= 'The large image file is not valid. So was not uploaded..<br/>';
                $is_message_error = true;
			} else {
			  if(!file_exists($member_file_dir.$_FILES['picture']['name'])) {
				$picture_filename=$_FILES['picture']['name'];
			  } else {
				$fileparts=explode('.',$_FILES['picture']['name']);
				$extension='.'.array_pop($fileparts);
				$name=implode('.',$fileparts).'_';
				$filecount=0;
				while(file_exists($member_file_dir.$name.$filecount.$extension))
				  $filecount=$filecount+1;
				$picture_filename=$name.$filecount.$extension;
			  }
			}
			move_uploaded_file($_FILES['picture']['tmp_name'],$member_file_dir.$picture_filename);
		  }
		}
		if(mysql_query("INSERT INTO team VALUES (default,'$member_name','$post','$description','$picture_filename',$category,$position);"))
			$message .= 'New team member created successfully.';
      }
      if($action == 4) {
		/* Blank form */
    ?>
	<form action="team.php" method="post" enctype="multipart/form-data">
	  <p>
		<div class="admin_label"><label for="id_name">Name:</label></div>
		<input class="input_wide" id="id_name" type="text" name="name" />
	  </p>
	  <p>
		<div class="admin_label"><label for="id_post">Post:</label></div>
		<input class="input_wide" id="id_post" type="text" name="post" />
	  </p>
	  <p>
		<div class="admin_label"><label for="id_category">Category:</label></div>
		<select name="category" id="id_category">
		  <?php
             $i=0;
             while($i<4) {
          ?>
		  <option value="<?php echo $i; ?>"><?php echo $categories[$i]; ?></option>
		  <?php ++$i; } ?>
		</select>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_description">Description:</label></div>
		<textarea name="description" id="id_description"></textarea>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_position">Position:</label></div>
		<input id="id_position" type="text" name="position"/>
		Position at which this member will be displayed
	  </p>
      <p>
		<div class="admin_label"><label for="id_picture">Picture:</label></div>
		<input type="file" name="picture" id="id_picture" />
		Only jpg/gif images of size less than <?php echo SMALL_IMG_FILE_SIZE/(1024*1024); ?>MB.
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
        $result = mysql_query("select * from team where id=$id");
        $row = mysql_fetch_assoc($result);
    ?>
	<form action="team.php" method="post" enctype="multipart/form-data">
	  <p>
		<div class="admin_label"><label for="id_name">Name:</label></div>
		<input class="input_wide" id="id_name" type="text" name="name" value="<?php echo $row['name']; ?>"/>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_post">Post:</label></div>
		<input class="input_wide" id="id_post" type="text" name="post" value="<?php echo $row['post']; ?>"/>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_category">Category:</label></div>
		<select name="category" id="id_category">
		  <?php
             $i=0;
             while($i<4) {
          ?>
		  <option value="<?php echo $i; ?>"<?php if($i==$row['category']) echo ' selected="selected"'; ?>><?php echo $categories[$i]; ?></option>
		  <?php ++$i; } ?>
		</select>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_description">Description:</label></div>
		<textarea name="description" id="id_description"><?php echo $row['description']; ?></textarea>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_position">Position:</label></div>
		<input id="id_position" type="text" name="position" value="<?php echo $row['position']; ?>"/>
		Position at which this member will be displayed
	  </p>

	  <?php if($row['picture']!='') { ?>
	  <p>Picture:
		<a href="<?php echo $member_file_dir,$row['picture']; ?>">File link</a>
		<input type="checkbox" name="delete_old_picture" value="Yes" id="id_delete_old_picture"/><label for="id_delete_old_picture">Delete</label>
		<input type="file" name="picture"/>
		Only jpg/gif images of size less than <?php echo SMALL_IMG_FILE_SIZE/(1024*1024); ?>MB.
	  </p>
	  <?php } else { ?>
	  <p>
		<div class="admin_label"><label for="id_picture">Picture:</label></div>
		<input type="file" name="picture" id="id_picture" />
		Only jpg/gif images of size less than <?php echo SMALL_IMG_FILE_SIZE/(1024*1024); ?>MB.
	  </p>
	  <?php } ?>

	  <input type="submit" value="Update" />
	  <input type="button" value="Cancel" onclick="javascript:window.location='?';" />
	  <input type="hidden" name="action" value="1"/>
	  <input type="hidden" name="id" value="<?php echo $id; ?>"/>
	</form>
	<?php
	  } /* End of actions */
      // Do not show the team members if an entry form was displayed
      if($action != 4 && $action !=5) {
        $q = "SELECT * FROM team ORDER BY name DESC";
        $r = mysql_query($q);
		if($message != '')
          if(!$is_message_error)
		    echo '<div class="admin_message admin_success">',$message,'</div>';
          else
            echo '<div class="admin_message admin_error">',$message,'</div>';
        if ( $r == false || mysql_num_rows($r) == 0 ) {
    ?>
    <h4>No team member to display</h4>
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
		  <h3><?php echo stripslashes($a['name']); ?></h3>
		  <p>
			<?php echo nl2br(stripslashes($a['description'])); ?>
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
