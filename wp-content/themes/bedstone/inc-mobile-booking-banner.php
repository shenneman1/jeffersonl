<?php
// Make $acf_options object available (from functions.php)
global $acf_options;

$bg_img_sm = $acf_options->booking_mod_bg_img_sm["url"];
?>


<section id="booking" class="banner-booking banner-booking--mobile" style="background-image: url(<?php echo $bg_img_sm; ?>)">
<div class="container">
        <h2 class="banner-booking__heading"><?php echo $acf_options->booking_mod_heading; ?></h2>
        <h3 class="banner-booking__subheading"><?php echo $acf_options->booking_mod_subheading; ?></h3>
        <div class="banner-booking__btns">
            <a class="banner-booking__btn icon-marker" href="https://ride.jeffersonlines.com/#/authentication/login?queryParams=undefined" target="_blank">Sign in/ Manage Trips</a>
            <a class="banner-booking__btn icon-marker" href="https://ride.jeffersonlines.com/#/authentication/CreateAccount" target="_blank">Create Account</a>
            <a class="banner-booking__btn icon-marker" href="https://ride.jeffersonlines.com/#/findboardingpasses?queryParams=undefined" target="_blank">Find Boarding Pass</a>
            <a class="banner-booking__btn icon-marker" href="https://www.jeffersonlines.com/jefferson-mobile-app/bus-tracker/">Bus Tracker</a>
        </div>
        <div class="banner-booking__iframe-wrap iframe-wrapper">
            <iframe title="yourname search form iframe" src="https://ride.jeffersonlines.com/#/searchformiframe" width="100%" height="750px"></iframe>
        </div>
    </div>
</section>
<a class="banner-booking__phone" href="tel:<?php echo $acf_options->global_main_phone; ?>"><?php echo $acf_options->global_main_phone; ?></a>
