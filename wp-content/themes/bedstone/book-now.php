<?php
/**
 * Template Name: Booking
 *
 * @package Bedstone
 */

get_header();
?>

<div class="site-columns">
    <div class="container">

        <div class="columns">
            <main id="main" class="site-main col col-12" role="main">
                <?php
                // include mobile booking element if we are not excluding the page.
                $current_post_ancestors = get_post_ancestors(get_the_ID());
                if (get_the_ID() != PAGE_BOOK_NOW && !in_array(PAGE_COLLEGE_CONNECTION, $current_post_ancestors)) {
                    get_template_part('inc', 'mobile-booking-button');
                }

                get_template_part('inc', 'site-headline');

                while (have_posts()) {
                    the_post();
                    get_template_part('content');
                }
                if ('post' == get_post_type()) {
                    get_template_part('nav', 'posts');
                }
                ?>
            </main>
        </div>

    </div>
</div>

<?php get_footer(); ?>
