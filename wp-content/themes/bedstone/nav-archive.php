<?php
/**
 * archive nav, for lists of posts
 *
 * @package Bedstone
 */

/**
 * Get pagination nav
 */
global $wp_query;
$big = 999999999;
$args = array(
    'base'               => str_replace($big, '%#%', get_pagenum_link($big)),
    'format'             => '?page=%#%',
    'total'              => $wp_query->max_num_pages,
    'current'            => max(1, get_query_var('paged')),
    'show_all'           => false,
    'end_size'           => 1,
    'mid_size'           => 1,
    'prev_next'          => true,
    'prev_text'          => '<i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Older',
    'next_text'          => 'Newer <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>',
    'type'               => 'plain',
    'add_args'           => false,
    'add_fragment'       => '',
    'before_page_number' => '',
    'after_page_number'  => ''
);
$pagination = paginate_links($args);
?>

<?php if ($pagination) : ?>
    <div class="nav-pagination clearfix hidden-print">
        <?php echo $pagination; ?>
    </div>
<?php endif; ?>
