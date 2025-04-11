<?php
/**
 * Get Bus Stop Posts.
 *
 * @return WP_Post[]
 */
function get_locations() {
	$locs = get_posts(
		array(
			'post_type'      => 'bus_stop',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);

	return $locs;

}

/**
 * Get state terms
 *
 */
function get_state_terms() {
	$states = get_terms(
		array(
			'taxonomy' => 'state',
			'hide_empty' => true,
		)
	);

	return $states;

}

/**
 * Retrieve the lat/lng from Google geocode API.
 *
 * @param string $zip A zip code for lookup.
 *
 * @return mixed
 */
function jl_get_lat_lng( $zip ) {

	/**
	 * Google geocode API endpoint URL.
	 *
	 * @var string $url
	 */
	$google_api_key = get_field( 'google_api_key', 'option' );
	$url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode( $zip ) . '&sensor=false&key=' . $google_api_key;

	/**
	 * Retrieve the result from Google geocode API.
	 *
	 * @var string $result_string
	 */
	$result_string = file_get_contents( $url );

	/**
	 * Decode the JSON response into an array.
	 *
	 * @var array $result
	 */
	$result = json_decode( $result_string, true );

	return $result['results'][0]['geometry']['location'];
}

/**
 * Get distance.
 *
 * @param float  $lat1 Latitude one for distance calculation.
 * @param float  $lon1 Longitude one for distance calculation.
 * @param float  $lat2 Latitude two for distance calculation.
 * @param float  $lon2 Longitude two for distance calculation.
 * @param string $unit Measurement unit type, K for kilometer, N for Nautical Miles (presumably), or M for miles.
 *
 * @return float $miles distance value in Miles
 */
function get_distance( $lat1, $lon1, $lat2, $lon2, $unit ) {

	$theta = $lon1 - $lon2;

	$dist  = sin( deg2rad( $lat1 ) ) * sin( deg2rad( $lat2 ) ) + cos( deg2rad( $lat1 ) ) * cos( deg2rad( $lat2 ) ) * cos( deg2rad( $theta ) );

	$dist  = acos( $dist );

	$dist  = rad2deg( $dist );

	$miles = $dist * 60 * 1.1515;

	$unit  = strtoupper( $unit );

	if ( 'K' === $unit ) {
		return ( $miles * 1.609344 );
	}

	if ( 'N' === $unit ) {
		return ( $miles * 0.8684 );
	}

	return $miles;

}
