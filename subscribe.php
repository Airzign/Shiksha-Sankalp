<?php
	include "headerinner.php";
	include "admin/config.php";
	//include "validation_class.php";
	/*
	* Actions to be performed for various values of $action
	* 0 => Show the form for subscribe and unsubscribe newsletter
	* 1 => Subscribe newsletter
	* 2 => Unsubscribe newsletter
	*/
	$action=0;
	$message='';
	if(array_key_exists('action',$_GET))
	{
		$action=$_GET['action'];
	}
	if(array_key_exists('action',$_POST))
	{
		$action=stripslashes($_POST['action']);
	}
?>
	<div id="content">
  		<div id="main_content">
        	<!-- the content goes here -->
<?php
	if($action == 0)
	{
?>
		<div class="innertitle">Subscribe Newsletter</div>

		<p>
		  Shiksha Sankalp sends out a quarterly newsletter to all it's
		  members and interested subscribers. To subscribe please
		  provide your name and email address in the form below:
		</p>

		<form action="subscribe.php?action=1" method="post" enctype="multipart/form-data">
		<p><label for="id_name">Name:</label> <input id="id_name" type="text" name="Name"/></p>
		<p><label for="id_email">Email Id:</label> <input id="id_email" type="text" name="Email" /></p>
		<input type="submit" value="Subscribe" />
		</form>

		<p style="margin:30px 0 30px 0;">
		  <i>
		    <b>Privacy policy</b>:
		    The data requested above is needed to
		    service your subscription to Shiksha Sankalp newsletter
		    only. Your email address will be kept completely
		    confidential and Shiksha Sankalp will not share it with
		    any third party.
		    </i>
		</p>
		<p>To unsubscribe at any time, please enter your email Id and click below.</p>

		<form action="subscribe.php?action=2" method="post" enctype="multipart/form-data">
			<p><label for="id_unsubscribeEmail">Email Id:</label> <input id="id_unsubscribeEmail" type="text" name="unsubscribeEmail" /></p>
			<input type="submit" value="Unsubscribe" />
		</form>

		<p>For any problems please write to shikshasankalp@gmail.com</p>
<?php
	}
	if($action == 1)
	{
		if(empty($_POST['Name']))
		{
			$message .= "Please enter your name. ";
		}
		if(empty($_POST['Email']))
		{
			$message .= "Please enter your name. ";
		}
		else
		{
			if(!preg_match("/^[0-9a-z]+(([\.\-_])[0-9a-z]+)*@[0-9a-z]+(([\.\-])[0-9a-z-]+)*\.[a-z]{2,}$/i", $_POST['Email']))
			{
				$message .= "Email Address entered is not valid. ";
			}
		}

		if(strlen($message) != 0)
		{
			echo "Errors: ".$message;
    	}
		else
		{
        	$selectquery="select * from shiksha_sankalpdb.NewsletterSubscribers where emailAddress = \"" . $_POST['Email'] . "\"";
			$result = mysql_db_query("shiksha_sankalpdb", $selectquery) or die("Failed Query of " . $selectquery);
			$thisrow=mysql_fetch_row($result);
			if ($thisrow)  //if the results of the query are not null
			{
				//mysql_close($con);
				echo "You have already subscribed";
			}
			else
			{
				$sql="INSERT INTO shiksha_sankalpdb.NewsletterSubscribers (subscriberName, emailAddress) VALUES ('$_POST[Name]','$_POST[Email]')";
				$res = mysql_query($sql) or die ("Query failed: " . mysql_error() . " Actual query: " . $query);
				//mysql_close($con);
				$to = $_POST['Email'];
				$subject = "Newsletter subscription confirmation";
				$name=$_POST['Name'];
				$body = $name.",\n\nThank you for your interest in Shiksha Sankalp.\n\nWe plan to initiate Pilot Modules to test the Shiksha Sankalp  model in August 2010. We would keep you informed  about the progress being made at our end through our quarterly newsletter.\n\nRegards,\nShiksha Sankalp Team ";
				$headers = "From: shikshasankalp@gmail.com\r\nReply-To: shikshasankalp@gmail.com";
				if (mail($to, $subject, $body, $headers))
				{
					echo "Mail Sent. Thank you for subscribing";
				}
				else
				{
					echo "Error. Please Try Later.";
				}
			}
		}
	}
	if($action == 2)
	{
		if(empty($_POST['unsubscribeEmail']))
		{
			$message .= "Please enter your Email Address ";
		}
		else
		{
			if (!preg_match("/^[0-9a-z]+(([\.\-_])[0-9a-z]+)*@[0-9a-z]+(([\.\-])[0-9a-z-]+)*\.[a-z]{2,}$/i", $_POST['unsubscribeEmail']))
			{
				$message .= "Please enter a valid email address ";
			}
		}

		if(strlen($message)!=0)
		{
			echo "Errors ".$message;
		}
		else
		{
			$selectquery="select * from shiksha_sankalpdb.NewsletterSubscribers where emailAddress = \"" . $_POST['unsubscribeEmail'] . "\"";
			$result = mysql_db_query("shiksha_sankalpdb", $selectquery) or die("Failed Query of " . $selectquery);  //do the query
			$thisrow = mysql_fetch_row($result);
			if ($thisrow)  //if the results of the query are not null
			{
				$deletequery="DELETE FROM shiksha_sankalpdb.NewsletterSubscribers where emailAddress = \"" . $_POST['unsubscribeEmail'] . "\"";
				mysql_query($deletequery) or die ("Query failed: " . mysql_error() . " Actual query: " . $query);
				//mysql_close($con);
				echo "You have been unsubscribed, Thank You!";
			}
			else
			{
				//mysql_close($con);
				echo "This email id has not subscribed yet.";
			}
		}
	}
?>

<!-- the content ends here -->


        </div>


        <div id="extra_content">
		<?php
		include "dynamic.php";
		echo "</div>";
		include "footer.php";
		?>
