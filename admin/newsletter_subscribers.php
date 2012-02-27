<?php
  require_once('auth.php');
  require_once('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>SS Admin | Newsletters Subscribers</title>
    <link href="loginmodule.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
      function confirmDelete(){
        return window.confirm('Are you sure you want to delete this?');
      }
    </script>
  </head>
  <body>
    <h1> Newsletters Subscribers Admin </h1>
    <?php include('menu.php'); ?>
    <?php
      /*
       * Actions to be performed for various values of $action
       * 1 => Add the entry submitted.
       * 2 => Delete the entry.
       */
      $action=0;
      $message='';
      $is_message_error=false;
      if(array_key_exists('action',$_GET)) {
        $action=$_GET['action'];
      }
      if(array_key_exists('action',$_POST)) {
        $action=stripslashes($_POST['action']);
      }
    ?>
    <p>Manually Add Subscriber</p>
    <?php
    if($action == 1) {
      $name = mysql_real_escape_string($_POST['name']);
      $email = mysql_real_escape_string($_POST['email']);
      $test = mysql_query("select * from newslettersubscribers where emailAddress='$email'");
      if(mysql_num_rows($test)>0) {
	?>
    <div class="admin_message admin_error"><?php echo $email; ?> is already subscribed.</div>
    <?php
      } else if(mysql_query("insert into newslettersubscribers(subscriberName,emailAddress) values('$name','$email')")) {
       ?>
    <div class="admin_message admin_success">Subscriber <?php echo $name; ?> was added successfully.</div>
    <?php
      }
      else {
       ?>
    <div class="admin_message admin_error">An error occured. Error code:SKRSSNS1.</div>
    <?php
      }
    }
       ?>
    <form method="POST">
    <?php
    if($action == 2) {
      $email = mysql_real_escape_string($_POST['email']);
      $test = mysql_query("select * from newslettersubscribers where emailAddress='$email'");
      if(mysql_num_rows($test) == 0) {
	?>
    <div class="admin_message admin_error"><?php echo $email; ?> is not subscribed to newsletters.</div>
    <?php
      } else if(mysql_query("delete from newslettersubscribers where emailAddress='$email'")) {
       ?>
    <div class="admin_message admin_success">Subscriber <?php echo $email; ?> was unsubscribed successfully.</div>
    <?php
      }
      else {
       ?>
    <div class="admin_message admin_error">An error occured. Error code:SKRSSNS2.</div>
    <?php
      }
    }
       ?>
      <p>
	<div class="admin_label"><label for="id_name">Name:</label></div>
	<input type="text" id="id_name" name="name"/>
      </p>
      <p>
	<div class="admin_label"><label for="id_email">Email:</label></div>
	<input type="text" id="id_email" name="email"/>
      </p>
      <p>
	<input type="hidden" name="action" value="1"/>
	<input type="submit" value="Subscribe"/>
      </p>
    </form>

    <p>Manually Delete Subscriber</p>
    <form method="POST">
      <p>
	<div class="admin_label"><label for="id_email1">Email:</label></div>
	<input type="text" id="id_email1" name="email"/>
      </p>
      <p>
	<input type="hidden" name="action" value="2"/>
	<input type="submit" value="Subscribe"/>
      </p>
    </form>

    <p>List of Newsletter Subscribers</p>
    <table id="email_list" cellspacing="0">
      <tr>
    	<th>Name</th>
    	<th>Email</th>
      </tr>
      <?php
        $results = mysql_query("select * from newslettersubscribers order by subscriberName");
        if(!$results) {
          echo "An error occured. Error code:SKRSSNS2";
        } else while($row = mysql_fetch_assoc($results)){
         ?>
      <tr>
    	<td><?php echo $row['subscriberName']; ?></td>
    	<td><?php echo $row['emailAddress']; ?></td>
      </tr>
        <?php
        }
         ?>
    </table>

    <p>
      Email List of Subscribers (This list can be copied by the admin and used
      for sending out newsletters by email).
    </p>
    <?php
      mysql_data_seek($results,0);
      $row = mysql_fetch_assoc($results);
      echo $row['emailAddress'];
      while($row = mysql_fetch_assoc($results))
        echo ', '.$row['emailAddress'];
       ?>
    <div style="height:100px;"></div>
  </body>
</html>
