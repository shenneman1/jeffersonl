<?php
// Make $acf_options object available (from functions.php)
global $acf_options;

// build social nav as one string for mmenu
$nav_social_html = '';
$nav_social_html .= '<ul class="social__list">';
if ( $acf_options->global_twitter ) {
    $nav_social_html .= '<li class="social__item"><a href="' . $acf_options->global_twitter . '" target="rel"><i class="fa fa-twitter"  aria-hidden="true" title="Twitter"></i><span class="screen-reader-text">Twitter</span></a></li>';
}
if ( $acf_options->global_facebook ) {
    $nav_social_html .= '<li class="social__item"><a href="' . $acf_options->global_facebook . '" target="rel"><i class="fa fa-facebook"  aria-hidden="true" title="Facebook"></i><span class="screen-reader-text">Facebook</span></a></li>';
}
if ( $acf_options->global_youtube ) {
    $nav_social_html .= '<li class="social__item"><a href="' . $acf_options->global_youtube . '" target="rel"><i class="fa fa-youtube"  aria-hidden="true" title="Youtube"></i><span class="screen-reader-text">Youtube</span></a></li>';
}
if ( $acf_options->global_instagram ) {
	$nav_social_html .= '<li class="social__item"><a href="' . $acf_options->global_instagram . '" target="rel"><i class="fa fa-instagram" aria-hidden="true" title="Instagram"></i><span class="screen-reader-text">Instagram</span></a></li>';
}
$nav_social_html .= '</ul>';

$mmenuBookingHtml = '';
$mmenuSearchHtml = '';
$mmenuPhoneHtml = '';
$mmenuSocialHtml = '';

// mobile booking
$mmenuBookingHtml .= '<div class="mobile-booking">';
$mmenuBookingHtml .= '<a class="btn booking-link--mobile" href="https://ride.jeffersonlines.com/#/">Book Now <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>';
$mmenuBookingHtml .= '</div>';

// mobile search
$mmenuSearchHtml .= '<div class="header-search search--mobile">';
$mmenuSearchHtml .= '<form class="header-search__form" role="search" method="get" action="'. home_url('/').'">';
$mmenuSearchHtml .= '<input class="header-search__field" type="text" name="s" placeholder="Search" title="Search" value="'. get_search_query() .'">';
$mmenuSearchHtml .= '<button class="header-search__btn" type="submit" title="Submit Search"><i class="fa fa-search" aria-hidden="true"></i></button>';
$mmenuSearchHtml .= '</form>';
$mmenuSearchHtml .= '</div>';

// mobile phone
$mmenuPhoneHtml .= '<div class="mobile-phone">';
$mmenuPhoneHtml .= '<a class="click-to-call" href="tel:<?php echo $acf_options->global_main_phone; ?>">';
$mmenuPhoneHtml .= '<i class="fa fa-phone" aria-hidden="true"></i>'. $acf_options->global_main_phone;
$mmenuPhoneHtml .= '</a>';
$mmenuPhoneHtml .= '</div>';


// mobile Social
$mmenuSocialHtml .= '<div class="social--mobile">';
$mmenuSocialHtml .= $nav_social_html;
$mmenuSocialHtml .= '</div>';
?>

<?php if ( has_nav_menu( 'mobile' ) ) : ?>

<?php endif; ?>


<div class="nav-mobile__wrap">
    <?php echo $mmenuBookingHtml;
    echo '<div class="mobile-menu-title"><span>Menu</span></div>';

        wp_nav_menu(
	        array(
		        'depth' => 1,
		        'container' => 'nav',
		        'container_class' => 'justify-content-end align-items-center',
		        'container_id' => 'mobile_menu',
		        'menu_class' => 'mobile_menu-container',
		        'menu_id' => 'mobile_menu',
		        'theme_location' => 'mobile',
		        'depth'           => 2,
	        )
        );
        ?>

    <div class="nav_footer">
        <?php echo $mmenuSearchHtml;
        echo $mmenuPhoneHtml;
        echo $mmenuSocialHtml;?>
    </div>
</div>
