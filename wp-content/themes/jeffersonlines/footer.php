	<div class="footer">
		<div class="footer_col1">
			<div class="footer_title">
				About Jefferson
			</div>
			<?php wp_nav_menu (array('theme_location' => 'footer-menu-1','menu_class' => 'nav'));?>
		</div>
		<div class="footer_col2">
			<div class="footer_title">
				The Jefferson Difference
			</div>
			<?php wp_nav_menu (array('theme_location' => 'footer-menu-2','menu_class' => 'nav'));?>
		</div>
		<div class="footer_col3">
			<div class="footer_title">
				Customer Service
			</div>
			<?php wp_nav_menu (array('theme_location' => 'footer-menu-3','menu_class' => 'nav'));?>
		</div>
		<div class="footer_col4">
			<div class="footer_title">
				My Account
			</div>
			<?php wp_nav_menu (array('theme_location' => 'footer-menu-4','menu_class' => 'nav'));?>
		</div>
		<div class="clear"></div>
	</div>
	<!-- /footer -->

	<p style="color: red; font-weight: bold; font-size: 24px; font-family: Arial, Helvetica, sans-serif; position: absolute; right: 0; top: 40px; margin: 0; text-shadow: #ffc 0 0 5px;">
		800-451-5333
	</p>

	</div>
	<!-- /content -->
		<p id="copyright" style="clear: both;">Content and layout &copy; 2011 Jefferson Lines. All rights reserved. <a href=
        "/privacy-policy/">Privacy Policy</a> | <a href="https://mobile.jeffersonlines.com/">Go to Mobile Site</a></p>

    <?php wp_footer(); ?>
		</div>
		<!-- /main -->


	</body>
</html>
