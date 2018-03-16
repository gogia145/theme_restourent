<?php global $rf_theme_options; ?>

<header id="pageheader" class="headerstyle2">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 logo-center">
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