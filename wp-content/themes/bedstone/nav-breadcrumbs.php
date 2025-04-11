<?php
/**
 * breadcrumb nav
 *
 * @package Bedstone
 */

$breadcrumbs = bedstone_get_breadcrumbs();
?>

<?php if (!empty($breadcrumbs)) : ?>
    <nav class="nav-breadcrumbs hidden-print" aria-label="breadcrumbs">
        <ul class="nav-breadcrumbs__list">
            <?php
            foreach ($breadcrumbs as $crumb) {
                echo '<li>';
                echo !empty($crumb['link']) ? '<a href="' . $crumb['link'] . '">': '<span>';
                echo $crumb['name'];
                echo !empty($crumb['link']) ? '</a>' : '</span>';
                echo '</li>';
            }
            ?>
        </ul>
    </nav>
<?php endif; ?>
