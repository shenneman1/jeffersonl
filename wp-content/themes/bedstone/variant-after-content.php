<?php
/**
 * Additional features after the main content <div>
 */


if ( wp_get_post_parent_id( get_the_id() ) == PAGE_BUS_STOPS ) {
    get_template_part('inc', 'bus-stop-table');
}


if ( get_the_id() == PAGE_BOOK_NOW || get_the_id() == PAGE_BOOK_NOW_GROUP_1 || get_the_id() == PAGE_BOOK_NOW_GROUP_2 ) {
    get_template_part('inc', 'booking-page-iframe');
}


if ( get_the_id() == PAGE_BUS_TRACKER ) {
    get_template_part('inc', 'bus-tracker-iframe');
}


if (defined('ENV_PAGE_TDS_TEST_BOOK') && ENV_PAGE_TDS_TEST_BOOK == get_the_ID()) {
    // TDS tests per Ron
    get_template_part('inc', 'booking-page-iframe');
}
