<?php
/**
 * Template Name: Charter
 */

$fields = (object) get_fields();

// test if there is contact data to be displayed
$charter_contact = $fields->charter_contact_name . $fields->charter_contact_email . $fields->charter_contact_phone_local . $fields->charter_contact_phone_toll_free;
$charter_has_contact = !empty($charter_contact);

get_header();
?>

<div class="site-columns">
    <div class="container">

        <div class="columns">
			
            <main id="main" class="site-main col col-lg-12" role="main">

                <?php
                get_template_part('inc', 'site-headline'); ?>
                <div class="charter-form">
                    <h2 id="request_a_quote" class="charter-form__heading">Request a Charter Quote</h2>
                    <div class="charter-form__gravity-form">
                        <img src="<?php echo esc_url( site_url( '/wp-content/uploads/CHARTER-QUOTE-IMAGE.png' ) ); ?>" alt="Charters Bus"/>
                        <a class="btn" href="https://charters.jeffersonlines.com" target="_blank" style="display: block; text-align: center;">Request A Quote</a>
			            <?php //echo do_shortcode('[gravityform id="2" title="false" description="false" ajax="true"]'); ?>
                    </div>
                </div>
	            <?php while (have_posts()) {
                    the_post();
                    get_template_part('content');
                }
                ?>

                <?php if ( have_rows('charter_ftr_rep') ) : ?>
                    <section class="charter-features">
                        <?php
                        $ftrs_heading = get_field('charter_ftr_heading');
                        $ftrs_footnote = get_field('charter_ftr_footnote');

                        echo ($ftrs_heading) ? '<h3 class="charter-features__heading">' . $ftrs_heading . '</h3>' : '';
                        echo '<ul class="charter-features__list">';

                        while ( have_rows('charter_ftr_rep') ) {
                            the_row();
                            echo '<li class="charter-features__item">';
                            echo '<img src="' . get_sub_field('img') . '">';
                            the_sub_field('name');
                            echo '</li>';
                        }

                        echo '</ul>';
                        echo ($ftrs_footnote) ? '<p class="charter-features__note">' . $ftrs_footnote . '</p>' : '';
                        ?>
                    </section>
                <?php endif; ?>	
				

                <?php if ( have_rows('charter_gallery_rep') ) : ?>
                    <div class="charter-gallery">
                        <?php while ( have_rows('charter_gallery_rep') ) : the_row(); ?>
                            <div class="charter-gallery__img" style="background-image: url(<?php echo get_sub_field('img'); ?>);"></div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
				
            </main>
		</div>
			<div class="charter-buttons-container" style="text-align: left; margin-top: -1.250em; margin-bottom: 30px; width: 100%;">
				<p class="charter-button"
				   style="max-width: 400px; height: 40px; background-color: #c00e30; border-radius: 5px; transition: background-color 0.3s ease;"
				   onmouseover="this.style.backgroundColor='#981b1e'"
				   onmouseout="this.style.backgroundColor='#c00e30'">
					<a href="https://www.jeffersonlines.com/charters/charter-bus-rental-minneapolis/"
					   class="charter-link"
					   style="display: flex; align-items: center; justify-content: center; height: 100%; padding: 0 20px; color: white;">
					   <span><strong>Minneapolis Charter Bus Rental</strong></span>
					</a>
				</p>
				<p class="charter-button"
				   style="max-width: 400px; height: 40px; background-color: #c00e30; border-radius: 5px; transition: background-color 0.3s ease;"
				   onmouseover="this.style.backgroundColor='#981b1e'"
				   onmouseout="this.style.backgroundColor='#c00e30'">
					<a href="https://www.jeffersonlines.com/charters/charter-bus-rental-billings/"
					   class="charter-link"
					   style="display: flex; align-items: center; justify-content: center; height: 100%; padding: 0 20px; color: white;">
					   <span><strong>Billings Charter Bus Rental</strong></span>
					</a>
				</p>
			</div>
			<img src="<?php echo esc_url( site_url( '/wp-content/uploads/Overhead-Storage-1.png' ) ); ?>" alt="Charters Banner" style="padding-bottom:10px; padding-top: 10px;"/>
        </div>
		

    </div>


<?php if (have_rows('charter_testimonials')) : ?>
    <section class="charter-testimonials">
        <div class="container">
            <div class="charter-testimonials__heading">What Our Customers Say</div>
            <div class="charter-testimonials__interactive">
                <div class="charter-testimonials__unslider">
                    <ul class="charter-testimonials__list">
                        <?php while (have_rows('charter_testimonials')) : the_row(); ?>
                            <li class="charter-testimonials__item">
                                <?php the_sub_field('charter_testimonial_quote'); ?>
                                <?php if ('' != get_sub_field('charter_testimonial_citation')) : ?>
                                    <div class="charter-testimonials__citation">
                                        <?php the_sub_field('charter_testimonial_citation'); ?>
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endwhile; ?>
                        <li class="charter-testimonials__item charter-testimonials__item--cta">
                            We look forward to working with you.
                            <div class="charter-testimonials__item--button">
                                <a href="#request_a_quote" class="btn">Request a Quote <i class="fa fa-chevron-circle-right"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>


<?php if (have_rows('charter_catalog_rep')) : ?>
    <section class="charter-catalog">
        <div class="container">
            <?php
            $catalog_heading = get_field('charter_catalog_heading');
            $catalog_subhead = get_field('charter_catalog_subhead');

            echo ($catalog_heading) ? '<h2 class="charter-catalog__heading">' . $catalog_heading . '</h2>' : '';
            echo ($catalog_subhead) ? '<h3 class="charter-catalog__subhead">' . $catalog_subhead . '</h3>' : '';

            echo '<div class="charter-catalog__items">';
            while (have_rows('charter_catalog_rep')) {
                the_row();
                $catalog_img = get_sub_field('image');
                $catalog_img = $catalog_img['sizes']['large'];
                $catalog_item_class = ($catalog_img) ? 'charter-catalog__item--has-img' : 'charter-catalog__item--no-img';

                echo '<div class="charter-catalog__item clearfix ' . $catalog_item_class . '">';
                echo ($catalog_img) ? '<div class="charter-catalog__img" style="background-image: url(' . $catalog_img . ');"></div>' : '';
                echo '<div class="charter-catalog__content content">' . get_sub_field('editor') . '</div>';
                echo '</div>';
            }
            echo '</div>';
            ?>
        </div>
    </section>
<?php endif; ?>


<?php if (have_rows('charter_service_areas')) : ?>
    <section class="charter-service-areas">
        <h2 class="charter-service-areas__heading">Learn More About Our Service Areas</h2>
        <div class="charter-service-areas__list container">
            <?php while (have_rows('charter_service_areas')) : the_row(); ?>
                <div class="charter-service-areas__item">
                    <a class="charter-service-areas__link" href="<?php the_sub_field('charter_service_area_page'); ?>">
                        <img class="charter-service-areas__image" alt="" src="<?php the_sub_field('charter_service_area_image'); ?>">
                        Rent a Charter From <span style="white-space:nowrap;"><?php the_sub_field('charter_service_area_name'); ?> <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></span>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
<?php endif; ?>


<?php if ($charter_has_contact) : ?>
    <div class="charter-contact">
        <div class="charter-contact__cta">
            <a href="https://charters.jeffersonlines.com/" target="_blank" class="btn btn--fancy">Request a Quote <i class="fa fa-chevron-circle-right"></i></a>
        </div>
        <div class="charter-contact__info">
            <?php if (!empty($fields->charter_contact_name)) : ?>
                <strong>
                    <?php
                    echo $fields->charter_contact_name;
                    echo !empty($fields->charter_contact_job_title) ? ', ' . $fields->charter_contact_job_title : '';
                    ?>
                </strong>
            <?php endif; ?>
            <?php
            echo !empty($fields->charter_contact_phone_local) ? '<br>Phone: ' . $fields->charter_contact_phone_local : ''; // no click-to-call; may include extension
            echo !empty($fields->charter_contact_phone_toll_free) ? '<br>Toll Free: ' . $fields->charter_contact_phone_toll_free : ''; // no click-to-call; may include extension
            echo !empty($fields->charter_contact_email) ? '<br>Email: <a href="mailto:' . $fields->charter_contact_email . '">' . $fields->charter_contact_email . '</a>' : '';
            ?>
        </div>
    </div>
<?php endif; ?>

<?php get_footer(); ?>
