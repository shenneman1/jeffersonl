<?php
/**
 * sidebar
 *
 * @package Bedstone
 */

// Make $acf_options object available (from functions.php)
//global $acf_options;

function travel_links( $link_repeater ) {
	$list_html = '';
	if ( have_rows( $link_repeater ) ) {
		$list_html .= '<ul class="travel-links__list">';

		while ( have_rows( $link_repeater ) ) {
			the_row();
			$list_html .= '<li>';
			$list_html .= '<a href="' . get_sub_field( 'link_dest' ) . '" rel="external">';
			$list_html .= get_sub_field( 'link_label' );
			$list_html .= '<span aria-hidden="true">&#187;</span>';
			$list_html .= '</a>';
			$list_html .= '</li>';
		}

		$list_html .= '</ul>';
	}

	return $list_html;
}

?>

<aside class="sidebar sidebar--travel col col-lg-4" role="complementary">

    <!-- <?php if ( true ) : ?>
        <a class="btn btn--fancy trigger-booking sidebar-booking--small" href="#booking">Book Now <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
    <?php endif; ?>
     -->


    <div class="container">
        <div class="banner-booking__iframe-wrap iframe-wrapper">
            <iframe title="yourname search form iframe" src="https://ride.jeffersonlines.com/#/searchformiframe"
                    width="100%" height="550px"></iframe>
        </div>
    </div>

    <div class="sidebar-item sidebar__travel-links">
		<?php
		if ( travel_links( 'travel_links_favorites' ) ) {
			echo '<h2 class="travel-links__heading"><i class="fa fa-heart" aria-hidden="true"></i> Visitor Favorites</h2>';
			echo travel_links( 'travel_links_favorites' );
		}

		if ( travel_links( 'travel_links_lodging' ) ) {
			echo '<h2 class="travel-links__heading"><i class="fa fa-bed" aria-hidden="true"></i> Places to Stay</h2>';
			echo travel_links( 'travel_links_lodging' );
		}

		if ( travel_links( 'travel_links_maps' ) ) {
			echo '<h2 class="travel-links__heading"><i class="fa fa-map-marker" aria-hidden="true"></i> Area Maps</h2>';
			echo travel_links( 'travel_links_maps' );
		}

		if ( travel_links( 'travel_links_news' ) ) {
			echo '<h2 class="travel-links__heading"><i class="fa fa-sun-o" aria-hidden="true"></i> News &amp; Weather</h2>';
			echo travel_links( 'travel_links_news' );
		}

		if ( travel_links( 'travel_links_transport' ) ) {
			echo '<h2 class="travel-links__heading"><i class="fa fa-bus" aria-hidden="true"></i> Public Transportation</h2>';
			echo travel_links( 'travel_links_transport' );
		}
		?>
    </div>

</aside>
