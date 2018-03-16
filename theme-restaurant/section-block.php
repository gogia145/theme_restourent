<?php 
global $rf_section_post;
$rf_section_bgcolor = get_post_meta($rf_section_post->ID, "sectionbgcolor", true);
$rf_section_titlecolor = get_post_meta($rf_section_post->ID, "sectiontitlecolor", true);
$rf_section_textcolor = get_post_meta($rf_section_post->ID, "sectiontextcolor", true);
$rf_section_margintop = get_post_meta($rf_section_post->ID, "sectionmargintop", true);
$rf_section_marginbottom = get_post_meta($rf_section_post->ID, "sectionmarginbottom", true);
$rf_block_upsidedown = get_post_meta($rf_section_post->ID, "sectionblockupsidedown", true);

$rf_block_filterbgcolor = get_post_meta($rf_section_post->ID, "blockfilterbgcolor", true);
$rf_block_filtertextcolor = get_post_meta($rf_section_post->ID, "blockfiltertextcolor", true);
$rf_block_filter = get_post_meta($rf_section_post->ID, "blockfilter", true);

$rf_section_backgroundimg = wp_get_attachment_url( get_post_thumbnail_id($rf_section_post->ID));

$rf_section_parallax = get_post_meta($rf_section_post->ID, "sectionparallax", true);

$rf_section_video = get_post_meta($rf_section_post->ID, "sectionvideo", true);

$rf_section_style = '';
if (isset($rf_section_bgcolor) && $rf_section_bgcolor != '') $rf_section_style .= "background-color:#" . str_replace('#','',$rf_section_bgcolor) . "; ";
if (isset($rf_section_backgroundimg) && $rf_section_backgroundimg != '') $rf_section_style .= "background-image: url('" . $rf_section_backgroundimg . "'); ";
?>

<section id="section-<?php echo $rf_section_post->ID; ?>" class="section block <?php if (isset($rf_block_filter) && $rf_block_filter != '') { echo 'hasfilter '; } if (isset($rf_block_upsidedown) && $rf_block_upsidedown == true) { echo 'upsidedown '; } if (isset($rf_section_parallax) && $rf_section_parallax != '') { echo 'parallax'; } ?>" style="<?php echo $rf_section_style; ?>">

	<?php if ($rf_section_parallax) { ?>
    <div class="section-background-container">
    	<div class="section-background" style="<?php echo $rf_section_style; ?>"></div>
    </div>
    <?php } elseif (isset($rf_section_video) && $rf_section_video != '') { ?>
    <div class="section-background-container">
        <video autoplay muted loop poster="<?php if (isset($rf_section_backgroundimg) && $rf_section_backgroundimg != '') echo $rf_section_backgroundimg; ?>">
            <source src="<?php echo $rf_section_video; ?>" type="video/<?php echo current(array_slice(explode('.',$rf_section_video), -1)); ?>">
        </video>
    </div>
    <?php } ?>

    <?php //if (isset($rf_block_filter) && $rf_block_filter != '') { ?>
    <div class="block-filter" style="background-color:#<?php if (isset($rf_block_filterbgcolor) && $rf_block_filterbgcolor != '') echo str_replace('#','',$rf_block_filterbgcolor); ?>; color:#<?php if (isset($rf_block_filtertextcolor) && $rf_block_filtertextcolor != '') echo str_replace('#','',$rf_block_filtertextcolor); ?>;">
    
        <div class="container">
        
            <div class="row">
                <div class="col-xs-12">
                    <div class="post-content" style=" <?php if (isset($rf_section_textcolor) && $rf_section_textcolor != '') echo 'color:#' . str_replace('#','',$rf_section_textcolor) . ';'; ?><?php if (isset($rf_section_margintop) && $rf_section_margintop != '') echo 'margin-top:' . str_replace('px','',$rf_section_margintop) . 'px;'; ?><?php if (isset($rf_section_marginbottom) && $rf_section_marginbottom != '') echo 'margin-bottom:' . str_replace('px','',$rf_section_marginbottom) . 'px;'; ?> ">
                        <?php $content = apply_filters('the_content', $rf_section_post->post_content);
                        $content = str_replace(']]>', ']]&gt;', $content);
                        echo $content; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
    </div>    
    <?php // } ?>
    
    
    
    <div class="container" style="margin-top:<?php if (isset($rf_section_margintop)) echo str_replace('px','',$rf_section_margintop); ?>px;margin-bottom:<?php if (isset($rf_section_marginbottom)) echo str_replace('px','',$rf_section_marginbottom); ?>px;">
    
        <div class="row">
        
			<?php $rf_block_items = get_post_meta($rf_section_post->ID, "blockitems", true);
            $rf_block_items = explode(',',$rf_block_items);
			$rf_block_columns = get_post_meta($rf_section_post->ID, "sectioncolumns", true);
			if ($rf_block_columns == '2') {
				$num_columns = 'col-md-6';
			} elseif ($rf_block_columns == '3') {
				$num_columns = 'col-lg-4 col-md-4 col-sm-4';
			} else {
				$num_columns = 'col-lg-3 col-md-6 col-sm-6';
			}
            
            foreach($rf_block_items as $rf_block_item) {
				
				if (function_exists( 'icl_object_id' )) {
					$rf_block_item = icl_object_id($rf_block_item, 'block', true, ICL_LANGUAGE_CODE);
				}
				
                $rf_block_post = get_post($rf_block_item);
				
				$rf_categories = get_the_terms($rf_block_post->ID, 'blockcat');
				$rf_catArray = '';
				if ($rf_categories){
					foreach($rf_categories as $rf_category) {
						$rf_catArray .= 'blockcat-' . $rf_category->term_id . ' ';
					}
				} 
				
				$rf_block_link = get_post_meta($rf_block_post->ID, "blocklink", true);
				if (!isset($rf_block_link) || $rf_block_link == '') {
					$rf_block_link = get_permalink($rf_block_item);
				}
				
				$rf_block_bgcolor = get_post_meta($rf_block_item, "blogtilecolor", true);
				?>
                
                <div class="<?php if (isset($num_columns)) echo $num_columns; ?>">
                    <a class="block-item <?php echo $rf_catArray; ?>" href="<?php echo $rf_block_link; ?>" data-path-hover="M 0,0 200,0 200,0 z">
                        <figure>
                        	<?php $rf_featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($rf_block_item), 'block-2' ); ?>
                            
                            <div class="block-img" style="background-image: url('<?php echo $rf_featured_image[0]; ?>');"></div>
                            
                            <svg viewBox="0 0 200 300" preserveAspectRatio="none" >
								<path d="M 0,0 200,0 100,100 100,100 0,200 z" style="fill:#fff;" data-path-hover="M 0,0 200,0 200,200 100,280 0,200 z" />
                            	<path d="M 0,0 100,100 200,0 z" style="fill:#eee;" data-path-hover="M 0,0 200,0 0,0 z" />
								<path d="M 200,0 100,100 200,200 z" style="<?php if (isset($rf_block_bgcolor) && $rf_block_bgcolor != '') echo 'fill:#' . str_replace('#','',$rf_block_bgcolor); ?>" data-path-hover="M 200,0 200,100 100,50 0,100 0,0 z" />
                            </svg>
                            
                            <figcaption>
                                <div class="block-content">
                                    <h3 style="color:#<?php if (isset($rf_section_titlecolor)) echo str_replace('#','',$rf_section_titlecolor); ?>;"><?php echo $rf_block_post->post_title; ?></h3>
                                    <p style="color:#<?php if (isset($rf_section_textcolor)) echo str_replace('#','',$rf_section_textcolor); ?>;"><?php echo $rf_block_post->post_excerpt; ?></p>
                                </div>
                            </figcaption>
                        </figure>
                    </a>

                </div>
            <?php } ?>
        
        </div>

    </div>
     <?php if (current_user_can('edit_posts')) echo '<a class="button thickbox" href="'.get_admin_url().'post.php?post='.$rf_section_post->ID.'&action=edit&iframe=1&#038;width=800&#038;height=800&#038;TB_iframe=true&#038;" title="'. __('Edit Section', 'the-restaurant') .'"></a>'; ?>
</section>