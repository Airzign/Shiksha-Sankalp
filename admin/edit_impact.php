<?php
require_once('auth.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SS Admin | Impact</title>
<link href="loginmodule.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1> Impact Admin </h1>

<?php
	require_once('config.php');
    $d=$new_heading=$id=null;
    if(array_key_exists("d",$_GET))
	{
		$d = mysql_real_escape_string($_GET["d"]); // if 1 delete entry with id  e = id
    }
if(array_key_exists("pic_desc",$_POST))
	{
		$new_heading = mysql_real_escape_string($_POST["pic_desc"]);
	}
if(array_key_exists("e",$_GET))
	{
		$id = $_GET["e"]; // if this is null act as add give empty form 
	}
	if($d == 1 && $id != null)
	{
		$q = "DELETE FROM impact WHERE id=$id";
		$r = mysql_query($q);
		if($r)
		{
			echo "Deleted impact with id = ".$id.'  ';
			echo '<a href="impact.php">Back to Impact</a>';
		}
		else
		{
			echo "Could not delete impact.";
		}
	}
	else if($new_heading == NULL)
	{
		$q = "SELECT * FROM impact WHERE id=$id";
		$r = mysql_query($q);
		if ( $r !== false && mysql_num_rows($r) > 0 ) {
			$a = mysql_fetch_assoc($r);
	        $pic_desc = stripslashes($a['pic_desc']);
	        $small_desc = stripslashes($a['small_desc']);
    	    $description = stripslashes($a['description']);
			$timestamp = stripslashes($a['tm']);
	        $entry_display .= <<<ENTRY_DISPLAY
	<form action="edit_impact.php?e=$id" method="post" enctype="multipart/form-data">	
	<p><label for="id_pic_desc">Small Image Caption:</label> <input id="id_pic_desc" type="text" name="pic_desc" value="$pic_desc" /></p>
	<p><label for="id_small_desc">Short Description:</label> <input id="id_small_desc" type="text" name="small_desc" value="$small_desc" /></p>
	<p><label for="id_description">Description:</label> <textarea name="description" id="id_description">$description</textarea></p>
	<p><label for="id_smallimg">Small Img File:</label> <input type="file" name="smallimg" id="id_smallimg" /></p>
	<p><label for="id_largeimg">Large Img File:</label> <input type="file" name="largeimg" id="id_largeimg" /></p>
	<input type="submit" value="Upload" />
	</form>

ENTRY_DISPLAY;
		}
		else {
    	 $entry_display = <<<ENTRY_DISPLAY
<form action="edit_impact.php" method="post" enctype="multipart/form-data">	
	<p><label for="id_pic_desc">Small Image Caption:</label> <input id="id_pic_desc" type="text" name="pic_desc" /></p>
	<p><label for="id_small_desc">Short Description:</label> <input id="id_small_desc" type="text" name="small_desc" /></p>
	<p><label for="id_description">Description:</label> <textarea name="description" id="id_description"></textarea></p>
	<p><label for="id_smallimg">Small Img File:</label> <input type="file" name="smallimg" id="id_smallimg" /></p>
	<p><label for="id_largeimg">Large Img File:</label> <input type="file" name="largeimg" id="id_largeimg" /></p>
	<input type="submit" value="Upload" />
	</form>
ENTRY_DISPLAY;
		}
	}
	else {
		$pic_desc = stripslashes($_POST['pic_desc']);
	    $small_desc = stripslashes($_POST['small_desc']);
    	$description = nl2br(stripslashes($_POST['description']));
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

    if (file_exists("../images/impact/" . $_FILES["smallimg"]["name"]))
      {
      echo $_FILES["smallimg"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["smallimg"]["tmp_name"],
      "../images/impact/" . $_FILES["smallimg"]["name"]);
      echo "Stored in: " . "../images/impact/" . $_FILES["smallimg"]["name"];
      }
    }
  }
else
  {
  echo "Invalid file";
  }
  //largeimg
	if ((($_FILES["largeimg"]["type"] == "image/gif")
		|| ($_FILES["largeimg"]["type"] == "image/jpeg")
		|| ($_FILES["largeimg"]["type"] == "image/pjpeg"))
		&& ($_FILES["largeimg"]["size"] < 20000))
  {
  if ($_FILES["largeimg"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["largeimg"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["largeimg"]["name"] . "<br />";
    echo "Type: " . $_FILES["largeimg"]["type"] . "<br />";
    echo "Size: " . ($_FILES["largeimg"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["largeimg"]["tmp_name"] . "<br />";

    if (file_exists("../images/impact/" . $_FILES["largeimg"]["name"]))
      {
      echo $_FILES["largeimg"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["largeimg"]["tmp_name"],
      "../images/impact/" . $_FILES["largeimg"]["name"]);
      echo "Stored in: " . "../images/impact/" . $_FILES["largeimg"]["name"];
      }
    }
  }
else
  {
  echo "Invalid file";
  }

  		$smallimgurl = $_FILES["smallimg"]["name"];
		$largeimgurl = $_FILES["largeimg"]["name"];
		if($id == Null) {
			$q = "INSERT INTO impact VALUES (default,'$pic_desc','$small_desc','$description','$smallimgurl','$largeimgurl',default);";
			$r = mysql_query($q);
			if ($r == true)
				echo "New IMPACT story created";
			else
				echo "New IMPACT story creation failed";
		}
		else {
			$q = "UPDATE impact SET pic_desc='$pic_desc', small_desc='$small_desc', description='$description'";
			if($smallimgurl != null)
				$q .= ", smallimgurl='$smallimgurl'";
			if($largeimgurl != null)
				$q .= ", largeimgurl='$largeimgurl'";
			$q .= " WHERE id=$id;";
			$r = mysql_query($q);
			if($r==true)
				echo "Impact Story with id = " . $id . "updated";
			else
				echo "Updation Failed";
		}
}
echo $entry_display;
?>
