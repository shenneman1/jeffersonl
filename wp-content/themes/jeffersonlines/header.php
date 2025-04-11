<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		

		<?php
			// get our URL segments
			$segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

			// control google analytics property ID for testing
			if($segments[0]=="test-page"){
				$google_UA = "UA-32099620-3";
			}else{
				$google_UA = "UA-32099620-1";
			}

			// list of URLs for which to ignore mobile detection
			$urls_to_ignore = array(	"terms-and-conditions",
										"ride-the-bus",
										"updated-baggage-policy",
										"updated-refund-policy",
										"customers-with-disabilities",
										"how-we-operate",
									);

			// check for matching URLs
			if( array_search($segments[0], $urls_to_ignore) === false ) {
			    require_once 'Detection/Mobile_Detect.php';
			    $detect = new Mobile_Detect;

			    if($detect->isMobile()){
				        ?>
				        <script type="text/javascript">
				            function getCookie(name)
				            {
				                var re = new RegExp(name + "=([^;]+)");
				                var value = re.exec(document.cookie);
				                return (value != null) ? unescape(value[1]) : null;
				            }
				            
				            function getParameterByName(name, url) {
								if (!url) url = window.location.href;
								
								name = name.replace(/[\[\]]/g, "\\$&");
								
								var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)", "i"),
									results = regex.exec(url);
								
								if (!results) return null;
								
								if (!results[2]) return '';
								
								return decodeURIComponent(results[2].replace(/\+/g, " "));
							}
							function dropCookie (){
								var dt = new Date();
		   						dt.setDate(dt.getDate() + 5);
		   
				            	document.cookie="bypassMobile=true; expires=" + dt + "; path=/";
							}
				            
				            if(getParameterByName('bypassMobile') !== "true"){
				            	if(getCookie("bypassMobile") === null){
					            	document.location = "https://mobile.jeffersonlines.com/";
					            }
				            }else{
				            	dropCookie();
				            }
				        </script>
				        <?php
				    }
			}
		?>
		<!-- - - - - - - - - - - - - - - - - - - -
			Internet Explorer Conditional Comments
		 - - - - - - - - - - - - - - - - - - -  -->
		<!--[if IE 6]>
			<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ie_6.css">
		<![endif]-->
		<!--[if IE 7]>
			<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ie_7.css">
		<![endif]-->

		<!-- Scripts -->

		<?php wp_head(); ?>

		<!--<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
			</script>-->

		<script src="<?php echo get_template_directory_uri(); ?>/js/iframe-resizer-master/js/iframeResizer.min.js" type="text/javascript"></script>

	</head>
	<body <?php body_class(); ?>>

    <script type="text/javascript">
        var utag_data = {
            sizmek_activity_id : "", //
            sizmek_tag_id : "", // Sizmek Tag ID (TID)
            page_name : "", // Contains a user-friendly name for the page.
            page_section : "", // Contains a user-friendly page section, e.g. 'configuration section'.
            page_category : "", // Contains a user-friendly page category, e.g. 'appliance page'.
            page_subcategory : "", // Contains a user-friendly page subcategory, e.g. 'refrigerator page'.
            page_type : "", // Contains a user-friendly page type, e.g. 'cart page'.
            search_term : "", // Contains the search term or query submitted by a visitor.
            search_results : "", // Contains the number of results returned with a search query.
            search_type : "", // Contains the type of search conducted by the visitor.
            parent_title : "", // Title of parent window
            parent_domain : "", // Domain of parent window
            parent_pathname : "", // Pathname of parent window
            parent_url : "", // URL of parent window
            parent_referrer : "", // Referrer of parent window
            sizmek_cn : "", // Sizmek CN
            sizmek_tag_type : "", // Sizmek Tag Type
            sizmek_tval : "", // Sizmek TVAL
            doubleclick_id : "", // Doubleclick Type
            doubleclick_type : "", //
            doubleclick_category : "", //
            google_tracking_id : "", //
            google_tracker_name : "" // Google Tracker Name
        }
    </script>
    <!-- Loading script asynchronously -->
    <script type="text/javascript">
        (function(a,b,c,d){ a='//tags.tiqcdn.com/utag/advantagepublisherservices/aps/prod/utag.js'; b=document;c='script';d=b.createElement(c);d.src=a;d.type='text/java'+c;d.async=true; a=b.getElementsByTagName(c)[0];a.parentNode.insertBefore(d,a); })();
    </script>

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', '<?php echo $google_UA; ?>', 'auto');
      ga('send', 'pageview');

    </script>

		<!-- Google website satisfaction survey -->
		<script async="" defer="" src="//survey.g.doubleclick.net/async_survey?site=cxlgx7gtxrjmjepojox56zqbiq"></script>
		<!-- Google Tag Manager -->
		<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-M7CSTR"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-M7CSTR');</script>
		<!-- End Google Tag Manager -->

		<!-- main -->
		<div class="main homepage <?php echo get_post_meta($post->ID, 'bg-class', true); ?>">
			<!-- content wrapper -->
			<div class="content" style="position: relative; top: 0; left: 0;">

			<!-- header -->
			<div class="header" role="banner">

					<!-- logo -->
					<div class="logo">
						<a href="<?php echo home_url(); ?>">
							<img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" width="354" height="47" alt="Jefferson Lines">
						</a>
						<div class="clear"></div>
					</div>
					<!-- /logo -->



			</div>
			<!-- /header -->

			<!-- nav -->
			<nav class="topnav" role="navigation">
				<?php html5blank_nav(); ?>
			</nav>
			<!-- /nav -->
			<div class="clear"></div>