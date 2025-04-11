<?php
/**
 * social share for the current post
 */

// values
$share_title = (is_front_page()) ? get_bloginfo('name') : get_the_title();

// standard encode
$encoded_title = urlencode($share_title);
$encoded_blogname = urlencode(get_bloginfo('name'));
$encoded_link = urlencode(get_permalink());
$encoded_tweet = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8') . ': ' . get_permalink());

// raw encode
$encoded_title_raw = rawurlencode($share_title);
$encoded_blogname_raw = rawurlencode(get_bloginfo('name'));
$encoded_link_raw = rawurlencode(get_permalink());

// links
$facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_link;
$twitter = 'https://twitter.com/home?status=' . $encoded_tweet;
$pinterest = 'https://www.pinterest.com/pin/create/button/';
$google = 'https://plus.google.com/share?url=' . $encoded_link;
$linkedin = 'https://www.linkedin.com/shareArticle?mini=true&amp;url=' . $encoded_link . '&amp;title=' . $encoded_title . '&amp;summary=&amp;source=';
$email = 'mailto:?subject=' . $encoded_blogname_raw . rawurlencode(': ') . $encoded_title_raw . '&amp;body=' . $encoded_title_raw . rawurlencode("\r\n") . $encoded_link_raw;
?>

<div class="social-share hidden-print">
    <span class="social-share__label">Share:</span>
    <a class="social-share__link" rel="external" href="<?php echo $facebook; ?>" aria-label="Share to Facebook"><i class="fab fab-facebook-alt"></i></a>
    <a class="social-share__link" rel="external" href="<?php echo $twitter; ?>" aria-label="Share to Twitter"><i class="fab fab-twitter"></i></a>
    <a class="social-share__link" data-pin-do="buttonBookmark" data-pin-custom="true" href="<?php echo $pinterest; ?>" aria-label="Save to Pinterest"><i class="fab fab-pinterest-alt"></i></a>
    <script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
    <a class="social-share__link" rel="external" href="<?php echo $linkedin; ?>" aria-label="Share to LinkedIn"><i class="fab fab-linkedin-alt"></i></a>
    <a class="social-share__link" rel="external" href="<?php echo $email; ?>" aria-label="Email link to this post"><i class="btr bt-envelope"></i></a>
</div>
