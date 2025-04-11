<?php
/**
 * sidebar
 *
 * @package Bedstone
 */

?>

<aside class="sidebar sidebar--travel col col-lg-4" role="complementary">

    <div class="sidebar-item sidebar__travel-links" style="margin-top: 0;">
        <?php if( get_field('giveaway_custom_sidebar') ): ?>
            <?php the_field('giveaway_custom_sidebar'); ?>
        <?php endif; ?>
    </div>

    <div class="sidebar-item sidebar-booking hidden-print">
        <div class="sidebar-booking__img" style="background-image: url(https://www.jeffersonlines.com/wp-content/uploads/jefferson-lines-100-years.jpg); height: 270px;"></div>
           	<div class="sidebar-booking__content">
                <h3 class="sidebar-booking__heading">100 Years of Jefferson Lines</h3>
                <a class="trigger-booking btn btn--fancy" href="#">Learn More <i class="fa fa-chevron-circle-right"></i></a>
            </div>
    </div>

</aside>
