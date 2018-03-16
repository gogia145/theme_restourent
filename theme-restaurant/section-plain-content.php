<?php 
// Get featured image url
if(isset($rf_section_meta['_thumbnail_id'])) $rf_section_backgroundimg = wp_get_attachment_url($rf_section_meta['_thumbnail_id']);

// Build style css for section
$rf_section_style = '';
if ( !empty($rf_section_meta['sectionbgcolor']) ) 	$rf_section_style .= "background-color:#" . str_replace('#','', $rf_section_meta['sectionbgcolor']) . "; ";
if ( !empty($rf_section_backgroundimg) ) 			$rf_section_style .= "background-image: url('" . $rf_section_backgroundimg . "'); ";
?>

<section id="section-<?php echo $rf_section_post->ID; ?>" style=" <?php echo $rf_section_style; ?> " class="<?php if( !empty($rf_section_meta['sectionparallax'])) { echo 'parallax'; } ?>">
    
	<?php
	// Output parallax image if available
	if( !empty($rf_section_meta['sectionparallax']) ){ ?>
    <div class="section-background-container">
        <div class="section-background" style=" <?php echo $rf_section_style; ?> "></div>
    </div>
    <?php } ?>
    
    <?php
	// Output the section content
	?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="post-content" style=" <?php if ( !empty($rf_section_meta['sectiontextcolor']) ) echo 'color:#' . str_replace('#', '', $rf_section_meta['sectiontextcolor']) . ';'; ?><?php if ( !empty($rf_section_meta['sectionmargintop']) ) echo 'margin-top:' . str_replace('px', '', $rf_section_meta['sectionmargintop']) . 'px;'; ?><?php if ( !empty($rf_section_meta['sectionmarginbottom']) ) echo 'margin-bottom:' . str_replace('px', '', $rf_section_meta['sectionmarginbottom']) . 'px;'; ?> ">
                    <?php 
					$content = apply_filters('the_content', $rf_section_post->post_content);
                    $content = str_replace(']]>', ']]&gt;', $content);
                    echo $content;
			  		?>
                </div>
            </div>
        </div>
    </div>
    
	<?php 
	// Output the edit button for this section
	if (current_user_can('edit_posts')) echo '<a class="button thickbox" href="'.get_admin_url().'post.php?post='.$rf_section_post->ID.'&action=edit&iframe=1&#038;width=800&#038;height=800&#038;TB_iframe=true&#038;" title="'. __('Edit Section', 'the-restaurant') .'"></a>'; 
	?>

</section>