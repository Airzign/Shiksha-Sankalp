<?php
   include "headerinner.php";
   include "admin/config.php";
   $pan = $_POST['pan'];
?>
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
        <input type="hidden" value="<?php echo $pan; ?>"/>
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
