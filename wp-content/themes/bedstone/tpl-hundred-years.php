<?php
/**
 * * Template Name: 100 Years Page
 */
get_header(); ?>

<div class="hundred-years-page">
	<?php

	// check if the flexible content field has rows of data
	if ( have_rows( 'hundred_years_sections' ) ) :

		// loop through the rows of data
		while ( have_rows( 'hundred_years_sections' ) ) : the_row();

			if ( get_row_layout() === 'hundred_years_banner' ) :
				$banner_media = get_sub_field( 'hundred_years_banner_media_type' );
				$banner_image = get_sub_field( 'hundred_years_banner_image' ); ?>
                <section class="hundred-year-banner">
                    <div class="banner-media">
						<?php if ( 'image' === $banner_media ) { ?>
                            <img src="<?php echo $banner_image['url']; ?>" alt="<?php echo $banner_image['alt']; ?>"/>
						<?php } else {
							$banner_video = get_sub_field( 'hundred_years_banner_video' ); ?>
                            <img src="<?php echo $banner_image['url']; ?>" alt="<?php echo $banner_image['alt']; ?>"/>
                            <div class="bg-video">
                                <video class="video-bg" autoplay muted loop preload="auto">
                                    <source src="<?php echo esc_url( $banner_video ); ?>" type="video/mp4">
                                </video>
                            </div>
						<?php } ?>
                    </div>
                </section>

			<?php elseif ( get_row_layout() === 'timeline' ) :
				$timeline_image = get_sub_field( 'timeline_image' );
				$timeline_content = get_sub_field( 'hundred_years_history_content' );
				$media_before = get_sub_field( 'media_before_content_image' );
				$media_before_url = get_sub_field( 'media_before_content_video_url' );
				$media_after = get_sub_field( 'media_with_content_image' );
				$media_after_url = get_sub_field( 'media_with_content_video_url' );
				$content_after = get_sub_field( 'media_with_content_text' );
				?>

                <section class="hundred-years-timeline">
                    <div class="container">
                        <div class="row">
							<?php if ( ! empty( $timeline_image ) ) : ?>
                                <div class="col-md-6 timeline-image wow fadeInLeft">
                                    <img src="<?php echo $timeline_image['url']; ?>"
                                         alt="<?php echo $timeline_image['alt']; ?>"/>
                                </div>
							<?php endif; ?>
                            <div class="col-md-6">
								<?php if ( ! empty( $media_before_url ) ) : ?>
                                    <div class="media-before with-video wow fadeInRight" data-wow-delay="0.2s">
                                        <a data-fancybox data-type="iframe"
                                           data-src="<?php echo esc_url( $media_before_url ); ?>" href="javascript:;">
                                            <img src="<?php echo $media_before['url']; ?>"
                                                 alt="<?php echo $media_before['alt']; ?>"/>
                                        </a>
                                    </div>
								<?php else: ?>
									<?php if ( ! empty( $media_before ) ) : ?>
                                        <div class="media-before wow fadeInRight" data-wow-delay="0.5s">
                                            <img src="<?php echo $media_before['url']; ?>"
                                                 alt="<?php echo $media_before['alt']; ?>"/>
                                        </div>
									<?php endif; ?>
								<?php endif; ?>
                                <div class="timeline-content">
									<?php echo wp_kses_post( $timeline_content ); ?>
                                </div>
                                <div class="bottom-content wow fadeInRight" data-wow-delay="0.2s">
									<?php if ( ! empty( $media_after_url ) ) : ?>

                                        <div class="media-after with-video">
                                            <img src="<?php echo $media_after['url']; ?>"
                                                 alt="<?php echo $media_before['alt']; ?>"/>
                                            <a data-fancybox data-type="iframe"
                                               data-src="<?php echo esc_url( $media_after_url ); ?>"
                                               href="javascript:;">
                                            </a>
                                        </div>

									<?php else: ?>
										<?php if ( ! empty( $media_after ) ) : ?>
                                            <div class="media-after">
                                                <img src="<?php echo $media_after['url']; ?>"
                                                     alt="<?php echo $media_after['alt']; ?>"/>
                                            </div>
										<?php endif; ?>
									<?php endif; ?>
                                    <div class="content-after">
										<?php echo wp_kses_post( $content_after ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


			<?php elseif ( get_row_layout() === 'three_column_count' ) : ?>

                <section class="three-column-count">
                    <div class="container">
						<?php if ( get_sub_field( 'section_title' ) ) : ?>
                            <h2 class="section-title"><?php the_sub_field( 'section_title' ); ?></h2>
						<?php endif; ?>
                        <div class="row">
							<?php if ( have_rows( 'repeater_content' ) ) : ?>

								<?php while ( have_rows( 'repeater_content' ) ) : the_row();
									$count_number    = get_sub_field( 'number_count' );
									$count_label     = get_sub_field( 'number_label' );
									$count_sub_title = get_sub_field( 'sub_title' );
									?>
                                    <div class="col-lg-4">

                                        <h2><span class="counter"><?php echo esc_attr( $count_number ) ?></span>
											<?php echo esc_attr( $count_label ); ?></h2>

                                        <h3><?php echo esc_attr( $count_sub_title ); ?></h3>

                                    </div>


								<?php endwhile; ?>

							<?php endif; ?>
                        </div>
                    </div>
                </section>

			<?php elseif ( get_row_layout() === 'three_image_blocks' ) :
				$three_image_bg = get_sub_field( 'section_background_color' );
				if ( 'white' === $three_image_bg ) {
					$bg_class = 'class="three-image-blocks bg-white"';
				} elseif ( 'blue' === $three_image_bg ) {
					$bg_class = 'class="three-image-blocks bg-dark-blue"';
				} else {
					$block_bg_image = get_sub_field( 'background_image' );
					$bg_class       = 'class="three-image-blocks bg-image" style="background-image: url(' . $block_bg_image['url'] . ')"';
				}
				$three_image_intro = get_sub_field( 'intro_content' );
				?>

                <section <?php echo $bg_class; ?>>
                    <div class="container">
                        <div class="row">
                            <div class="col-12 intro-content">
								<?php echo wp_kses_post( $three_image_intro ) ?>
                            </div>
							<?php if ( have_rows( 'columns_content' ) ) :
								$count = 0; ?>

								<?php while ( have_rows( 'columns_content' ) ) : the_row();
								$col_image   = get_sub_field( 'image' );
								$col_content = get_sub_field( 'content' );
								?>

                                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.<?php echo esc_attr( $count ) ?>s">


                                    <img src="<?php echo $col_image['url']; ?>"
                                         alt="<?php echo $col_image['alt']; ?>"/>

                                    <div class="three-block-content">
										<?php echo wp_kses_post( $col_content ); ?>
                                    </div>

                                </div>
								<?php $count ++;
							endwhile; ?>

							<?php endif; ?>

                        </div>
                    </div>
                </section>


			<?php elseif ( get_row_layout() === 'section_divider' ) : ?>

                <div class="section-divider-100">
                    <div class="container">
                        <hr>
                    </div>
                </div>


			<?php elseif ( get_row_layout() === 'full_width_content' ) :
				$full_width_content = get_sub_field( 'content' );
				?>

                <section class="full-width-content-100">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
								<?php echo wp_kses_post( $full_width_content ); ?>
                            </div>
                        </div>
                    </div>
                </section>


			<?php
            elseif ( get_row_layout() === 'accordion' ) :
				$accordion_intro_title = get_sub_field( 'hundred_years_accordion_title' );
				?>

                <section class="hundred-years-accordion">
                    <div class="container">
                        <div class="row">
                            <div class="accordion-section-title col-12">
								<?php echo wp_kses_post( $accordion_intro_title ); ?>
                            </div>
                            <div class="accordion col-12">
								<?php if ( have_rows( 'hundred_years_accordion' ) ) : ?>

									<?php while ( have_rows( 'hundred_years_accordion' ) ) : the_row();
										$accordion_row_title   = get_sub_field( 'accordion_title' );
										$accordion_sub_title   = get_sub_field( 'accordion_sub_title' );
										$accordion_row_image   = get_sub_field( 'image' );
										$accordion_row_content = get_sub_field( 'accordion_content' );
										?>

                                        <div class="accordion__row">
                                            <div class="accordion__title">
												<?php echo esc_attr( $accordion_row_title ); ?>
												<?php if ( ! empty( $accordion_sub_title ) ) : ?>
                                                    <span class="accordion_sub_title"><?php echo esc_html( $accordion_sub_title ); ?></span>
												<?php endif; ?>
                                            </div>
                                            <div class="accordion__content">
                                                <div class="row">
													<?php if ( ! empty( $accordion_row_image ) ) : ?>
                                                        <div class="col-md-6">
                                                            <img src="<?php echo $accordion_row_image['url']; ?>"
                                                                 alt="<?php echo $accordion_row_image['alt']; ?>"/>
                                                        </div>
                                                        <div class="accordion-content col-md-6">
															<?php echo wp_kses_post( $accordion_row_content ); ?>
                                                        </div>
													<?php else : ?>
                                                        <div class="accordion-content">
															<?php echo wp_kses_post( $accordion_row_content ); ?>
                                                        </div>
													<?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

									<?php endwhile; ?>

								<?php endif; ?>
                            </div>

							<?php if ( have_rows( 'hundred_years_accordion' ) ) : ?>

								<?php while ( have_rows( 'hundred_years_accordion' ) ) : the_row(); ?>

									<?php the_sub_field( '' ); ?>

								<?php endwhile; ?>

							<?php endif; ?>
                        </div>
                    </div>
                </section>

			<?php elseif ( get_row_layout() === 'hundred_years_testimonial_slider' ) :
				$hundred_years_extra_title = get_sub_field( 'hundred_years_testimonials_title' );
				?>

				<?php if ( have_rows( 'hundred_years_slider' ) ) : ?>
                <section class="extra-testimonials">
                    <div class="container">
                        <div class="extra-testimonials__heading">
                            <h3><?php echo esc_attr( $hundred_years_extra_title ); ?></h3>
                        </div>
                        <div class="extra-testimonials__interactive">
                            <div class="extra-testimonials__unslider">
                                <ul class="extra-testimonials__list">
									<?php while ( have_rows( 'hundred_years_slider' ) ) : the_row(); ?>
                                        <li class="extra-testimonials__item">
											<?php the_sub_field( 'hundred_years_charter_testimonial_quote' ); ?>
											<?php if ( '' !== get_sub_field( 'hundred_years_charter_testimonial_citation' ) ) : ?>
                                                <div class="extra-testimonials__citation">
													<?php the_sub_field( 'hundred_years_charter_testimonial_citation' ); ?>
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

			<?php elseif ( get_row_layout() === 'booking_cta' ) :
				get_template_part( 'inc', 'booking-module' );
			endif;

		endwhile;

	else :

		// no layouts found

	endif;

	?>
</div>

<?php get_footer(); ?>
