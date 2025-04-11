<?php
// Make $acf_options object available (from functions.php)
global $acf_options;

$bg_img_full = $acf_options->booking_mod_bg_img["url"];

// iframe for booking
$iframe_src = 'https://webstore.tdstickets.com/step1_small/4314?redirect=' . ENV_TDS_URL_ENCODE;
if (defined('ENV_PAGE_TDS_TEST_MODULE') && ENV_PAGE_TDS_TEST_MODULE == get_the_ID()) {
    // TDS tests per Ron
    $iframe_src = 'https://node.stage.tdstickets.com/step1_small/4314?redirect=https%3A%2F%2Fwww.jeffersonlines.com%2Fbook-now-test';
}

// iframe breakpoint for Home is slightly different
$iframe_lazyLoadWidth = (PAGE_HOME == get_the_ID()) ? 767 : 991;
?>

<section id="booking" tabindex="-1" class="banner-booking banner-booking--large" style="background-image: url(<?php echo $bg_img_full; ?>)">
<div class="banner-booking__btns">
        <a class="banner-booking__btn icon-marker" href="https://ride.jeffersonlines.com/#/authentication/login?queryParams=undefined" target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/sign-in-icon.svg" alt="Sign in icon" /> SIGN IN/MANAGE TRIPS</a></a>
        <a class="banner-booking__btn icon-marker" href="https://ride.jeffersonlines.com/#/authentication/CreateAccount" target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/account-plus.png"  alt="Create account icon"/> Create Account</a></a>
        <a class="banner-booking__btn icon-marker" href="https://ride.jeffersonlines.com/#/findboardingpasses?queryParams=undefined" target="_blank"><img class="magnifying-glass" src="<?php echo get_template_directory_uri();?>/images/find-boarding-pass.png"  alt="Find boarding pass search icon"/> Find Boarding Pass</a></a>
        <a class="banner-booking__btn icon-marker" href="https://www.jeffersonlines.com/jefferson-mobile-app/bus-tracker/"><img src="<?php echo get_template_directory_uri();?>/images/bus-tracker-icon.svg"  alt="Bus tracker clock icon"/> Bus Tracker</a>
    </div>
    <div class="container">
        <div class="banner-booking__iframe-wrap iframe-wrapper">
        <iframe title="yourname search form iframe" src="https://ride.jeffersonlines.com/#/searchformiframe" width="100%" height="550px"></iframe>
        </div>

    </div>
</section>
