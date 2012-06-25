<?php
   include "headerinner.php";
   include "admin/config.php";
   $pan = $_POST['pan'];
?>
<div id="content">
  <div id="main_content">
	<div class="innertitle">Donate Now</div>
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
    <div class="donate_submit">
      <form method="POST" action="donate2b.php">
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
