<?php
   include "headerinner.php";
   include "admin/config.php";
   ?>
<script type="text/javascript" src="js/jquery.createFaq.js"></script>
<div id="content">
  <div id="main_content">
    <div class="innertitle">Frequently Asked Questions</div>

    <?php
       $results = mysql_query("select * from faq order by position");
       $i = 0;
       if(!$results)
         echo 'An error occured. Error Code:SKRSSFA1';
       else while($row = mysql_fetch_assoc($results)) {
       ?>
    <p class="question">
      <?php echo ++$i; ?>
      .
      <?php echo $row['question']; ?>
    <p class="answer">
      <?php echo nl2br($row['answer']); ?>
    </p>
    <?php } ?>

  </div>
  <div id="extra_content">
    <?php
       include "dynamic.php";
       ?>
  </div>
  <?php
     include "footer.php";
     ?>
