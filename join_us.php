<?php
include "headerinner.php";
include "admin/config.php";
?>
  <div id="content">
  		<div id="main_content">
        	<!-- the content goes here -->
           <p> 
<h3><b>Join Us</b></h3><br />

<p>1. <b>Donors</b> - Your contributions will provide direct cash incentives to economically weak families, based on demonstrated academic performance of their school going children. Shiksha Sankalp is committed to be a vehicle for delivering your assistance to eligible beneficiaries with highest standards of transparency and performance accountability. 
Click <a href="donate.php">here</a> to Donate</p>

<p>Want to understand responsibilities of Shiksha Sankalp towards its donors ? Click <a href="donor_resp.php">here</a> to find out</p>


<p>2. <b>Volunteers</b> - We invite fellow Indians residing in India and abroad - particularly students, housewives and retired people, as well as working professionals to Join Shiksha Sankalp as volunteers, As a volunteer, you could be helping with several activities ranging from working directly in the field, to administrative support in our office and marketing efforts among donors. Shiksha Sankalp would assign responsibilities commensurate with their professional capabilities and the amount of time and effort they maybe able and willing to commit. </p>

<p>Interested in understanding the work you can do as a Volunteer ? Click <a href="volunteer_resp.php">Here</a></p>


<p>For enrolling as a Volunteer, please fill the registration form : </p>

<form action="#" method="post" enctype="multipart/form-data">	
	<p><label for="id_name">Name:</label> <input id="id_name" type="text" name="Name"/></p>
	<p><label for="id_address">Address:</label> <input id="id_address" type="text" name="address" /></p>
	<p><label for="id_city">City:</label><input id="id_city" type="text" name="city" /></p>
	<p><label for="id_state">State:</label><input id="id_state" type="text" name="state" /></p>
	<p><label for="id_country">Country:</label><input id="id_country" type="text" name="country" /></p>
	<p><label for="id_pin">PIN/ZIP code:</label><input id="id_country" type="text" name="country" /></p>
	<p><label for="id_largeimg">Large Img File:</label> <input type="file" name="largeimg" id="id_largeimg" /></p>
	<input type="submit" value="Upload" />
	</form>
<p>3. <b>Job Seekers</b> - If the cause inspires you and you would like to devote full time to Shiksha Sankalp, send us your resumes at jobs@shikshasankalp.org</p>
<!-- the content ends here -->
            
            </p>
  
        </div>
        
        
        <div id="extra_content">
		<?php
		include "dynamic.php";
		echo "</div>";
		include "footer.php";
		?>
