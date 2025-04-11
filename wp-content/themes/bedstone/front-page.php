<?php
/**
 * front page
 *
 * @package Bedstone
 */

$acf_home = (object) get_fields( PAGE_HOME );

$home_cta_class = ( $acf_home->home_cta_img ) ? 'home-cta--has-img' : 'home-cta--no-img';

$bottom_class         = ( $acf_home->home_bottom_img ) ? 'home-bottom--has-img' : 'home-bottom--no-img';
$bottom_content_class = ( $acf_home->home_bottom_img ) ? 'col-lg-12' : 'col-12';

get_header(); ?>
<main id="main" class="site-main" role="main">
	<?php get_template_part( 'inc', 'booking-module' );
	get_template_part( 'inc', 'mobile-booking-banner' );
	?>

	<?php while ( have_posts() ) : the_post(); ?>


        <section class="page-features">
        <?php
                /**
                 * Buckets Block
                 */
                $classes = '';
                if ( ! empty( $block['className'] ) ) {
                    $classes = ' ' . $block['className'];
                }

                $anchor = '';
                if ( ! empty( $block['anchor'] ) ) {
                    $anchor = ' id="' . sanitize_title( $block['anchor'] ) . '"';
                }

                $bucket_content = get_field( 'bucket_content' );
                ?>

                <section class="buckets pt-5<?php echo $classes ?>"<?php echo $anchor; ?>>
                    <?php if ( ! empty( $bucket_content ) ) : ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <?php echo wp_kses_post( $bucket_content ); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    $bucket_repeater = get_field( 'buckets' );
                    $bucket_count = count( $bucket_repeater );
                    if ( have_rows( 'buckets' ) ) : ?>
                        <div class="container">
                            <div class="columns home-bottom__cols">
                                <?php while ( have_rows( 'buckets' ) ) : the_row(); ?>
                                    <?php
                                    $bucket_img = get_sub_field( 'bucket_image');
                                    $bucket_content = get_sub_field( 'bucket_content' );
                                    $bucket_link = get_sub_field( 'bucket_link' );
                                    ?>
                                    <div class="single-bucket col col-md-3 col-6 mb-md-0 mb-4" style="text-align:center;">
                                                <?php
                                                    if( $bucket_img ) {
                                                        echo wp_get_attachment_image( $bucket_img, 'full', "", ["class" => "mb-3"] );
                                                    }
                                                ?>
                                                <div class="links-container">
                                                    <div class="copy-container">
                                                        <?php echo wp_kses_post( $bucket_content ); ?>
                                                    </div>
                                                    <?php if ( ! empty( $bucket_link ) ) : ?>
                                                    <span class="btn btn--fancy bucket-btn"><?php echo $bucket_link['title'] ?></span>
                                                 </div>
                                            <?php endif; ?>
                                            <?php if ( ! empty( $bucket_link ) ) :
                                            $bucket_link_target = $bucket_link['target'] ? $bucket_link['target'] : '_self';
                                            ?>
                                            <a class="coverall-link" href="<?php echo esc_url( $bucket_link['url'] ); ?>" target="<?php echo $bucket_link_target; ?>"><span class="sr-only">Go to page</span></a>  
                                        <?php endif; ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </section>
        </section>

        <section class="home-bottom <?php echo $bottom_class; ?>">
            <div class="container">
                <div class="columns home-bottom__cols">
					<?php if ( $acf_home->home_bottom_img ) : ?>
                        <div class="col col-md-4 col-lg-12 col-xl-offset-1 home-bottom__img">
                            <img src="<?php echo $acf_home->home_bottom_img; ?>" alt="">
                        </div>
					<?php endif; ?>
                    <div class="col <?php echo $bottom_content_class; ?> home-bottom__content">
                        <h2 class="home-bottom__heading"><?php echo $acf_home->home_bottom_heading; ?></h2>
                        <div class="home-bottom__desc">
							<?php echo $acf_home->home_bottom_desc; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>


	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
