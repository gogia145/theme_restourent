<?php

// Replace ID if translation exists (WPML)
if (function_exists('icl_object_id')){ 
	$rf_section_ID = icl_object_id($rf_section_ID, 'section', true, ICL_LANGUAGE_CODE);
}
elseif (has_filter('wpml_object_id')){
	$rf_section_ID = apply_filters( 'wpml_object_id', $rf_section_ID, 'section', true);
}

// Get posts
$rf_section_post = get_post($rf_section_ID);

// Get all customfields in array
$rf_section_meta = rf_get_post_custom_single($rf_section_post->ID);

// Select Section Type
if (isset($rf_section_meta['sectiontype'])){
	
	// include section type section-{sectiontype}.php
	if(!@include(locate_template('section-'.sanitize_title($rf_section_meta['sectiontype']).'.php'))) throw new Exception('Failed to include section-'.sanitize_title($rf_section_meta['sectiontype']).'.php');			
}

?>