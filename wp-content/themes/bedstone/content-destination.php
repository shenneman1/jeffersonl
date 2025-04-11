<?php
/**
 * content output, destination
 *
 * @package Bedstone
 */
?>

<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php if ('post' == get_post_type()) : ?>
        <header class="article-header">
            <h1 class="article-header__title"><?php the_title(); ?></h1>
            <?php get_template_part('nav', 'article-meta'); ?>
        </header>
    <?php endif; ?>

    <?php
    if ('post' == get_post_type()) {
        get_template_part('inc', 'social-share');
    }
    ?>

    <div class="content clearfix">
        <?php the_content(); ?>
    </div>

    <?php get_template_part('variant', 'after-content'); ?>

    <?php // comments_template(); ?>

</div>
