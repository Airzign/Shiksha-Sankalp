<?php
   if(!array_key_exists("pan", $_POST))
     header("Location: donate1.php?error=true&page=donate3b.php");
   include "headerinner.php";
   include "admin/config.php";
   $pan = $_POST['pan'];
   $name = $_POST['name'];
   $email = $_POST['email'];
   $account = $_POST['account'];
   $citizen = $_POST['citizen'];
   $students = intval($_POST['students']);
   $years = intval($_POST['years']);
   $amount = $students * $years * 120;
?>
<div id="content">
  <div id="main_content">
	<div class="innertitle">Donate Now</div>
    <div class="donate_under">
      STEP-3: Make Payment
    </div>
    <p>
      You can make a payment through any of the following three channels:
    </p>
    <div class="donate_num">1.</div>
    <div class="donate_value">
      <span class="donate_under">By Cheque</span>
      in favor of Shiksha Sankalp Incorporated.
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">&nbsp;</div>
    <div class="donate_value">
      Please send the cheque to 10286 N Portal Avenue, Cupertino, CA 95014, USA.
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">&nbsp;</div>
    <div class="donate_value">
      Our bank details are: Wells Fargo Bank, Routing # 121042882, Account # 2222862563.
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
      : Shiksha Sankalp Incorporated
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">&nbsp;</div>
    <div class="donate_name">
      Address
    </div>
    <div class="donate_value">
      : 10286 N Portal Avenue, Cupertino, CA 95014, USA.
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">&nbsp;</div>
    <div class="donate_name">
      Account Number
    </div>
    <div class="donate_value">
      : 2222862563
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">&nbsp;</div>
    <div class="donate_name">
      Bank Name
    </div>
    <div class="donate_value">
      : Wells Fargo Bank
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">&nbsp;</div>
    <div class="donate_name">
      Routing Number
    </div>
    <div class="donate_value">
      : 121042882
    </div>
    <div style="clear:both"></div>
    <div class="donate_num">3.</div>
    <div class="donate_value">
      <span class="donate_under">Online Payment</span>
      by debit/credit card
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
      <span class="donate_prev" style="position:relative;top:110px;">
        <input type="submit" id="back" value="Back"/>
      </span>
    </form>
    <div class="donate_paypal" style="width:200px;margin:0 auto;">
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="SG3NDNPSRBCFQ">
        <input type="image"
               src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif"
               border="0" name="submit" alt="PayPal - The safer, easier way to pay
                                             online!">
        <img alt="" border="0"
             src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1"
             height="1">
      </form>
    </div>
  </div>
  <div id="extra_content">
	<?php
	   include "dynamic.php";
    ?>
  </div>
  <?php
	 include "footer.php";
  ?>
