<?php
/**
 * theme pack functions
 *
 * @package Bedstone
 */

require 'inc/helpers.php';
require 'inc/session.php';
require 'inc/updates.php';
require 'inc/branding.php';
require 'inc/analytics.php';
require 'inc/editor.php';
require 'inc/comments.php';
require 'inc/nav.php';
require 'inc/shortcodes.php';

/**
 * Remove the admin bar if SHOW_ADMIN_BAR constant is false
 */
if (defined('SHOW_ADMIN_BAR') && !SHOW_ADMIN_BAR) {
    add_filter('show_admin_bar', '__return_false');
}

/**
 * Remove emoji introduced in WP 4.2
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/**
 * add page id column to Admin views
 */
add_action('admin_head', 'bedstone_admin_id_column_style');
function bedstone_admin_id_column_style()
{
    echo "<style>\n"
       . ".fixed .column-pid { width: 10%; }
          </style>
          ";
}
add_action('admin_init', 'bedstone_admin_id_column');
function bedstone_admin_id_column()
{
    // page
    add_filter('manage_pages_columns', 'bedstone_pid_column');
    add_action('manage_pages_custom_column', 'bedstone_pid_value', 10, 2);
    // post
    add_filter('manage_posts_columns', 'bedstone_pid_column');
    add_action('manage_posts_custom_column', 'bedstone_pid_value', 10, 2);
    // users
    add_filter('manage_users_columns', 'bedstone_pid_column');
    add_action('manage_users_custom_column', 'bedstone_pid_return_value', 10, 3);
    // taxonomy
    foreach(get_taxonomies() as $tax) {
        add_action('manage_edit-' . $tax . '_columns', 'bedstone_pid_column');
        add_filter('manage_' . $tax . '_custom_column', 'bedstone_pid_return_value', 10, 3);
    }
}
function bedstone_pid_column($cols)
{
    $cols['pid'] = 'ID';
    return $cols;
}
function bedstone_pid_value($column, $id)
{
    if ($column == 'pid') {
        echo $id;
    }
}
function bedstone_pid_return_value($value, $column, $id)
{
    if ($column == 'pid') {
        $value = $id;
    }
    return $value;
}

/**
 * Filter title for trademarks
 * Replaces reg and tm with html superscript element and html chars
 */
if (!is_admin()) {
    // does not filter in the admin area
    add_filter('the_title', 'bedstone_title_trademarks');
}
function bedstone_title_trademarks($title)
{
    $title = str_replace('&copy;', '<sup>&copy;</sup>', $title);
    $title = preg_replace('/\x{00A9}/u', '<sup>&copy;</sup>', $title);
    $title = str_replace('&reg;', '<sup>&reg;</sup>', $title);
    $title = preg_replace('/\x{00AE}/u', '<sup>&reg;</sup>', $title);
    $title = str_replace('&trade;', '<sup>&trade;</sup>', $title);
    $title = preg_replace('/\x{2122}/u', '<sup>&trade;</sup>', $title);
    $title = str_replace('&#8480;', '<sup>&#8480;</sup>', $title); // service mark
    $title = preg_replace('/\x{2120}/u', '<sup>&#8480;</sup>', $title); // service mark
    return $title;
}

/**
 * Filter body class
 */
add_filter('body_class', 'bedstone_body_class');
function bedstone_body_class($classes)
{
    $root_parent = false;
    if (is_front_page()) {
        $root_parent = 'front-page';
    } elseif (is_home()) {
        $root_parent = 'home';
    } elseif (is_category()) {
        $root_parent = 'category';
    } elseif (is_tag()) {
        $root_parent = 'tag';
    } elseif (is_author()) {
        $root_parent = 'author';
    } elseif (is_day() || is_month() || is_year()) {
        $root_parent = 'date';
    } elseif (is_search()) {
        $root_parent = 'search';
    } elseif ('post' == get_post_type()) {
        $root_parent = 'post';
    } elseif ('page' == get_post_type()) {
        $root_parent = bedstone_get_the_root_parent();
    }
    if ($root_parent) {
        $classes[] = 'root-parent-' . $root_parent;
    }
    return $classes;
}

/**
 * Display favicon meta
 *
 * @link https://sites.google.com/a/windmilldesign.com/development/blade-sites/dev-specs/favicons
 * @link http://realfavicongenerator.net/
 *
 * @param array Args [Safari pinned tab color, MS tile color, Theme color] as hex values
 *
 * @return void
 */
function bedstone_favicons($args = array())
{
    $args = wp_parse_args($args, array(
        'safariPinnedTabColor' => '#ffffff',
        'msTileColor' => '#ffffff',
        'themeColor' => '#ffffff',
    ));
    $dir = get_bloginfo('template_directory') . '/favicons';
    echo "
    <link rel='shortcut icon' href='$dir/favicon.ico' type='image/x-icon' />
    <link rel='icon' href='$dir/favicon.ico' type='image/x-icon' />
    <link rel='apple-touch-icon' sizes='57x57' href='$dir/apple-touch-icon-57x57.png'>
    <link rel='apple-touch-icon' sizes='60x60' href='$dir/apple-touch-icon-60x60.png'>
    <link rel='apple-touch-icon' sizes='72x72' href='$dir/apple-touch-icon-72x72.png'>
    <link rel='apple-touch-icon' sizes='76x76' href='$dir/apple-touch-icon-76x76.png'>
    <link rel='apple-touch-icon' sizes='114x114' href='$dir/apple-touch-icon-114x114.png'>
    <link rel='apple-touch-icon' sizes='120x120' href='$dir/apple-touch-icon-120x120.png'>
    <link rel='apple-touch-icon' sizes='144x144' href='$dir/apple-touch-icon-144x144.png'>
    <link rel='apple-touch-icon' sizes='152x152' href='$dir/apple-touch-icon-152x152.png'>
    <link rel='apple-touch-icon' sizes='180x180' href='$dir/apple-touch-icon-180x180.png'>
    <link rel='icon' type='image/png' href='$dir/favicon-32x32.png' sizes='32x32'>
    <link rel='icon' type='image/png' href='$dir/android-chrome-192x192.png' sizes='192x192'>
    <link rel='icon' type='image/png' href='$dir/favicon-96x96.png' sizes='96x96'>
    <link rel='icon' type='image/png' href='$dir/favicon-16x16.png' sizes='16x16'>
    <link rel='manifest' href='$dir/manifest.json'>
    <link rel='mask-icon' href='$dir/safari-pinned-tab.svg' color='" . $args['safariPinnedTabColor'] . "'>
    <meta name='msapplication-TileColor' content='" . $args['msTileColor'] . "'>
    <meta name='msapplication-TileImage' content='$dir/mstile-144x144.png'>
    <meta name='theme-color' content='" . $args['themeColor'] . "'>
    ";
}

/**
 * Get the root parent
 *
 * @param int $id Post id
 *
 * @return int Post id of the root-most parent
 */
function bedstone_get_the_root_parent($id = false)
{
    $root = 0;
    if (!$id) {
        global $post;
        $id = isset($post->ID) ? $post->ID : 0;
    }
    $ancestors = get_post_ancestors($id);
    if (!empty($ancestors)) {
        $root = end($ancestors);
    } else {
        $root = $id;
    }
    return $root;
}
function bedstone_the_root_parent($id = false)
{
    echo bedstone_get_the_root_parent($id);
}

/**
 * Determine if posts should use alternate title as the document title, e.g. "Blog" for a blog section
 *
 * @return string Title or empty string
 */
function bedstone_get_posts_section_title()
{
    $ret = '';
    if ('post' == get_post_type()) {
        $section_title = get_the_title(get_option('page_for_posts', true));
        if ('' != $section_title) {
            $ret = $section_title;
        }
    }
    return $ret;
}
