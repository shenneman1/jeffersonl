<?php
/**
 * ACF Google Map
 */
function jl_acf_init( $api ) {

	$api['key'] = 'AIzaSyAUgDdE1RH1m9oKT-X8CGFxvoxrLnY_58A';
	return $api;

}

//old APi in theme settings AIzaSyCetFiln26pXK4KpLCpmAo0fGom6p2qeno

add_filter( 'acf/fields/google_map/api', 'jl_acf_init' );
