<?php
  require_once('auth.php');
  require_once('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>SS Admin | FAQs</title>
    <link href="loginmodule.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
      function confirmDelete(){
        return window.confirm('Are you sure you want to delete this?');
      }
    </script>
  </head>
  <body>
    <h1> FAQs Admin </h1>
    <?php include('menu.php'); ?>
    <div class="admin_link">
      <a href="?action=4">Add a new entry</a>
    </div>
    <?php
      /*
       * Actions to be performed for various values of $action
       * 0 => Show All the FAQs.
       * 1 => Update the entry submitted.
       * 2 => Delete the entry.
       * 3 => Add a new entry.
       * 4 => Show the form to get details for new entry.
       * 5 => Show the form to edit an entry.
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
      if($action == 1) {
        /* Update */
        $id = $_POST['id'];
        $question = stripslashes($_POST['question']);
        $answer = stripslashes($_POST['answer']);
        $position = stripslashes($_POST['position']);
        if(mysql_query("update faq set answer='$answer',question='$question',position='$position' where id = $id"))
          $message .= 'The FAQ was updated successfully.';
      }
      if($action == 2) {
          /* Deletion */
          $id=$_GET['id'];
          if(mysql_query("delete from faq where id=$id"))
            $message .= 'The FAQ was deleted successfully.';
      }
      if($action == 3) {
        /* Addition */
        $question=mysql_real_escape_string($_POST['question']);
        $answer = mysql_real_escape_string($_POST['answer']);
        $position = mysql_real_escape_string($_POST['position']);
        if(mysql_query("INSERT INTO faq(question,answer,position) VALUES ('$question','$answer','$position');"))
            $message .= 'New FAQ created successfully.';
      }
      if($action == 4) {
        /* Blank form */
    ?>
    <form method="post" enctype="multipart/form-data">
      <p>
        <div class="admin_label"><label for="id_question">Question:</label></div>
        <input class="input_wide" id="id_question" type="text" name="question" />
      </p>
      <p>
        <div class="admin_label"><label for="id_answer">Answer:</label></div>
        <textarea name="answer" id="id_answer"></textarea>
      </p>
      <p>
        <div class="admin_label"><label for="id_position">Position:</label></div>
        <input class="input_wide" type="text" name="position" id="id_position" />
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
        $result = mysql_query("select * from faq where id=$id");
        $row = mysql_fetch_assoc($result);
    ?>
    <form method="post" enctype="multipart/form-data">
      <p>
        <div class="admin_label"><label for="id_question">Question:</label></div>
        <input class="input_wide" id="id_question" type="text" name="question" value="<?php echo $row['question']; ?>"/>
      </p>
      <p>
        <div class="admin_label"><label for="id_answer">Answer:</label></div>
        <textarea name="answer" id="id_answer"><?php echo $row['answer']; ?></textarea>
      </p>
      <p>
        <div class="admin_label"><label for="id_position">Position:</label></div>
        <input style="width:500px;" type="text" name="position" id="id_position" value="<?php echo $row['position']; ?>"/>
	Position at which this question will be displayed
      </p>
      <input type="submit" value="Update" />
      <input type="button" value="Cancel" onclick="javascript:window.location='?';" />
      <input type="hidden" name="action" value="1"/>
      <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    </form>
    <?php
      } /* End of actions */
      // Do not show the FAQs if an entry form was displayed
      if($action != 4 && $action !=5) {
        $q = "SELECT * FROM faq ORDER BY position";
        $r = mysql_query($q);
           if($message != '')
          if(!$is_message_error)
            echo '<div class="admin_message admin_success">',$message,'</div>';
          else
            echo '<div class="admin_message admin_error">',$message,'</div>';
        if ( $r == false || mysql_num_rows($r) == 0 ) {
    ?>
    <h4>No FAQ to display</h4>
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
          <h3><?php echo $a['position'].'. '.stripslashes($a['question']); ?></h3>
          <p>
            <?php echo nl2br(stripslashes($a['answer'])); ?>
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
