<?php global $rf_theme_options; ?>

<header id="pageheader">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <a class="logo" href="<?php echo home_url() ?>" title="<?php bloginfo('name'); ?>">
                    <?php if (isset($rf_theme_options['cp_bloglogo']) && $rf_theme_options['cp_bloglogo'] != '') { ?>
                        <img 
                            src="<?php echo $rf_theme_options['cp_bloglogo']; ?>" 
                            alt="<?php bloginfo('name'); ?>" 
                            style="<?php if (isset($rf_theme_options['cp_logowidth']) && $rf_theme_options['cp_logowidth'] != '') echo 'max-width:' . $rf_theme_options['cp_logowidth'] . ';'; ?>" />
                    <?php } else {
                        bloginfo('name');
                    } ?>
                </a>
            </div>
            <div class="col-xs-12 col-sm-8">
                <div id="tagline">
                	<?php if (isset($rf_theme_options['cp_tagline_phone']) && $rf_theme_options['cp_tagline_phone'] != '') { ?>
	                    <span>
	                    	<i class=" fa fa-phone"></i>
                            <a href="tel:<?php echo stripslashes($rf_theme_options['cp_tagline_phone']); ?>"><?php echo stripslashes($rf_theme_options['cp_tagline_phone']); ?></a>
	                    </span>
                    <?php }
                    if (isset($rf_theme_options['cp_tagline_email']) && $rf_theme_options['cp_tagline_email'] != '') { ?>
	                    <span>
	                    	<i class=" fa fa-envelope-o"></i>
                            <a href="mailto:<?php echo stripslashes($rf_theme_options['cp_tagline_email']); ?>"><?php echo stripslashes($rf_theme_options['cp_tagline_email']); ?></a>
	                    </span>
                    <?php }
                    if (isset($rf_theme_options['cp_tagline_location']) && $rf_theme_options['cp_tagline_location'] != '') { ?>
	                    <span>
	                    	<i class=" fa fa-map-marker"></i> <?php echo stripslashes($rf_theme_options['cp_tagline_location']); ?>
	                    </span>
                    <?php } ?>
                </div>
            </div>
        </div>        
    </div>
    
	<nav class="mainnav">
        <div class="container">
            <?php wp_nav_menu(array(
                'theme_location' => 'main-menu',
                'fallback_cb'	=> 'rf_emptymenu'
            )); ?>
        </div>
    </nav>

    <a href="#" class="mobile-nav-button">
        <i class="glyphicon glyphicon-menu-hamburger"></i>
        <i class="glyphicon glyphicon-remove"></i>
    </a>
</header>