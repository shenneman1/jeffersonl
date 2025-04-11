<?php
/**
 * wysiwyg functions
 *
 * @package Bedstone
 */

/**
 * Custom MCE editor blockformats
 *     ** this should come BEFORE any other MCE-related functions
 */
add_filter('tiny_mce_before_init', 'bedstone_editor_items');
function bedstone_editor_items($init)
{
    // Add block format elements you want to show in dropdown
    $init['block_formats'] = 'Paragraph=p; Heading (h2)=h2; Sub-heading (h3)=h3';
    // Disable unnecessary items and buttons
    $init['toolbar1'] = 'bold,italic,alignleft,aligncenter,alignright,bullist,numlist,outdent,indent,link,unlink,hr'; // 'template,|,bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv',
    $init['toolbar2'] = 'formatselect,pastetext,removeformat,charmap,undo,redo,wp_help,styleselect'; // 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help',
    // Display the kitchen sink by default
    $init['wordpress_adv_hidden'] = false;
    // [optional] Add elements not included in standard tinyMCE dropdown
    //$init['extended_valid_elements'] = 'code[*]';
    return $init;
}

/**
 * Advanced Custom Fields: Custom MCE editor blockformats
 */
add_filter('acf/fields/wysiwyg/toolbars', 'bedstone_acf_editor_items');
function bedstone_acf_editor_items($toolbars)
{
    if (isset($toolbars['Full'][2])) {
        $toolbars['Full'][2][] = 'styleselect';
    }
    return $toolbars;
}
