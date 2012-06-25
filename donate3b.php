<?php
   include "headerinner.php";
   include "admin/config.php";
   $pan = $_POST['pan'];
?>
<div id="content">
  <div id="main_content">
	<div class="innertitle">Donate Now</div>
    <div class="donate_under">
      STEP-2: Make Payment
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
    <div id="new_paypal_container">
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
