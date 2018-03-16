<?php global $rf_theme_options, $wp_query; ?>

<?php get_header(); ?>

<?php
the_post();

// Get all customfields in array
$rf_post_meta = rf_get_post_custom_single(get_the_ID());

// Set featuerd image or default header images
/*if(isset($rf_post_meta['_thumbnail_id']) && !empty($rf_post_meta['_thumbnail_id']))	 $rf_header_image_url = wp_get_attachment_url($rf_post_meta['_thumbnail_id']);
else $rf_header_image_url = get_header_image();*/

// If page title is on
if ((!isset($rf_post_meta['pagetitle']) || $rf_post_meta['pagetitle'] == false)) {
	?>
  
    <div id="page-title">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1><?php the_title(); ?></h1>
                </div>
                <?php if (isset($rf_theme_options['cp_breadcrumbs']) && $rf_theme_options['cp_breadcrumbs'] == true) { ?>
                <div class="col-sm-6">
                    <?php the_breadcrumb(get_the_ID()); ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    
	<?php
}

// Get sections ID's in order and the content position
if(isset($rf_post_meta['sections']) && !empty($rf_post_meta['sections'])){
	?>
    
	<div id="sections">
    
		<?php 
        // Build array with sections on this page
        $rf_section_IDs = array_filter(explode(',', $rf_post_meta['sections']));
        
        // Removes "content" from array the real content is triggerd with content-on
        $rf_section_IDs = array_diff($rf_section_IDs, array("content"));
        
        // Add thickbox for iframe popup links
        if (current_user_can('edit_posts')) add_thickbox();
        
        // Loop sections including page content
        foreach($rf_section_IDs as $rf_section_ID) {
            
            // Get page content continue to next section
            if($rf_section_ID == 'content-on'){
                get_template_part('page-content');
                continue;
            }
            
            //Get section
            include(locate_template('section.php'));
        } ?>
    
	</div>

<?php } else { ?>
    <div id="sections">
	   <?php  get_template_part('page-content'); ?>
    </div>
<?php } ?>

<?php get_footer(); ?>