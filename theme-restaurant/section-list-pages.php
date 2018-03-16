<?php 
// Get featured image url
$rf_section_backgroundimg = '';
if(isset($rf_section_meta['_thumbnail_id'])) $rf_section_backgroundimg = wp_get_attachment_url($rf_section_meta['_thumbnail_id']);

// Build style css for section
$rf_section_style = '';
if ( !empty($rf_section_meta['sectionbgcolor']) ) 	$rf_section_style .= "background-color:#" . str_replace('#','', $rf_section_meta['sectionbgcolor']) . "; ";
if ( !empty($rf_section_backgroundimg) ) 			$rf_section_style .= "background-image: url('" . $rf_section_backgroundimg . "'); ";
?>

<section id="section-<?php echo $rf_section_post->ID; ?>" style=" <?php echo $rf_section_style; ?> " class="yellow <?php if( !empty($rf_section_meta['sectionparallax'])) { echo 'parallax'; } ?> <?php if(isset($rf_section_meta['sectionclass'])) echo $rf_section_meta['sectionclass']; ?>">
   
    
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
                    <div class="row">
					<?php 

					// build query
					$postQuery = array( 
										'post_type' 			=> 'page',
										'posts_per_page' 		=> 99,
										'order' 				=> 'ASC',
										'orderby' 				=> 'post__in'
										);
					
					// If there is a selection only show selection
					if(isset($rf_section_meta['selectpages']) && !empty($rf_section_meta['selectpages'])){
						$postQuery['post__in'] = explode(",", $rf_section_meta['selectpages']);
					}
					
					// Get posts
					$posts = new WP_Query($postQuery);
					
					$i = 1;
					
					// Build 
					$col_in_row = 3;
					$num_columns = 'col-lg-4 col-md-4 col-sm-4';
					
					
					if ($posts->have_posts()){
					      // Loop posts
						  while ($posts->have_posts()): $posts->the_post();
						  
							  // Get custom post data
							  //$rf_section_meta = rf_get_post_custom_single(get_the_ID());
							  
							  ?>
							  <div class="<?php if (isset($num_columns)) echo $num_columns; ?>">
									<div class="block-item">
										<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID())); ?>" />
										<h2><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title(); ?></a></h2>
										<div class="slide-content">
											<?php echo apply_filters('the_excerpt', get_the_excerpt() ); ?>
										</div>
								</div>
							  </div>
							  <?php 
							  // Output new row
							  if($i%$col_in_row == 0){  ?>
								</div><div class="row">
							  <?php	}
							  $i++;
						  endwhile; 
						  
					}
					wp_reset_query();
					?>
			  		</div>
                </div>
            </div>
        </div>
    </div>
    
	<?php 
	// Output the edit button for this section
	if (current_user_can('edit_posts')) echo '<a class="button thickbox" href="'.get_admin_url().'post.php?post='.$rf_section_post->ID.'&action=edit&iframe=1&#038;width=800&#038;height=800&#038;TB_iframe=true&#038;" title="'. __('Edit Section', 'the-restaurant') .'"></a>'; 
	?>
</section>