<?php
/**
 * sidebar
 *
 * @package Bedstone
 */

// Make $acf_options object available (from functions.php)
global $acf_options;

// get pages nav
if (is_page()) {
    $family_tree = bedstone_get_family_tree();
}
?>

<aside class="sidebar col col-lg-<?php echo COLS_SIDEBAR; ?>" role="complementary">

    <?php if ( get_the_id() != PAGE_BOOK_NOW) if(!is_page(28)) : ?>
        <div class="sidebar-item sidebar-booking hidden-print">
            <div class="sidebar-booking__img" style="background-image: url(<?php echo $acf_options->global_sidebar_booking_img; ?>);"></div>
            <div class="sidebar-booking__content">
                <h2 class="sidebar-booking__heading"><?php echo $acf_options->global_sidebar_booking_heading; ?></h2>
                <a class="trigger-booking btn btn--fancy" style="padding:0.5em 3.5em 0.5em 1em;"href="#booking">Search
                <div class="button-circle-sidebar">
                    <svg aria-hidden="true" role="img" focusable="false" viewBox="0 0 24 24" style="height: 24px; width:24px; margin-left:-12.5px; margin-top:3px; position:absolute;" class="q-icon notranslate"><path d="M0 0h24v24H0z" style="fill: none;"></path><path style="fill:#c00e30;" d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"></path></svg>
                </div></a>
            </div>
        </div>
    <?php endif; ?>


    <?php if (!empty($family_tree)) : ?>
        <!-- <nav class="sidebar-item nav-family-tree hidden-print">
            <h4>Pages</h4>
            <ul class="nav-family-tree__list">
                <?php // echo $family_tree; ?>
            </ul>
        </nav> -->
    <?php endif; ?>


    <!-- <?php if (is_home() || is_single() || is_category() || is_tag() || is_date()) : ?>
        <nav class="sidebar-item sidebar-item--shadow nav-categories hidden-print" aria-label="Categories">
            <h2 class="nav-categories__heading">Categories</h2>
            <ul class="nav-categories__list">
                <?php 
                // wp_list_categories( array(
                //     'title_li' => '',
                    
                // )); 

                $all_categories = get_categories( array(
                    'orderby' => 'name'
                ));

                foreach($all_categories as $categories_item) {
                    echo '<li class="cat-item">' . '<a href="' . esc_url( get_category_link( $categories_item-> term_id ) ) . '">' . esc_html( $categories_item->name ) . '<i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
                };
                
                
                ?>
            </ul>
        </nav>
    <?php endif; ?> -->

</aside>
