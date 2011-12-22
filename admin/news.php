<?php
  require_once('auth.php');
  require_once('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>SS Admin | News</title>
	<link href="loginmodule.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
	  function confirmDelete(){
        return window.confirm('Are you sure you want to delete this?');
	  }
	</script>
  </head>
  <body>
	<h1> News Admin </h1>
	<?php include('menu.php'); ?>
	<div class="admin_link">
	  <a href="?action=4">Add a new entry</a>
	</div>
	<?php
	  /*
	   * Actions to be performed for various values of $action
	   * 0 => Show All the news.
	   * 1 => Update the entry submitted.
	   * 2 => Delete the entry.
	   * 3 => Add a new entry.
       * 4 => Show the form to get details for new entry.
       * 5 => Show the form to edit an entry.
	   */
	  $action=0;
      $message='';
      $news_img_dir='../images/news/';
      $allowed_file_types=array('image/gif','image/jpeg','image/pjpeg','image/png');
      if(array_key_exists('action',$_GET)) {
        $action=$_GET['action'];
      }
      if(array_key_exists('action',$_POST)) {
	    $action=stripslashes($_POST['action']);
      }
      if($action == 1) {
		/* Update */
		$id = $_POST['id'];
        $heading = stripslashes($_POST['heading']);
		$news_date = stripslashes($_POST['news_date']);
		$small_desc = stripslashes($_POST['small_desc']);
        $description = stripslashes($_POST['description']);
		$large_img_desc = stripslashes($_POST['large_img_desc']);
		$result = mysql_query("select smallimgurl,largeimgurl from news where id=$id");
		$assoc = mysql_fetch_assoc($result);
		$old_small_img_filename = $assoc['smallimgurl'];
		$old_large_img_filename = $assoc['largeimgurl'];
		$new_small_img_filename = $old_small_img_filename;
		$new_large_img_filename = $old_large_img_filename;
		$update_small_img = True;
		$update_large_img = True;
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
			  if(!file_exists($news_img_dir.$_FILES['smallimg']['name'])) {
				$small_img_filename=$_FILES['smallimg']['name'];
			  } else {
				$fileparts=explode('.',$_FILES['smallimg']['name']);
				$extension='.'.array_pop($fileparts);
				$name=implode('.',$fileparts).'_';
				$filecount=0;
				while(file_exists($news_img_dir.$name.$filecount.$extension))
				  $filecount=$filecount+1;
				$small_img_filename=$name.$filecount.$extension;
			  }
			}
			move_uploaded_file($_FILES['smallimg']['tmp_name'],$news_img_dir.$small_img_filename);
		  }
		}
		if(array_key_exists('largeimg',$_FILES) && $_FILES['largeimg']['name'] !== '') {
		  if($_FILES["largeimg"]["size"] > LARGE_IMG_FILE_SIZE) {
		    $message .= 'The large image is larger than the maximum allowed size('.LARGE_IMG_FILE_SIZE/(1024*1024).'MB) so was not uploaded.<br/>';
			$update_large_img = False;
	      } else {
			$allowed=false;
			foreach($allowed_file_types as $type)
			  if($_FILES['largeimg']['type'] == $type)
				$allowed=true;
			if(!$allowed) {
				$message .= 'The large image file is not a valid image so was not uploaded..<br/>';
				$update_large_img = False;
			} else {
			  if(!file_exists($news_img_dir.$_FILES['largeimg']['name'])) {
				$large_img_filename=$_FILES['largeimg']['name'];
			  } else {
				$fileparts=explode('.',$_FILES['largeimg']['name']);
				$extension='.'.array_pop($fileparts);
				$name=implode('.',$fileparts).'_';
				$filecount=0;
				while(file_exists($news_img_dir.$name.$filecount.$extension))
				  $filecount=$filecount+1;
				$large_img_filename=$name.$filecount.$extension;
			  }
			}
			move_uploaded_file($_FILES['largeimg']['tmp_name'],$news_img_dir.$large_img_filename);
		  }
		}
		if(array_key_exists('delete_old_small_img',$_POST) && isset($_POST['delete_old_small_img']))
		  if($old_small_img_filename!='') {
			$new_small_img_filename = '';
			if(file_exists($news_img_dir.$old_small_img_filename))
			  unlink($news_img_dir.$old_small_img_filename);
		  }
		if(array_key_exists('smallimg',$_FILES) && $_FILES['smallimg']['name']!='' && $update_small_img) {
		  $new_small_img_filename = $small_img_filename;
		  if($old_small_img_filename!='')
			if(file_exists($news_img_dir.$old_small_img_filename))
			  unlink($news_img_dir.$old_small_img_filename);
		  }
		if(array_key_exists('delete_old_large_img',$_POST) && isset($_POST['delete_old_large_img']))
		  if($old_large_img_filename!='') {
			$new_large_img_filename = '';
			if(file_exists($news_img_dir.$old_large_img_filename))
			  unlink($news_img_dir.$old_large_img_filename);
		  }
		if(array_key_exists('largeimg',$_FILES) && $_FILES['largeimg']['name']!='' && $update_large_img) {
		  $new_large_img_filename = $large_img_filename;
		  if($old_large_img_filename!='' && file_exists($news_img_dir.$old_large_img_filename))
			  unlink($news_img_dir.$old_large_img_filename);
		  }
        if(mysql_query("update news set heading='$heading',smallimgurl='$new_small_img_filename',largeimgurl='$new_large_img_filename',large_img_desc='$large_img_desc',news_date='$news_date',small_desc='$small_desc',description='$description' where id = $id"))
          $message .= 'The news was updated successfully.';
      }
      if($action == 2) {
		  /* Deletion */
		  $id=$_GET['id'];
          $query = mysql_query("select * from news where id=$id");
          $row=mysql_fetch_assoc($query);
          if($row['smallimgurl'] !== null && $row['smallimgurl'] !== '' && file_exists($news_img_dir.$row['smallimgurl']))
            unlink($news_img_dir.$row['smallimgurl']);
          if($row['largeimgurl'] !== null && $row['largeimgurl'] !== '' && file_exists($news_img_dir.$row['largeimgurl']))
            unlink($news_img_dir.$row['largeimgurl']);
          if(mysql_query("delete from news where id=$id"))
            $message .= 'The news was deleted successfully.';
      }
      if($action == 3) {
		/* Addition */
        $heading=stripslashes($_POST['heading']);
		$news_date = stripslashes($_POST['news_date']);
		$small_desc = stripslashes($_POST['small_desc']);
        $description = stripslashes($_POST['description']);
		$large_img_desc = stripslashes($_POST['large_img_desc']);
        $small_img_filename = '';
        $large_img_filename = '';
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
			  if(!file_exists($news_img_dir.$_FILES['smallimg']['name'])) {
				$small_img_filename=$_FILES['smallimg']['name'];
			  } else {
				$fileparts=explode('.',$_FILES['smallimg']['name']);
				$extension='.'.array_pop($fileparts);
				$name=implode('.',$fileparts).'_';
				$filecount=0;
				while(file_exists($news_img_dir.$name.$filecount.$extension))
				  $filecount=$filecount+1;
				$small_img_filename=$name.$filecount.$extension;
			  }
			}
			move_uploaded_file($_FILES['smallimg']['tmp_name'],$news_img_dir.$small_img_filename);
		  }
		}
		if($_FILES['largeimg']['name'] !== '') {
		  if($_FILES["largeimg"]["size"] > LARGE_IMG_FILE_SIZE) {
		    $message .= 'The large image is larger than the maximum allowed size so was not uploaded.<br/>';
	      } else {
			$allowed=false;
			foreach($allowed_file_types as $type)
			  if($_FILES['largeimg']['type'] == $type)
				$allowed=true;
			if(!$allowed) {
				$message .= 'The large image file is not a valid image so was not uploaded..<br/>';
			} else {
			  if(!file_exists($news_img_dir.$_FILES['largeimg']['name'])) {
				$large_img_filename=$_FILES['largeimg']['name'];
			  } else {
				$fileparts=explode('.',$_FILES['largeimg']['name']);
				$extension='.'.array_pop($fileparts);
				$name=implode('.',$fileparts).'_';
				$filecount=0;
				while(file_exists($news_img_dir.$name.$filecount.$extension))
				  $filecount=$filecount+1;
				$large_img_filename=$name.$filecount.$extension;
			  }
			}
			move_uploaded_file($_FILES['largeimg']['tmp_name'],$news_img_dir.$large_img_filename);
		  }
		}
		if(mysql_query("INSERT INTO news VALUES (default,'$heading','$news_date','$small_desc','$description','$small_img_filename','$large_img_filename','$large_img_desc',default);"))
			$message .= 'New news created successfully.';
      }
      if($action == 4) {
		/* Blank form */
    ?>
	<form action="news.php" method="post" enctype="multipart/form-data">
	  <p>
		  <div class="admin_label"><label for="id_heading">Heading:</label></div>
		  <input class="input_wide" id="id_heading" type="text" name="heading" maxlength="46"/>
	  </p>
	  <p>
	    <div class="admin_label"><label for="id_news_date">Date(YYYY-MM-DD):</label></div>
		<input class="input_wide" id="id_news_date" type="text" name="news_date" maxlength="200"/>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_small_desc">Small Description:</label></div>
		<input class="input_wide" id="id_small_desc" type="text" name="small_desc" maxlength="200"/>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_large_img_desc">Description for the large image:</label></div>
		<textarea name="large_img_desc" id="id_large_img_desc"></textarea>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_description">Description:</label></div>
		<textarea name="description" id="id_description"></textarea>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_smallimg">Small Img File:</label></div>
		<input type="file" name="smallimg" id="id_smallimg" />
		Only jpg/gif images allowed, size &lt;2MB
	  </p>
      <p>
		<div class="admin_label"><label for="id_largeimg">Large Img File:</label></div>
		<input type="file" name="largeimg" id="id_largeimg" />
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
        $result = mysql_query("select * from news where id=$id");
        $row = mysql_fetch_assoc($result);
    ?>
	<form action="news.php" method="post" enctype="multipart/form-data">
	  <p>
		<div class="admin_label"><label for="id_heading">Heading:</label></div>
		<input class="input_wide" id="id_heading" type="text" name="heading" value="<?php echo $row['heading']; ?>" maxlength="46"/>
	  </p>
      <p>
		<div class="admin_label"><label for="id_news_date">Date(YYYY-MM-DD):</label></div>
		<input class="input_wide" id="id_news_date" type="text" name="news_date" value="<?php echo $row['news_date']; ?>"/>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_small_desc">Small Description:</label></div>
		<input class="input_wide" id="id_small_desc" type="text" name="small_desc" value="<?php echo $row['small_desc']; ?>" maxlength="200"/>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_large_img_desc">Description for the large image:</label></div>
		<textarea name="large_img_desc" id="id_large_img_desc"><?php echo $row['large_img_desc']; ?></textarea>
	  </p>
	  <p>
		<div class="admin_label"><label for="id_description">Description:</label></div>
		<textarea name="description" id="id_description"><?php echo $row['description']; ?></textarea>
	  </p>
	  <?php if($row['smallimgurl']!='') { ?>
	  <p>Small Img File:
		<a href="<?php echo $news_img_dir,$row['smallimgurl']; ?>"><?php echo $row['smallimgurl']; ?></a>
		<input type="checkbox" name="delete_old_small_img" value="Yes" id="id_delete_old_small_img"/><label for="id_delete_old_small_img">Delete</label>
		<input type="file" name="smallimg"/>
	  </p>
	  <?php } else { ?>
	  <p>
		<div class="admin_label"><label for="id_smallimg">Small Img File:</label></div>
		<input type="file" name="smallimg" id="id_smallimg" />
		Only jpg/gif images allowed, size &lt;2MB
	  </p>
	  <?php } ?>
	  <?php if($row['largeimgurl']!='') { ?>
	  <p>Large Img File:
		<a href="<?php echo $news_img_dir,$row['largeimgurl']; ?>"><?php echo $row['largeimgurl']; ?></a>
		<input type="checkbox" name="delete_old_large_img" value="Yes" id="id_delete_old_large_img"/><label for="id_delete_old_large_img">Delete</label>
		<input type="file" name="largeimg"/>
	  </p>
	  <?php } else { ?>
	  <p>
		<div class="admin_label"><label for="id_largeimg">Large Img File:</label></div>
		<input type="file" name="largeimg" id="id_largeimg" />
		Only jpg/gif images allowed, size &lt;2MB
	  </p>
	  <?php } ?>

	  <input type="submit" value="Update" />
	  <input type="button" value="Cancel" onclick="javascript:window.location='?';" />
	  <input type="hidden" name="action" value="1"/>
	  <input type="hidden" name="id" value="<?php echo $id; ?>"/>
	</form>
	<?php
	  } /* End of actions */
      // Do not show the news if an entry form was displayed
      if($action != 4 && $action !=5) {
        $q = "SELECT * FROM news ORDER BY tm DESC";
        $r = mysql_query($q);
        echo $message;
        if ( $r == false || mysql_num_rows($r) == 0 ) {
    ?>
    <h4>No news to display</h4>
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
          <h3><?php echo stripslashes($a['heading']); ?></h3>
		  <p>
			<?php echo nl2br(stripslashes($a['small_desc'])); ?>
		  </p>
		</div>
	  <p><a class="admin_delete" href="?action=2&id=<?php echo $id; ?>" onclick="return confirmDelete();">Delete</a></p>
	</a>
	</div>
	<?php
        }
      }
    }
    ?>
</body>
</html>
