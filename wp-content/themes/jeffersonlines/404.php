<?php get_header(); ?>

		<!-- page_title -->
		<div class="page_title">
			<div class="page_title_bg_h1"><h1>404</h1></div>
			<div class="page_title_bg_h2"><h2>Page not found</h2></div>
		</div>
		<!-- /page_title -->
		<div class="main_content">
			<div class="timetable_left">
				<div class="timetable_left_section">
					<h2>
						<a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'html5blank' ); ?></a>
					</h2>
					<p>The resource you are looking for has been removed, had its name changed, or is temporarily unavailable.</p>
				</div>
			</div>
			<div class="timetable_right">
				<?php get_sidebar(); ?>
				<div class="timetable_grey_box">
					<div class="clear"></div>
				</div>
			</div>
			<!-- /timetable_right -->
			<div style="clear:both;"></div>
		</div>
		<!-- /main_content -->

<?php get_footer(); ?>
