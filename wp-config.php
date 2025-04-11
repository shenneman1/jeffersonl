<?php
# Database Configuration
define( 'DB_NAME', 'wp_jeffersonlines' );
define( 'DB_USER', 'jeffersonlines' );
define( 'DB_PASSWORD', 'jwzhDdjjzb1IAiIN' );
define( 'DB_HOST', '127.0.0.1:3306' );
define( 'DB_HOST_SLAVE', '127.0.0.1:3306' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');

//define( 'DISALLOW_FILE_EDIT', FALSE ); // Sucuri Security: Wed, 01 Jun 2016 16:21:47 +0000

$table_prefix = 'wp_jeff_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         'wvl^(0+6I$-y1:E^?hZL?sCw5L[~XI?m[GFs_wnd(j$?+jBhe-6x4F>];r/Xrw/5');
define('SECURE_AUTH_KEY',  '4=3w#=}!@)+@vH!lL`nrEZ`SP@;.%^*gpX5r;Gh~k5f4tg.`^V;!^xL $>$-GDc`');
define('LOGGED_IN_KEY',    'kk[eb~eM-f4<Z$jnBY*}!I;U)r xZ}G>{m.8Z[pZwW0Vt(QaMy}#-?-a=:vbX]!g');
define('NONCE_KEY',        'TbA]|HlG+}Q#>n]k5Awl5eO9G{A#c2OGT+G@u6._V|dI~oVuP%n+Ja6--`CZqHDL');
define('AUTH_SALT',        'v~CWcFb%D%4QJb[2:]u<^TgK<qloK2|!:WC<W<$B0_Xl6:^kw!wl>WDJ3Y*@^|rg');
define('SECURE_AUTH_SALT', '*BrCl~t :ZfswM1NaL.VdW*S(t@M6SbZZ95@x~_{).V5LnRx2NEK7s%=Wu!]V4@m');
define('LOGGED_IN_SALT',   'z^:o7duT^[0H*63,CA9$_^iQqF543[L]GboUDM5:wj09yEHEh5gcy(5LoHCR^bZp');
define('NONCE_SALT',       '%fE)|HN,s/BE0cER+/9h*m$z}J7CZ Y~ik)9RY3{$)fLM/R?k;Ym?-zzp8[v@wNh');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'jeffersonlines' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '06a8d1cea67018901855ceb8eeadd7b1d524909b' );

define( 'WPE_FOOTER_HTML', "" );

define( 'WPE_CLUSTER_ID', '219629' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_LBMASTER_IP', '' );

define( 'WPE_CDN_DISABLE_ALLOWED', false );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', true );

define( 'FORCE_SSL_LOGIN', true );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

// Increasing memory limit
define( 'WP_MEMORY_LIMIT', '512M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );

define( 'WP_DEBUG', false );

if ( WP_DEBUG ) {
    define( 'WP_DEBUG_DISPLAY', false );
    define( 'WP_DEBUG_LOG', true );
    define( 'SAVEQUERIES', true );
    define( 'SCRIPT_DEBUG', true );
}

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'www.jeffersonlines.com', 1 => 'jeffersonlines.wpengine.com', 2 => 'jeffersonlines.com', 3 => 'jeffersonlines.wpenginepowered.com', );

$wpe_varnish_servers=array ( 0 => '127.0.0.1', );

$wpe_special_ips=array ( 0 => '104.198.4.115', 1 => 'pod-219629-utility.pod-219629.svc.cluster.local', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( 0 =>  array ( 'match' => 'www.jeffersonlines.com', 'custom' => 'jeffersonlines.wpenginepowered.com', 'secure' => true, 'dns_check' => 0, ), );

$wpe_netdna_domains_secure=array ( 0 =>  array ( 'match' => 'www.jeffersonlines.com', 'custom' => 'jeffersonlines.wpenginepowered.com', 'secure' => true, 'dns_check' => 0, ), );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( 'default' =>  array ( 0 => 'unix:///tmp/memcached.sock', ), );


//define( 'WP_SITEURL', 'http://www.jeffersonlines.com' );

//define( 'WP_HOME', 'http://www.jeffersonlines.com' );

define( 'WPE_SFTP_ENDPOINT', '34.82.42.47' );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings








# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');
