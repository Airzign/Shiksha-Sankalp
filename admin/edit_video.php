<?php
require_once('auth.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SS Admin | Video</title>
<link href="loginmodule.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1> Video Admin </h1>
<?php
	require_once('config.php');
    $d=$new_heading=$id=null;
    if(array_key_exists("d",$_GET))
	{
		$d = mysql_real_escape_string($_GET["d"]); // if 1 delete entry with id  e = id
	}
    if(array_key_exists("heading",$_POST))
	{
		$new_heading = mysql_real_escape_string($_POST["heading"]);
	}
    if(array_key_exists("e",$_GET))
	{
		$id = $_GET["e"]; // if this is null act as add give empty form 
	}
	if($d == 1 && $id != null)
	{
		$q = "DELETE FROM video WHERE id=$id";
		$r = mysql_query($q);
		$entry_display="";
		if($r)
		{
			echo "Deleted video with id = ".$id.'  ';
			echo '<a href="video.php">Back to video</a>';
		}
		else
		{
			echo "Could not delete video.";
		}
	}
	else if($new_heading == NULL)
	{
		$q = "SELECT * FROM video WHERE id=$id";
		$r = mysql_query($q);
		if ( $r !== false && mysql_num_rows($r) > 0 ) {
			$a = mysql_fetch_assoc($r);
	        $heading = stripslashes($a['heading']);
    	    $description = stripslashes($a['description']);
			$link = stripslashes($a['link']);
			$timestamp = stripslashes($a['tm']);
	        $entry_display = <<<ENTRY_DISPLAY
	<form action="edit_video.php?e=$id" method="post" enctype="multipart/form-data">	
	<p><label for="id_heading">Heading:</label> <input id="id_heading" type="text" name="heading" value="$heading" /></p>
	<p><label for="id_description">Description:</label> <textarea name="description" id="id_description">$description</textarea></p>
	<p><label for="id_smallimg">Small Img File:</label> <input type="file" name="smallimg" id="id_smallimg" /></p>
	<p><label for="id_link">Video Link:</label><input id="id_link" type="text" name="link" value="$link" /></p>

	<input type="submit" value="Upload" />
	<input type="button" value="Cancel" onclick="javascript:window.location='video.php';" />
	</form>

ENTRY_DISPLAY;
		}
		else {
    	 $entry_display = <<<ENTRY_DISPLAY
	<form action="edit_video.php" method="post" enctype="multipart/form-data">	
	<p><label for="id_heading">Heading:</label> <input id="id_heading" type="text" name="heading" /></p>
	<p><label for="id_description">Description:</label> <textarea name="description" id="id_description"></textarea></p>
	<p><label for="id_smallimg">Small Img File:</label> <input type="file" name="smallimg" id="id_smallimg" /></p>
	<p><label for="id_link">Video Link:</label><input id="id_link" type="text" name="link" /></p>

	<input type="submit" value="Upload" />
	<input type="button" value="Cancel" onclick="javascript:window.location='video.php';" />
	</form>
ENTRY_DISPLAY;
		}
	}
	else {
		$entry_display="<br/><a href='video.php'>Back to Videos</a>";
		$heading = stripslashes($_POST['heading']);
		$description = stripslashes($_POST['description']);
		$link = stripslashes($_POST['link']);
		if ((($_FILES["smallimg"]["type"] == "image/gif")
		|| ($_FILES["smallimg"]["type"] == "image/jpeg")
		|| ($_FILES["smallimg"]["type"] == "image/pjpeg"))
		&& ($_FILES["smallimg"]["size"] < 20000))
  {
	  if ($_FILES["smallimg"]["error"] > 0)
	  {
		  echo "Return Code: " . $_FILES["smallimg"]["error"] . "<br />";
	  }
	  else
	  {
		  echo "Upload: " . $_FILES["smallimg"]["name"] . "<br />";
		  echo "Type: " . $_FILES["smallimg"]["type"] . "<br />";
		  echo "Size: " . ($_FILES["smallimg"]["size"] / 1024) . " Kb<br />";
		  echo "Temp file: " . $_FILES["smallimg"]["tmp_name"] . "<br />";
		  
		  if (file_exists("../images/video/" . $_FILES["smallimg"]["name"]))
		  {
			  echo $_FILES["smallimg"]["name"] . " already exists. ";
		  }
		  else
		  {
			  move_uploaded_file($_FILES["smallimg"]["tmp_name"],
								 "../images/video/" . $_FILES["smallimg"]["name"]);
			  echo "Stored in: " . "../images/video/" . $_FILES["smallimg"]["name"];
		  }
    }
  }
  else
  {
	  if($_FILES["smallimg"]["name"] != null)
		  echo "Invalid file";

  }

  		$smallimgurl = $_FILES["smallimg"]["name"];
		if($id == Null) {
			$q = "INSERT INTO video VALUES (default,'$heading','$description','$smallimgurl','$link',default);";
			$r = mysql_query($q);
			if ($r == true)
				echo "New video created";
			else
				echo "New video creation failed";
		}
		else {
			$q = "UPDATE video SET heading='$heading', description='$description'";
			if($smallimgurl != null)
				$q .= ", smallimgurl='$smallimgurl'";
			if($link != null)
				$q .= ", link='$link'";
			$q .= " WHERE id=$id;";
			$r = mysql_query($q);
			if($r==true)
				echo "video with id = " . $id . "updated";
			else
				echo "Updation Failed";
		}
}
echo $entry_display;
?>
