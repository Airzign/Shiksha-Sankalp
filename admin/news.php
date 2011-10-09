<?php
require_once('auth.php');
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
<?php
	require_once('config.php');
    $entry_display = <<<ADMIN_OPTION

	<div class="admin_link" style="float:left">
      <a href="edit_news.php">Add a New Entry</a>
    </div>
    <div style="float:right">
        <a href="admin.php">Back to dashboard</a>
    </div>
    <div style="clear:both"></div>
ADMIN_OPTION;

    $q = "SELECT * FROM news ORDER BY tm DESC LIMIT 20";
    $r = mysql_query($q);

    if ( $r !== false && mysql_num_rows($r) > 0 ) {
      while ( $a = mysql_fetch_assoc($r) ) {
        $heading = stripslashes($a['heading']);
        $description = nl2br(stripslashes($a['description']));
		$id = stripslashes($a['id']);
        $entry_display .= <<<ENTRY_DISPLAY

    <h3>$heading</h3>
    <p>
      $description
    </p>
	<p><a href="edit_news.php?e=$id">Edit</a></p>
	<p><a href="edit_news.php?e=$id&d=1" onclick="return confirmDelete();">Delete</a></p>
	

ENTRY_DISPLAY;
      }
    } else {
      $entry_display = <<<ENTRY_DISPLAY

    <h4>No news to display</h4>
    <p>
      No entries have been made on this page.
      Please check back soon, or click the
      link below to add an entry!
	  <div class="admin_link" style="float:left">
		<a href="edit_news.php">Add a New Entry</a>
      </div>
      <div style="float:right">
        <a href="admin.php">Back to dashboard</a>
      </div>
      <div style="clear:both"></div>
    </p>

ENTRY_DISPLAY;
    }

    echo $entry_display;
  
?>
</body>
</html>
