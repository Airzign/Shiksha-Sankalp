<?php
   include "headerinner.php";
   include "admin/config.php";

   $pan = "";
   $name = "";
   $email = "";
   $account = "nonindian";
   $citizen = "nonindian";

   // BACK button has been pressed
   if(array_key_exists("pan", $_POST)) {
     $pan = $_POST['pan'];
     $name = $_POST['name'];
     $email = $_POST['email'];
     $account = $_POST['account'];
     $citizen = $_POST['citizen'];
   }
?>
<div id="content">
  <div id="main_content">
	<div class="innertitle">Donate Now</div>
    <p>
      Thanks for your interest in supporting Shiksha Sankalp’s mission.
      <br/>
      You can make a payment in
      <span class="donate_high">three easy steps</span>.
      Here is how:
    </p>
    <div class="donate_under" style="padding-top:15px;">STEP-1: Help us guide you</div>
    <p>
      Shiksha Sankalp is registered as a non-profit organization in India as
      well as USA. Help us guide where your donation would be most appropriate.
      Please answer the following questions:
    </p>
    <form method="POST" id="donate_form" action="donate2a.php">
      <div class="donate_ques">
        Your Name
      </div>
      <div>
        <input type="text" name="name" class="donate_text" value="<?php echo $name; ?>"/>
      </div>
      <div style="clear:both"></div>
      <div class="donate_ques">
        Your Email Address
      </div>
      <div>
        <input type="text" name="email" class="donate_text" value="<?php echo $email; ?>"/>
      </div>
      <div style="clear:both"></div>
      <div class="donate_ques">
        Are you an Indian citizen?
      </div>
      <?php if($citizen != "indian") { ?>
      <div class="donate_opt">
        <input type="radio" name="citizen" value="indian" id="citizen_y"/><label for="citizen_y">Yes</label>
      </div>
      <div class="donate_opt">
        <input type="radio" name="citizen" value="nonindian" id="citizen_n" checked="checked"/><label for="citizen_n">No</label>
      </div>
      <?php } else { ?>
      <div class="donate_opt">
        <input type="radio" name="citizen" value="indian" id="citizen_y" checked="checked"/><label for="citizen_y">Yes</label>
      </div>
      <div class="donate_opt">
        <input type="radio" name="citizen" value="nonindian" id="citizen_n"/><label for="citizen_n">No</label>
      </div>
      <?php } ?>
      <div style="clear:both"></div>
      <div class="donate_ques">
        Would you pay from an account located in India?
      </div>
      <?php if($account != "indian") { ?>
      <div class="donate_opt">
        <input type="radio" name="account" value="indian" id="account_y"/><label for="account_y">Yes</label>
      </div>
      <div class="donate_opt">
        <input type="radio" name="account" value="nonindian" id="account_n" checked="checked"/><label for="account_n">No</label>
      </div>
      <?php } else { ?>
      <div class="donate_opt">
        <input type="radio" name="account" value="indian" id="account_y" checked="checked"/><label for="account_y">Yes</label>
      </div>
      <div class="donate_opt">
        <input type="radio" name="account" value="nonindian" id="account_n"/><label for="account_n">No</label>
      </div>
      <?php } ?>
      <div style="clear:both"></div>
      <div id="pan_div"<?php if($account != "indian" || $citizen != "indian") { echo 'style="display:none;"'; } ?>>
        <div class="donate_ques">
          Please provide your Permanent Account Number (PAN No)
        </div>
        <div>
          <input type="text" name="pan" class="donate_text" value="<?php echo $pan; ?>"/>
        </div>
        <div style="clear:both"></div>
      </div>
      <div class="donate_next">
        <input id="next" href="#confirm_non_india" type="button" value="Next" title="Are you sure?"/>
      </div>
    </form>
    <div id="confirm_india" style="display:none;">
      <p>
        You have indicated that you are an Indian citizen and would be making the
        payment from a bank account in India. Accordingly, your payment would be
        received by
        <span class="donate_high">Shiksha Sankalp Foundation, India</span>.
      </p>
      <p>
        Please note that contributions to Shiksha Sankalp Foundation are exempt
        from Income Tax in India under Section-80G of the Income Tax Act.
      </p>
      <div>
        <input type="button" value="Change" onclick="javascript:go_back();"/>
        <span style="float:right;">
          <input type="button" style="width:60px;" value="OK" onclick="javascript:go_next();"/>
        </span>
      </div>
    </div>
    <div id="confirm_non_india" style="display:none;">
      <p>
        You have indicated that you are not an Indian citizen and/or you would be
        making the payment from a bank account outside India. Accordingly, your
        payment would be received by
        <span class="donate_high">Shiksha Sankalp Incorporated, USA</span>.
      </p>
      <p>
        Please note that contributions to Shiksha Sankalp Incorporated are exempt
        from Income Tax in USA under Section-501(C)(3) of the Income Tax Act.
      </p>
      <div>
        <input type="button" value="Change" onclick="javascript:go_back();"/>
        <span style="float:right;">
          <input type="button" style="width:60px;" value="OK" onclick="javascript:go_next();"/>
        </span>
        <script type="text/javascript">
        </script>
      </div>
    </div>

    <script type="text/javascript">
      function go_next() {
        var citizen = $("[name=citizen]:checked").val();
        var account = $("[name=account]:checked").val();
        if(citizen == "indian" && account == "indian")
        {
          $("#donate_form").attr("action", "donate2a.php");
          var pan = $("[name=pan]").val();
          if(pan == "")
          {
            alert("Please provide your Permanent Account Number");
            $("#donate_form").attr("action", "donate.php");
          }
        }
        else
        {
          $("#donate_form").attr("action", "donate2b.php");
        }
        $("#donate_form").submit();
      }
      function go_back() {
        $("#donate_form").attr("action", "donate.php");
        $("#donate_form").submit();
      }
      function changed()
      {
        var citizen = $("[name=citizen]:checked").val();
        var account = $("[name=account]:checked").val();
        if(citizen == "indian" && account == "indian")
        {
          $("#pan_div").show();
          $("#next").attr("href", "#confirm_india");
          $("#next").prettyPhoto();
        }
        else
        {
          $("#pan_div").hide();
          $("#next").attr("href", "#confirm_non_india");
          $("#next").prettyPhoto();
        }
      }
      $(document).ready(function(){$("#next").prettyPhoto();});
      $("[name=citizen]").change(changed);
      $("[name=account]").change(changed);
    </script>
  </div>
  <div id="extra_content">
	<?php
	   include "dynamic.php";
    ?>
  </div>
  <?php
	 include "footer.php";
  ?>
