<?php
/**
 * comments functions
 *
 * @package Bedstone
 */

add_filter('comment_form_default_fields', 'bedstone_comment_form_default_fields');
function bedstone_comment_form_default_fields($fields)
{
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $html5 = (current_theme_supports('html5', 'comment-form')) ? true : false;
    $author = '<div class="comment-form__group">'
            . '<input class="comment-form__field" name="author" size="30" type="text" placeholder="Name' . ($req ? ' (required)' : '') . '" value="' . esc_attr($commenter['comment_author']) . '">'
            . '</div>';
    $email = '<div class="comment-form__group">'
           . '<input class="comment-form__field" name="email" size="30" type="' . ($html5 ? 'email' : 'text') . '" placeholder="Email' . ($req ? ' (required)' : '') . '" value="' . esc_attr($commenter['comment_author_email']) . '">'
           . '</div>';
    $url = '<div class="comment-form__group">'
         . '<input class="comment-form__field" name="url" size="30" type="' . ($html5 ? 'url' : 'text') . '" placeholder="Website URL" value="' . esc_attr($commenter['comment_author_url']) . '">'
         . '</div>';
    $fields = array($author, $email, $url);
    return $fields;
}

add_filter('comment_form_defaults', 'bedstone_comment_form_defaults');
function bedstone_comment_form_defaults($args)
{
    $rand = rand(1000, 9999); // for element ids
    $args['comment_field'] = '<div class="comment-form__group">'
                           . '<textarea class="comment-form__textarea" name="comment" placeholder="Comment" cols="35" rows="5"></textarea>'
                           . '</div>';
    return $args;
}

add_action('comment_form', 'bedstone_comment_form');
function bedstone_comment_form()
{
    echo '<button class="" type="submit">Submit</button>';
}
