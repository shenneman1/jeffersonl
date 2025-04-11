<?php
/**
 * default catch all
 *
 * author
 * category
 * custom post type archive
 * custom taxonomy archive
 * date archive -- year, month, day
 * search results
 * tag archive
 *
 * @package Bedstone
 */

get_header();
?>

<div class="site-columns">
    <div class="container">

        <div class="columns">
            <main id="main" class="site-main col col-lg-<?php echo COLS_MAIN; ?>" role="main">
                <?php
                get_template_part('inc', 'mobile-booking-button');

                get_template_part('inc', 'site-headline');

                if (is_search()) {
                    // get_search_form();
                }
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        // do not show homepage in results
                        if ( get_the_id() != PAGE_HOME ) {
                            get_template_part('content', 'list');
                        }
                    }
                    get_template_part('nav', 'archive');
                } else {
                    get_template_part('content', 'none');
                }
                ?>
            </main>
            <?php get_sidebar(); ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>
