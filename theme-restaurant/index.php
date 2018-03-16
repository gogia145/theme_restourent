<?php global $more, $wp_query;
get_header();

$pageid = get_the_ID();
if (is_home()) { 
	$pageid = get_option( 'page_for_posts' );
} 
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	if (is_shop() || is_product_category() || is_product_tag() || is_product()) {
		$pageid = get_option('woocommerce_shop_page_id'); 
	} elseif (is_cart()) {
		$pageid = get_option('woocommerce_cart_page_id');
	} elseif (is_checkout()) {
		$pageid = get_option('woocommerce_checkout_page_id');
	} elseif (is_account_page()) {
		$pageid = get_option('woocommerce_myaccount_page_id');
	}
}

if (isset($rf_theme_options['cp_sidebar_position'])) $sidebar_pos = $rf_theme_options['cp_sidebar_position'];
if (isset($pageid)) $sidebar_pos_page = get_post_meta($pageid, "pagelayout", true);
if (isset($sidebar_pos_page) && $sidebar_pos_page != '' && $sidebar_pos_page != 'Global setting') $sidebar_pos = $sidebar_pos_page;
?>



<?php if (is_category()) {
		
	$rf_pagetitle = single_cat_title(__('Category: ','the-restaurant'), false);
	
} elseif (is_tag()) {
	
	$rf_pagetitle = single_tag_title(__('Tag: ','the-restaurant'), false);
	
} elseif (is_author()) {
		
	$rf_author = get_user_by('slug', get_query_var('author_name'));
	$rf_pagetitle = __('Author: ','the-restaurant') . $rf_author->nickname;
	
} elseif (is_search()) {

	$rf_pagetitle = __('Search: ','the-restaurant') . sanitize_text_field($_REQUEST['s']);

} else {
	
	$rf_pagetitle = get_the_title( get_option( 'page_for_posts' ) );
	
} ?>

<div id="page-title">
	<?php if (!is_home() || (is_home() && !is_front_page())) { ?>
	<div class="container">
		<div class="row">
                <div class="col-sm-6">
                    <h1><?php echo $rf_pagetitle; ?></h1>
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



<?php if (is_single()) {
	$more = 1;
} else {
	$more = 0;
} ?>



<div class="container">

    <div class="row">
    
        <div class="<?php if (isset($sidebar_pos) && $sidebar_pos == 'Fullwidth page') { echo 'col-xs-12'; } elseif ($sidebar_pos == 'Sidebar left') { echo 'col-md-9 col-md-push-3'; } else { echo 'col-md-9'; } ?>">
    
            <?php if ( have_posts() ) {
				
				while ( have_posts() ) : the_post(); ?>
				
				<div id="post-<?php the_ID(); ?>" <?php post_class('post hentry'); ?>>
		
					<?php if (has_post_thumbnail()) { ?>
					<div class="post-leadimage">
						<?php the_post_thumbnail('fullwidth'); ?>
					</div>
					<?php } ?>
					
					<?php if (get_the_title()) { ?>
					<h3 class="post-title">
						<?php if (!is_single()) { ?>
						<a href="<?php the_permalink() ?>" title="<?php the_title() ?>" rel="bookmark">
						<?php }
						if (is_sticky()) { ?>
							<i class="glyphicon glyphicon-pushpin"></i>
						<?php } elseif (has_post_format( 'aside' )) { ?>
							<i class="glyphicon glyphicon-align-left"></i>
						<?php } elseif (has_post_format( 'gallery' )) { ?>
							<i class="glyphicon glyphicon-th"></i>
						<?php } elseif (has_post_format( 'link' )) { ?>
							<i class="glyphicon glyphicon-link"></i>
						<?php } elseif (has_post_format( 'image' )) { ?>
							<i class="glyphicon glyphicon-picture"></i>
						<?php } elseif (has_post_format( 'quote' )) { ?>
							<i class="glyphicon glyphicon-font"></i>
						<?php } elseif (has_post_format( 'status' )) { ?>
							<i class="glyphicon glyphicon-bullhorn"></i>
						<?php } elseif (has_post_format( 'video' )) { ?>
							<i class="glyphicon glyphicon-film"></i>
						<?php } elseif (has_post_format( 'audio' )) { ?>
							<i class="glyphicon glyphicon-volume-down"></i>
						<?php } elseif (has_post_format( 'chat' )) { ?>
							<i class="glyphicon glyphicon-comment"></i>
						<?php }
							the_title();
						if (!is_single()) { ?>
						</a>
						<?php } ?>
					</h3>
					<?php } ?>
					
					<div class="post-content">
						<?php if (is_single()) {
							the_content();
						} else {
							the_excerpt();
						} ?>
					</div>
                    
                    <?php if (is_single()) { ?>
                    <div class="postpagination">
                        <?php wp_link_pages(array(
                            'before'           => __( 'Pages:', 'the-restaurant' ),
                            'after'            => '',
                            'link_before'      => '',
                            'link_after'       => '',
                            'next_or_number'   => 'number',
                            'separator'        => '<span class="seperator"></span>',
                            'nextpagelink'     => __( 'Next page', 'the-restaurant' ),
                            'previouspagelink' => __( 'Previous page', 'the-restaurant' ),
                            'pagelink'         => '%',
                            'echo'             => 1
                        )); ?>
                    </div>
                    <?php } ?>
					
					<div class="meta">
						<span class="meta-part">
							<?php _e('By: ', 'the-restaurant');
							the_author_posts_link(); ?>
						</span>

						<span class="meta-part meta-date"><?php the_time('F j, Y'); ?></span>

						<?php if (comments_open()) { ?>
						<span class="meta-part meta-comments"><?php comments_popup_link( __( 'Post Comment', 'the-restaurant' ), '1 ' . __( 'comment', 'the-restaurant' ), '% '. __( 'comments', 'the-restaurant' ) ); ?>
						</span>
						<?php } ?>

						<span class="meta-part meta-categories"><?php the_category(', '); ?></span>

						<?php $hastags = get_the_tags();
						if ( $hastags ) { ?>
                        <span class="meta-part meta-tags"><?php the_tags(); ?></span>
                        <?php } ?>
					</div>
		
				</div><!-- .post -->

				<?php if (is_single()) { ?>
				<div class="hentry">
					<?php comments_template(); ?>
				</div>
				<?php } ?>
				
				<?php endwhile;
				
			} else {
				
				the_post(); ?>
            
            	<div class="hentry">
                
                	<p><?php _e('No posts are found.', 'the-restaurant') ?></p>
                
                </div>
            
            <?php } ?>
            
        </div>

        <?php get_sidebar(); ?>
        
    </div>

</div>



<div id="nicepagination">

	<div class="container">
    
        <div class="row">
        
            <div class="<?php if (isset($sidebar_pos) && $sidebar_pos == 'Fullwidth page') { echo 'col-md-12'; } elseif ($sidebar_pos == 'Sidebar left') { echo 'col-md-9 col-md-offset-1 sidebar-left'; } else { echo 'col-md-9'; } ?> centering">

				<?php $big = 999999999;
				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages,
					'prev_text' => '<i class="glyphicon glyphicon-step-backward"></i>',
					'next_text' => '<i class="glyphicon glyphicon-step-forward"></i>'
				) ); ?>
                
            </div>
            
        </div>
    
    </div>
    
</div>

<?php get_footer(); ?>