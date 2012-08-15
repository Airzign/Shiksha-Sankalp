<?php
   if(!array_key_exists("pan", $_POST))
     header("Location: donate.php?error=true&page=donate3a.php");
   include "headerinner.php";
   include "admin/config.php";
   $pan = $_POST['pan'];
   $name = $_POST['name'];
   $email = $_POST['email'];
   $account = $_POST['account'];
   $citizen = $_POST['citizen'];
   $students = intval($_POST['students']);
   $years = intval($_POST['years']);
   $amount = $students * $years * 6000;
?>
<div id="content">
  <div id="main_content">
	<div class="innertitle">Donate Now</div>
    <div class="donate_under">
      STEP-3: Make Payment
    </div>
    <p>
      You can make a payment through any of the following two channels:
    </p>
    <div class="donate_num">1.</div>
    <div class="donate_value">
      <span class="donate_under">By Cheque</span>
      in favor of Shiksha Sankalp Foundation.
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">&nbsp;</div>
    <div class="donate_value">
      Please send the cheque to A-160, Vikas Puri, New Delhi-110018.
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">2.</div>
    <div class="donate_value">
      <span class="donate_under">By Electronic Transfer</span>
      based on the following details:
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">&nbsp;</div>
    <div class="donate_name">
      Name
    </div>
    <div class="donate_value">
      : Shiksha Sankalp Foundation
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">&nbsp;</div>
    <div class="donate_name">
      Address
    </div>
    <div class="donate_value">
      : A-160, Vikas Puri, New Delhi-110018, INDIA
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">&nbsp;</div>
    <div class="donate_name">
      Account Number
    </div>
    <div class="donate_value">
      : 082705000220
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">&nbsp;</div>
    <div class="donate_name">
      Bank Name
    </div>
    <div class="donate_value">
      : ICICI Bank
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">&nbsp;</div>
    <div class="donate_name">
      Bank Address
    </div>
    <div class="donate_value">
      : D-16, Prashant Vihar, New Delhi-110085
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">&nbsp;</div>
    <div class="donate_name">
      Swift Code
    </div>
    <div class="donate_value">
      : ICICINBBCTS
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">&nbsp;</div>
    <div class="donate_name">
      RTGS/NEFT IFSC code
    </div>
    <div class="donate_value">
      : ICIC0000827
    </div>
    <div style="clear:both"></div>
    <form method="POST" action="donate2a.php">
      <input type="hidden" name="pan" value="<?php echo $pan; ?>" />
      <input type="hidden" name="name" value="<?php echo $name; ?>" />
      <input type="hidden" name="email" value="<?php echo $email; ?>" />
      <input type="hidden" name="account" value="<?php echo $account; ?>" />
      <input type="hidden" name="citizen" value="<?php echo $citizen; ?>" />
      <input type="hidden" name="students" value="<?php echo $students; ?>" />
      <input type="hidden" name="years" value="<?php echo $years; ?>" />
      <span class="donate_prev">
        <input type="submit" id="back" value="Back"/>
      </span>
    </form>
    <!--
    <div class="donate_num">3.</div>
    <div class="donate_value">
      <span class="donate_under">Online Payment</span>
      by debit/credit card
    </div>
    <div style="clear:both"></div>
    -->
  </div>
  <div id="extra_content">
	<?php
	   include "dynamic.php";
    ?>
  </div>
  <?php
	 include "footer.php";
  ?>
