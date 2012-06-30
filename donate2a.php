<?php
   if(!array_key_exists("pan", $_POST))
     header("Location: donate1.php?error=true");
   include "headerinner.php";
   include "admin/config.php";
   $pan = $_POST['pan'];
   $name = $_POST['name'];
   $email = $_POST['email'];
?>
<style type="text/css">
  #main_content p { font-size:15px; }
  #main_content { font-size:15px; }
</style>
<div id="content">
  <div id="main_content">
	<div class="innertitle">Donate Now</div>
    <div class="donate_under">
      STEP-2: Decide Donation Amount
    </div>
    <p>
      Shiksha Sankalp requires a donation of Rs. 6000 per child per annum (at
      the rate of Rs.500 per child per month). Please decide the number of
      children and the period for which you would like to support.
    </p>
    <form method="POST" action="donate3a.php">
      <input type="hidden" name="pan" value="<?php echo $pan; ?>"/>
      <input type="hidden" name="name" value="<?php echo $name; ?>"/>
      <input type="hidden" name="email" value="<?php echo $email; ?>"/>
      <div class="donate_ques">
        Please enter the number of students you would like to support
      </div>
      <div>
        <input type="text" name="students" class="donate_text_small" autocomplete="off"/>
      </div>
      <div style="clear:both"></div>
      <div class="donate_ques">
        Please enter the number of years
      </div>
      <div>
        <input type="text" name="years" class="donate_text_small" autocomplete="off"/>
      </div>
      <div style="clear:both"></div>
      <p>
        Amount to be paid by you is <i><span id="total"></span></i>
      </p>
      <span>
        <input type="button" id="back" value="Back"/>
      </span>
      <span style="float:right;margin-right:50px;">
        <input type="submit" value="Next"/>
      </span>
    </form>
  </div>
  <script type="text/javascript">
    $("#back").click(function() {
      window.location = "donate1.php";
    });
    
    function isNum(str)
    {
      if(str.length == 0)
        return false;
      for(var i=0;i<str.length;++i)
        if(str[i] <'0' || str[i] > '9')
          return false;
      return true;
    }

    function changed()
    {
      var studs = $("[name=students]").val();
      var years = $("[name=years]").val();
      if(isNum(studs) && isNum(years))
        $("#total").html("Rs. " + parseInt(studs)*parseInt(years)*6000);
      else
        $("#total").html("");
    }
    $("[name=students]").change(changed);
    $("[name=years]").change(changed);
    $("form").submit(function() {
      var studs = $("[name=students]").val();
      var years = $("[name=years]").val();
      if(isNum(studs) && isNum(years))
        return true;
      alert("Please fill valid values");
      return false;
    });
  </script>
  <div id="extra_content">
	<?php
	   include "dynamic.php";
    ?>
  </div>
  <?php
	 include "footer.php";
  ?>
