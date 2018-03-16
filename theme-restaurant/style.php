<?php
global $rf_theme_options, $wp_query;

if (isset($rf_theme_options['cp_color1'])) $rf_color1 = str_replace('#','',$rf_theme_options['cp_color']);
if (isset($rf_theme_options['cp_color2'])) $rf_color2 = str_replace('#','',$rf_theme_options['cp_color2']);
if (isset($rf_theme_options['cp_color2_fg'])) $rf_color2_fg = str_replace('#','',$rf_theme_options['cp_color2_fg']);
if (isset($rf_theme_options['cp_color3'])) $rf_color3 = str_replace('#','',$rf_theme_options['cp_color3']);
if (isset($rf_theme_options['cp_color3_fg'])) $rf_color3_fg = str_replace('#','',$rf_theme_options['cp_color3_fg']);

if (isset($rf_theme_options['cp_font1_family'])) $rf_font1 = $rf_theme_options['cp_font1_family'];
if (isset($rf_theme_options['cp_font2_family'])) $rf_font2 = $rf_theme_options['cp_font2_family'];

if (isset($rf_theme_options['cp_site_background_color'])) $rf_site_background_color = str_replace('#','',$rf_theme_options['cp_site_background_color']);
if (isset($rf_theme_options['cp_content_background_color'])) $rf_content_background_color = str_replace('#','',$rf_theme_options['cp_content_background_color']);

if (isset($rf_theme_options['cp_menu_bg_color'])) $rf_menu_bg_color = str_replace('#','',$rf_theme_options['cp_menu_bg_color']);
if (isset($rf_theme_options['cp_menu_text_color'])) $rf_menu_text_color = str_replace('#','',$rf_theme_options['cp_menu_text_color']);

if (isset($rf_theme_options['cp_headertitlebg'])) $rf_headertitlebg = str_replace('#','',$rf_theme_options['cp_headertitlebg']);
if (isset($rf_theme_options['cp_headertitlecolor'])) $rf_headertitlecolor = str_replace('#','',$rf_theme_options['cp_headertitlecolor']);

if (isset($rf_theme_options['cp_footer_bg_color'])) $rf_footer_bg_color = str_replace('#','',$rf_theme_options['cp_footer_bg_color']);
if (isset($rf_theme_options['cp_footer_title_color'])) $rf_footer_title_color = str_replace('#','',$rf_theme_options['cp_footer_title_color']);
if (isset($rf_theme_options['cp_footer_text_color'])) $rf_footer_text_color = str_replace('#','',$rf_theme_options['cp_footer_text_color']);
?>

<style type="text/css">



/* First color */
<?php if (isset($rf_color1)) { ?>
body,
.woocommerce div.product p.price, 
.woocommerce div.product span.price,
.woocommerce ul.products li.product .price,
.woocommerce div.product p.price span, 
.woocommerce div.product span.price span,
.woocommerce ul.products li.product .price span {
	color: #<?php echo $rf_color1; ?>;
}
<?php } ?>



/* Second color */
<?php if (isset($rf_color2)) { ?>


a,
/*sale price */
.woocommerce .woocommerce-info:before,
.woocommerce .woocommerce-message:before,
h3.menucard-cat,
.menucard-item h4 {
	color: #<?php echo $rf_color2; ?>;
}



a:not(.btn):not(.button):not(button):hover {
	color: #<?php echo $rf_color2; ?> !important;
}



.widget-area .sidepanel h3,
.btn,
input[type=submit],
button,
.button,
.menucard-nav,
.menucard-tags span,
.wpcr3_show_btn,
.wpcr3_submit_btn,
.wpcr3_cancel_btn,
.woocommerce #content input.button, 
.woocommerce #respond input#submit, 
.woocommerce a.button, 
.woocommerce button.button, 
.woocommerce input.button, 
.woocommerce-page #content input.button, 
.woocommerce-page #respond input#submit, 
.woocommerce-page a.button, 
.woocommerce-page button.button, 
.woocommerce-page input.button,
.woocommerce #content input.button.alt, 
.woocommerce #respond input#submit.alt, 
.woocommerce a.button.alt, 
.woocommerce button.button.alt, 
.woocommerce input.button.alt, 
.woocommerce-page #content input.button.alt, 
.woocommerce-page #respond input#submit.alt, 
.woocommerce-page a.button.alt, 
.woocommerce-page button.button.alt, 
.woocommerce-page input.button.alt {
	background: #<?php echo $rf_color2; ?>;
}

.woocommerce ul.products li.product .onsale:before,
.woocommerce span.onsale:before,
.widget-area .sidepanel h3:before,
.btn:before,
input[type=submit]:before,
button:before,
.button:before,
.menucard-nav:before,
.wpcr3_show_btn:before,
.wpcr3_submit_btn:before,
.wpcr3_cancel_btn:before,
.woocommerce #content input.button:before, 
.woocommerce #respond input#submit:before, 
.woocommerce a.button:before, 
.woocommerce button.button:before, 
.woocommerce input.button:before, 
.woocommerce-page #content input.button:before, 
.woocommerce-page #respond input#submit:before, 
.woocommerce-page a.button:before, 
.woocommerce-page button.button:before, 
.woocommerce-page input.button:before,
.woocommerce #content input.button.alt:before, 
.woocommerce #respond input#submit.alt:before, 
.woocommerce a.button.alt:before, 
.woocommerce button.button.alt:before, 
.woocommerce input.button.alt:before, 
.woocommerce-page #content input.button.alt:before, 
.woocommerce-page #respond input#submit.alt:before, 
.woocommerce-page a.button.alt:before, 
.woocommerce-page button.button.alt:before, 
.woocommerce-page input.button.alt:before {
    border-color: <?php echo adjustBrightness($rf_color2, -40); ?>;
}
/*sale badge */
.woocommerce span.onsale,
/* remove x */
.woocommerce a.remove:hover,
/* button */
.woocommerce #respond input#submit.alt,
.woocommerce a.button.alt,
.woocommerce button.button.alt,
.woocommerce input.button.alt {
	background-color: #<?php echo $rf_color2; ?>;

}
.btn:hover,
input[type=submit]:hover,
button:hover,
.button:hover,
.menucard-nav:hover,
.wpcr3_show_btn:hover,
.wpcr3_submit_btn:hover,
.wpcr3_cancel_btn:hover,
.woocommerce #respond input#submit.alt:hover,
.woocommerce a.button.alt:hover,
.woocommerce button.button.alt:hover,
.woocommerce input.button.alt:hover,
.woocommerce #content input.button:hover, 
.woocommerce #respond input#submit:hover, 
.woocommerce a.button:hover, 
.woocommerce button.button:hover, 
.woocommerce input.button:hover, 
.woocommerce-page #content input.button:hover, 
.woocommerce-page #respond input#submit:hover, 
.woocommerce-page a.button:hover, 
.woocommerce-page button.button:hover, 
.woocommerce-page input.button:hover,
.woocommerce #content input.button.alt:hover, 
.woocommerce #respond input#submit.alt:hover, 
.woocommerce a.button.alt:hover, 
.woocommerce button.button.alt:hover, 
.woocommerce input.button.alt:hover, 
.woocommerce-page #content input.button.alt:hover, 
.woocommerce-page #respond input#submit.alt:hover, 
.woocommerce-page a.button.alt:hover, 
.woocommerce-page button.button.alt:hover, 
.woocommerce-page input.button.alt:hover {
    background-color: <?php echo adjustBrightness($rf_color2, -40); ?>;
}

.woocommerce .woocommerce-info,
.woocommerce .woocommerce-message {
    border-top-color: #<?php echo $rf_color2; ?>;
}

<?php } ?>



<?php if (isset($rf_color2_fg)) { ?>
.widget-area .sidepanel h3,
.btn,
input[type=submit],
button,
.button,
.menucard-nav i,
.menucard-tags span,
.wpcr3_show_btn,
.wpcr3_submit_btn,
.wpcr3_cancel_btn,
.woocommerce #content input.button, 
.woocommerce #respond input#submit, 
.woocommerce a.button, 
.woocommerce button.button, 
.woocommerce input.button, 
.woocommerce-page #content input.button, 
.woocommerce-page #respond input#submit, 
.woocommerce-page a.button, 
.woocommerce-page button.button, 
.woocommerce-page input.button,
.woocommerce #content input.button.alt, 
.woocommerce #respond input#submit.alt, 
.woocommerce a.button.alt, 
.woocommerce button.button.alt, 
.woocommerce input.button.alt, 
.woocommerce-page #content input.button.alt, 
.woocommerce-page #respond input#submit.alt, 
.woocommerce-page a.button.alt, 
.woocommerce-page button.button.alt, 
.woocommerce-page input.button.alt {
	color: #<?php echo $rf_color2_fg; ?> !important;
}
<?php } ?>



/* Third color */
<?php if (isset($rf_color3)) { ?>
/*a:not(.btn):not(.button):not(button):hover {
	color: #<?php echo $rf_color3; ?> !important;
}*/



/*something {
	background-color: #<?php echo $rf_color3; ?>;
}*/



/*something {
	border-color: #<?php echo $rf_color3; ?>;
}*/
<?php } ?>



<?php if (isset($rf_color3_fg)) { ?>
/*something {
	color: #<?php echo $rf_color3_fg; ?> !important;
}*/
<?php } ?>



/* Primary font */
<?php if (isset($rf_font1)) { ?>
h1,
h2,
h3,
h4,
h5,
h6,
nav.mainnav ul li a,
footer {
	<?php echo stripslashes($rf_font1); ?>
}
<?php } ?>



/* Secondary font */
<?php if (isset($rf_font2)) { ?>
body {
	<?php echo stripslashes($rf_font2); ?>
}
<?php } ?>



<?php if (isset($rf_content_background_color) && $rf_content_background_color != '') { ?>
.hentry,
.sidepanel,
.menucard-cat span,
.menucard-item h4,
.menucard-item .menucard-price {
	background-color: #<?php echo $rf_content_background_color; ?>;
}
.menucard-item .menucard-title-price:before,
.rf_fronttext_widget .fronttext-image-container,
.sidepanel li,
.post-leadimage,
.woocommerce ul.products li.product a img {
	border-color: <?php echo adjustBrightness($rf_content_background_color, -40); ?>;
}
.tagcloud a {
	background-color: <?php echo adjustBrightness($rf_content_background_color, -40); ?>;
}

.woocommerce .woocommerce-ordering select{
    padding: 5px;
}
.woocommerce .woocommerce-ordering select,
.select2-container .select2-choice,
textarea,
input[type=text],
input[type=tel],
input[type=search],
input[type=email],
input[type=password] {
	background-color: <?php echo adjustBrightness($rf_content_background_color, -10); ?>;
}
<?php } ?>



<?php if (isset($rf_site_background_color) && $rf_site_background_color != '') { ?>
body,
section {
	background-color: #<?php echo $rf_site_background_color; ?>;
}

.hentry:before,
.sidepanel:before {
	border: #<?php echo $rf_site_background_color; ?> 1px solid;

}

.widget_shopping_cart_content li.mini_cart_item,
.widget_shopping_cart_content .total {
	border-color:#<?php echo $rf_site_background_color; ?>;
}
<?php } ?>



<?php if (isset($rf_menu_bg_color) || $rf_menu_bg_color != '') { ?>
nav.mainnav,
nav.mainnav ul.sub-menu,
.mobile-nav-button,
nav.wp_nav_menu_mobile,
nav.wp_nav_menu_mobile ul li a {
	background: rgba(<?php echo rf_hex2rgb($rf_menu_bg_color); ?>,1);
}
nav.mainnav ul li.current-menu-item a,
nav.mainnav ul li a:hover {
	color: rgba(<?php echo rf_hex2rgb($rf_menu_bg_color); ?>,1) !important;
}
<?php } ?>



<?php if (isset($rf_menu_text_color) && $rf_menu_text_color != '') { ?>
nav.mainnav,
nav.mainnav ul li a,
.mobile-nav-button i,
nav.wp_nav_menu_mobile,
nav.wp_nav_menu_mobile ul li a,
nav.wp_nav_menu_mobile ul li.menu-item-has-children a:after,
nav.wp_nav_menu_mobile ul li.toggle-submenu a:before {
	color: #<?php echo $rf_menu_text_color; ?>;
}
nav.mainnav ul li.current-menu-item a,
nav.mainnav ul li a:hover {
	background: #<?php echo $rf_menu_text_color; ?>;
}
nav.wp_nav_menu_mobile ul li.current-menu-item a {
	border-left-color: #<?php echo $rf_menu_text_color; ?>;
}
<?php } ?>



<?php if (isset($rf_headertitlebg) && $rf_headertitlebg != '') { ?>
#pageheader {
	background-color: #<?php echo $rf_headertitlebg; ?>;
}
<?php } ?>



<?php if (isset($rf_headertitlecolor) && $rf_headertitlecolor != '') { ?>
#pageheader,
#pageheader a {
	color: #<?php echo $rf_headertitlecolor; ?>;
}
<?php } ?>



<?php if (isset($rf_footer_bg_color) && $rf_footer_bg_color != '' ) { ?>
footer {
	background: #<?php echo $rf_footer_bg_color; ?>;
}
<?php } ?>



<?php if (isset($rf_footer_title_color) && $rf_footer_title_color != '' ) { ?>
footer .sidepanel h3,
footer nav ul li a,
#footertext {
	color: #<?php echo $rf_footer_title_color; ?>;
}
#footer-line {
	background-color: #<?php echo $rf_footer_title_color; ?>;
}
<?php } ?>



<?php if (isset($rf_footer_text_color) && $rf_footer_text_color != '') { ?>
footer {
	color: #<?php echo $rf_footer_text_color; ?>;
}
<?php } ?>



/* Custom CSS from theme settings */
<?php if (isset($rf_theme_options['cp_custom_css']) && $rf_theme_options['cp_custom_css'] != '') echo stripslashes( $rf_theme_options['cp_custom_css'] ); ?>

</style>