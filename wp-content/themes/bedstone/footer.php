<?php
/**
 * footer
 *
 * @package Bedstone
 */

// Make $acf_options object available (from functions.php)
global $acf_options;

if ( !is_front_page() && get_the_id() != PAGE_BOOK_NOW && 'tpl-charter.php' != get_page_template_slug() && 'tpl-hundred-years.php' != get_page_template_slug() ) {
    get_template_part('inc', 'booking-module');
}
?>

<footer class="site-footer">
    <?php if ( ! is_page_template( 'tpl-hundred-years.php' ) && ! is_page( '2019-giveaway' ) ) : ?>
        <?php get_template_part('inc', 'signup-module'); ?>
    <?php endif; ?>

    <div class="footer-main">
        <div class="container">
            <div class="columns">
                <div class="footer-main__col col col-sm-6 col-lg-3">
                    <h2 class="footer-main__col-heading"><?php echo $acf_options->footer_nav_1_heading ?></h2>
                    <ul class="nav-footer__list">
                        <?php echo post_obj_repeater_list('footer_nav_1_repeater'); // functions.php ?>
                    </ul>
                </div>

                <div class="footer-main__col col col-sm-6 col-lg-3">
                    <h2 class="footer-main__col-heading"><?php echo $acf_options->footer_nav_2_heading ?></h2>
                    <ul class="nav-footer__list">
                        <?php echo post_obj_repeater_list('footer_nav_2_repeater'); // functions.php ?>
                    </ul>
                </div>

                <div class="footer-main__col col col-sm-6 col-lg-3">
                    <h2 class="footer-main__col-heading"><?php echo $acf_options->footer_nav_3_heading ?></h2>
                    <ul class="nav-footer__list">
                        <?php echo post_obj_repeater_list('footer_nav_3_repeater'); // functions.php ?>
                    </ul>
                </div>

                <div class="footer-main__col col col-sm-6 col-lg-3">
                    <h2 class="footer-main__col-heading"><a href="<?php echo get_permalink(PAGE_CONTACT); ?>">Contact Us</a></h2>
                    <span class="phone phone--footer">
                        <a class="click-to-call" href="tel:<?php echo $acf_options->global_main_phone; ?>"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $acf_options->global_main_phone; ?></a>
                    </span>
                    <div class="customer-care">
                        <h2 class="footer-main__col-heading">Customer Care Hours</h2>
                        <ul class="nav-footer__list">
                            <li>Mon-Fri: 7:30AM – 7:00PM</li>
                            <li>Sat-Sun: 7:30AM – 4:00PM</li>
                        </ul>
                    </div>
                    <div class="social social--footer">
                        <?php get_template_part('inc', 'nav-social'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="subfooter">
        <div class="container">
            <ul class="subfooter__list">
                <li>&copy; <?php echo date('Y') . ' ' . get_bloginfo('name'); ?></li>
                <li><a href="<?php echo get_privacy_policy_url(); ?>">Privacy Policy</a></li>
                <li><a href="<?php echo get_permalink(PAGE_SITE_MAP); ?>"><?php echo get_the_title(PAGE_SITE_MAP); ?></a></li>
            </ul>
        </div>
    </div>

</footer>

<?php
// disabling wifi popup
//    if ( get_the_id() == PAGE_WIFI ) {
//        get_template_part('inc', 'wifi-popup');
//    }
?>

</div> <!-- .body-overlay -->

<?php wp_footer(); ?>

<?php /* placeholder support for legacy IE */ ?>
<!--[if lte IE 9]>
<script src="https://cdn.jsdelivr.net/jquery.placeholder/2.1.1/jquery.placeholder.min.js" type="text/javascript"></script>
<script type="text/javascript"> jQuery(document).ready(function($){ $('input, textarea').placeholder(); }); </script>
<![endif]-->

<!--[if lte IE 9]> </div> <![endif]-->
<!--[if IE 9]> </div> <![endif]-->
<!--[if IE 8]> </div> <![endif]-->
</body>
</html>
