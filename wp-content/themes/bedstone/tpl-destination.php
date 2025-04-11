<?php
/**
 * Template Name: Travel Destination
 */

get_header();
?>

<div class="site-columns">
    <div class="container">
        <?php
        get_template_part('inc', 'mobile-booking-button');
        get_template_part('inc', 'site-headline');

        if ( get_field('travel_intro') ) {
            echo '<div class="travel__intro">';
            echo get_field('travel_intro');
            echo '</div>';
        }
        ?>

        <div class="columns">
            <main id="main" class="site-main col col-lg-8" role="main">
                <?php
                while (have_posts()) {
                    the_post();
                    get_template_part('content-destination');
                }
                if ('post' == get_post_type()) {
                    get_template_part('nav', 'posts');
                }
                ?>
            </main>
            <?php get_sidebar('travel-destination'); ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>
