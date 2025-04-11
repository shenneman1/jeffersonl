<?php
/**
 * sidebar
 *
 * @package Bedstone
 */

// Make $acf_options object available (from functions.php)
//global $acf_options;
$link = get_field('testimonial_sidebar_button');
$image = get_field('testimonial_sidebar_image');
$text = get_field('testimonial_sidebar_text');
?>

<aside class="sidebar sidebar--testimonial col col-lg-4" role="complementary">

    <div class="testimonial-lists">
        <?php if ( have_rows( 'testimonial_sidebar_lists' ) ) : ?>

            <?php while ( have_rows( 'testimonial_sidebar_lists' ) ) : the_row();
            $list_title = get_sub_field( 'lists_title' );
            $list_icon = get_sub_field('icon');
            ?>

                <div class="title">
                    <i class="fa fa-<?php echo esc_attr( $list_icon ); ?>" aria-hidden="true"></i>
                    <h2><?php echo esc_attr( $list_title ); ?></h2>
                </div>

                <div class="list">
                    <?php $list = get_sub_field('list'); ?>
                    <?php echo wp_kses_post( $list );?>
                </div>

            <?php endwhile; ?>

        <?php endif; ?>
    </div>

    <div class="sidebar-item sidebar-booking hidden-print">
        <div class="sidebar-booking__img" role="img" aria-label="Person using Jefferson Lines mobile app for contactless travel." style="background-image: url(<?php echo $image['url']; ?>)"></div>
        <div class="sidebar-booking__content">
            <h2 class="sidebar-booking__heading"><?php echo esc_attr( $text ); ?></h2>
            <a class="btn btn--fancy" href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ); ?>"><?php echo esc_attr( $link['title'] ); ?><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
        </div>
    </div>

</aside>