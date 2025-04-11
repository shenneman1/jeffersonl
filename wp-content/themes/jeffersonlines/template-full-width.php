<?php /* Template Name: Full Width Page Template */ get_header(); ?>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- page_title -->
			<div class="page_title">
							<div class="page_title_bg_h1"><h1><?php echo get_post_meta($post->ID, 'top-level-page-heading', true); ?></h1></div>
							<div class="page_title_bg_h2"><h2><?php echo get_post_meta($post->ID, 'second-level-page-heading', true); ?></h2></div>
			</div>
			<!-- /page_title -->

			<!-- main_content -->
			<div id="post-<?php the_ID(); ?>" class="main_content">
				<?php the_content(); ?>
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
