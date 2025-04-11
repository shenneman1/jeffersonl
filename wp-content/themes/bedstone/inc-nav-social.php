<?php
// Make $acf_options object available (from functions.php)
global $acf_options;

echo '<ul class="social__list">';

if ( $acf_options->global_twitter ) {
	echo '<li class="social__item"><a href="' . $acf_options->global_twitter . '" target="rel"><i class="fa fa-twitter" aria-hidden="true" title="Twitter"></i><span class="screen-reader-text">Twitter</span></a></li>';
}
if ( $acf_options->global_facebook ) {
	echo '<li class="social__item"><a href="' . $acf_options->global_facebook . '" target="rel"><i class="fa fa-facebook" aria-hidden="true" title="Facebook"></i><span class="screen-reader-text">Facebook</span></a></li>';
}
if ( $acf_options->global_youtube ) {
	echo '<li class="social__item"><a href="' . $acf_options->global_youtube . '" target="rel"><i class="fa fa-youtube" aria-hidden="true" title="YouTube"></i><span class="screen-reader-text">YouTube</span></a></li>';
}
if ( $acf_options->global_instagram ) {
	echo '<li class="social__item"><a href="' . $acf_options->global_instagram . '" target="rel"><i class="fa fa-instagram" aria-hidden="true" title="Instagram"></i><span class="screen-reader-text">Instagram</span></a></li>';
}

echo '</ul>';
