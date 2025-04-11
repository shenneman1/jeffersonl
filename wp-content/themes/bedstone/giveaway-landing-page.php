<?php
/**
 * Template Name: Giveaway Landing Page
 */

get_header();
?>

<div class="site-columns">
    <div class="container">
        <?php
        get_template_part('inc', 'mobile-booking-button');
        get_template_part('inc', 'site-headline');

        if ( get_field('travel_intro2') ) {
            echo '<div class="travel__intro">';
            echo get_field('travel_intro2');
            echo '</div>';
        }
        ?>

        <div class="columns">
            <main class="site-main col col-lg-8" role="main">

				<div class="videoWrapper">
			        <?php if( get_field('giveaway_video') ): ?>
			            <?php the_field('giveaway_video'); ?>
			        <?php endif; ?>
				</div>
				<style>
				.videoWrapper {
					position: relative;
					padding-bottom: 56.25%; 
					/* 16:9 */padding-top: 25px; 
					height: 0;
					margin-bottom: 40px;
				}
				.videoWrapper iframe {
					position: absolute;
					top: 0;
					left: 0;
					width: 100%;
					height: 100%;
				}
				</style>

				<div style="margin: 40px 0 50px;">
                	<?php get_template_part('inc', 'giveaway-signup-module'); ?>
            	</div>

                <?php
                while (have_posts()) {
                    the_post();
                    get_template_part('content');
                }
                if ('post' == get_post_type()) {
                    get_template_part('nav', 'posts');
                }
                ?>

				<div class="content">
					<h2>Winners</h2>
					<?php echo do_shortcode('[wpaft_logo_slider category="giveaway-2019"]'); ?>
				</div>
				<hr>
				<div class="content" style="margin: 40px 0 70px;">
			        <?php if( get_field('giveaway_terms') ): ?>
			            <?php the_field('giveaway_terms'); ?>
			        <?php endif; ?>
			    </div>

            </main>
            <?php get_sidebar('giveaway-landing-page'); ?>
        </div>

    </div>
</div>

<?php get_footer('giveaway-landing-page'); ?>
