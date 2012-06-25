<?php
   include "headerinner.php";
   include "admin/config.php";
?>
<div id="content">
  <div id="main_content">
	<div class="innertitle">Donate Now</div>
    <p>Thanks for your interest in supporting Shiksha Sankalp’s mission.</p>
    <p>
      You can make a payment in
      <span class="donate_high">three easy steps</span>.
      Here is how:
    </p>
    <div class="donate_under" style="height:40px;padding-top:15px;">STEP-1: Help us guide you</div>
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
        Please provide your Permanent Account Number (PAN No)
      </div>
      <div>
        <input type="text" name="pan" class="donate_text"/>
      </div>
      <div style="clear:both"></div>
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
        }
        else
        {
          where = "1b";
        }
        $("#donate_form").attr("action", "donate" + where + ".php");
        return true;
      });
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
