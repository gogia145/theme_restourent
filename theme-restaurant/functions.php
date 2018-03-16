<?php 
global $rf_theme_name, $rf_theme_options;

// Theme slug
$rf_theme_name = 'therestaurant';

// Full name with space and capitals
$rf_theme_name_full = 'The Restaurant';

// Get Theme options from database
$rf_theme_options = get_option($rf_theme_name);

// Tells WordPress to setup the theme
function rf_theme_setup() {
	global $rf_theme_options;
	
	// Load textdomain for translation plugins
	load_theme_textdomain('the-restaurant');
	
	// Register the wp3 menu
	register_nav_menus(
		array(
			'main-menu' => 'Main menu',
			'mainleft-menu' => 'Main left menu',
			'mainright-menu' => 'Main right menu',
			'footer-menu' => 'Footer menu',
			'mobile-menu' => 'Mobile main menu'
		)
	);
	
	// Add support for post formats
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
	
	// Add header image option to header
	add_theme_support( 
		'custom-header', array(
		'flex-width'    => true,
		'width'         => 1200,
		'flex-height'    => true,
		'height'        => 300
	));
	
	// Add RSS feeds to the header
	add_theme_support( 'automatic-feed-links' );
	
	// Add WooCommerce support
	add_theme_support( 'woocommerce' );
	
	// Add wordpress title tag support
	add_theme_support('title-tag');

	// Custom media image sizes
	if ( function_exists( 'add_image_size' ) ) {
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'fullwidth', 1920, 999999, true );
	}	
	
	//register the sidebars
	if ( function_exists('register_sidebar') ) {
		register_sidebar(array(
			'name' => 'Sidebar',
			'id' => 'sidebar',
			'before_widget' => '<div class="sidepanel">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		));
		register_sidebar(array(
			'name' => 'Footer',
			'id' => 'footer-widgets',
			'before_widget' => '<div class="===columnnumber==="><div class="sidepanel">',
			'after_widget' => '</div></div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		));
		if (isset($rf_theme_options['cp_sidebars']) && $rf_theme_options['cp_sidebars'] != '') {
			$sidebars = explode(',',$rf_theme_options['cp_sidebars']);
			foreach ($sidebars as $sidebarName) {
				if (isset($sidebarName) && $sidebarName != '') {
					$title = str_replace(' ','',$sidebarName);
					$id = strtolower($title);
					register_sidebar(array(
						'name' => $title,
						'id' => $id,
						'before_widget' => '<div class="===columnnumber==="><div class="sidepanel">',
						'after_widget' => '</div></div>',
						'before_title' => '<h3>',
						'after_title' => '</h3>'
					));
				}
			}
		}
	}
}
add_action( 'after_setup_theme', 'rf_theme_setup' );


// backwards compatibility function before wordpress 4.1
if(!function_exists('_wp_render_title_tag')){
	function theme_slug_render_title() {
		?>
		<title><?php wp_title( '-', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'theme_slug_render_title' );
}

// Load settings arrays
require_once(TEMPLATEPATH . '/backend/custom-fields.php');
require_once(TEMPLATEPATH . '/backend/theme-options.php');

// Include the admin controlpanel
require_once(TEMPLATEPATH . '/backend/inc/class-controlpanel.php');
$rf_cpanel = new rf_ControlPanel($optionlist);

// Include the customfields options
require_once(TEMPLATEPATH . '/backend/inc/class-customfields.php');
$rf_myCustomFields_var = new rf_myCustomFields($customFields);

// Load frontend scripts
function rf_script_loader() {
	global $rf_theme_options;
	
	if (!is_admin()) {
		wp_register_style('bootstrap', get_template_directory_uri().'/css/bootstrap.css');
		wp_enqueue_style('bootstrap');
		
		wp_register_style('style', get_bloginfo('stylesheet_url'), array('bootstrap'));
		wp_enqueue_style('style');
		
		if (current_user_can('edit_posts')){
			wp_register_style('frontend_style', get_template_directory_uri().'/backend/css/frontend.css'); 
			wp_enqueue_style('frontend_style');
		}
		
		wp_register_style('woocommerce-custom', get_template_directory_uri().'/css/woocommerce-custom.css', array('woocommerce-general'));
		wp_enqueue_style('woocommerce-custom');

		wp_register_style('swiper-css', get_template_directory_uri().'/css/swiper.css', array('style'));
		wp_enqueue_style('swiper-css');
		
		wp_register_style('fontawesome', get_template_directory_uri().'/css/font-awesome.min.css', array('style'));
		wp_enqueue_style('fontawesome');
		
		// These lines fix the Visual Composer bug where styles were not loaded on section pages
		if ( in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			wp_register_style('js_composer_front', get_template_directory_uri().'/../../plugins/js_composer/assets/css/js_composer_front.css', array('style'));
			wp_enqueue_style('js_composer_front');
		}
		
		if (isset($rf_theme_options['cp_font1_source'])) {
			wp_register_style('font1', $rf_theme_options['cp_font1_source'], array('style'));
			wp_enqueue_style('font1');
		}
		
		if (isset($rf_theme_options['cp_font2_source'])) {
			wp_register_style('font2', $rf_theme_options['cp_font2_source'], array('style'));
			wp_enqueue_style('font2');
		}
		
		wp_enqueue_script('jquery');
		
		//
		if (current_user_can('edit_posts')) {
			wp_register_script('mainbackendjs', get_template_directory_uri().'/backend/js/main.js');
			wp_enqueue_script('mainbackendjs');
		}
		
		wp_register_script('mainjs', get_template_directory_uri().'/js/main.js');
		wp_enqueue_script('mainjs');

		wp_register_script('perfectscrollbar', get_template_directory_uri().'/js/perfect-scrollbar.jquery.min.js', array('jquery'), '', true);
		wp_enqueue_script('perfectscrollbar');
		
		wp_register_script('bootstrap-js', get_template_directory_uri().'/js/bootstrap.min.js', array('jquery'), '', true);
		wp_enqueue_script('bootstrap-js');

		wp_register_script('swiper-js', get_template_directory_uri().'/js/swiper.jquery.min.js', array('jquery'), '', true);
		wp_enqueue_script('swiper-js');
		
		if ( is_singular() ) wp_enqueue_script( "comment-reply" );
	}

}
add_action('wp_enqueue_scripts', 'rf_script_loader');


// Load styles from the Theme Settings
function rf_load_style_settings() {
	include_once('style.php');
}
add_action('wp_head', 'rf_load_style_settings', 999);


// Load backend scripts
function rf_admin_script_loader() {

	if( (isset($_REQUEST['page']) && $_REQUEST['page'] == 'theme_settings') || (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') ) {
		wp_register_style('simplegrid', get_template_directory_uri().'/backend/css/simplegrid.css');
		wp_enqueue_style('simplegrid');
	}
	
	wp_register_style('controlpanel', get_template_directory_uri().'/backend/css/controlpanel.css');
	wp_enqueue_style('controlpanel');
	
	
	// Load css on iframe / iframe is active
	if(isset($_REQUEST['iframe']) && $_REQUEST['iframe'] == 1) {
		wp_register_style('iframe_style', get_template_directory_uri().'/backend/css/iframe.css'); 
		wp_enqueue_style('iframe_style');
	}
    
	// Add the color picker css file       
    wp_enqueue_style('wp-color-picker'); 
	
    wp_register_style('alpha-color-picker', get_template_directory_uri().'/backend/css/alpha-color-picker.css');
	wp_enqueue_style('alpha-color-picker');  
	 
	wp_enqueue_script('jquery-ui-core', array('jquery'));
	
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker-alpha', get_template_directory_uri().'/backend/js/alpha-color-picker.js', array( 'wp-color-picker' ), '1.2');

	wp_register_script('controlpanel_js', get_template_directory_uri().'/backend/js/controlpanel.js');
	wp_enqueue_script('controlpanel_js');
	
	wp_register_script('upload', get_template_directory_uri().'/backend/js/upload.js', array('jquery'));
	wp_enqueue_script('upload');
	
	wp_enqueue_script('media-upload');
	
	wp_enqueue_media();
	
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('jquery-ui-sortable');
	
	wp_register_script('sortable', get_template_directory_uri().'/backend/js/sortable.js', array('jquery-ui-sortable'));
	wp_enqueue_script('sortable');
	
	wp_register_script('pagetemplateselect', get_template_directory_uri().'/backend/js/pagetemplateselect.js');
	$array = array(
		"MapViewLatitude" => "51.505",
		"MapViewLongitude" => "-0.09",
	);
	wp_localize_script( 'pagetemplateselect', 'rfthemedata', $array);
	wp_enqueue_script('pagetemplateselect');
	
	wp_register_script('jsvalueslider', get_template_directory_uri().'/backend/js/valueslider.js');
	wp_enqueue_script('jsvalueslider');

	wp_register_script('mainjs', get_template_directory_uri().'/backend/js/main.js');
	wp_enqueue_script('mainjs');
	
}
add_action('admin_enqueue_scripts', 'rf_admin_script_loader', 1);



/*function rf_theme_init() {
	global $rf_theme_options;
	
	// Set custom post types in this file
	require_once(TEMPLATEPATH . '/backend/custom-post-types.php');
}
add_action( 'init', 'rf_theme_init', 5);*/



// Load widgets
include_once('widgets/rf_featured_content_widget.php');

// Default navigation menu before menu setup
function rf_emptymenu() {
	echo "<div class='empty-menu'>". __("You haven't set up a navigation menu yet. You can do this under 'Appearance -> Menus'.", 'the-restaurant') ."</div>";
}

// Setting editor content width
if ( ! isset( $content_width ) ) $content_width = 900;

// Force wordpress to use full image quality (no compression)
function jpeg_full_quality( $quality ) { 
	return 100;
}
add_filter( 'jpeg_quality', 'jpeg_full_quality' );


// hex to rgb converter
function rf_hex2rgb($hex) {
   if (isset($hex)) {
	   $hex = str_replace("#", "", $hex);
	
	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   
	   return implode(",", $rgb);
   }
}


// adjust color brightness
function adjustBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color   = hexdec($color); // Convert to decimal
        $color   = max(0,min(255,$color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }

    return $return;
}



// Set up default WooCommerce
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'rf_woocommerce_image_dimensions', 1 );

function rf_woocommerce_image_dimensions() {
  	$catalog = array(
		'width' 	=> '400',	// px
		'height'	=> '400',	// px
		'crop'		=> 1 		// true
	);

	$single = array(
		'width' 	=> '400',	// px
		'height'	=> '400',	// px
		'crop'		=> 1 		// true
	);

	$thumbnail = array(
		'width' 	=> '100',	// px
		'height'	=> '100',	// px
		'crop'		=> 1 		// true
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}



// WooCommerce wrappers, filters and hooks
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
	add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);
	
	function my_theme_wrapper_start() {
		global $rf_theme_options, $wp_query;
		
		if (isset($wp_query->post->ID)) $pageid = $wp_query->post->ID;
		if (is_home()) { 
			$pageid = get_option( 'page_for_posts' );
		} elseif (is_shop() || is_product_category() || is_product_tag() || is_product()) {
			$pageid = get_option('woocommerce_shop_page_id'); 
		} elseif (is_cart()) {
			$pageid = get_option('woocommerce_cart_page_id');
		} elseif (is_checkout()) {
			$pageid = get_option('woocommerce_checkout_page_id'); 
		} elseif (is_account_page()) {
			$pageid = get_option('woocommerce_myaccount_page_id');
		} else {
			$pageid = '';
		}
		
		$sidebar_pos = $rf_theme_options['cp_sidebar_position'];
		$sidebar_pos_page = get_post_meta($pageid, "pagelayout", true);
		if (isset($sidebar_pos_page) && $sidebar_pos_page != '' && $sidebar_pos_page != 'Global setting') $sidebar_pos = $sidebar_pos_page; ?>
		
		<div id="page-title" style="background-image: url('<?php echo $rf_theme_options['cp_headerimage']; ?>'); background-color:#<?php echo $rf_theme_options['cp_headercolor']; ?>">
			
            <?php if (!is_front_page() || (is_front_page() && $rf_theme_options['cp_frontpage_header'] =! 'hide')) { ?>
            <div class="container">
				<div class="row">
					<div class="col-sm-6">						
						<h1><?php woocommerce_page_title(); ?></h1>						
					</div>

					<?php if (isset($rf_theme_options['cp_breadcrumbs']) && $rf_theme_options['cp_breadcrumbs'] == true) { ?>
	                <div class="col-sm-6">
	                    <?php the_breadcrumb(get_the_ID()); ?>
	                </div>
	                <?php } ?>
				</div>
			</div>
            <?php } ?>
            
		</div>
		
		<div class="container"><div class="row"><div class="<?php if (isset($sidebar_pos) && $sidebar_pos == 'Fullwidth page') { echo 'col-md-12'; } elseif ($sidebar_pos == 'Sidebar left') { echo 'col-md-9 col-md-offset-1 sidebar-left'; } else { echo 'col-md-9'; } ?>"><div class="hentry">
	<?php }
	
	function my_theme_wrapper_end() {
		echo '</div></div>';
	}
	
	function rf_woocommerce_title($wc_title) {
		return false;
	}
	add_filter('woocommerce_show_page_title', 'rf_woocommerce_title');
	
	remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
	
	function rf_woocommerce_sidebar_end() {
		echo '</div></div>';
	}
	add_action('woocommerce_sidebar', 'rf_woocommerce_sidebar_end', 99);
	
	function rf_woocommerce_before_mini_cart() {
		echo '<div id="shopcartcontent">';
	}
	add_action('woocommerce_before_mini_cart', 'rf_woocommerce_before_mini_cart', 1);
	
	function rf_woocommerce_widget_shopping_cart_before_buttons() {
		echo '</div><div id="shopcartbuttons">';
	}
	add_action('woocommerce_widget_shopping_cart_before_buttons', 'rf_woocommerce_widget_shopping_cart_before_buttons', 1);
	
	function rf_woocommerce_after_mini_cart() {
		echo '</div>';
	}
	add_action('woocommerce_after_mini_cart', 'rf_woocommerce_after_mini_cart', 99);

	// Change number or products per row to 4
	add_filter('loop_shop_columns', 'loop_columns');
	if (!function_exists('loop_columns')) {
		function loop_columns() {
			return 4;
		}
	}
}



// Single comment format
function rf_custom_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
	?>
    
	<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body clearfix">
	<?php endif; ?>
    
    <div class="comment-meta commentmetadata">
    	<div class="comment-meta-part vcard">
			<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        </div>
    	<div class="comment-meta-part">
			<?php printf(__('<cite class="fn">%s</cite> says:', 'the-restaurant'), get_comment_author_link()) ?>
            <br />
			<?php printf( __('%1$s at %2$s', 'the-restaurant'), get_comment_date(),  get_comment_time()) ?>
            <?php edit_comment_link(__('(Edit)', 'the-restaurant'),'  ','' ); ?>
        </div>
	</div>

    <div class="comment-content">
    	<?php if ($comment->comment_approved == '0') : ?>
        <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'the-restaurant') ?></em>
        <?php endif; ?>
    
        <?php comment_text() ?>
    </div>

    <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
    
	<?php endif; ?>
	<?php
}

function replace_reply_link_class($class){
    $class = str_replace("class='comment-reply-link", "class='comment-reply-link btn", $class);
    return $class;
}
add_filter('comment_reply_link', 'replace_reply_link_class');



//create the breadcrumb
function the_breadcrumb() {
       
    // Settings
    $separator          = '/';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = __('Home', 'the-restaurant');
    $prefix				= '';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page', 'the-restaurant') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">' . __('Search results for: ', 'the-restaurant') . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        } elseif ( is_home() ) {
        	// Current page
            echo '<li class="item-current"><strong title="' . get_the_title( get_option( 'page_for_posts' ) ) . '"> ' . get_the_title( get_option( 'page_for_posts' ) ) . '</strong></li>';
        }
       
        echo '</ul>';
           
    }
       
}

/*function the_breadcrumb( $pageID = null ) {
	wp_reset_query();

	global $post;

	if (!isset($pageID)) $pageID = get_the_ID();

	echo '<div class="rf-breadcrumb">';

	echo '<span><a href="' . get_home_url() . '">' . __( 'Home', 'tacx' ) . '</a></span>';

	if (!is_front_page()) {		

		if (is_search()) {
			echo ' / Search';
		} elseif (get_post_type($pageID) == 'product') {
			echo ' / <span>' . __( 'Product', 'tacx' ) . '</span>';
			$categories = get_the_terms( $pageID, 'product_cat' );
			foreach($categories as $category) {
			    echo ' / <span>'.__($category->name).'</span>';
			}
			echo ' / ' . get_the_title($pageID);
		} elseif (is_category($pageID) || is_single($pageID)) {
			$categories = array_reverse(get_the_category($pageID));
			if (empty($categories)){
				$category = get_the_category_by_ID($pageID);
				echo ' / <span>'.__($category).'</span>';
			} else {
				foreach($categories as $category) {
					echo ' / <span>'.__($category->cat_name).'</span>';
				}
			}
			echo ' / ' . get_the_title($pageID);
		} else {
			echo ' / ' . get_the_title($pageID);
		}

	}

	echo '</div>';
}*/

/*function the_breadcrumb( $pageID = null ) {
	if (!isset($pageID)) $pageID = get_the_ID();

	echo '<div class="rf-breadcrumb">';

	echo '<span>' . __( 'Home', 'the-restaurant' ) . '</span>';

	if (is_page($pageID)) {
		echo ' / ' . get_the_title($pageID);
	} elseif (is_product($pageID) || is_product_category($pageID)) {
		echo ' / <span>' . __( 'Products', 'the-restaurant' ) . '</span>';
		$categories = get_the_terms( $pageID, 'product_cat' );
		foreach($categories as $category) {
		    echo ' / <span>'.__($category->name).'</span>';
		}
	} elseif (is_category($pageID) || is_single($pageID)) {
		$categories = array_reverse(get_the_category($pageID));
		foreach($categories as $category) {
			echo ' / <span>'.__($category->cat_name).'</span>';
		}
	}

	if (is_single($pageID) || is_product($pageID)) {
		echo ' / ' . get_the_title($pageID);
	}

	echo '</div>';
}*/



//  Include the TGM_Plugin_Activation class
require_once(TEMPLATEPATH . '/backend/inc/class-tgm-plugin-activation.php');
add_action( 'tgmpa_register', 'rf_theme_register_required_plugins' );
function rf_theme_register_required_plugins() {

    $plugins = array(
    	array(
			'name'               => 'The Restaurant: Theme specific post types and taxonomies', // The plugin name.
			'slug'               => 'therestaurant-posttypes', // The plugin slug (typically the folder name).
			'source'             => get_stylesheet_directory() . '/plugins/therestaurant-posttypes.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		),
        array(
            'name'      => 'Easy Bootstrap Shortcode',
            'slug'      => 'easy-bootstrap-shortcodes',
            'required'  => false,
        ),
		array(
            'name'      => 'WooCommerce',
            'slug'      => 'woocommerce',
            'required'  => false,
        ),
		array(
            'name'      => 'MailChimp for WordPress',
            'slug'      => 'mailchimp-for-wp',
            'required'  => false,
        ),
		array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => false,
        ),
		array(
            'name'      => 'Black Studio TinyMCE Widget',
            'slug'      => 'black-studio-tinymce-widget',
            'required'  => false,
        ),
        array(
            'name'      => 'Open Table Widget',
            'slug'      => 'open-table-widget',
            'required'  => false,
        ),
        array(
            'name'      => 'Recent tweets widget',
            'slug'      => 'recent-tweets-widget',
            'required'  => false,
        ),
        array(
            'name'      => 'Restaurant reservations',
            'slug'      => 'restaurant-reservations',
            'required'  => false,
        ),
        array(
            'name'      => 'WP Customer Reviews',
            'slug'      => 'wp-customer-reviews',
            'required'  => false,
        ),
        array(
            'name'      => 'WP Rocket',
            'slug'      => 'wp-rocket',
            'required'  => false,
        ),

    );

    $config = array(
        'id'           => 'therestaurant-therestaurant',      // Unique ID for hashing notices for multiple instances of therestaurant.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'therestaurant-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'the-restaurant' ),
            'menu_title'                      => __( 'Install Plugins', 'the-restaurant' ),
            'installing'                      => __( 'Installing Plugin: %s', 'the-restaurant' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'the-restaurant' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'the-restaurant' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'the-restaurant' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'the-restaurant' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'the-restaurant' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'the-restaurant' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'the-restaurant' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'the-restaurant' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'the-restaurant' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'the-restaurant' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'the-restaurant' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'the-restaurant' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'the-restaurant' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'the-restaurant' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );
}


// If iframe is set in post or get Set again in url
add_filter('redirect_post_location', 'redirect_to_post_on_publish_or_save');
function redirect_to_post_on_publish_or_save($location){
	if(isset($_REQUEST['iframe']) && $_REQUEST['iframe'] == 1) {
		$location = add_query_arg( array('iframe' => 1), $location);
	}
	return $location;
}

// if you don't add 3 as as 4th argument, this will not work as expected
add_action( 'post_updated', 'rf_close_update_ifame', 99, 3 );
add_action('trashed_post', 'rf_close_update_ifame',99, 3);
function rf_close_update_ifame($post_ID, $post, $update){
	if(!isset($post)) global $post;
	
	if(isset($_REQUEST['iframe']) && $_REQUEST['iframe'] == 1) {
		// If post title is empty show no title
		if($post->post_title == '')$post->post_title =  __('No title', 'the-restaurant');
		
		// Call javascript to close iframe
		echo '<script>parent.postMessage({action:"closeUpdateIfame",post_title:"'.$post->post_title.'", id:'.$post->ID.', sectiontype:"'.sanitize_title($post->sectiontype).'", post_status:"'.$post->post_status.'"},"*");</script>';
		exit();
	}
}


/*
 * Get post custom Single 
 */

function rf_get_post_custom_single($post_id) {
  $metas = get_post_meta($post_id);

  if(get_post_meta($post_id)){
	  foreach($metas as $key => $value) {
		if(sizeof($value) == 1) {
		  $metas[$key] = $value[0];
		}
	  }
	  return $metas;
  }
  return false;
}



// Slider Shortcode
function rf_slider_shortcode(){

	$posts = new WP_Query( array( 'post_type' => 'slide', 'posts_per_page' => -1 ) );

    if ($posts->have_posts()){

		ob_start();
		?>
		<div class="swiper-container">
			<div class="swiper-wrapper">
				<?php while ($posts->have_posts()): $posts->the_post();
				
				$rf_slide_meta = rf_get_post_custom_single(get_the_ID()); ?>
                
                <div class="swiper-slide" style="background-image: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID())); ?>');">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                    
								<?php if (isset($rf_slide_meta['slidelink']) && !empty($rf_slide_meta['slidelink'])) { ?>
                                <a href="<?php echo $rf_slide_meta['slidelink']; ?>">
                                <?php } ?>
                                    
                                    <div class="swiper-title">
                                    	<h3>
                                    		<?php the_title(); ?>
                                    		<i class="glyphicon glyphicon-chevron-right"></i>
                                    	</h3>
                                    </div>
                                
                                <?php if (isset($rf_slide_meta['slidelink']) && !empty($rf_slide_meta['slidelink'])) { ?>
                                </a>
                                <?php } ?>
                            
                            </div>                    
                        </div>                    
                    </div>
                </div>
                
                <?php endwhile; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev swiper-button-white"></div>
            <div class="swiper-button-next swiper-button-white"></div>
        </div>
		<?php
		
		wp_reset_query();
		return ob_get_clean();  
	} else {			
		wp_reset_query();
    	return; // no posts found
	}

}
//add_shortcode('rf-slider', 'rf_slider_shortcode');
?>