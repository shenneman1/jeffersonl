<?php
/**
 * Jefferson Lines shortcode functions.
 *
 * @link https://codex.wordpress.org/Shortcode_API
 *
 * @package Bedstone
 */

/**
 * Adds a [button] shortcode.
 *
 * @param array  $atts  An array of shortcode attributes.
 *
 * @return string
 */
function jeffersonlines_button_shortcode( $atts, $content = '' ) {

	extract(
		shortcode_atts(
			array(
				'link'  => '#',
				'icon'  => '',
				'color' => '',
			), $atts
		)
	);

	/**
	 * Adds FontAwesome Icon Markup if the attribute exists, otherwise it outputs nothing
	 *
	 * @return string
	 */
	if ( ! empty( $icon ) ) {
		$button_icon = '<i class="fa fa-' . $icon . '"></i>';
	} else {
		$button_icon = '';
	}

	if ( ! empty( $color ) ) {
		$color = ' button-' . $color;
	} else {
		$color = '';
	}

	return '<a class="button'. $color . '" href="' . $link . '">' . $content .  $button_icon . '</a>';
}

function jeffersonlines_icon_link_shortcode( $atts, $content = '' ) {

	extract(
		shortcode_atts(
			array(
				'link'  => '#',
				'icon'  => '',
				'color' => '',
			), $atts
		)
	);

	/**
	 * Adds FontAwesome Icon Markup if the attribute exists, otherwise it outputs nothing
	 *
	 * @return string
	 */
	if ( ! empty( $icon ) ) {
		$button_icon = '<i class="fa fa-' . $icon . '"></i>';
	} else {
		$button_icon = '';
	}

	if ( ! empty( $color ) ) {
		$color = ' button-' . $color;
	} else {
		$color = '';
	}

	return '<a class="icon-link'. $color . '" href="' . $link . '">' . $content .  $button_icon . '</a>';
}

function jeffersonlines_register_shortcodes() {
	add_shortcode( 'button', 'jeffersonlines_button_shortcode' );
	add_shortcode( 'icon-link', 'jeffersonlines_icon_link_shortcode' );
}
add_action( 'init', 'jeffersonlines_register_shortcodes' );
