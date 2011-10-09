<?php
  require_once('auth.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>SS Admin | News</title>
	<link href="loginmodule.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
	<h1> News Admin </h1>
	<a href="admin.php">Back to dashboard</a>
	<br /><br />
	<?php
require_once('config.php');
$d=$new_heading=$id=null;
$entry_display="";
if(array_key_exists("d",$_GET)) {
	$d = mysql_real_escape_string($_GET["d"]); // if 1 delete entry with id  e = id
}
if(array_key_exists("heading",$_POST)) {
	$new_heading = mysql_real_escape_string($_POST["heading"]);
}
if(array_key_exists("e",$_GET)) {
	$id = mysql_real_escape_string($_GET["e"]); // if this is null act as add give empty form 
}
if($d == 1 && $id != null)
{
	$q = "DELETE FROM news WHERE id=$id";
	$r = mysql_query($q);
	if($r)
	{
		echo "Deleted news with id = ".$id.'  ';
		echo '<br/><br/><a href="news.php">Back to News</a>';
	}
	else
	{
		echo "Could not delete news.";
	}
}
else if($new_heading == NULL)
{
	$q = "SELECT * FROM news WHERE id=$id";
	$r = mysql_query($q);
	if ( $r !== false && mysql_num_rows($r) > 0 ) {
		$a = mysql_fetch_assoc($r);
		$heading = stripslashes($a['heading']);
		$description = str_replace('<br />',"",stripslashes($a['description']));
		$timestamp = stripslashes($a['tm']);
		$entry_display .= <<<ENTRY_DISPLAY
			<form action="edit_news.php?e=$id" method="post" enctype="multipart/form-data">	
			<p><label for="id_heading">Heading:</label> <input id="id_heading" type="text" name="heading" value="$heading" /></p>
	<p><label for="id_description">Description:</label> <textarea name="description" id="id_description">$description</textarea></p>
	<p><label for="id_smallimg">Small Img File:</label> <input type="file" name="smallimg" id="id_smallimg" /></p>
	<p><label for="id_largeimg">Large Img File:</label> <input type="file" name="largeimg" id="id_largeimg" /></p>
	<input type="submit" value="Upload" />
	<input type="button" value="Cancel" onclick="javascript:window.location='news.php';" />
	</form>

ENTRY_DISPLAY;
		}
		else {
    	 $entry_display .= <<<ENTRY_DISPLAY
	<form action="edit_news.php" method="post" enctype="multipart/form-data">	
	<p><label for="id_heading">Heading:</label> <input id="id_heading" type="text" name="heading" /></p>
	<p><label for="id_description">Description:</label> <textarea name="description" id="id_description"></textarea></p>
	<p><label for="id_smallimg">Small Img File:</label> <input type="file" name="smallimg" id="id_smallimg" />  Only jpg/gif images allowed, size <2MB</p>
	<p><label for="id_largeimg">Large Img File:</label> <input type="file" name="largeimg" id="id_largeimg" /></p>
	<input type="submit" value="Upload" />
	<input type="button" value="Cancel" onclick="javascript:window.location='news.php';" />
	</form>
ENTRY_DISPLAY;
		}
	}
	else {

		$heading = stripslashes($_POST['heading']);
		$description = nl2br(stripslashes($_POST['description']));
		if ((($_FILES["smallimg"]["type"] == "image/gif")
			 || ($_FILES["smallimg"]["type"] == "image/jpeg")
			 || ($_FILES["smallimg"]["type"] == "image/pjpeg"))
			&& ($_FILES["smallimg"]["size"] < SMALL_IMG_FILE_SIZE))
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

				if (file_exists("../images/news/" . $_FILES["smallimg"]["name"]))
				{
					echo $_FILES["smallimg"]["name"] . " already exists. ";
				}
				else
				{
					move_uploaded_file($_FILES["smallimg"]["tmp_name"],
									   "../images/news/" . $_FILES["smallimg"]["name"]);
					echo "Stored in: " . "../images/news/" . $_FILES["smallimg"]["name"];
				}
			}
		}
		else
		{
			if($_FILES["smallimg"]["size"] >= SMALL_IMG_FILE_SIZE) {
				echo 'Small image file size too large.';
			}
			else if($_FILES["smallimg"]["name"] != null)
				echo "Invalid file";
		}
			//largeimg
		if ((($_FILES["largeimg"]["type"] == "image/gif")
			 || ($_FILES["largeimg"]["type"] == "image/jpeg")
			 || ($_FILES["largeimg"]["type"] == "image/png")
			 || ($_FILES["largeimg"]["type"] == "image/pjpeg"))
			&& ($_FILES["largeimg"]["size"] < LARGE_IMG_FILE_SIZE))
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

				if (file_exists("../images/news/" . $_FILES["largeimg"]["name"]))
				{
					echo $_FILES["largeimg"]["name"] . " already exists. ";
				}
				else
				{
					move_uploaded_file($_FILES["largeimg"]["tmp_name"],
									   "../images/news/" . $_FILES["largeimg"]["name"]);
					echo "Stored in: " . "../images/news/" . $_FILES["largeimg"]["name"]."<br/>";
				}
			}
		}
		else
		{
			if($_FILES["largeimg"]["size"] >= LARGE_IMG_FILE_SIZE)
				echo 'Large image file size too large.';
			else if($_FILES["largeimg"]["name"]!=null)
				echo "Invalid file";
		}

  		$smallimgurl = $_FILES["smallimg"]["name"];
		$largeimgurl = $_FILES["largeimg"]["name"];
		if($id == Null) {
			$q = "INSERT INTO news VALUES (default,'$heading','$description','$smallimgurl','$largeimgurl',default);";
			$r = mysql_query($q);
			if ($r == true)
				echo "New NEWS created";
			else
				echo "New NEWS creation failed";
		}
		else {
			$q = "UPDATE news SET heading='$heading', description='$description'";
			if($smallimgurl != null)
				$q .= ", smallimgurl='$smallimgurl'";
			if($largeimgurl != null)
				$q .= ", largeimgurl='$largeimgurl'";
			$q .= " WHERE id=$id;";
			$r = mysql_query($q);
			if($r==true)
				echo "News with id = " . $id . "updated";
			else
				echo "Updation Failed";
		}
	}
echo $entry_display;
?>

</body>
</html>
