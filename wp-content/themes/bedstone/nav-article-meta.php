<?php
/**
 * meta for posts
 *
 * @package Bedstone
 */

//$meta_author = get_the_author();
$meta_date = get_the_date();
$meta_categories = get_the_category_list(', ');
$meta_tags = get_the_tag_list('', ', ');
//$meta_comments = (comments_open() || '0' != get_comments_number()) ? get_comments_link() : '';
?>

<?php if ($meta_author || $meta_date || $meta_categories || $meta_tags) : ?>
    <div class="nav-article-meta">
        <ul class="nav-article-meta__list">
            <?php
            echo ($meta_date) ? '<li>' . $meta_date . '</li>' : '';
            echo ($meta_categories) ? '<li>' . $meta_categories . '</li>' : '';
            echo ($meta_tags) ? '<li>' . $meta_tags . '</li>' : '';
            ?>
        </ul>
    </div>
<?php endif; ?>
