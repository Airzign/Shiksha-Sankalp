<?php
   include "headerinner.php";
   include "admin/config.php";
?>
<style type="text/css">
  #main_content p { font-size:15px; }
  #main_content { font-size:15px; }
</style>
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
    <form method="POST" id="donate_form">
      <div class="donate_ques">
        Are you an Indian citizen?
      </div>
      <div class="donate_opt">
        <input type="radio" name="citizen" value="indian" id="citizen_y" checked="checked"/><label for="citizen_y">Yes</label>
      </div>
      <div class="donate_opt">
        <input type="radio" name="citizen" value="nonindian" id="citizen_n"/><label for="citizen_n">No</label>
      </div>
      <div style="clear:both"></div>
      <div class="donate_ques">
        Would be making a payment from an account located in India?
      </div>
      <div class="donate_opt">
        <input type="radio" name="account" value="indian" id="account_y" checked="checked"/><label for="account_y">Yes</label>
      </div>
      <div class="donate_opt">
        <input type="radio" name="account" value="nonindian" id="account_n"/><label for="account_n">No</label>
      </div>
      <div style="clear:both"></div>
      <div class="donate_ques">
        Your Name
      </div>
      <div>
        <input type="text" name="name" class="donate_text"/>
      </div>
      <div style="clear:both"></div>
      <div class="donate_ques">
        Your Email Address
      </div>
      <div>
        <input type="text" name="email" class="donate_text"/>
      </div>
      <div style="clear:both"></div>
      <div id="pan_div">
        <div class="donate_ques">
          Please provide your Permanent Account Number (PAN No)
        </div>
        <div>
          <input type="text" name="pan" class="donate_text"/>
        </div>
        <div style="clear:both"></div>
      </div>
      <div class="donate_submit">
        <input type="submit" value="Submit"/>
      </div>
    </form>
    <script type="text/javascript">
      $("#donate_form").submit(function() {
        var citizen = $("[name=citizen]:checked").val();
        var account = $("[name=account]:checked").val();
        var where;
        if(citizen == "indian" && account == "indian")
        {
          where = "1a";
          var pan = $("[name=pan]").val().trim();
          if(pan === "")
          {
            alert("Please give a Permanent Account Number");
            return false;
          }
        }
        else
        {
          where = "1b";
        }
        $("#donate_form").attr("action", "donate" + where + ".php");
        return true;
      });
      function changed()
      {
        var citizen = $("[name=citizen]:checked").val();
        var account = $("[name=account]:checked").val();
        if(citizen == "indian" && account == "indian")
          $("#pan_div").show();
        else
          $("#pan_div").hide();
      }
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
