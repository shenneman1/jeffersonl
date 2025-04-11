<?php /* Template Name: Location Page Template */ get_header(); ?>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- page_title -->
			<div class="page_title">
							<div class="page_title_bg_h1"><h1>Jefferson Lines Bus Service</h1></div>
							<div class="page_title_bg_h2"><h2>Service Locations in <?php the_title(); ?></h2></div>
			</div>
			<!-- /page_title -->

			<!-- main_content -->
			<div class="main_content">
				<div class="bus_service_left">
					<h4>Scheduled Bus Service: 800-451-5333</h4>
					<div class="bus_service_locations">
<ul>
	<li><a href="/locations/arkansas/">Arkansas</a></li>
	<li><a href="/locations/iowa/">Iowa</a></li>
	<li><a href="/locations/kansas/">Kansas</a></li>
</ul>
<ul>
	<li><a href="/locations/minnesota/">Minnesota</a></li>
	<li><a href="/locations/missouri/">Missouri</a></li>
	<li><a href="/locations/montana/">Montana</a></li>
</ul>
<ul>
	<li><a href="/locations/nebraska/">Nebraska</a></li>
	<li><a href="/locations/north-dakota/">North Dakota</a></li>
	<li><a href="/locations/oklahoma/">Oklahoma</a></li>
</ul>
<ul>
	<li><a href="/locations/south-dakota/">South Dakota</a></li>
	<li><a href="/locations/texas/">Texas</a></li>
	<li><a href="/locations/wisconsin/">Wisconsin</a></li>
	<li><a href="/locations/wyoming/">Wyoming</a></li>
</ul>
						<div style="clear:both;"></div>
					</div>
					<!-- /bus_service_locations -->
				</div>
				<!-- /bus_service_left -->
				<div class="bus_service_right">
					<div class="icon_col"><img src="<?php echo get_template_directory_uri(); ?>/img/icon_passenger_stop.png" alt="Passenger stop"></div>
					<div class="desc_col">Passenger stop</div>
					<div class="clear"></div>
					<div class="icon_col"><img src="<?php echo get_template_directory_uri(); ?>/img/icon_tickets_sold.png" alt="Tickets Sold at location"></div>
					<div class="desc_col">Tickets sold at location</div>
					<div class="clear"></div>
					<div class="icon_col"><img src="<?php echo get_template_directory_uri(); ?>/img/icon_package.png" alt="Package shipping location"></div>
					<div class="desc_col">Package shipping location</div>
					<div class="clear"></div>
					<div class="icon_col"><img src="<?php echo get_template_directory_uri(); ?>/img/icon_college.png" alt="College Connection location"></div>
					<div class="desc_col">College Connection location</div>
					<div class="clear"></div>
				</div><!-- END right area -->
				<div style="clear:both;"></div>

					<!-- start locations table -->
					<h3><?php the_title(); ?></h3>
						<?php the_content(); ?>
					<p class="note" style="color: #585858; font-size: 13px; margin: 0.5em 0 0 0;">* Locations with hours of "Meets bus" are unstaffed during the day, but a representative will be present when a bus is scheduled to arrive.</p>
				</div>

				<!-- end Locations table -->
				<?php edit_post_link(); ?>

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>

<?php get_footer(); ?>
