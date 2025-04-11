<?php
/**
 * * Template Name: Testimonials Page
 */
get_header(); ?>

<div class="site-columns testimonials-page">
    <div class="container">
		<?php
		get_template_part('inc', 'site-headline');

		while (have_posts()) {
			the_post();
			get_template_part('content');
		}
		?>

        <div class="columns">
            <main id="main" class="site-main col col-lg-8" role="main">
                <?php
                $media_type = get_field('testimonial_media_type');
                if ( 'image' === $media_type) {
	                $intro_image = get_field('intro_image'); ?>
                    <img src="<?php echo $intro_image['url']; ?>" alt="<?php echo $intro_image['alt']; ?>" />
                <?php }

                else{ ?>
	                <div class='embed-container'>
                    <iframe title='<?php the_field('testimonial_video_title'); ?>' src='<?php the_field('testimonial_video'); ?>' frameborder='0' allowfullscreen></iframe>
                </div>
                <?php } ?>
                <div class="other-info">
                    <?php the_field('info_paragraph'); ?>
                </div>
                <div class="employee-testimonials">
                    <?php if ( have_rows( 'testimonials' ) ) : ?>

                        <h2><?php the_field('testimonials_title'); ?></h2>

                        <?php while ( have_rows( 'testimonials' ) ) : the_row(); ?>

                            <div class="testimonial-row">
                                <?php $image = get_sub_field('image'); ?>
	                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                                <div class="testimonial-info">
                                    <h3><?php the_sub_field('citation');?></h3>
                                    <p><?php the_sub_field('quote'); ?></p>
                                </div>
                            </div>

                        <?php endwhile; ?>

                    <?php endif; ?>
                </div>
            </main>
			<?php get_sidebar('testimonials-sidebar'); ?>
        </div>

    </div>
	<?php if (have_rows('testimonials_slider')) :
		$extra_title = get_field('testimonials_slider_title');
		?>
        <section class="extra-testimonials">
            <div class="container">
                <div class="extra-testimonials__heading">
					<?php echo esc_attr( $extra_title ) ?>
                </div>
                <div class="extra-testimonials__interactive">
                    <div class="extra-testimonials__unslider">
                        <ul class="extra-testimonials__list">
							<?php while (have_rows('testimonials_slider')) : the_row(); ?>
                                <li class="extra-testimonials__item">
									<?php the_sub_field('testimonial_quote'); ?>
									<?php if ('' != get_sub_field('testimonial_citation')) : ?>
                                        <div class="extra-testimonials__citation">
											<?php the_sub_field('testimonial_citation'); ?>
                                        </div>
									<?php endif; ?>
                                </li>
							<?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
	<?php endif; ?>
    <section class="cta-testimonials">
        <div class="container">
            <?php

            $link = get_field('cta_button');

            if( $link ): ?>
                <a class="btn btn--fancy button" href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ); ?>"><?php echo esc_attr( $link['title'] ); ?>
                    <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                </a>

            <?php endif; ?>
            <div class="contact-info">
                <?php the_field('contact_info'); ?>
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>
