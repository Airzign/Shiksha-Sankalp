<?php
  require_once('auth.php');
  require_once('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>SS Admin | Video</title>
	<link href="loginmodule.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
	  function confirmDelete(){
        return window.confirm('Are you sure you want to delete this?');
	  }
	</script>
  </head>
  <body>
	<h1> Video Admin </h1>
	<?php include('menu.php'); ?>
    <div style="clear:both"></div>
	<?php
	  /*
	   * Actions to be performed for various values of $action
	   * 0 => Show All the videos.
	   * 1 => Update the entry submitted.
	   * 2 => Delete the entry.
	   * 3 => Add a new entry.
       * 4 => Show the form to get details for new entry.
       * 5 => Show the form to edit an entry.
	   */
	  $action=0;
      $message='';
      $video_img_dir='../images/video/';
      $allowed_file_types=array('image/gif','image/jpeg','image/pjpeg','image/png');
      if(array_key_exists('action',$_GET)) {
        $action=$_GET['action'];
      }
      if(array_key_exists('action',$_POST)) {
	    $action=stripslashes($_POST['action']);
      }
      if($action == 1) {
		/* Update */
        /* $id = $_POST['id']; */
        /* $heading = stripslashes($_POST['heading']); */
        /* $description = stripslashes($_POST['description']); */
		/* $link = stripslashes($_POST['link']); */
        /* if(mysql_query("update video set heading='$heading', link='$link', description='$description' where id = $id")) */
        /*   $message .= 'The video was updated successfully.'; */
				/* Update */
		$id = $_POST['id'];
        $heading = stripslashes($_POST['heading']);
        $description = stripslashes($_POST['description']);
		$result = mysql_query("select smallimgurl from video where id=$id");
		$link = stripslashes($_POST['link']);
		$assoc = mysql_fetch_assoc($result);
		$old_small_img_filename = $assoc['smallimgurl'];
		$new_small_img_filename = $old_small_img_filename;
		$update_small_img = True;
		if(array_key_exists('smallimg',$_FILES) && $_FILES['smallimg']['name'] !== '') {
		  if($_FILES["smallimg"]["size"] > SMALL_IMG_FILE_SIZE) {
		    $message .= 'The small image is larger than the maximum allowed size('.SMALL_IMG_FILE_SIZE/(1024*1024).'MB) so was not uploaded.<br/>';
			$update_small_img = False;
	      } else {
			$allowed=false;
			foreach($allowed_file_types as $type)
			  if($_FILES['smallimg']['type'] == $type)
				$allowed=true;
			if(!$allowed) {
				$message .= 'The small image file is not a valid image so was not uploaded.<br/>';
				$update_small_img = False;
			} else {
			  if(!file_exists($video_img_dir.$_FILES['smallimg']['name'])) {
				$small_img_filename=$_FILES['smallimg']['name'];
			  } else {
				$fileparts=explode('.',$_FILES['smallimg']['name']);
				$extension='.'.array_pop($fileparts);
				$name=implode('.',$fileparts).'_';
				$filecount=0;
				while(file_exists($video_img_dir.$name.$filecount.$extension))
				  $filecount=$filecount+1;
				$small_img_filename=$name.$filecount.$extension;
			  }
			}
			move_uploaded_file($_FILES['smallimg']['tmp_name'],$video_img_dir.$small_img_filename);
		  }
		}
		if(array_key_exists('delete_old_small_img',$_POST) && isset($_POST['delete_old_small_img']))
		  if($old_small_img_filename!='') {
			$new_small_img_filename = '';
			if(file_exists($video_img_dir.$old_small_img_filename))
			  unlink($video_img_dir.$old_small_img_filename);
		  }
		if(array_key_exists('smallimg',$_FILES) && $_FILES['smallimg']['name']!='' && $update_small_img) {
		  $new_small_img_filename = $small_img_filename;
		  if($old_small_img_filename!='')
			if(file_exists($video_img_dir.$old_small_img_filename))
			  unlink($video_img_dir.$old_small_img_filename);
		  }
        if(mysql_query("update video set heading='$heading',smallimgurl='$new_small_img_filename',link='$link',description='$description' where id = $id"))
          $message .= 'The Video was updated successfully.';
      }
      if($action == 2) {
		  /* Deletion */
		  $id=$_GET['id'];
          $query = mysql_query("select * from video where id=$id");
          $row=mysql_fetch_assoc($query);
          if($row['smallimgurl'] !== null && $row['smallimgurl'] !== '' && file_exists($video_img_dir.$row['smallimgurl']))
            unlink($video_img_dir.$row['smallimgurl']);
          if(mysql_query("delete from video where id=$id"))
            $message .= 'The video was deleted successfully.';
      }
      if($action == 3) {
		/* Addition */
        $heading=stripslashes($_POST['heading']);
        $description = stripslashes($_POST['description']);
		$link = stripslashes($_POST['link']);
        $small_img_filename = '';
		if($_FILES['smallimg']['name'] !== '') {
		  if($_FILES["smallimg"]["size"] > SMALL_IMG_FILE_SIZE) {
		    $message .= 'The small image is larger than the maximum allowed size so was not uploaded.<br/>';
	      } else {
			$allowed=false;
			foreach($allowed_file_types as $type)
			  if($_FILES['smallimg']['type'] == $type)
				$allowed=true;
			if(!$allowed) {
				$message .= 'The small image file is not a valid image so was not uploaded.<br/>';
			} else {
			  if(!file_exists($video_img_dir.$_FILES['smallimg']['name'])) {
				$small_img_filename=$_FILES['smallimg']['name'];
			  } else {
				$fileparts=explode('.',$_FILES['smallimg']['name']);
				$extension='.'.array_pop($fileparts);
				$name=implode('.',$fileparts).'_';
				$filecount=0;
				while(file_exists($video_img_dir.$name.$filecount.$extension))
				  $filecount=$filecount+1;
				$small_img_filename=$name.$filecount.$extension;
			  }
			}
			move_uploaded_file($_FILES['smallimg']['tmp_name'],$video_img_dir.$small_img_filename);
		  }
		}
		if(mysql_query("INSERT INTO video VALUES (default,'$heading','$description','$small_img_filename','$link',default);"))
			$message .= 'New video created successfully.';
      }
      if($action == 4) {
		/* Blank form */
    ?>
	<form action="video.php" method="post" enctype="multipart/form-data">
	  <p><label for="id_heading">Heading:</label> <input id="id_heading" type="text" name="heading" /></p>
	  <p><label for="id_description">Description:</label> <textarea name="description" id="id_description"></textarea></p>
	  <p><label for="id_smallimg">Small Img File:</label> <input type="file" name="smallimg" id="id_smallimg" />Only jpg/gif images allowed, size &lt;2MB</p>
      <p><label for="id_link">Video link:</label> <input type="text" name="link" id="id_link" /></p>
	  <input type="hidden" name="action" value="3" />
	  <input type="submit" value="Upload" />
	  <input type="button" value="Cancel" onclick="javascript:window.location='?';" />
	</form>
	<?php
      }
      if($action == 5) {
		/* Editing form */
        $id = $_GET['id'];
        $result = mysql_query("select * from video where id=$id");
        $row = mysql_fetch_assoc($result);
    ?>
	<form action="video.php" method="post" enctype="multipart/form-data">
	  <p><label for="id_heading">Heading:</label> <input id="id_heading" type="text" name="heading" value="<?php echo $row['heading']; ?>"/></p>
	  <p><label for="id_description">Description:</label> <textarea name="description" id="id_description"><?php echo $row['description']; ?></textarea></p>
	  <?php if($row['smallimgurl']!='') { ?>
	  <p>Small Img File:
		<a href="<?php echo $video_img_dir,$row['smallimgurl']; ?>"><?php echo $row['smallimgurl']; ?></a>
		<input type="checkbox" name="delete_old_small_img" value="Yes" id="id_delete_old_small_img"/><label for="id_delete_old_small_img">Delete</label>
		<input type="file" name="smallimg"/>
	  </p>
	  <?php } else { ?>
	  <p><label for="id_smallimg">Small Img File:</label> <input type="file" name="smallimg" id="id_smallimg" />Only jpg/gif images allowed, size &lt;2MB</p>
	  <?php } ?>
	  <p>
		<label for="id_link">Video link:</label>
		<input type="text" name="link" id="id_link" value="<?php echo $row['link']; ?>"/>
		<a href="<?php echo $row['link']; ?>">Existing link</a>
	  </p>
	  <input type="submit" value="Update" />
	  <input type="button" value="Cancel" onclick="javascript:window.location='?';" />
	  <input type="hidden" name="action" value="1"/>
	  <input type="hidden" name="id" value="<?php echo $id; ?>"/>
	</form>
	<?php
	  } /* End of actions */
      // Do not show the videos if an entry form was displayed
      if($action != 4 && $action !=5) {
        $q = "SELECT * FROM video ORDER BY tm DESC";
        $r = mysql_query($q);
        echo $message;
        if ( $r == false || mysql_num_rows($r) == 0 ) {
    ?>
    <h4>No videos to display</h4>
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
    <h3><?php echo stripslashes($a['heading']); ?></h3>
    <p>
      <?php echo nl2br(stripslashes($a['description'])); ?>
    </p>
	<p><a href="?action=5&id=<?php echo $id; ?>">Edit</a></p>
	<p><a href="?action=2&id=<?php echo $id; ?>" onclick="return confirmDelete();">Delete</a></p>
	<?php
        }
      }
    }
    ?>
</body>
</html>
