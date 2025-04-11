<?php
/**
 * Template Name: Map Page
 */

get_header();

$states = get_state_terms();
?>

<main role="main">
    <section class="map">
        <div class="container">
            <header class="site-headline">
                <?php the_content(); ?>
            </header>
            <div class="map-wrapper">
                <!-- Container to initialize Map -->
                <div id="map-container" role="region" aria-label="map"></div>
                <!-- Loading animation -->
                <div id="loading-animation"></div>
            </div>

            <div class="search-container">
                <div class="zip-search">
                    <form role="search">
                        <label for="zip">
                            <span class="label">Search by Zip Code <span class="label-sub-text">(50 mile radius)</span></span>
                            <input type="number" id="zip" name="zip" placeholder="Zip Code"/>
                        </label>
                        <button class="btn btn--fancy" type="submit"><span>Search <i class="fa fa-chevron-right" aria-hidden="true"></i></span></button>
                    </form>
                </div>
                <span class="or">OR</span>
                <div class="state-search">
                    <label for="state">
                        <span class="label">Search by State</span>
                        <div class="select-wrap">
                            <select id="state" name="state">
                                <option value="" disabled selected>Select a State:</option>
                                <option value="all">View All</option>
		                        <?php
		                        foreach ( $states as $state ) {
			                        echo '<option value="' . esc_attr( $state->term_id ) . '">' . esc_html( $state->name ) . '</option>';
		                        }
		                        ?>
                            </select>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </div>
                    </label>
                </div>
            </div>

            <div class="location-results"></div>
        </div>
    </section>
</main>

<?php
get_footer();
