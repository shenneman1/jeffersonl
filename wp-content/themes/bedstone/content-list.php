<?php
/**
 * content output, list
 *
 * @package Bedstone
 */

// set thumb url
$has_thumb = false;
if (!is_search() && has_post_thumbnail()) {
    $thumb_url_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail-size', true);
    $thumb_url = $thumb_url_array[0];
    $has_thumb = true;
}
?>

<article <?php post_class('list-article clearfix ' . ($has_thumb ? 'list-article--has-thumb' : 'list-article--no-thumb')); ?> id="post-<?php the_ID(); ?>">

    <?php if ($has_thumb) : ?>
        <a href="<?php the_permalink(); ?>">
            <div class="list-article__thumb" style="background-image: url('<?php echo $thumb_url ?>');"></div>
        </a>
    <?php endif; ?>

    <div class="list-article__content">
        <header class="article-header">
            <h2 class="article-header__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php if ('post' == get_post_type()) { get_template_part('nav', 'article-meta'); } ?>
        </header>

        <div class="content">
            <?php echo get_the_excerpt() . '&nbsp;&nbsp;'; ?>
            <span class="call-to-action"><a href="<?php echo get_the_permalink(); ?>">Read More <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a></span>
        </div>
    </div>

</article>
