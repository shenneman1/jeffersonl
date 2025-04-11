<?php
/**
 * wp update functions
 *
 * @package Bedstone
 */

/**
 * Auto-update settings
 * @link https://codex.wordpress.org/Configuring_Automatic_Background_Updates
 *
 * Although not specifically referenced, plugins SHOULD recieve exploit updates
 * when the WordPress Security Team pushes a critical update.
 */
add_filter('automatic_updates_is_vcs_checkout', '__return_false', 1); // allow updates in version-controlled directories
add_filter('allow_major_auto_core_updates', '__return_false'); // disallow major core updates
add_filter('allow_minor_auto_core_updates', '__return_true'); // allow major core updates
//wp_maybe_auto_update(); // un-comment to force updates
