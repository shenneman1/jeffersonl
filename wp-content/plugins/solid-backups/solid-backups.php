<?php
/**
 * Plugin Name: Solid Backups - NextGen
 * Plugin URI: https://solidwp.com/backups
 * Description: Keep your site backed up to the cloud.
 * Author: SolidWP
 * Author URI: https://solidwp.com
 * Version: 10.0.1
 * Text Domain: solid-backups
 * Domain Path: /lang
 * Network: True
 * License: GPLv2
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * iThemes Package: solid-backups
 *
 * @package Solid_Backups
 */

define( 'SOLIDWP_BACKUPS_PLUGIN_FILE', __FILE__ );

if ( ! function_exists( 'solidwp_backups_register_updater' ) ) {
	/**
	 * Register the plugin with the iThemes Updater.
	 *
	 * @param Ithemes_Updater_Settings $updater The Updater Settings.
	 *
	 * @return void
	 */
	function solidwp_backups_register_updater( Ithemes_Updater_Settings $updater ) {
		$updater->register( 'solid-backups', __FILE__ );
	}

	add_action( 'ithemes_updater_register', 'solidwp_backups_register_updater' );

	if ( file_exists( __DIR__ . '/lib/updater/load.php' ) ) {
		require_once __DIR__ . '/lib/updater/load.php';
	}
}


/**
 * Render the settings page.
 *
 * @return void
 */
function solidwp_backups_settings_page_html() {
	?>
	<div class="wrap solidwp-backups-settings-page"></div>
	<?php
}

/**
 * Load the onboard page scripts.
 *
 * @return void
 */
function solidwp_backups_load_onboard_page_scripts() {
	$plugin_path = realpath( plugin_dir_path( SOLIDWP_BACKUPS_PLUGIN_FILE ) ) . '/';
	$asset_path  = $plugin_path . 'dist/onboard.asset.php';
	if ( ! file_exists( $asset_path ) ) {
		// @todo What should we do in this situation?
		return;
	}
	$script_meta = include $asset_path;

	add_action(
		'admin_enqueue_scripts',
		function () use ( $script_meta ) {
			$url_path = trailingslashit( plugin_dir_url( SOLIDWP_BACKUPS_PLUGIN_FILE ) );
			// Enqueue the settings page scripts.
			wp_enqueue_script( 'solidwp-backups-onboard', $url_path . 'dist/onboard.js', $script_meta['dependencies'], $script_meta['version'], true );
		}
	);
}

/**
 * Load the settings page scripts.
 *
 * @return void
 */
function solidwp_backups_load_settings_page_scripts() {
	$plugin_path = realpath( plugin_dir_path( SOLIDWP_BACKUPS_PLUGIN_FILE ) ) . '/';
	$asset_path  = $plugin_path . 'dist/settings.asset.php';
	if ( ! file_exists( $asset_path ) ) {
		// @todo What should we do in this situation?
		return;
	}
	$script_meta = include $asset_path;

	add_action(
		'admin_enqueue_scripts',
		function () use ( $script_meta ) {
			$site_id = solidwp_backups_get_central_site_id();

			$url_path = trailingslashit( plugin_dir_url( SOLIDWP_BACKUPS_PLUGIN_FILE ) );

			// Enqueue the settings page scripts.
			wp_enqueue_script( 'solidwp-backups-settings', $url_path . 'dist/settings.js', $script_meta['dependencies'], $script_meta['version'], true );

			wp_add_inline_script('solidwp-backups-settings', 'window.backupsExports = ' . json_encode( [
					'site_id'        => $site_id,
					'status'         => solidwp_backups_get_connection_status( $site_id ),
					'is_authed_user' => solidwp_backups_is_authed_user( $site_id ),
					'links'          => [
						'timeline' => apply_filters( 'sync_api_request_url', 'https://central.solidwp.com/timeline?' . build_query(
								[
									'filters' => [
										[
											'field' => 'site',
											'value' => [ $site_id ],
											'operator' => 'isAny'
										]
									]
								]
							)
						),
						'edit_connection' => apply_filters( 'sync_api_request_url', "https://central.solidwp.com/site/$site_id/ng-backups" ),
					]
				]
			), 'before' );
		}
	);
}

/**
 * Load the onboard page styles.
 *
 * @return void
 */
function solidwp_backups_load_onboard_page_styles() {
	remove_all_actions( 'all_admin_notices' );
	remove_all_actions( 'network_admin_notices' );
	remove_all_actions( 'admin_notices' );

	wp_enqueue_style( 'solid-backups-onboard', plugins_url( 'assets/css/onboard.css', __FILE__ ), [ 'wp-components' ] );
}

/**
 * Load the settings page styles.
 *
 * @return void
 */
function solidwp_backups_load_settings_page_styles() {
	remove_all_actions( 'all_admin_notices' );
	remove_all_actions( 'network_admin_notices' );
	remove_all_actions( 'admin_notices' );
	wp_enqueue_style( 'wp-components' );
}

/**
 * Check if the user has onboarded.
 *
 * @return bool
 */
function solidwp_backups_user_has_onboarded() {
	if ( ! is_plugin_active( 'ithemes-sync/init.php' ) ) {
		return false;
	}

	if ( empty( solidwp_backups_get_authentications() ) ) {
		return false;
	}

	if ( ! isset( $GLOBALS['ithemes_updater_path'] ) ) {
		return false;
	}

	include_once $GLOBALS['ithemes_updater_path'] . '/keys.php';

	$license_keys = Ithemes_Updater_Keys::get( [ 'solid-backups' ] );
	return ( ! empty( $license_keys['solid-backups'] ) );
}

/**
 * Add the settings page to the admin menu.
 *
 * @return void
 */
function solidwp_backups_settings_page() {
	$page = add_submenu_page(
		'options-general.php',
		__( 'Solid Backups', 'it-l10n-solid-backups' ),
		__( 'Solid Backups', 'it-l10n-solid-backups' ),
		'manage_options',
		'solid-backups',
		'solidwp_backups_settings_page_html'
	);

	if ( solidwp_backups_user_has_onboarded() ) {
		add_action( "load-{$page}", 'solidwp_backups_load_settings_page_scripts' );
		add_action( "load-{$page}", 'solidwp_backups_load_settings_page_styles' );
	} else {
		add_action( "load-{$page}", 'solidwp_backups_load_onboard_page_scripts' );
		add_action( "load-{$page}", 'solidwp_backups_load_onboard_page_styles' );
	}
}
add_action( 'admin_menu', 'solidwp_backups_settings_page' );

/**
 * Link to the Central onboarding sequence on WordPress 6.5.
 *
 * The onboarding JS requires WordPress 6.6. For users who are on older
 * WordPress versions, we redirect them to Central to complete onboarding.
 *
 * @return void
 */
function solidwp_backups_override_onboard_link() {
	if ( solidwp_backups_user_has_onboarded() ) {
		return;
	}

	require ABSPATH . WPINC . '/version.php';

	if ( version_compare( $wp_version, '6.6', '>=' ) ) {
		return;
	}

	global $submenu;

	foreach ( $submenu['options-general.php'] as $key => $menu_item ) {
		if ( $menu_item[2] !== 'solid-backups' ) {
			continue;
		}

		$submenu['options-general.php'][ $key ][2] = 'https://central.solidwp.com/onboard/backups';
	}
}

add_action( 'admin_head', 'solidwp_backups_override_onboard_link' );

/**
 * Get the authentications.
 *
 * @return array
 */
function solidwp_backups_get_authentications() {
	if ( ! isset( $GLOBALS['ithemes-sync-settings'] ) ) {
		return [];
	}
	$sync_settings = $GLOBALS['ithemes-sync-settings'];
	return $sync_settings->get_option( 'authentications' );
}

/**
 * Get the Backup Connection Status from Central.
 *
 * @param int|string $site_id The Central Site ID.
 *
 * @return string
 */
function solidwp_backups_get_connection_status( $site_id ) {

	// Check if we already have the status.
	$ping_status = get_transient( "solid_central_ping_$site_id" );
	$has_status  = $ping_status && isset( $ping_status['backups']['connection_status'] );

	// If the status is 'unknown', check for it again.
	if ( $has_status && 'unknown' === $ping_status['backups']['connection_status'] ) {
		$has_status = false;
	}

	if ( ! $has_status ) {
		// Run the ping check.
		require_once $GLOBALS['ithemes_sync_path'] . '/server.php';

		$result = $GLOBALS['ithemes-sync-settings']->do_ping_check( $site_id );

		if ( ! is_wp_error( $result ) && isset( $result['success'] ) ) {
			unset( $result['success'] );
			set_transient( "solid_central_ping_$site_id", $result, DAY_IN_SECONDS );

			$ping_status = $result;
			if ( isset ( $ping_status['backups']['connection_status'] ) ) {
				$has_status = true;
			}
		}
	}

	if ( ! $has_status ) {
		return 'unknown';
	}

	return $ping_status['backups']['connection_status'];
}

/**
 * Get the current user's Central ite ID.
 *
 * If a Central user is currently logged in, this will
 * return their Central Site ID.
 *
 * If the current user has not authorized with Central,
 * this will return the first Central Site ID in the list.
 *
 * @return int
 */
function solidwp_backups_get_central_site_id() {
	$authentications = solidwp_backups_get_authentications();
	$current_user    = wp_get_current_user();
	$user_login      = $current_user->user_login;

	foreach( $authentications as $site_id => $data ) {
		if ( ! isset( $data['local_user'] ) ) {
			continue;
		}
		if ( $data['local_user'] === $user_login ) {
			return (int) $site_id;
		}
	}
	return (int) array_keys( $authentications )[0];
}

/**
 * Check if the current user is the one who authenticated with Central.
 *
 * This is used to display different content to the user who authenticated.
 *
 * @param int|string $site_id Central Site ID.
 *
 * @return bool
 */
function solidwp_backups_is_authed_user( $site_id ) {
	$authentications = solidwp_backups_get_authentications();
	$current_user    = wp_get_current_user();
	$user_login      = $current_user->user_login;

	// Sanity check.
	if ( ! isset( $authentications[ (int) $site_id ] ) ) {
		return false;
	}

	return $authentications[ (int) $site_id ]['local_user'] === $user_login;
}
