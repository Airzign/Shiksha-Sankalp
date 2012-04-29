<?php
   include "headerinner.php";
   include "admin/config.php";
?>
<div id="content">
  <div id="main_content">
	<div class="innertitle">Donate Now</div>
    <div class="donate_part donate_first_part">
      <p>
        If you are an Indian citizen and are currently located in India, you can
        donate to Shiksha Sankalp Foundation, India.
      </p>
      <div class="donate_paypal">
        <div style="height:50px;"></div>
        <!-- <form action="https://www.paypal.com/cgi-bin/webscr" method="post"> -->
        <!--   <input type="hidden" name="cmd" value="_s-xclick"> -->
        <!--   <input type="hidden" name="hosted_button_id" value="SG3NDNPSRBCFQ"> -->
        <!--   <input type="image" -->
        <!--          src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" -->
        <!--          border="0" name="submit" alt="PayPal - The safer, easier way to pay -->
        <!--                                        online!"> -->
        <!--   <img alt="" border="0" -->
        <!--        src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" -->
        <!--        height="1"> -->
        <!-- </form> -->
      </div>
      <p>
        Your donations to Shiksha Sankalp Foundation are tax exempt in India under
        section 80G.
      </p>
    </div>
    <div class="donate_part">
      <p>
        If you are not an Indian citizen or are currently located outside India,
        you can donate to Shiksha Sankalp Incorporated, USA.
      </p>
      <div class="donate_paypal">
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
      <p>
        Your donations to Shiksha Sankalp Incorporated are tax exempt in the USA
        under section 501(C)(3).
      </p>
    </div>
    <div style="clear:both"></div>
  </div>
  <div id="extra_content">
	<?php
	   include "dynamic.php";
    ?>
  </div>
  <?php
	 include "footer.php";
  ?>
