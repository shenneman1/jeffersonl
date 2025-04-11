<?php /* Template Name: Homepage Page Template */ get_header(); ?>

<?php get_header(); ?>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- page_title -->
			<div class="page_title">
							<div class="page_title_bg_h1"><h1><?php echo get_post_meta($post->ID, 'top-level-page-heading', true); ?></h1></div>
							<div class="page_title_bg_h2"><h2><?php echo get_post_meta($post->ID, 'second-level-page-heading', true); ?></h2></div>
			</div>
			<!-- /page_title -->

			<!-- main_content -->
			<div class="main_content">
				<!-- promo -->
				<div id="promo">
                  <?php get_sidebar(); ?>
                  <div id="aboutticketing">
                      <h1>Bus-Tracker</h1>
                      <p style="text-align: center;">Use Bus-Tracker to get
                      the status and estimated arrival time of your
                      bus.<br></p>

                      <div style="text-align: center;">
                          <b><a href=
                          "http://tds1.saucontech.com/jefferson-forecasting/findmybusexternal.html"
                          style="font-size: 24px;" target="_blank">
                          <table align="center" border="0" cellpadding="2"
                          cellspacing="2" style="width: 60%;">
                              <tbody>
                                  <tr>
                                      <td style="background-color: #0C4073">
                                          <p style=
                                          "font-size: 14px; text-align: center">
                                          Check Now</p>
                                      </td>
                                  </tr>

                                  <tr>
                                      <td></td>
                                  </tr>
                              </tbody>
                          </table></a></b>

                          <p></p>
                      </div>
                  </div>

                  <div id="announce">
                      <h1>Service Announcement</h1>

                      <p class="p1" style="text-align: center">
                      <strong><a style="color:red;" href="/information/" target=
                      "_self">Click Here - ALL ANNOUNCEMENTS</a></strong></p>
                  </div>

                  <div id="map">
                      <a href="/locations/"><img alt=
                      "Discover your next destination!" src=
                      "<?php echo get_template_directory_uri(); ?>/img/route-maps.png"></a>
                  </div>

                  <div style="clear: both;"></div>
                </div>
								<!-- /promo -->

								<div class="page_title" style="padding-top: 0; position: absolute; top: 220px; left: 626px; width: 354px; height: 622px;">
									<div class="page_title_bg_h2" style="width: 354px;">
											<h2><?php echo get_post_meta($post->ID, 'additional-second-level-heading', true); ?></h2>
									</div>

									<div style="background: white; width: 354px; height: 567px; clip: rect(0, 354px, 567px, 0); overflow: hidden;">

										<div class="home_widget_signup_wrapper">
											<div class="home_wrapper home_widget_signup">
												<div class="grid fit">
													<div id="home-signup-widget">
														<h2>SIGN UP FOR DEALS &amp; NEWS:</h2>
														<div class="body-div">
															<div class="div_to">
															<form id="icpsignup4721" accept-charset="UTF-8" action="https://app.icontact.com/icp/signup.php" method="post" name="icpsignup" target="_blank"><input name="redirect" type="hidden" value="https://www.jeffersonlines.com/email-signup-thank-you-page/" /><input name="errorredirect" type="hidden" value="http://www.icontact.com/www/signup/error.html" /><input name="listid" type="hidden" value="81370" /><input name="specialid:81370" type="hidden" value="KQHR" /><input name="clientid" type="hidden" value="1151114" /><input name="formid" type="hidden" value="4721" /><input name="reallistid" type="hidden" value="1" /><input name="doubleopt" type="hidden" value="0" /><input id="signup_input" name="fields_email" type="text" placeholder="Enter your email address.." /><input maxlength="5" name="fields_zip" size="5" type="text" placeholder="Zip Code" /><input id="signup_submit" type="submit" value="Join Now" /></form>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

												<?php the_content(); ?>
                  </div>
                </div>


				<?php edit_post_link(); ?>

			</div>
			<!-- /main_content -->

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>

<?php get_footer(); ?>