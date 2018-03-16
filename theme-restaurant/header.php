<?php global $rf_theme_options; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="<?php bloginfo('html_type'); ?>;" />    
    <meta name="description" content="<?php bloginfo('description') ?>" />
    <meta name="generator" content="WordPress <?php bloginfo('version') ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <?php if (function_exists('wp_site_icon')) {
        wp_site_icon();
    } ?>
    

    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Comments RSS Feed" href="<?php bloginfo('comments_rss2_url') ?>"  />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_head(); ?>
    <?php if (isset($rf_theme_options['cp_trackingcode']) && $rf_theme_options['cp_trackingcode'] != '') { ?>
	<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', '<?php echo $rf_theme_options['cp_trackingcode']; ?>', 'auto');
      ga('send', 'pageview');
    
    </script>
    <?php } ?>
</head>

<body <?php body_class('woocommerce'); ?>>

<div id="container">

    <?php if (isset($rf_theme_options['cp_headertype']) && $rf_theme_options['cp_headertype'] != '') {
        $headertype = $rf_theme_options['cp_headertype'];
    } else {
        $headertype = 'header1';
    }

    if ($headertype == 'header1') {
        get_template_part( 'header1' ); 
    } elseif ($headertype == 'header2') {
        get_template_part( 'header2' ); 
    } elseif ($headertype == 'header3') {
        get_template_part( 'header3' ); 
    }
    ?>

    <?php // Load the slider
    if (is_front_page()) { ?>
    <div id="header-slider">  
        
            <?php echo rf_slider_shortcode(); ?>
        
    </div>
    <?php } ?>