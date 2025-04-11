<?php
/**
 * analytics functions
 *
 * @package Bedstone
 */

/**
 * Display google tag manager script
 * This needs to be in the <body> because it uses an iframe
 *
 * @link https://support.google.com/tagmanager/answer/6103696?hl=en
 *
 * @param string $gtm Client ID
 *
 * @return void
 */
function bedstone_google_tag_manager($gtm = '')
{
    if (!empty($gtm)) {
        echo "
        <!-- Google Tag Manager -->
        <noscript><iframe src='//www.googletagmanager.com/ns.html?id=" . $gtm . "'
        height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','" . $gtm . "');</script>
        <!-- End Google Tag Manager -->
        ";
    }
}

/**
 * Display google analytics script
 *
 * @link https://support.google.com/analytics/answer/1008080?hl=en#GA
 *
 * @param string $ua Client user account
 * @param bool $debug Loads analytics_debug.js script
 *
 * @return void
 */
function bedstone_google_analytics($ua = '', $debug = false)
{
    if (!empty($ua)) {
        echo "
        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics" . ($debug ? '_debug' : '') . ".js','ga');
        ga('create', '" . $ua . "', 'auto');
        ga('send', 'pageview');
        </script>
        ";
    }
}
