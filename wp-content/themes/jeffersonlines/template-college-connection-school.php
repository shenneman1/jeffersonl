<?php /* Template Name: College Connection School Template */ get_header(); ?>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- page_title -->
			<div class="page_title">
							<div class="page_title_bg_h1" style="padding-left: 125px;"><h1>College Connection</h1></div>
							<div class="page_title_bg_h2" style="padding-left: 125px;"><h2>On Campus Pickup and Dropoff</h2></div>
			</div>
			<!-- /page_title -->

			<!-- main_content -->
			<div id="post-<?php the_ID(); ?>" class="main_content">
				<!-- college connection emblem -->
				<img src="<?php echo get_template_directory_uri(); ?>/img/college-connection/cc-header.png" alt="jefferson Lines College Connection Emblem" style="position: absolute; top: 158px; left: -25px;" />
				<div class="timetable_left cc" style="color:#333;">
					<?php the_content(); ?>
				</div>
				<div class="timetable_right">
					<div id="signup-widget">
					<style type="text/css">#signup-widget p {
						font-size: 13px;
						color: black;
						font-weight: normal;
						margin: 1em 0 0 0;
					}
					#signup-widget input {
						margin: 0 !important;
					}
					#signup-widget button {
						border: none;
						background: #62b4f0;
						color: white;
						padding: 2px 5px !important;
						text-transform: uppercase;
						font-weight: bold;
						cursor: pointer;
						cursor: hand;
					}
					#signup-widget button:hover {
						background: #00c;
					}
					#signup-widget h2 {
						text-transform: uppercase;
					}
					</style>
					<h2>Sign Up For Deals &amp; News</h2>
					<form method="post" action="https://app.icontact.com/icp/signup.php" name="icpsignup" id="icpsignup4721" accept-charset="UTF-8" onsubmit="return verifyRequired4721();" >
					<input type="hidden" name="redirect" value="http://www.icontact.com/www/signup/thanks.html">
					<input type="hidden" name="errorredirect" value="http://www.icontact.com/www/signup/error.html">
					<input type="hidden" name="listid" value="80968">
					<input type="hidden" name="specialid:80968" value="SOR9">
					<input type="hidden" name="clientid" value="1151114">
					<input type="hidden" name="formid" value="4721">
					<input type="hidden" name="reallistid" value="1">
					<input type="hidden" name="doubleopt" value="0">
					<p><input type="text" name="fields_email" placeholder="E-mail address" size="25">
						<input type="text" name="fields_zip" placeholder="ZIP code" size="6">
						<button type="submit" name="Submit" value="Submit">Join Now</button></p>
					</form>
					<script type="text/javascript">
					var icpForm4721 = document.getElementById('icpsignup4721');
					if (document.location.protocol === "https:") {
						icpForm4721.action = "https://app.icontact.com/icp/signup.php";
					}
					function verifyRequired4721() {
						if (icpForm4721["fields_email"].value == "") {
							icpForm4721["fields_email"].focus();
							alert("The Email field is required.");
							return false;
						}
						if (icpForm4721["fields_zip"].value == "") {
							icpForm4721["fields_zip"].focus();
							alert("The Zip field is required.");
							return false;
						}
						return true;
					}
					</script>
					</div>
					<?php get_sidebar(); ?>
					<div class="timetable_grey_box">
						<table style="background: white; margin: 0 auto; width: auto;">
							<tr>
								<td style="padding: 2px; border: none; width: 118px; text-align: center;"><img src="<?php echo get_template_directory_uri(); ?>/img/college-connection/safe-drivers.jpg" alt=""></td>
								<td style="padding: 2px; border: none; width: 118px; text-align: center;"><img src="<?php echo get_template_directory_uri(); ?>/img/college-connection/campus-stops.jpg" alt=""></td>
								<td style="padding: 2px; border: none; width: 118px; text-align: center;"><img src="<?php echo get_template_directory_uri(); ?>/img/college-connection/student-discounts.jpg" alt=""></td>
							</tr>
							<tr>
								<td style="padding: 0 2px; border: none; text-align: center; text-transform: uppercase; vertical-align: top;">Safe &amp; Reliable Drivers</td>
								<td style="padding: 0 2px; border: none; text-align: center; text-transform: uppercase; vertical-align: top;">On-Campus Stops Only</td>
								<td style="padding: 0 2px; border: none; text-align: center; text-transform: uppercase; vertical-align: top;">15% Off for Students</td>
							</tr>
						</table>
						<div class="clear"></div>
					</div>
				</div>
				<!-- /timetable_right -->
				<div style="clear:both;"></div>


				<?php edit_post_link(); ?>

			</div>
			<!-- /end something -->

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>
<?php get_footer(); ?>
