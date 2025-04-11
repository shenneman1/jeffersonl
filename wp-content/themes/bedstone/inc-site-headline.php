<?php
/**
 * site-wide include
 *
 * @package Bedstone
 */

 if(is_page(73)) {
    $secondary_headline = 'secondary-headline';
 } else {
    $secondary_headline = '';
 }
?>
<div class="site-headline <?php echo $secondary_headline ?>">
    <?php get_template_part('nav', 'breadcrumbs'); ?>
    <h1 class="headline-title">
        <?php
            if (is_page()) {
                the_title();
            } elseif (is_single()) {
                // use section, e.g. "Blog" or "News"
                $posts_section_title = bedstone_get_posts_section_title();
                echo !empty($posts_section_title) ? $posts_section_title : get_the_title();
            } elseif (is_404()) {
                echo 'Page Not Found (404)';
            } elseif (is_search()) {
                echo 'Results for: ' . get_search_query();
            } elseif (is_category()) {
                single_cat_title();
            } elseif (is_tag()) {
                single_tag_title();
            } elseif (is_author()) {
                echo 'Author: ' . get_the_author();
            } elseif (is_day()) {
                echo 'Archive: ' . get_the_date('l, F j, Y');
            } elseif (is_month()) {
                echo 'Archive: ' . get_the_date('j Y');
            } elseif (is_year()) {
                echo 'Archive: ' . get_the_date('Y');
            } elseif (is_search()) {
                echo 'Results for: ' . get_search_query();
            } elseif (is_home() && is_front_page()) {
                // Settings > Reading > Front Page Displays > Your Latest Posts
                echo get_bloginfo('name');
            } elseif (is_home()) {
                // Settings > Reading > Front Page Displays > Static Page > Posts Page
                echo get_the_title(get_option('page_for_posts', true));
            } else {
                echo 'Archives';
            }
        ?>
    </h1>
</div>
