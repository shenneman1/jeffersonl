<?php
/**
 * posts nav, for linking to next post in a series
 *
 * @package Bedstone
 */

$prev = get_previous_post_link('%link', '<i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Older');
$next = get_next_post_link('%link', 'Newer <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>');
?>

<?php if ($prev || $next) : ?>
    <div class="nav-prevnext hidden-print">
        <ul>
            <?php
            echo ($prev) ? '<li class="nav-item-prev">' . $prev . '</li>' : '';
            echo ($next) ? '<li class="nav-item-next">' . $next . '</li>' : '';
            ?>
        </ul>
    </div>
<?php endif; ?>
