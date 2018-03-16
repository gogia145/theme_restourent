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
                <div class="hentry post-content" style=" <?php if ( !empty($rf_section_meta['sectiontextcolor']) ) echo 'color:#' . str_replace('#', '', $rf_section_meta['sectiontextcolor']) . ';'; ?><?php if ( !empty($rf_section_meta['sectionmargintop']) ) echo 'margin-top:' . str_replace('px', '', $rf_section_meta['sectionmargintop']) . 'px;'; ?><?php if ( !empty($rf_section_meta['sectionmarginbottom']) ) echo 'margin-bottom:' . str_replace('px', '', $rf_section_meta['sectionmarginbottom']) . 'px;'; ?> ">
                    
                	<?php if ( !empty($rf_section_meta['menucardcats']) ) {

                		if ( isset($rf_section_meta['menucardfilter']) ) { ?>
	                	<div class="menucard-cats">
            				<?php $menucardcats = explode(',', $rf_section_meta['menucardcats']);
            				foreach ($menucardcats as $catid) {                					
            					$cat = get_term( $catid, 'menucardcat' ); ?>

            					<a href="#" class="btn">
            						<?php echo $cat->name; ?>
            					</a>
            				<?php } ?>
	                	</div>
	                	<?php } ?>
	                	

	                    <div class="menucard-slider">
	                    	<div class="menucard-slide-container" data="1">
								<?php 
								$menucardcats = explode(',', $rf_section_meta['menucardcats']);
			                	foreach ($menucardcats as $catid) { ?>

			                		<div class="menucard-slide">
										<div class="row">

											<?php $cat = get_term( $catid, 'menucardcat' ); ?>
											<h3 class="menucard-cat">
												<span><?php echo $cat->name; ?></span>
											</h3>

											<?php // build query
											$programCats = array(
					                            array(
					                                'taxonomy' => 'menucardcat',
					                                'field'    => 'term-id',
					                                'terms'    => $catid,
					                            )
					                        );

											$postQuery = array( 
												'post_type' 			=> 'menucard',
												'posts_per_page' 		=> -1,
												'order' 				=> 'ASC',
												'orderby' 				=> 'post__in',
												'tax_query'				=> $programCats
											);
											
											// Get posts
											$posts = new WP_Query($postQuery);

											if ( isset($rf_section_meta['sectioncolumns']) && $rf_section_meta['sectioncolumns'] == 1 ) {
												$num_columns = 'col-sm-12';
											} else {
												$num_columns = 'col-lg-6 col-md-6 col-sm-12';
											}
											
											if ($posts->have_posts()){
											    // Loop posts
												while ($posts->have_posts()): $posts->the_post();
												  
													// Get custom post data
													$rf_menuitem_meta = rf_get_post_custom_single(get_the_ID());
													$rf_menuitem_tags = wp_get_post_tags(get_the_ID());
													?>

													<div class="<?php if (isset($num_columns)) echo $num_columns; ?>">										
														<div class="menucard-item">

															<?php  $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail', true);
															$image = $image[0];
															if (isset($image) && $image != '' && strpos($image, 'default') == false) { ?>
															<img src="<?php echo $image; ?>" />
															<?php } ?>
															
															<div class="menucard-title-price">
																<span class="menucard-price"><?php echo $rf_menuitem_meta['menuprice']; ?></span>
																<h4><?php the_title(); ?></h4>
															</div>

															<?php if (isset($rf_menuitem_tags)) { ?>
															<div class="menucard-tags">
																<?php foreach ($rf_menuitem_tags as $tag) { ?>
																	<span><?php echo $tag->name; ?></span>
																<?php } ?>
															</div>
															<?php } ?>

															<div class="menucard-content">
																<?php echo apply_filters('the_excerpt', get_the_excerpt() ); ?>
															</div>
														</div>
													</div>
										
												<?php endwhile;
											} ?>

										</div>
									</div>

									<?php wp_reset_query();
								} ?>

							</div>

						</div>

						<a href="#" class="menucard-nav menucard-nav-left fade">
							<i class="glyphicon glyphicon-menu-left"></i>
						</a>
						<a href="#" class="menucard-nav menucard-nav-right">
							<i class="glyphicon glyphicon-menu-right"></i>
						</a>

			  		<?php } ?>
                </div>
            </div>
        </div>
    </div>
    
	<?php 
	// Output the edit button for this section
	if (current_user_can('edit_posts')) echo '<a class="button thickbox" href="'.get_admin_url().'post.php?post='.$rf_section_post->ID.'&action=edit&iframe=1&#038;width=800&#038;height=800&#038;TB_iframe=true&#038;" title="'. __('Edit Section', 'the-restaurant') .'"></a>'; 
	?>
</section>