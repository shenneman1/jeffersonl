<?php
/**
 * attachment
 * custom post type
 * blog post
 * page
 *
 * @package Bedstone
 */

get_header();
?>

<div class="site-columns">
    <div class="container">

        <!-- <?php if (is_page(28)) { ?>
            <div class="banner-booking__btns">
                <a class="banner-booking__btn icon-marker"
                    href="https://ride.jeffersonlines.com/#/authentication/login?queryParams=undefined" target="_blank"><img
                        src="<?php echo get_template_directory_uri(); ?>/images/sign-in-icon.svg" alt="Sign in icon" /> SIGN
                    IN/MANAGE TRIPS</a></a>
                <a class="banner-booking__btn icon-marker"
                    href="https://ride.jeffersonlines.com/#/authentication/CreateAccount" target="_blank"><img
                        src="<?php echo get_template_directory_uri(); ?>/images/account-plus.png"
                        alt="Create account icon" /> Create Account</a></a>
                <a class="banner-booking__btn icon-marker"
                    href="https://ride.jeffersonlines.com/#/findboardingpasses?queryParams=undefined" target="_blank"><img
                        class="magnifying-glass"
                        src="<?php echo get_template_directory_uri(); ?>/images/find-boarding-pass.png"
                        alt="Find boarding pass search icon" /> Find Boarding Pass</a></a>
                <a class="banner-booking__btn icon-marker"
                    href="https://www.jeffersonlines.com/jefferson-mobile-app/bus-tracker/"><img
                        src="<?php echo get_template_directory_uri(); ?>/images/bus-tracker-icon.svg"
                        alt="Bus tracker clock icon" /> Bus Tracker</a>
            </div>
            <div class="container">
                <div class="banner-booking__iframe-wrap iframe-wrapper" style="height:200px;">
                    <iframe title="yourname search form iframe" src="https://ride.jeffersonlines.com/#/searchformiframe"
                        width="100%" height="550px"></iframe>
                </div>

            </div>
        <?php } ?> -->
        <div class="columns">
            <main id="main" class="site-main col col-lg-<?php echo COLS_MAIN; ?>" role="main">
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
            <?php get_sidebar(); ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>