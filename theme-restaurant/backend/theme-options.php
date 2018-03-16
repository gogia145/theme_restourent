<?php

//Theme options
$optionlist = Array(
	array(
		'id' => 'general',
		'name' => 'General',
		'first' => true,
		'options' => array(
			array(
				'name' => 'General',
				'type' => 'title'
			),
			array(
				'id' => 'cp_bloglogo',
				'name' => 'Website logo',
				'type' => 'upload'
			),
			array(
				'id' => 'cp_logowidth',
				'name' => 'Maximum logo width',
				'type' => 'text',
				'default' => '220px',
				'desc' => 'The maximum width of your logo (for example: 240px)'
			),
			/*array(
				'id' => 'cp_favicon',
				'name' => 'Favicon',
				'type' => 'upload'
			),*/
			array(
				'id' => 'cp_tagline_phone',
				'name' => 'Top header: Phone',
				'type' => 'text',
				'desc' => 'The phone number displayed at the top of the site'
			),
			array(
				'id' => 'cp_tagline_email',
				'name' => 'Top header: Email',
				'type' => 'text',
				'desc' => 'The email displayed at the top of the site'
			),
			array(
				'id' => 'cp_tagline_location',
				'name' => 'Top header: Location',
				'type' => 'text',
				'desc' => 'The location displayed at the top of the site'
			),
			array(
				'id' => 'cp_breadcrumbs',
				'name' => 'Display a breadcrumb',
				'type' => 'checkbox',
				'desc' => 'Display the breadcrumb under the slider & navigation menu'
			),
			array(
				'id' => 'cp_trackingcode',
				'name' => 'Google analytics',
				'type' => 'text',
				'desc' => 'Insert your google analytics tracking number'
			),
			array(
				'id' => 'cp_sidebar_position',
				'name' => 'Sidebar position',
				'type' => 'dropdown',
				'options' => array(
					'Sidebar right' => 'Sidebar on the right',
					'Sidebar left' => 'Sidebar on the left',
					'Fullwidth page' => 'Fullwidth page: hide the sidebar'
				),
				'default' => 'Sidebar right',
				'desc' => 'Select the default position for the sidebar.'
			),
			array(
				'id' => 'cp_sidebars',
				'name' => 'Custom sidebars',
				'type' => 'text',
				'desc' => 'Your custom sidebars. Seperate the sidebar names with a comma. For example: home, contact, services'
			),
			array(
				'id' => 'cp_footer_text',
				'name' => 'Footer text',
				'type' => 'text',
				'desc' => 'The text located in the bottom of the footer, mainly used for copyright text.'
			)
		)
	),
	array(
		'id' => 'design',
		'name' => 'Design',
		'options' => array(
			array(
				'name' => 'Design',
				'type' => 'title'
			),
			array(
				'id' => 'cp_headertype',
				'name' => 'Header type',
				'type' => 'dropdown',
				'options' => array(
					'header1' => 'Logo left',
					'header2' => 'Logo center',
					'header3' => 'Logo in menubar'
				),
				'default' => 'header1',
				'desc' => 'Select the type of header.'
			),
			array(
				'id' => 'cp_site_background_color',
				'name' => 'Site background color',
				'type' => 'colorpicker',
				'default' => 'edeae6',
				'desc' => 'The background color used for the site'
			),
			array(
				'id' => 'cp_content_background_color',
				'name' => 'Content background color',
				'type' => 'colorpicker',
				'default' => 'ffffff',
				'desc' => 'The background color used for the content'
			),
			/*array(
				'id' => 'cp_sitewidth',
				'name' => 'Container width',
				'type' => 'text',
				'default' => '1200',
				'desc' => 'The maximum width of your content (for example: 1200px)'
			),*/
			array(
				'id' => 'cp_headertitlebg',
				'name' => 'Header title background',
				'type' => 'colorpicker',
				'default' => '110e0e',
				'desc' => 'The title background color used in the header of the site'
			),
			array(
				'id' => 'cp_headertitlecolor',
				'name' => 'Header text color',
				'type' => 'colorpicker',
				'default' => 'ffffff',
				'desc' => 'The text color used in the header of the site'
			),
			array(
				'id' => 'cp_menu_bg_color',
				'name' => 'Menu background color',
				'type' => 'colorpicker',
				'default' => 'b00000',
				'desc' => 'The background color for the navigation menu'
			),
			/*array(
				'id' => 'cp_menu_bg_opacity',
				'name' => 'Menu background opacity',
				'type' => 'slider',
				'default' => '1',
				'desc' => 'The opacity of the navigation menu bar'
			),*/
			array(
				'id' => 'cp_menu_text_color',
				'name' => 'Menu text color',
				'type' => 'colorpicker',
				'default' => 'ffffff',
				'desc' => 'The text color for the navigation menu'
			),
			array(
				'id' => 'cp_color',
				'name' => 'Theme text color',
				'type' => 'colorpicker',
				'default' => '585858',
				'desc' => 'The text color used in the theme'
			),
			array(
				'id' => 'cp_color2',
				'name' => 'Primary theme color',
				'type' => 'colorpicker',
				'default' => 'b00000',
				'desc' => 'The Primary color used in the theme for buttons, links, lines etc'
			),
			array(
				'id' => 'cp_color2_fg',
				'name' => 'Primary theme text color',
				'type' => 'colorpicker',
				'default' => 'ffffff',
				'desc' => 'The Primary text color used for text in buttons'
			),
			/*array(
				'id' => 'cp_color3',
				'name' => 'Secondary theme color',
				'type' => 'colorpicker',
				'default' => 'e99d3a',
				'desc' => 'The Secondary color used in the theme mainly for hovers'
			),
			array(
				'id' => 'cp_color3_fg',
				'name' => 'Secondary theme text color',
				'type' => 'colorpicker',
				'default' => 'fff',
				'desc' => 'The secondary text color used for text in buttons upon hover'
			),*/
			array(
				'id' => 'cp_footer_bg_color',
				'name' => 'Footer background color',
				'type' => 'colorpicker',
				'default' => '222222',
				'desc' => 'The background color for the footer'
			),
			array(
				'id' => 'cp_footer_title_color',
				'name' => 'Footer title color',
				'type' => 'colorpicker',
				'default' => 'ffffff',
				'desc' => 'The title color for the footer'
			),
			array(
				'id' => 'cp_footer_text_color',
				'name' => 'Footer text color',
				'type' => 'colorpicker',
				'default' => 'aaaaaa',
				'desc' => 'The text color for the footer'
			),
			array(
				'id' => 'cp_font1_source',
				'name' => 'Title font source',
				'type' => 'textarea',
				'default' => 'https://fonts.googleapis.com/css?family=Montserrat:400,700',
				'desc' => 'The title font used in the theme. Copy & paste the source link from the Google Font directory: <a href="http://www.google.com/fonts">http://www.google.com/fonts</a>. Copy the source link in this field. For the Montserrat font this would be "https://fonts.googleapis.com/css?family=Montserrat:400,700".'
			),
			array(
				'id' => 'cp_font1_family',
				'name' => 'Title font family',
				'type' => 'textarea',
				'default' => 'font-family: "Montserrat", sans-serif;',
				'desc' => 'The family declaration for the title font. You can copy & paste this from the google page. For the "Montserrat" font this would be: font-family: "Montserrat", sans-serif;'
			),
			array(
				'id' => 'cp_font2_source',
				'name' => 'Body font source',
				'type' => 'textarea',
				'default' => 'https://fonts.googleapis.com/css?family=Muli:400,400i,600,600i,700,700i,800,800i,900,900i',
				'desc' => 'The body font used in the theme. Copy & paste the source link from the Google Font directory: <a href="http://www.google.com/fonts">http://www.google.com/fonts</a>. Copy the source link in this field. For the "Muli" font this would be "https://fonts.googleapis.com/css?family=Muli:400,400i,600,600i,700,700i,800,800i,900,900i".'
			),
			array(
				'id' => 'cp_font2_family',
				'name' => 'Body font family',
				'type' => 'textarea',
				'default' => 'font-family: "Muli", sans-serif;',
				'desc' => 'The family declaration for the body font. You can copy & paste this from the google page. For the "Muli" font this would be: font-family: "Muli", serif;'
			)
		)
	),
	array(
		'id' => 'error',
		'name' => 'Error page',
		'options' => array(
			array(
				'name' => 'Error page',
				'type' => 'title'
			),
			array(
				'id' => 'cp_error_title',
				'name' => 'Error page title',
				'type' => 'text',
				'default' => 'Woops, something went wrong!',
				'desc' => 'The title for the 404 error page'
			),
			array(
				'id' => 'cp_error_content',
				'name' => 'Error page content',
				'type' => 'textarea',
				'default' => 'Apologies, but we were unable to find what you were looking for.',
				'desc' => 'The content for the 404 error page'
			)
		)
	),
	array(
		'id' => 'customcss',
		'name' => 'Custom css',
		'options' => array(
			array(
				'name' => 'Custom CSS',
				'type' => 'title'
			),
			array(
				'id' => 'cp_custom_css',
				'name' => 'Custom CSS',
				'type' => 'textarea',
				'desc' => 'Use this text area to overwrite css styles from the theme or from plugins. This css will be loaded after everything else.'
			)
		)
	)
);



?>
