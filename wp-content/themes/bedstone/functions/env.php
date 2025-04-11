<?php
/**
 * environment vars
 *
 * @package Bedstone
 */

$env_debug = false;

$env = array();
$host = (!empty($_SERVER['X_FORWARDED_HOST'])) ? $_SERVER['X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST'];

// domains
$hosts = array(
    // do not include http:// prefix
    'LIVE'        => 'www.jeffersonlines.com',
    'PROOF'       => 'jeffersonlines.staging.wpengine.com',
    'STAGING'     => 'jefferson.windmilldesignworks.com',
);

// set DEFAULT values
$env['ENV_SHOW_ANALYTICS'] = true;
// URL Encode for TDS Booking Module
$env['ENV_TDS_URL_ENCODE'] = urlencode( 'http://' .  $hosts['LIVE'] . '/plan-your-trip/book-now' );

// env pages
$env['ENV_PAGE_THANKYOU'] = 2753;
$env['ENV_PAGE_WIFI'] = 2763;
$env['ENV_PAGE_WIFI_TERMS'] = 2764;
$env['ENV_PAGE_BUS_WIFI_TERMS'] = 2817;

if ($host == $hosts['LIVE']) {
    // set LIVE values (these should be defaults)

    // TDS tests per Ron
    $env['ENV_PAGE_TDS_TEST_MODULE'] = 2890;
    $env['ENV_PAGE_TDS_TEST_BOOK'] = 2891;
} else {
    // set NON-LIVE values
    $env['ENV_SHOW_ANALYTICS'] = false;

    if ($host == $hosts['PROOF']) {
        // set STAGING values
        // URL Encode for TDS Booking Module
        $env['ENV_TDS_URL_ENCODE'] = urlencode( 'http://' .  $hosts['PROOF'] . '/plan-your-trip/book-now' );
    }

    if ($host == $hosts['STAGING']) {
        // set STAGING values
        // URL Encode for TDS Booking Module
        $env['ENV_TDS_URL_ENCODE'] = urlencode( 'http://' .  $hosts['STAGING'] . '/plan-your-trip/book-now' );
        $env['ENV_PAGE_THANKYOU'] = 2741;
        $env['ENV_PAGE_WIFI'] = 2743;
        $env['ENV_PAGE_WIFI_TERMS'] = 2748;
        $env['ENV_PAGE_BUS_WIFI_TERMS'] = 2753;
    }
}

// Optional local file for private values -- ignore this file from the repo
if (file_exists(__DIR__ . '/env-local.php')) {
    if (!require(__DIR__ . '/env-local.php')) {
        exit('When processing $env settings, there was an error trying to include the local settings file.');
    }
}

// Loop through and define() everything
if (!empty($env)) {
    foreach ($env as $name => $value) {
        if (!define($name, $value)) {
            exit("When processing \$env settings, the define() of '$name' failed.");
        }
    }
}

// Debugging output and exit
if ($env_debug) {
    $lf = "\n\n";
    echo "View Source... $lf <!-- $lf \$host $lf";
    var_dump($host);
    echo "$lf \$env $lf";
    ksort($env);
    var_dump($env);
    echo "$lf get_defined_constants()['user'] $lf";
    $defined_constants = array_intersect_key(get_defined_constants(true), array('user' => 1));
    ksort($defined_constants['user']);
    var_dump($defined_constants['user']);
    echo "$lf -->";
    exit;
}

// remove vars
unset(
    $env_debug,
    $env,
    $host,
    $hosts
);
