<?php
/**
 * navigation functions
 *
 * @package Bedstone
 */

/**
 * Nav child pages shortcode
 * [child_pages parent="25" exclude="58,74"] ... returns children of 25 excluding 58 and 74
 *
 * @param array Atts
 * @param string Content if the shortcode wraps content
 *
 * @return string HTML output child nav
 */
add_shortcode('child_pages', 'bedstone_child_pages_shortcode');
function bedstone_child_pages_shortcode($atts = array(), $content = '')
{
    extract(shortcode_atts(array(
        'exclude' => '',
        'parent' => get_the_ID(),
    ), $atts));
    $child_pages = wp_list_pages(array(
        'exclude' => $exclude,
        'child_of' => $parent,
        'depth' => 1,
        'sort_column' => 'menu_order, title',
        'title_li' => '',
        'echo' => 0,
    ));
    return "\n<ul class='nav-child-pages-shortcode'>\n" . $child_pages . "</ul>\n\n" . do_shortcode($content);
}

/**
 * Breadcrumbs array
 *
 * @return array Breadrumbs string name, optional string link
 */
function bedstone_get_breadcrumbs()
{
    $breadcrumbs = array();
    $page_on_front = get_option('page_on_front');
    $page_for_posts = get_option('page_for_posts', true);

    // initialize with front page
    if ($page_on_front && !is_front_page()) {
        $breadcrumbs[] = array(
            'name' => get_the_title($page_on_front),
            'link' => get_permalink($page_on_front),
        );
    }

    if ($page_for_posts && is_home()) {
        $breadcrumbs[] = array('name' => get_the_title($page_for_posts));
    } elseif (is_404()) {
        $breadcrumbs[] = array('name' => 'Page Not Found');
    } elseif (is_search()) {
        $breadcrumbs[] = array('name' => 'Search Results');
    } elseif ($page_for_posts && !is_tax() && (is_single() || is_archive())) {
        $breadcrumbs[] = array(
            'name' => get_the_title($page_for_posts),
            'link' => get_permalink($page_for_posts),
        );
        if (is_category()) {
            $breadcrumbs[] = array('name' => single_cat_title('', false));
        } elseif (is_tag()) {
            $breadcrumbs[] = array('name' => single_tag_title('', false));
        }
    } elseif (!is_front_page()) {
        $ancestors = get_ancestors(get_the_ID(), 'page');
        $ancestors = array_reverse($ancestors);
        foreach ($ancestors as $ancestor) {
            $breadcrumbs[] = array(
                'name' => get_the_title($ancestor),
                'link' => get_permalink($ancestor),
            );
        }
        $breadcrumbs[] = array('name' => get_the_title());
    }
    return $breadcrumbs;
}

/**
 * Family tree
 *
 * @param int Page ID
 *
 * @return string Nav list items
 */
function bedstone_get_family_tree($id = null)
{
    if (null === $id) {
        $id = get_the_ID();
    }
    $family = '';
    $nav_ids = array();
    if (is_page()) {
        $children = new WP_Query(array(
            'post_type' => 'page',
            'nopaging' => true,
            'post_parent' => $id,
            'fields' => 'ids',
        ));
        if (!empty($children->posts)) {
            $nav_ids = array_merge(
                $children->posts,
                array($id)
            );
        } else {
            $parent = wp_get_post_parent_id($id);
            if (!empty($parent)) {
                $siblings = new WP_Query(array(
                    'post_type' => 'page',
                    'nopaging' => true,
                    'post_parent' => $parent,
                    'fields' => 'ids',
                ));
                if (!empty($siblings->posts)) {
                    $nav_ids = array_merge(
                        $siblings->posts,
                        array($parent)
                    );
                }
            }
        }
        if (!empty($nav_ids)) {
            asort($nav_ids);
            $family = wp_list_pages(array(
                'include' => implode(',', $nav_ids),
                'title_li' => '',
                'sort_column' => 'post_parent, menu_order',
                'echo' => false,
            ));
        }
    }
    return $family;
}
