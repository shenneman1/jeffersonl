<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * PixelYourSite Core class.
 */
final class PYS extends Settings implements Plugin {
	
	private static $_instance;

	/** @var $eventsManager EventsManager */
	private $eventsManager;

    /** @var $registeredPixels array Registered pixels */
    private $registeredPixels = array();

    /** @var $registeredPlugins array Registered plugins (addons) */
    private $registeredPlugins = array();

    private $adminPagesSlugs = array();
    private $externalId;
    /**
     * @var PYS_Logger
     */
    private $logger;
	
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
		
	}
	
	public function getPluginName() {}

    public function getPluginFile() {}

    public function getPluginVersion() {
        return PYS_FREE_VERSION;
    }
    public function adminUpdateLicense() {}
    public function __construct() {
		
	    // initialize settings
	    parent::__construct( 'core' );
    
        add_action( 'admin_init', array( $this, 'updatePlugin' ), 0 );
	    add_action( 'admin_init', 'PixelYourSite\manageAdminPermissions' );

	    // Priority 9 used to keep things same as on PRO version
        add_action( 'wp', array( $this, 'controllSessionStart'), 10);
        add_action( 'init', array( $this, 'set_pbid'), 8);
        add_action( 'init', array( $this, 'init' ), 9 );
        add_action( 'init', array( $this, 'afterInit' ), 11 );

        add_action( 'admin_menu', array( $this, 'adminMenu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
        add_action( 'admin_notices', 'PixelYourSite\adminRenderNotices' );
        add_action( 'admin_init', array( $this, 'adminProcessRequest' ), 11 );

        // run Events Manager
        add_action( 'template_redirect', array( $this, 'managePixels' ), 1);
        // track user login event
        add_action('wp_login', [$this,'userLogin'], 10, 2);
        // track user registrations
        add_action( 'user_register', array( $this, 'userRegisterHandler' ) );
	    // "admin_permission" option custom sanitization function
	    add_filter( 'pys_core_settings_sanitize_admin_permissions_field', function( $value ) {

	    	// "administrator" always should be allowed
	    	if ( ! is_array( $value ) || ! in_array( 'administrator', $value ) ) {
	    		$value[] = 'administrator';
		    }

		    manageAdminPermissions();

	    	return $this->sanitize_multi_select_field( $value );

	    } );

	    add_action( 'wp_ajax_pys_get_gdpr_filters_values', array( $this, 'ajaxGetGdprFiltersValues' ) );
	    add_action( 'wp_ajax_nopriv_pys_get_gdpr_filters_values', array( $this, 'ajaxGetGdprFiltersValues' ) );


        add_action( 'wp_ajax_pys_get_pbid', array( $this, 'get_pbid_ajax' ) );
        add_action( 'wp_ajax_nopriv_pys_get_pbid', array( $this, 'get_pbid_ajax' ) );
        /*
         * Restore settings after COG plugin
         * */
        add_action( 'deactivate_pixel-cost-of-goods/pixel-cost-of-goods.php',array($this,"restoreSettingsAfterCog"));
        add_action( 'woocommerce_checkout_create_order', array( $this,'add_order_external_meta_data'), 10, 2 );

        $this->logger = new PYS_Logger();

    }

    public function init() {

        if ( isset( $_GET[ 'download_logs' ] ) && $_GET['download_logs'] == 'meta' ) {
            PYS()->getLog()->downloadLogFile();
        }
        elseif (isset( $_GET[ 'download_logs' ] ) && $_GET['download_logs'] == 'pinterest' && method_exists(Pinterest(), 'getLog')){
            Pinterest()->getLog()->downloadLogFile();
        }

        if ( isset( $_GET[ 'clear_plugin_logs' ] ) ) {
            PYS()->getLog()->remove();
            $actual_link = ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            wp_redirect( remove_query_arg( 'clear_plugin_logs', $actual_link ) );
            exit;
        } elseif ( isset( $_GET[ 'clear_pinterest_logs' ] ) ) {
            Pinterest()->getLog()->remove();
            $actual_link = ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            wp_redirect( remove_query_arg( 'clear_pinterest_logs', $actual_link ) );
            exit;
        }
        register_post_type( 'pys_event', array(
            'public' => false,
            'supports' => array( 'title' )
        ) );

	    // initialize options
	    $this->locateOptions(
		    PYS_FREE_PATH . '/includes/options_fields.json',
		    PYS_FREE_PATH . '/includes/options_defaults.json'
	    );

	    // register pixels and plugins (add-ons)
	    do_action( 'pys_register_pixels', $this );
	    do_action( 'pys_register_plugins', $this );

        // load dummy Pinterest plugin for admin UI
	    if ( ! array_key_exists( 'pinterest', $this->registeredPlugins ) ) {
		    /** @noinspection PhpIncludeInspection */
		    require_once PYS_FREE_PATH . '/modules/pinterest/pinterest.php';
	    }

        // load dummy Bing plugin for admin UI
        if ( ! array_key_exists( 'bing', $this->registeredPlugins ) ) {
            /** @noinspection PhpIncludeInspection */
            require_once PYS_FREE_PATH . '/modules/bing/bing.php';
        }

        // maybe disable Facebook for WooCommerce pixel output
	    if ( isWooCommerceActive()
	         && array_key_exists( 'facebook', $this->registeredPixels ) && Facebook()->configured() ) {
		    add_filter( 'facebook_for_woocommerce_integration_pixel_enabled', '__return_false' );
	    }

        $this->logger->init();
        if(Facebook()->getOption('test_api_event_code_expiration_at'))
        {
            foreach (Facebook()->getOption('test_api_event_code_expiration_at') as $key => $test_code_expiration_at)
            {
                if(time() >= $test_code_expiration_at)
                {
                    Facebook()->updateOptions(array("test_api_event_code" => array()));
                    Facebook()->updateOptions(array("test_api_event_code_expiration_at" => array()));
                }
            }
        }
        $eventsFormFactory = apply_filters("pys_form_event_factory",[]);
        if(!$eventsFormFactory)
        {
            $options = array(
                'enable_success_send_form'     => false
            );
            PYS()->updateOptions($options);
        }

        if (isRealCookieBannerPluginActivated()) {

            add_action('RCB/Templates/TechnicalHandlingIntegration', function ( $integration ) {

                $this->handle_rcb_integration($integration, Facebook()->configured(), 'facebook-pixel', PYS_FREE_PLUGIN_FILE);
                $this->handle_rcb_integration($integration, GA()->configured(), 'google-analytics-analytics-4', PYS_FREE_PLUGIN_FILE);
                if(isPinterestActive()){
                    $this->handle_rcb_integration($integration, Pinterest()->configured(), 'pinterest-tag', PYS_PINTEREST_PLUGIN_FILE);
                }
                if(isBingActive()){
                    $this->handle_rcb_integration($integration, Bing()->configured(), 'bing-ads', PYS_BING_PLUGIN_FILE);
                }



            });
        }

        EnrichOrder()->init();

        AjaxHookEventManager::instance()->addHooks();
    }

    private function handle_rcb_integration( $integration, $is_active, $type, $plugin_dir) {

        if (
            $is_active
            && $integration->integrate($plugin_dir, $type)
        ) {
            $integration->setCodeOptIn('');
            $integration->setCodeOptOut('');
        }
    }

    function controllSessionStart(){
        if(PYS()->getOption('session_disable')) return;

        // Checking if the directory exists and is writable
        if (!is_admin() && php_sapi_name() !== 'cli' && session_status() != PHP_SESSION_DISABLED) {
            if (!headers_sent() && session_status() == PHP_SESSION_NONE) {
                if(!session_start()) return;
            }
            if (empty($_SESSION['TrafficSource'])) {
                $_SESSION['TrafficSource'] = getTrafficSource();
            }
            if (empty($_SESSION['LandingPage'])) {
                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
                $currentUrl = $protocol . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '');
                $landing = explode('?', $currentUrl)[0];
                $_SESSION['LandingPage'] = $landing;
            }
            if (empty($_SESSION['TrafficUtms'])) {
                $_SESSION['TrafficUtms'] = getUtms();
            }
            if (empty($_SESSION['TrafficUtmsId'])) {
                $_SESSION['TrafficUtmsId'] = getUtmsId();
            }
        }
    }

    function get_pbid(){
        return $this->externalId;
    }
    function set_pbid(){
        $pbidCookieName = 'pbid';
        $isTrackExternalId = EventsManager::isTrackExternalId();


        if (empty($_COOKIE[$pbidCookieName]) && $isTrackExternalId) {
            $uniqueId = bin2hex(random_bytes(16));
            $encryptedUniqueId = hash('sha256', $uniqueId);
            $this->externalId = $encryptedUniqueId;
        }
        elseif(!empty($_COOKIE[$pbidCookieName]) && $isTrackExternalId){
            $this->externalId = $_COOKIE[$pbidCookieName];
        }
    }

    public function get_pbid_ajax(){
        if(defined('DOING_AJAX') && wp_doing_ajax()){
            $isTrackExternalId = EventsManager::isTrackExternalId();
            if ($isTrackExternalId && !empty($this->externalId)) {
                wp_send_json_success( array('pbid'=> $this->externalId));
            }
        }
    }
    public function add_order_external_meta_data($order, $posted_data){

        $pbidCookieName = 'pbid';
        $pbid = false;
        if (isset($_COOKIE[$pbidCookieName])) {
            $pbid = $_COOKIE[$pbidCookieName];
        }
        // Добавляем мета-информацию в заказ
        if(!empty($pbid)){
            if ( isWooCommerceVersionGte('3.0.0') ) {
                // WooCommerce версия >= 3.0
                if($order) {
                    $order->update_meta_data( 'external_id', $pbid );
                    $order->save();
                }

            } else {
                // WooCommerce версия < 3.0
                update_post_meta( $order->get_id(), 'external_id', $pbid );
            }
        }

    }
    public function utmTemplate() {
        include 'views/html-utm-templates.php';
    }
	/**
	 * Extend options after post types are registered
	 */
    public function afterInit() {

	    // add available public custom post types to settings
	    foreach ( get_post_types( array( 'public' => true, '_builtin' => false ), 'objects' ) as $post_type ) {

		    // skip product post type when WC is active
		    if ( isWooCommerceActive() && $post_type->name == 'product' ) {
			    continue;
		    }

		    // skip download post type when EDD is active
		    if ( isEddActive() && $post_type->name == 'download' ) {
			    continue;
		    }

		    $this->addOption( 'general_event_on_' . $post_type->name . '_enabled', 'checkbox', false );

	    }

	    maybeMigrate();

    }

	/**
	 * @param Pixel|Settings $pixel
	 */
    public function registerPixel( &$pixel ) {
        switch ($pixel->getSlug()) {
            case 'pinterest':
                if(!isPinterestVersionIncompatible()){
                    $this->registeredPixels[ $pixel->getSlug() ] = $pixel;
                }
                else{
                    $minVersion = PYS_FREE_PINTEREST_MIN_VERSION;
                    add_action( 'wp_head', function() use ($minVersion) {
                        echo "<script type='application/javascript' id='pys-pinterest-version-incompatible'>console.warn('You are using incompatible version of PixelYourSite Pinterest Add-On. PixelYourSite PRO requires at least PixelYourSite Pinterest Add-On $minVersion. Please, update to latest version.');</script>\r\n";
                    } );
                }
                break;
            case 'bing' :
                if(!isBingVersionIncompatible()){
                    $this->registeredPixels[ $pixel->getSlug() ] = $pixel;
                }
                else{
                    $minVersion = PYS_FREE_BING_MIN_VERSION;
                    add_action( 'wp_head', function() use ($minVersion) {
                        echo "<script type='application/javascript' id='pys-bing-version-incompatible'>console.warn('You are using incompatible version of PixelYourSite Bing Add-On. PixelYourSite PRO requires at least PixelYourSite Bing Add-On $minVersion. Please, update to latest version.');</script>\r\n";
                    } );
                }
                break;
            default :
                $this->registeredPixels[ $pixel->getSlug() ] = $pixel;
                break;
        }
    }

    /**
     * Hook
     * @param String $user_login
     * @param \WP_User $user
     */
    function userLogin($user_login, $user) {
        update_user_meta($user->ID,'pys_just_login',true);
    }

    public function userRegisterHandler( $user_id ) {

        if ( PYS()->getOption( 'woo_complete_registration_enabled' )
            || PYS()->getOption( 'automatic_event_signup_enabled' )
        ) {
            update_user_meta( $user_id, 'pys_complete_registration', true );
        }

    }

	/**
	 * Return array of registered pixels
	 *
	 * @return array
	 */
	public function getRegisteredPixels() {
		return $this->registeredPixels;
	}

	/**
	 * @param Pixel|Settings $plugin
	 */
	public function registerPlugin( &$plugin ) {
		$this->registeredPlugins[ $plugin->getSlug() ] = $plugin;
	}

	/**
	 * Return array of registered plugins
	 *
	 * @return array
	 */
    public function getRegisteredPlugins() {
	    return $this->registeredPlugins;
    }

	/**
	 * Front-end entry point
	 */
    public function managePixels() {

        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        // disable Events Manager on Customizer and preview mode
        if (is_admin() || is_customize_preview() || is_preview()) {
            return;
        }
        if($this->is_user_agent_bot())
        {
            return;
        }
        // disable Events Manager on Elementor editor
        if (did_action('elementor/preview/init')
            || did_action('elementor/editor/init')
            || (isset( $_GET['action'] ) && $_GET['action'] == 'piotnetforms') // skip preview for piotnet forms plugin
        ) {
            return;
        }

        // disable Events Manager on Divi Builder
        if (function_exists('et_core_is_fb_enabled') && et_core_is_fb_enabled()) {
            return;
        }

        if(PYS()->getOption( 'block_ip_enabled') && in_array($this->get_user_ip(), PYS()->getOption('blocked_ips')))
        {
            return;
        }

        $theme = wp_get_theme(); // gets the current theme
        if ( ('Bricks' == $theme->name || 'Bricks' == $theme->parent_theme) && isset($_GET['bricks']) && $_GET['bricks']=='run') {
            return;
        }

    	// output debug info
        if(!PYS()->getOption( 'hide_version_plugin_in_console')) {
            add_action('wp_head', function () {
                echo "<script type='application/javascript'  id='pys-version-script'>console.log('PixelYourSite Free version " . PYS_FREE_VERSION . "');</script>\r\n";
            }, 1);
        }
	    if ( isDisabledForCurrentRole() ) {
	    	return;
	    }
        // setup events
        $this->eventsManager = new EventsManager();
	    // at least one pixel should be configured
	    if ( ! Facebook()->configured() && ! GA()->configured() && ! Pinterest()->configured() && ! Bing()->configured() ) {
            if(!PYS()->getOption( 'hide_version_plugin_in_console')) {
                add_action('wp_head', function () {
                    echo "<script type='application/javascript' id='pys-config-warning-script'>console.warn('PixelYourSite: no pixel configured.');</script>\r\n";
                });
            }
	    	return;

	    }



    }

    function get_user_ip(){
        $ip = $_SERVER['REMOTE_ADDR'];

        // Check if HTTP_X_FORWARDED_FOR is set and not empty
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Split the list of IPs using a comma and take the first IP
            $forwarded_ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($forwarded_ips[0]);
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // Use HTTP_CLIENT_IP if available
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }

        return $ip;
    }

    function is_user_agent_bot(){
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $options = array(
                'YandexBot', 'YandexAccessibilityBot', 'YandexMobileBot', 'YandexDirectDyn', 'YandexScreenshotBot',
                'YandexImages', 'YandexVideo', 'YandexVideoParser', 'YandexMedia', 'YandexBlogs',
                'YandexFavicons', 'YandexWebmaster', 'YandexPagechecker', 'YandexImageResizer', 'YandexAdNet',
                'YandexDirect', 'YaDirectFetcher', 'YandexCalendar', 'YandexSitelinks', 'YandexMetrika',
                'YandexNews', 'YandexNewslinks', 'YandexCatalog', 'YandexAntivirus', 'YandexMarket',
                'YandexVertis', 'YandexForDomain', 'YandexSpravBot', 'YandexSearchShop', 'YandexMedianaBot',
                'YandexOntoDB', 'YandexOntoDBAPI', 'Googlebot', 'Googlebot-Image', 'Googlebot-News',
                'Googlebot-Video', 'Mediapartners-Google', 'AdsBot-Google', 'Chrome-Lighthouse', 'Lighthouse',
                'Mail.RU_Bot', 'bingbot', 'Accoona', 'ia_archiver', 'Ask Jeeves', 'OmniExplorer_Bot',
                'W3C_Validator', 'WebAlta', 'YahooFeedSeeker', 'Yahoo!', 'Ezooms', 'Tourlentabot', 'MJ12bot',
                'AhrefsBot', 'SearchBot', 'SiteStatus', 'Nigma.ru', 'Baiduspider', 'Statsbot', 'SISTRIX',
                'AcoonBot', 'findlinks', 'proximic', 'OpenindexSpider', 'statdom.ru', 'Exabot', 'Spider',
                'SeznamBot', 'oBot', 'C-T bot', 'Updownerbot', 'Snoopy', 'heritrix', 'Yeti', 'DomainVader',
                'DCPbot', 'PaperLiBot', 'APIs-Google', 'AdsBot-Google-Mobile', 'AdsBot-Google-Mobile-Apps',
                'FeedFetcher-Google', 'Google-Read-Aloud', 'DuplexWeb-Google', 'Storebot-Google', 'lscache_runner',
                'ClaudeBot', 'SeekportBot', 'GPTBot', 'Applebot',
                'DuckDuckBot', 'Sogou', 'facebookexternalhit', 'Swiftbot', 'Slurp', 'CCBot', 'Go-http-client',
                'Sogou Spider', 'Facebot', 'Alexa Crawler', 'Cốc Cốc Bot', 'Majestic-12', 'SemrushBot',
                'DotBot', 'Qwantify', 'Pinterest', 'GrapeshotCrawler', 'archive.org_bot', 'LinkpadBot',
                'uptimebot', 'Wget', 'curl', 'Google-Structured-Data-Testing-Tool', 'Google-PageSpeed Insights',
                'Google-Site-Verification', 'BingPreview', 'Slackbot', 'TelegramBot', 'DiscordBot', 'WhatsApp',
                'RedditBot', 'Yahoo! Slurp', 'Tumblr', 'PetalBot', 'FlipboardProxy', 'LinkedInBot',
                'SkypeUriPreview', 'Google-Firebase-Storage', 'BitlyBot', 'FeedlyBot', 'AppleNewsBot',
                'ZyBorg', 'ia_archiver-web.archive.org', 'Mediatoolkitbot', 'DeuSu', 'SMTBot', 'MegaIndex.ru',
                'Seomoz', 'BLEXBot', 'YisouSpider', '360Spider', 'AddThis', 'TweetmemeBot', 'ContextAd Bot',
                'Screaming Frog SEO Spider', 'Nutch', 'Baiduspider-image', 'Panscient.com', 'Twitterbot',
                'YoudaoBot', 'OpenSiteExplorer', 'Linkfluence', 'YaK', 'ContentKing', 'Spinn3r', 'PhantomJS',
                'HeadlessChrome', 'Snapchat', 'Pingdom', 'Googlebot-Mobile'
            );

            foreach($options as $row) {
                if (stripos(strtolower($_SERVER['HTTP_USER_AGENT']), strtolower($row)) !== false) {
                    return true;
                }
            }
        }

        return false;
    }

    public function ajaxGetGdprFiltersValues() {

            wp_send_json_success( array(
                'all_disabled_by_api'       => apply_filters( 'pys_disable_by_gdpr', false ),
                'facebook_disabled_by_api'  => apply_filters( 'pys_disable_facebook_by_gdpr', false ),
                'analytics_disabled_by_api' => apply_filters( 'pys_disable_analytics_by_gdpr', false ),
                'pinterest_disabled_by_api' => apply_filters( 'pys_disable_pinterest_by_gdpr', false ),
                'bing_disabled_by_api' => apply_filters( 'pys_disable_bing_by_gdpr', false ),
                'externalID_disabled_by_api' => apply_filters( 'pys_disable_externalID_by_gdpr', false ),
                'disabled_all_cookie'       => apply_filters( 'pys_disable_all_cookie', false ),
                'disabled_start_session_cookie' => apply_filters( 'pys_disabled_start_session_cookie', false ),
                'disabled_advanced_form_data_cookie' => apply_filters( 'pys_disable_advanced_form_data_cookie', false ),
                'disabled_landing_page_cookie'  => apply_filters( 'pys_disable_landing_page_cookie', false ),
                'disabled_first_visit_cookie'  => apply_filters( 'pys_disable_first_visit_cookie', false ),
                'disabled_trafficsource_cookie' => apply_filters( 'pys_disable_trafficsource_cookie', false ),
                'disabled_utmTerms_cookie' => apply_filters( 'pys_disable_utmTerms_cookie', false ),
                'disabled_utmId_cookie' => apply_filters( 'pys_disable_utmId_cookie', false ),
            ) );

    }

	public function getEventsManager() {
		return $this->eventsManager;
	}

    public function adminMenu() {
        global $submenu;

        add_menu_page( 'PixelYourSite', 'PixelYourSite', 'manage_pys', 'pixelyoursite',
            array( $this, 'adminPageMain' ), PYS_FREE_URL . '/dist/images/favicon.png' );

        $addons = $this->registeredPlugins;

        if ( $addons['head_footer'] ) {
            unset( $addons['head_footer'] );
        }

        // display Licenses menu item only when at lest one addon is active
        if ( count( $addons ) ) {
            add_submenu_page( 'pixelyoursite', 'Licenses', 'Licenses',
                'manage_pys', 'pixelyoursite_licenses', array( $this, 'adminPageLicenses' ) );
        }

        if(isWooCommerceActive()) {
            add_submenu_page( 'pixelyoursite', 'WooCommerce Reports', 'WooCommerce Reports',
                'manage_pys', 'pixelyoursite_woo_reports', array( $this, 'wooReport' ) );
        }
        if(isEddActive()) {
            add_submenu_page( 'pixelyoursite', 'EDD Reports', 'EDD Reports',
                'manage_pys', 'pixelyoursite_edd_reports', array( $this, 'eddReport' ) ,9);
        }

        add_submenu_page( 'pixelyoursite', 'UTM Builder', 'UTM Builder',
            'manage_pys', 'pixelyoursite_utm', array( $this, 'utmTemplate' ) );

        add_submenu_page( 'pixelyoursite', 'System Report', 'System Report',
            'manage_pys', 'pixelyoursite_report', array( $this, 'adminPageReport' ) );

        // core admin pages
        $this->adminPagesSlugs = array(
            'pixelyoursite',
            'pixelyoursite_licenses',
            'pixelyoursite_report',
            'pixelyoursite_woo_reports',
            'pixelyoursite_edd_reports',
            'pixelyoursite_utm',
        );

        // rename first submenu item
        if ( isset( $submenu['pixelyoursite'] ) ) {
            $submenu['pixelyoursite'][0][0] = 'Dashboard';
        }

	    $this->adminSaveSettings();

    }

    public function adminEnqueueScripts() {
        wp_enqueue_style( 'pys_notice', PYS_FREE_URL . '/dist/styles/notice.css', array(), PYS_FREE_VERSION );
        if ( in_array( getCurrentAdminPage(), $this->adminPagesSlugs ) ) {


            wp_register_style( 'select2_css', PYS_FREE_URL . '/dist/styles/select2.min.css' );
            wp_enqueue_script( 'select2_js', PYS_FREE_URL . '/dist/scripts/select2.min.js',
                array( 'jquery' ) );

	        wp_enqueue_script( 'popper', PYS_FREE_URL . '/dist/scripts/popper.min.js', 'jquery' );
	        wp_enqueue_script( 'bootstrap', PYS_FREE_URL . '/dist/scripts/bootstrap.min.js', 'jquery',
		        'popper' );

            wp_enqueue_style( 'pys_css', PYS_FREE_URL . '/dist/styles/admin.css', array( 'select2_css' ), PYS_FREE_VERSION );
            wp_enqueue_script( 'pys_js', PYS_FREE_URL . '/dist/scripts/admin.js', array( 'jquery', 'select2_js', 'popper',
                                                                                 'bootstrap' ), PYS_FREE_VERSION );

        }

    }

    public function adminPageMain() {
        $this->adminResetSettings();
        include 'views/html-wrapper-main.php';
    }

	public function adminPageReport() {
		include 'views/html-report.php';
	}

    public function wooReport() {
        include 'views/html-report-woo.php';
    }
    public function eddReport() {
        include 'views/html-report-edd.php';
    }

	public function adminPageLicenses() {

        $this->adminUpdateLicense();

        /** @var Plugin|Settings $plugin */
        foreach ( $this->registeredPlugins as $plugin ) {
            if ( $plugin->getSlug() !== 'head_footer' ) {
                $plugin->adminUpdateLicense();
            }
        }

		include 'views/html-licenses.php';
	}



    public function updatePlugin() {
    
        foreach ( $this->registeredPlugins as $slug => $plugin ) {
        
            if ( $slug == 'head_footer' ) {
                continue;
            }
        
            updatePlugin( $plugin );
        
        }
        
    }

	public function adminSecurityCheck() {
  
		// verify user access
		if ( ! current_user_can( 'manage_pys' ) ) {
			return false;
		}

		// nonce filed and PYS data are required request
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! isset( $_REQUEST['pys'] ) ) {
			return false;
		}

		return true;

	}
    
    public function adminProcessRequest() {
        $this->adminUpdateCustomEvents();
        $this->adminEnableGdprAjax();
    }
    
	private function adminUpdateCustomEvents() {

		if ( ! $this->adminSecurityCheck() ) {
			return;
		}

		/**
		 * Single Custom Event Actions
		 */
		if ( isset( $_REQUEST['pys']['event'] ) && isset( $_REQUEST['action'] ) ) {

			$nonce   = isset( $_REQUEST['_wpnonce'] ) ? $_REQUEST['_wpnonce'] : null;
			$action  = $_REQUEST['action'];
			if(isset( $_REQUEST['pys']['event']['post_id'] )) {
                $post_id =  sanitize_key($_REQUEST['pys']['event']['post_id']) ;
            } else {
                $post_id = false;
            }


			if ( $action == 'update' && wp_verify_nonce( $nonce, 'pys_update_event' ) ) {

				if ( $post_id ) {
					$event = CustomEventFactory::getById( $post_id );
					$event->update( $_REQUEST['pys']['event'] );
				} else {
				    if(isset( $_REQUEST['pys']['event']) && is_array($_REQUEST['pys']['event'])) {
                        CustomEventFactory::create( $_REQUEST['pys']['event'] );
                    } else {
                        CustomEventFactory::create( [] );
                    }

				}

			} elseif ( $action == 'enable' && $post_id && wp_verify_nonce( $nonce, 'pys_enable_event' ) ) {

				$event = CustomEventFactory::getById( $post_id );
				$event->enable();

			} elseif ( $action == 'disable' && $post_id && wp_verify_nonce( $nonce, 'pys_disable_event' ) ) {

				$event = CustomEventFactory::getById( $post_id );
				$event->disable();

			} elseif ( $action == 'remove' && $post_id && wp_verify_nonce( $nonce, 'pys_remove_event' ) ) {

				CustomEventFactory::remove( $post_id );

			}

			purgeCache();

			// redirect to events tab
			wp_safe_redirect( buildAdminUrl( 'pixelyoursite', 'events' ) );
			exit;

		}

		/**
		 * Bulk Custom Events Actions
		 */
		if ( isset( $_REQUEST['pys']['bulk_event_action'], $_REQUEST['pys']['selected_events'] )
		     && isset( $_REQUEST['pys']['bulk_event_action_nonce'] )
		     && wp_verify_nonce( $_REQUEST['pys']['bulk_event_action_nonce'], 'bulk_event_action' )
		     && is_array( $_REQUEST['pys']['selected_events'] ) ) {

			foreach ( $_REQUEST['pys']['selected_events'] as $event_id ) {

				$event_id = (int) $event_id;

				switch ( $_REQUEST['pys']['bulk_event_action'] ) {
					case 'enable':
						$event = CustomEventFactory::getById( $event_id );
						$event->enable();
						break;

					case 'disable':
						$event = CustomEventFactory::getById( $event_id );
						$event->disable();
						break;

					case 'clone':
						CustomEventFactory::makeClone( $event_id );
						break;

					case 'delete':
						CustomEventFactory::remove( $event_id );
						break;
				}

			}

			purgeCache();

			// redirect to events tab
			wp_safe_redirect( buildAdminUrl( 'pixelyoursite', 'events' ) );
			exit;

		}

	}

    private function adminSaveSettings() {

    	if ( ! $this->adminSecurityCheck() ) {
    		return;
	    }

        if ( wp_verify_nonce( $_REQUEST['_wpnonce'], 'pys_save_settings' ) ) {

            if(isset( $_POST['pys']['core'] ) && is_array($_POST['pys']['core'])) {
                $core_options = $_POST['pys']['core'];
            } else {
                $core_options =  array();
            }


    
            $gdpr_ajax_enabled = isset( $core_options['gdpr_ajax_enabled'] )
                ? $core_options['gdpr_ajax_enabled']        // value from form data
                : $this->getOption( 'gdpr_ajax_enabled' );    // previous value
    
            // allow 3rd party plugins to by-pass option value
            $core_options['gdpr_ajax_enabled'] = apply_filters( 'pys_gdpr_ajax_enabled', $gdpr_ajax_enabled );

	        if (isPixelCogActive() ) {

		        if (isset($core_options['woo_purchase_value_option'])) {
                    $core_options = $this->updateDefaultNoCogOption($core_options,'woo_purchase_value_option','woo_purchase_value_cog');
                }
                if (isset($core_options['woo_view_content_value_option'])) {
                    $core_options = $this->updateDefaultNoCogOption($core_options,'woo_view_content_value_option','woo_content_value_cog');
                }
                if (isset($core_options['woo_add_to_cart_value_option'])) {
                    $core_options = $this->updateDefaultNoCogOption($core_options,'woo_add_to_cart_value_option','woo_add_to_cart_value_cog');
                }
                if (isset($core_options['woo_initiate_checkout_value_option'])) {
                    $core_options = $this->updateDefaultNoCogOption($core_options,'woo_initiate_checkout_value_option','woo_initiate_checkout_value_cog');
                }
	        }

            // update core options
            $this->updateOptions( $core_options );

        	$objects = array_merge( $this->registeredPixels, $this->registeredPlugins );

        	// update plugins and pixels options
	        foreach ( $objects as $obj ) {
	        	/** @var Plugin|Pixel|Settings $obj */
		        $obj->updateOptions();
	        }
            GATags()->updateOptions();
	        purgeCache();

        }

    }

    private function updateDefaultNoCogOption($core_options,$optionName,$defaultOptionName) {
        $val = $core_options[$optionName];
        $currentVal = $this->getOption($optionName);
        if($val != 'cog') {
            $core_options[$defaultOptionName] = $val;
        } elseif ( $currentVal != 'cog' ) {
            $core_options[$defaultOptionName] = $currentVal;
        }
        return $core_options;
    }

    private function adminResetSettings() {

	    if ( ! $this->adminSecurityCheck() ) {
		    return;
	    }

	    if ( wp_verify_nonce( $_REQUEST['_wpnonce'], 'pys_save_settings' ) && isset( $_REQUEST['pys']['reset_settings'] ) ) {
	    	
		    if ( isPinterestActive() ) {

			    $old_options = array(
				    'license_key'     => Pinterest()->getOption( 'license_key' ),
				    'license_status'  => Pinterest()->getOption( 'license_status' ),
				    'license_expires' => Pinterest()->getOption( 'license_expires' ),
				    'pixel_id'        => Pinterest()->getOption( 'pixel_id' ),
			    );

			    Pinterest()->resetToDefaults();
			    Pinterest()->updateOptions( $old_options );

		    }
		    
		    PYS()->resetToDefaults();
		    Facebook()->resetToDefaults();
		    GA()->resetToDefaults();
		    
		    // do redirect
		    wp_safe_redirect( buildAdminUrl( 'pixelyoursite' ) );
		    exit;

	    }

    }
    
    private function adminEnableGdprAjax() {
        
        if ( ! $this->adminSecurityCheck() ) {
            return;
        }
        
        if ( isset( $_REQUEST['pys']['enable_gdpr_ajax'] ) ) {
            $this->updateOptions( array(
                'gdpr_ajax_enabled' => true,
                'gdpr_cookie_law_info_integration_enabled' => true,
                'consent_magic_integration_enabled' => true,
            ) );
            
            add_action( 'admin_notices', 'PixelYourSite\adminGdprAjaxEnabledNotice' );
            purgeCache();
        }
        
    }

    function restoreSettingsAfterCog() {

        $params = array();
        $oldPurchase = $this->getOption("woo_purchase_value_cog");
        $oldContent = $this->getOption("woo_content_value_cog");
        $oldAddCart = $this->getOption("woo_add_to_cart_value_cog");
        $oldInitCheckout = $this->getOption("woo_initiate_checkout_value_cog");

        if($this->getOption('woo_purchase_value_option') == 'cog') {
            if(!empty($oldPurchase)) $params['woo_purchase_value_option'] = $oldPurchase;
            else $params['woo_purchase_value_option'] = "price";
        }
        if($this->getOption('woo_view_content_value_option') == 'cog') {
            if(!empty($oldContent)) $params['woo_view_content_value_option'] = $oldContent;
            else $params['woo_view_content_value_option'] = "price";
        }
        if($this->getOption('woo_add_to_cart_value_option') == 'cog') {
            if(!empty($oldAddCart)) $params['woo_add_to_cart_value_option'] = $oldAddCart;
            else $params['woo_add_to_cart_value_option'] = "price";
        }
        if($this->getOption('woo_initiate_checkout_value_option') == 'cog') {
            if(!empty($oldInitCheckout)) $params['woo_initiate_checkout_value_option'] = $oldInitCheckout;
            else $params['woo_initiate_checkout_value_option'] = "price";
        }

        $params['woo_purchase_value_cog'] = '';
        $params['woo_content_value_cog'] = '';
        $params['woo_add_to_cart_value_cog'] = '';
        $params['woo_initiate_checkout_value_cog'] = '';

        $this->updateOptions($params);
    }

    public function getLog() {
        return $this->logger;
    }

    function woo_is_order_received_page() {
        if(is_order_received_page()) return true;
        global $post;
        $ids = PYS()->getOption("woo_checkout_page_ids");
        if(!empty($ids)) {
            if($post && in_array($post->ID,$ids)) {
                return true;
            }
        }
        if (did_action( 'elementor/loaded' )) {
            if ($post) {
                $elementor_page_id = get_option('elementor_woocommerce_purchase_summary_page_id');
                if ($elementor_page_id == $post->ID) return true;
            }
        }

        if(is_wc_endpoint_url( 'order-received')){
            return true;
        }

        return false;
    }
    public function isWPRocketPreload() {
        if(!empty($_SERVER['HTTP_USER_AGENT'])){
            $options = array('WP Rocket/Preload', 'WP-Rocket-Preload', 'WP Rocket/Homepage_Preload');
            foreach($options as $row) {
                if (stripos(strtolower($_SERVER['HTTP_USER_AGENT']), strtolower($row)) !== false) {
                    return true;
                }
            }
        }
        return false;
    }
}

/**
 * @return PYS
 */
function PYS() {
    return PYS::instance();
}