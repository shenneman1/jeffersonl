<?php
/**
 * 404
 *
 * @package Bedstone
 */

get_header();
?>

<div class="site-columns">
    <div class="container">

        <div class="columns">
            <main id="main" class="site-main col col-lg-<?php echo COLS_MAIN; ?>" role="main">
                <?php get_template_part('inc', 'site-headline'); ?>
                <div class="content">
                    <p class="callout">We're sorry. We could not find the page you requested.</p>
                    <p class="call-to-action"><a href="/">Visit Our Homepage</a></p>
                </div>
                <?php get_search_form(); ?>
            </main>
            <?php get_sidebar(); ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>
