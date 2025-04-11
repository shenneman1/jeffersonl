<?php
/**
 * Windmill branding
 *
 * @package Bedstone
 */

/**
 * Login branding
 */
add_action('login_enqueue_scripts', 'bedstone_login_css');
function bedstone_login_css()
{
    echo "<style>\n";
    echo 'body.login div#login h1 a {';
    echo "background: url('" . get_bloginfo('template_directory') . "/branding/windmill-login-cobrand.png');";
    echo 'background-size: 276px 77px;';
    echo 'width: 276px;';
    echo 'height: 77px;';
    echo "} \n";
    echo '</style>';
}
add_filter('login_headerurl', 'bedstone_login_logo_url');
function bedstone_login_logo_url()
{
    return 'http://www.windmilldesign.com';
}
add_filter('login_headertitle', 'bedstone_login_logo_url_title');
function bedstone_login_logo_url_title()
{
    return 'Windmill Design';
}

/**
 * Admin footer branding
 */
add_action('in_admin_footer', 'bedstone_admin_footer');
function bedstone_admin_footer()
{
    echo '<p style="margin-top: 1em; margin-bottom: .8em;">';
    echo '<img alt="" style="display: inline-block; margin: 0 2px -3px 0;" src="' . get_bloginfo('template_directory') . '/branding/windmill-footer-mark.png" />';
    echo 'Website Design and Development by <a target="_blank" style="color: rgb(205, 65, 44);" href="http://www.windmilldesign.com">Windmill Design</a>';
    if (defined('DOCUMENTATION_LINK') && '' != DOCUMENTATION_LINK) {
        echo ' &mdash; <a target="_blank" href="' . DOCUMENTATION_LINK . '">Site Documentation</a>';
    }
    echo '</p>';
}
