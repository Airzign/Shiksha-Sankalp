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
    <div class="donate_submit">
      <form method="POST" action="donate2a.php">
        <input type="hidden" name="pan" value="<?php echo $pan; ?>"/>
        <input type="hidden" name="name" value="<?php echo $name; ?>"/>
        <input type="hidden" name="email" value="<?php echo $email; ?>"/>
        <input type="submit" value="Next"/>
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
