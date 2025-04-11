<?php

?>

<div  class="wd-modal__overlay">
    <div id="wd_modal_wifi" class="wd-modal wifi-popup">

        <img class="wifi-popup__logo" src="<?php bloginfo('template_directory'); ?>/images/logo-jefferson-lines.svg" alt="<?php bloginfo('name'); ?>">


        <script type="text/javascript" src="//app.icontact.com/icp/static/form/javascripts/validation.js"></script>
        <script type="text/javascript" src="//app.icontact.com/icp/static/form/javascripts/tracking.js"></script>
        <link rel="stylesheet" type="text/css" href="//app.icontact.com/icp/static/human/css/signupBuilder/formGlobalStyles.css">


        <div class="popup__form-wrap popup__form-wrap--wifi">
            <form id="ic_signupform" method="POST" action="https://app.icontact.com/icp/core/mycontacts/signup/designer/form/?id=12&cid=1151114&lid=20504">

                <div class="form-section form-section--wifi form-section--w-labels">
                    <h4>Complimentary Wi-Fi Service</h4>

                    <span class="faux-link toggle--wifi-terms">Terms and Conditions</span>

                    <div class="target--wifi-terms">
                        <div class="content">
                            <?php echo get_post_field('post_content', PAGE_WIFI_TERMS); ?>
                        </div>
                    </div>

                    <label class="label-checkbox" for="wifi-terms"><input id="wifi-terms" type="checkbox" name="wifi-terms" value="true"> Yes, I agree to abide by the above terms and conditions by taking advantage of the complimentary Wi-Fi service.</label>
                </div>

                <hr>

                <div class="form-section form-section--newsletter form-section--w-labels">
                    <h4>Subscribe to our Newsletter</h4>
                    <label class="label-checkbox" for="wifi-signup"><input id="wifi-signup" type="checkbox" name="wifi-signup" value="true" checked> Yes, I would like to recieve emails from Jefferson Lines with news, specials, and discounts.</label>
                </div>

                <div class="formEl fieldtype-input required" data-validation-type="1" data-label="Email">
                    <label>Email<span class="indicator required">*</span></label>
                    <input id="wifi_email_input" type="text" placeholder="Email Address" name="data[email]">
                </div>

                <div class="formEl fieldtype-checkbox required" dataname="listGroups" data-validation-type="1" data-label="Lists" style="display: none; width: 100%;">
                    <h3>Lists<span class="indicator required">*</span></h3>
                    <div class="option-container">
                        <label class="checkbox"><input type="checkbox" alt="" name="data[listGroups][]" value="81370" checked="checked">0 - JL Master List (opt-in email; no College Connection)</label>
                    </div>
                </div>

                <div class="submit-container">
                    <input id="form-submit" type="submit" value="Submit" class="btn btn-submit">
                </div>

                <div class="hidden-container" style="visibility: hidden;"></div>

                <div id="form_opt_out" class="form-section form-section--opt-out">
                    <span class="faux-link newsletter-opt-out">No Thank You - Take me to the Web</span>
                </div>

            </form>
            <img class="ic-img" src="//app.icontact.com/icp/core/signup/tracking.gif?id=12&cid=1151114&lid=20504" style="visibility: hidden;"/>
        </div>

    </div>
</div>