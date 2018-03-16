<?php

if ( !class_exists('rf_myCustomFields') ) {
	class rf_myCustomFields {
		/**
		* @var  string  $prefix  The prefix for storing custom fields in the postmeta table
		*/
		var $prefix = '';
		/**
		* @var  array  $customFields  Defines the custom fields available
		*/
		var $customFields = array();
		
		/**
		* PHP 5 Constructor
		*/
		function __construct($customFieldsArray) {
			// Set var array in object
			$this->customFields = $customFieldsArray;
			
			add_action( 'admin_menu', array( &$this, 'createCustomFields' ) );
			add_action( 'post_updated', array( &$this, 'saveCustomFields' ), 1, 2 );
			// Comment this line out if you want to keep default custom fields meta box
			add_action( 'do_meta_boxes', array( &$this, 'removeDefaultCustomFields' ), 10, 3 );
		}
		/**
		* Remove the default Custom Fields meta box
		*/
		function removeDefaultCustomFields( $type, $context, $post ) {
			foreach ( array( 'normal', 'advanced', 'side' ) as $context ) {
				remove_meta_box( 'postcustom', 'post', $context );
				remove_meta_box( 'postcustom', 'page', $context );
				remove_meta_box( 'postcustom', 'section', $context );
				remove_meta_box( 'postcustom', 'menucard', $context );
				remove_meta_box( 'postcustom', 'slide', $context );
			}
		}
		/**
		* Create the new Custom Fields meta box
		*/
		function createCustomFields() {
			global $rf_theme_name_full;
			if ( function_exists( 'add_meta_box' ) ) {
				add_meta_box( 'my-custom-fields', $rf_theme_name_full.' Additional settings', array( &$this, 'displayCustomFields' ), 'post', 'normal', 'high' );
				add_meta_box( 'my-custom-fields', $rf_theme_name_full.' Additional settings', array( &$this, 'displayCustomFields' ), 'page', 'normal', 'high' );
				add_meta_box( 'my-custom-fields', $rf_theme_name_full.' Sections settings', array( &$this, 'displayCustomFields' ), 'section', 'normal', 'high' );
				add_meta_box( 'my-custom-fields', $rf_theme_name_full.' Menucard settings', array( &$this, 'displayCustomFields' ), 'menucard', 'normal', 'high' );
				add_meta_box( 'my-custom-fields', $rf_theme_name_full.' Slide settings', array( &$this, 'displayCustomFields' ), 'slide', 'normal', 'high' );
			}
		}
		/**
		* Display the new Custom Fields meta box
		*/
		function displayCustomFields() {
			global $post, $theme_options;
			?>
			<div class="form-wrap">
				<div class="grid grid-pad">

				<?php
				//
				wp_nonce_field('my-custom-fields', 'my-custom-fields_wpnonce', false, true);
				
				// Set no menu in post if set
				if(isset($_REQUEST['iframe']) && $_REQUEST['iframe'] == 1) {
					echo '<input type="hidden" name="iframe" value="1" />';
				}
				
				$customFieldsCounter = 0;
				foreach ( $this->customFields as $customField ){
					$customFieldsCounter++;
					
					// Check scope
					$scope = $customField['scope'];
					$output = false;
					foreach ( $scope as $scopeItem ) {
						switch ( $scopeItem ) {
							case "post": {
								// Output on any post screen
								if ($post->post_type=="post" )
									$output = true;
								break;
							}
							case "page": {
								// Output on any page screen
								if ($post->post_type=="page" )
									$output = true;
								break;
							}
							case "section": {
								// Output on any section screen
								if ($post->post_type=="section" )
									$output = true;
								break;
							}
							case "menucard": {
								// Output on any section screen
								if ($post->post_type=="menucard" )
									$output = true;
								break;
							}
							case "slide": {
								// Output on any section screen
								if ($post->post_type=="slide" )
									$output = true;
								break;
							}
						}
						if ( $output ) break;
					}
					
					// Check capability
					if ( !current_user_can( $customField['capability'], $post->ID ) )
						$output = false;
						
					// Output if allowed
					if ( $output ) { ?>
                    	 
						<div class="form-field form-required <?php if ($customField[ 'pagetemplate' ]) echo $customField[ 'pagetemplate' ]; ?>">
                        	<input type="hidden" name="rf_hidden_flag" value="true" />
                            <?php

							switch ( $customField[ 'type' ] ) {
								case "header": {
									// Header
									echo '<div class="customfield_header">' . $customField[ 'title' ] . '</div>';
									break;
								}
								case "checkbox": {
									// Checkbox
									echo '<label><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<div class="checkbox-container"><input type="checkbox" name="' . $this->prefix . $customField['name'] . '" id="' . $this->prefix . $customField['name'] . '" value="yes"';
									if ( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) == "yes" )
										echo ' checked="checked"';
									echo '" style="width: auto;" />';
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'">'. $customField[ 'title' ] .'</label></div>';
									break;
								}
								case "textarea": {
									// Text area
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<textarea name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" columns="30" rows="3">' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '</textarea>';
									break;
								}
								case "upload": {
									// Upload field
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" class="upload_field" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
									echo '<div><input class="upload_button" style="width:auto;" type="button" value="Browse" /></div>';
									break;
								}
								case "dropdown": {
									// Dropdown field
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<select name="' . $this->prefix . $customField[ 'name' ] .'" id="' . $this->prefix . $customField[ 'name' ] .'">';
									
									// options can be array or sting with ,
									if(is_array($customField['options'])){
										$options = $customField['options'];
									}
									else{
										$options = explode(',',$customField['options']);
									}
									
									foreach ($options as $option) {
										$selected = '';
										if (get_post_meta($post->ID, $this->prefix.$customField['name'], true) == $option) {
											$selected = 'selected="selected"';
										}
										echo '<option '.$selected.' value="'.$option.'">'.$option.'</option>';
									}
									echo '</select>';
									break;
								}
								case "categories": {
									// Category list
                                    echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<div class="sortable-list">';
									$category_array = get_post_meta( $post->ID, $this->prefix . $customField['name'], true );
									$temp_array = array();
									if ($category_array) {
										$temp_array = explode(',',$category_array);
										foreach ($temp_array as $catid) {
											echo '<div class="sortable">';
											echo '<input type="checkbox" checked name="' . $this->prefix . $customField['name'] . '[]" id="' . $this->prefix . $customField['name'] . '" value="' . $catid .'" />' . get_cat_name($catid);
											echo '</div>';
										}
									}
									$categories = get_categories('order_by=name&order=asc&hide_empty=0');
									foreach ($categories as $cat) {
										if ($cat->category_parent == 0 && !in_array($cat->term_id, $temp_array)) {
											echo '<div class="sortable">';
											echo '<input type="checkbox" name="' . $this->prefix . $customField['name'] . '[]" id="' . $this->prefix . $customField['name'] . '" value="' . $cat->term_id .'" />' . $cat->name;
											echo '</div>';
										}
									}
									echo '</div>';
									break;
								}
								
								case "selector": {
									
									//save main post
									$main_post = $post;
									
                                    echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<div class="sortable-list sortable-single">';
									
									// Get checked id's and make array
									$pages_checked = get_post_meta( $post->ID, $this->prefix.$customField['name'], true );
									$pages_checked_array = explode(",", $pages_checked);
									
									// Get checked posts
									$pages_checked = new WP_Query( array( 
														'post_type' => $customField['settings']['post_type'],
														'post__in'  => $pages_checked_array,
														'orderby' => 'post__in',
														'posts_per_page' => -1,
														));
									
									// Get other posts
									$pages_notchecked = new WP_Query( array( 
														'post_type' => $customField['settings']['post_type'],
														'post__not_in'  => $pages_checked_array,
														'posts_per_page' => -1,
														));		
									
									// Merge Query
									$all_pages = new WP_Query();
									$all_pages->posts = array_merge( $pages_checked->posts, $pages_notchecked->posts );
									$all_pages->post_count = count( $all_pages->posts );
														
									// Loop posts
 									while ( $all_pages->have_posts() ) : $all_pages->the_post();
									
										// Set checked or don't
										$pagechecked = (in_array(get_the_ID(), $pages_checked_array)) ? 'checked' : '';
										
										echo '<div class="sortable sortable-single">';
										echo '<input type="checkbox" '.$pagechecked.' name="' . $this->prefix . $customField['name'] . '[]" id="' . $this->prefix . $customField['name'] . '" value="' . get_the_ID() .'" />' . get_the_title();
										echo '</div>';
									endwhile;

									// wp_reset_query working alternative
									$post = $main_post;
									
									echo '</div>';
									
									break;
								}

								case "sections": {
									
									// Add thickbox for iframe popup links
									add_thickbox();
									
									// Echo column 1
									echo '<div class="col-1-2"><div class="content drag-pos"><div class="field-header">';
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									
									// Add New Section link
									echo '<a class="button thickbox" href="'.get_admin_url().'post-new.php?post_type=section&iframe=1&#038;width=800&#038;height=800&#038;TB_iframe=true">'. __('Add new section', 'the-restaurant') .'</a>';
									echo '</div><div id="sectionsPage" class="sortable-list">';
									
									// Get Section array string and build array	
									$sections_array = get_post_meta( $post->ID, $this->prefix . $customField['name'], true );
									$sections_array = array_filter(explode(',',$sections_array));
									
									// If content is not in array add on top
									if (!in_array("content", $sections_array)) {
										array_unshift($sections_array , 'content-on');
										array_unshift($sections_array , 'content');
									}

									$i =0;
									
									/// Loop array of sections and content on page
									foreach ($sections_array as $sectionsid){
										if($sectionsid=='content'){
											if( isset($sections_array[$i+1]) && $sections_array[$i+1]=='content-on'){
												$checked = 'checked';
												$class = '';
											}else{
												$checked = '';
												$class = 'off';
											}
											
											// Build page content sortable item
											echo '<div id="sortable-content" class="unsortable dashicons-after wp-menu-image icon-pageContent '.$class.'">';
												echo __('This Page Content', 'the-restaurant');
												echo '<input type="checkbox" checked name="' . $this->prefix . $customField['name'] . '[]" value="content" />';
												echo '<input type="checkbox" '.$checked.' name="' . $this->prefix . $customField['name'] . '[]" id="pageContent" value="content-on" />';
											echo '</div>';	
										}
										elseif($sectionsid=='content-on'){
											// Do noting only a var to check
										}
										else{
											// Get section post object
											$section_post = get_post($sectionsid);
											
											// Test if section is not trash
											if($section_post->post_status != 'trash'){
												// Set title to no tile if empty
												if($section_post->post_title=='')$section_post->post_title = __('No title', 'the-restaurant');
												
												// Build section sortable item
												echo '<div id="sortable-'.$section_post->ID.'" class="sortable dashicons-after wp-menu-image icon-'.sanitize_title($section_post->sectiontype).'">';
													echo '<input type="checkbox" checked name="' . $this->prefix . $customField['name'] . '[]" id="' . $this->prefix . $customField['name'] . '" value="' . $section_post->ID .'" />';
													echo '<a class="thickbox" href="'.get_admin_url().'post.php?post='.$section_post->ID.'&action=edit&iframe=1&#038;width=800&#038;height=800&#038;TB_iframe=true&#038;hidemenu=true">' .$section_post->post_title ."</a>";
												echo '</div>';
											}
										}
										$i++;
									}
									
									// Close sortable list place icon div close collum
									echo '</div><div class="icon-drag"></div></div></div>';
									
									// Echo column 2
									echo '<div class="col-1-2"><div class="content"><div class="field-header"><label for="' . $this->prefix . $customField[ 'name' ] .'"><b>'.__('All Sections', 'the-restaurant').'</b></label></div><div id="sectionsSort" class="sortable-list">';
									
									// Get all section objects
									$sections = get_posts(
													array( 	'posts_per_page' 	=> -1,
															'post_type' 		=> 'section',
															'order' 			=> 'DESC',
															'post_status' 		=> array('publish', 'pending', 'draft', 'future', 'private', 'inherit') 
													));
								
									// Loop all sections
									foreach ( $sections as $section ){
										
										// Skip Sections that are already on this page
										if (!in_array($section->ID, $sections_array)) {
											
											// Set title to no tile if empty
											if($section->post_title=='') $section->post_title = __('No title', 'the-restaurant');
											
											// Build sortable item for section
											echo '<div id="sortable-'.$section->ID.'" class="sortable dashicons-after wp-menu-image icon-'.sanitize_title($section->sectiontype).'">';
												echo '<input type="checkbox" name="' . $this->prefix . $customField['name'] . '[]" id="' . $this->prefix . $customField['name'] . '" value="' . $section->ID .'" />';
												echo '<a class="thickbox" href="'.get_admin_url().'post.php?post='.$section->ID.'&action=edit&iframe=1&#038;width=800&#038;height=800&#038;TB_iframe=true&#038;hidemenu=true">' . $section->post_title ."</a>";
											echo '</div>';
										}
									}
									
									// 
									wp_reset_postdata();
									
									echo '</div></div></div>';
									break;
								}
								
								
								/*case "portfolio": {
                                    echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<div class="sortable-list">';
									$category_array = get_post_meta( $post->ID, $this->prefix . $customField['name'], true );
									$temp_array = array();
									if ($category_array) {
										$temp_array = explode(',',$category_array);
										foreach ($temp_array as $catid) {
											echo '<div class="sortable">';
											echo '<input type="checkbox" checked name="' . $this->prefix . $customField['name'] . '[]" id="' . $this->prefix . $customField['name'] . '" value="' . $catid .'" />' . get_the_title($catid);
											echo '</div>';
										}
									}
									
									$args = array( 'posts_per_page' => -1, 'post_type' => 'portfolio', 'order' => 'DESC');
									$sections = get_posts( $args );
								
									foreach ( $sections as $section ) : 
										if (!in_array($section->ID, $temp_array)) {
											echo '<div class="sortable">';
											echo '<input type="checkbox" name="' . $this->prefix . $customField['name'] . '[]" id="' . $this->prefix . $customField['name'] . '" value="' . $section->ID .'" />' . $section->post_title;
											echo '</div>';
										}
									endforeach;
									wp_reset_postdata();
									echo '</div>';
									break;
								}*/
								case "menucard-cats": {
                                    echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<div class="sortable-list">';
									$category_array = get_post_meta( $post->ID, $this->prefix . $customField['name'], true );
									$temp_array = array();
									if ($category_array) {
										$temp_array = explode(',',$category_array);
										foreach ($temp_array as $catid) {
											$cat = get_term( $catid, 'menucardcat' );
											echo '<div class="sortable">';
											echo '<input type="checkbox" checked name="' . $this->prefix . $customField['name'] . '[]" id="' . $this->prefix . $customField['name'] . '" value="' . $catid .'" />' . $cat->name;
											echo '</div>';
										}
									}
									
									$args = array(
										'orderby' => 'name',
										'order' => 'ASC',
										'taxonomy' => 'menucardcat',
										'hide_empty' => false
									);
									$categories = get_categories($args);
								
									foreach ( $categories as $cat ) : 
										if (!in_array($cat->term_id, $temp_array)) {
											echo '<div class="sortable">';
											echo '<input type="checkbox" name="' . $this->prefix . $customField['name'] . '[]" id="' . $this->prefix . $customField['name'] . '" value="' . $cat->term_id .'" />' . $cat->name;
											echo '</div>';
										}
									endforeach;
									wp_reset_postdata();
									echo '</div>';
									break;
								}
								case "sidebar": {
									// Dropdown field
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<select name="' . $this->prefix . $customField[ 'name' ] .'" id="' . $this->prefix . $customField[ 'name' ] .'">';

									foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
										if ($sidebar['id']) {
											$selected = '';
											if (get_post_meta($post->ID, $this->prefix.$customField['name'], true) == $sidebar['id']) {
												$selected = 'selected="selected"';
											}
											echo '<option '.$selected.' value="'.$sidebar['id'].'">'.$sidebar['name'].'</option>';
										}
									}
										
									echo '</select>';
									break;
								}
								case "color": {
									// color field
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									//echo '<div class="colorexample" style="background:#' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . ';"></div>';
									echo '<input type="text" class="cp_colorpicker" name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" data-alpha="true" />';
									break;
								}
								default: {
									// Plain text field
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
									break;
								}
							}
							?>
							<?php if ( isset($customField[ 'description' ]) ) echo '<p class="description">' . $customField[ 'description' ] . '</p>'; ?>
						</div>
						<?php
						if ($customFieldsCounter % 2 == 0 || 1==1) { ?>
							</div><div class="grid grid-pad">
                        <?php }
					}
				} ?>
                </div>
			</div>
			<?php
		}
		/**
		* Save the new Custom Fields values
		*/
		function saveCustomFields( $post_id, $post ) {
			if (!isset($_POST['rf_hidden_flag'])) 
				return;
			if ( isset($_POST[ 'my-custom-fields_wpnonce' ]) && !wp_verify_nonce( $_POST[ 'my-custom-fields_wpnonce' ], 'my-custom-fields' ) )
				return;
			if ( !current_user_can( 'edit_post', $post_id ) )
				return;
			if ( $post->post_type != 'page' && $post->post_type != 'post' && $post->post_type != 'section' && $post->post_type != 'menucard' && $post->post_type != 'slide' )
				return;
			foreach ( $this->customFields as $customField ) {
				if ( current_user_can( $customField['capability'], $post_id ) && isset($customField[ 'name' ]) ) {
					if ( isset( $_POST[ $this->prefix . $customField['name'] ] ) && trim((is_array($_POST[$this->prefix.$customField['name']]) ? implode(",",$_POST[$this->prefix.$customField['name']]) : $_POST[$this->prefix.$customField['name']]))) {
						update_post_meta( $post_id, $this->prefix . $customField[ 'name' ], (is_array($_POST[$this->prefix.$customField['name']]) ? implode(",",$_POST[$this->prefix.$customField['name']]) : $_POST[$this->prefix.$customField['name']]) );
					} else {
						delete_post_meta( $post_id, $this->prefix . $customField[ 'name' ] );
					}
				}
			}
		}
	} // End Class
} // End if class exists statement




function rf_wp_nav_menu_item_post_type_meta_box(  ) {
    global $_nav_menu_placeholder, $nav_menu_selected_id;
 
 	$post_type_name = 'section';
 
    $post_type_name = $post_type['args']->name;
 
    // Paginate browsing for large numbers of post objects.
    $per_page = 50;
    $pagenum = isset( $_REQUEST[$post_type_name . '-tab'] ) && isset( $_REQUEST['paged'] ) ? absint( $_REQUEST['paged'] ) : 1;
    $offset = 0 < $pagenum ? $per_page * ( $pagenum - 1 ) : 0;
 
    $args = array(
        'offset' => $offset,
        'order' => 'ASC',
        'orderby' => 'title',
        'posts_per_page' => $per_page,
        'post_type' => $post_type_name,
        'suppress_filters' => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false
    );
 
    if ( isset( $post_type['args']->_default_query ) )
        $args = array_merge($args, (array) $post_type['args']->_default_query );
 
    // @todo transient caching of these results with proper invalidation on updating of a post of this type
    $get_posts = new WP_Query;
    $posts = $get_posts->query( $args );
    if ( ! $get_posts->post_count ) {
        echo '<p>' . __( 'No items.', 'the-restaurant' ) . '</p>';
        return;
    }
 
    $num_pages = $get_posts->max_num_pages;
 
    $page_links = paginate_links( array(
        'base' => add_query_arg(
            array(
                $post_type_name . '-tab' => 'all',
                'paged' => '%#%',
                'item-type' => 'post_type',
                'item-object' => $post_type_name,
            )
        ),
        'format' => '',
        'prev_text' => __('&laquo;', 'the-restaurant'),
        'next_text' => __('&raquo;', 'the-restaurant'),
        'total' => $num_pages,
        'current' => $pagenum
    ));
 
    $db_fields = false;
    if ( is_post_type_hierarchical( $post_type_name ) ) {
        $db_fields = array( 'parent' => 'post_parent', 'id' => 'ID' );
    }
 
    $walker = new Walker_Nav_Menu_Checklist( $db_fields );
 
    $current_tab = 'most-recent';
    if ( isset( $_REQUEST[$post_type_name . '-tab'] ) && in_array( $_REQUEST[$post_type_name . '-tab'], array('all', 'search') ) ) {
        $current_tab = $_REQUEST[$post_type_name . '-tab'];
    }
 
    if ( ! empty( $_REQUEST['quick-search-posttype-' . $post_type_name] ) ) {
        $current_tab = 'search';
    }
 
    $removed_args = array(
        'action',
        'customlink-tab',
        'edit-menu-item',
        'menu-item',
        'page-tab',
        '_wpnonce',
    );
 
    ?>
    <div id="posttype-<?php echo $post_type_name; ?>" class="posttypediv">
        <ul id="posttype-<?php echo $post_type_name; ?>-tabs" class="posttype-tabs add-menu-item-tabs">
            <li <?php echo ( 'most-recent' == $current_tab ? ' class="tabs"' : '' ); ?>>
                <a class="nav-tab-link" data-type="tabs-panel-posttype-<?php echo esc_attr( $post_type_name ); ?>-most-recent" href="<?php if ( $nav_menu_selected_id ) echo esc_url(add_query_arg($post_type_name . '-tab', 'most-recent', remove_query_arg($removed_args))); ?>#tabs-panel-posttype-<?php echo $post_type_name; ?>-most-recent">
                    <?php _e( 'Most Recent', 'the-restaurant' ); ?>
                </a>
            </li>
            <li <?php echo ( 'all' == $current_tab ? ' class="tabs"' : '' ); ?>>
                <a class="nav-tab-link" data-type="<?php echo esc_attr( $post_type_name ); ?>-all" href="<?php if ( $nav_menu_selected_id ) echo esc_url(add_query_arg($post_type_name . '-tab', 'all', remove_query_arg($removed_args))); ?>#<?php echo $post_type_name; ?>-all">
                    <?php _e( 'View All', 'the-restaurant' ); ?>
                </a>
            </li>
            <li <?php echo ( 'search' == $current_tab ? ' class="tabs"' : '' ); ?>>
                <a class="nav-tab-link" data-type="tabs-panel-posttype-<?php echo esc_attr( $post_type_name ); ?>-search" href="<?php if ( $nav_menu_selected_id ) echo esc_url(add_query_arg($post_type_name . '-tab', 'search', remove_query_arg($removed_args))); ?>#tabs-panel-posttype-<?php echo $post_type_name; ?>-search">
                    <?php _e( 'Search', 'the-restaurant'); ?>
                </a>
            </li>
        </ul><!-- .posttype-tabs -->
 
        <div id="tabs-panel-posttype-<?php echo $post_type_name; ?>-most-recent" class="tabs-panel <?php
            echo ( 'most-recent' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' );
        ?>">
            <ul id="<?php echo $post_type_name; ?>checklist-most-recent" class="categorychecklist form-no-clear">
                <?php
                $recent_args = array_merge( $args, array( 'orderby' => 'post_date', 'order' => 'DESC', 'posts_per_page' => 15 ) );
                $most_recent = $get_posts->query( $recent_args );
                $args['walker'] = $walker;
 
                /**
                 * Filter the posts displayed in the 'Most Recent' tab of the current
                 * post type's menu items meta box.
                 *
                 * The dynamic portion of the hook name, `$post_type_name`, refers to the post type name.
                 *
                 * @since 4.3.0
                 *
                 * @param array  $most_recent An array of post objects being listed.
                 * @param array  $args        An array of WP_Query arguments.
                 * @param object $post_type   The current post type object for this menu item meta box.
                 */
                $most_recent = apply_filters( "nav_menu_items_{$post_type_name}_recent", $most_recent, $args, $post_type );
 
                echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $most_recent), 0, (object) $args );
                ?>
            </ul>
        </div><!-- /.tabs-panel -->
 
        <div class="tabs-panel <?php
            echo ( 'search' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' );
        ?>" id="tabs-panel-posttype-<?php echo $post_type_name; ?>-search">
            <?php
            if ( isset( $_REQUEST['quick-search-posttype-' . $post_type_name] ) ) {
                $searched = esc_attr( $_REQUEST['quick-search-posttype-' . $post_type_name] );
                $search_results = get_posts( array( 's' => $searched, 'post_type' => $post_type_name, 'fields' => 'all', 'order' => 'DESC', ) );
            } else {
                $searched = '';
                $search_results = array();
            }
            ?>
            <p class="quick-search-wrap">
                <input type="search" class="quick-search input-with-default-title" title="<?php esc_attr_e('Search', 'the-restaurant'); ?>" value="<?php echo $searched; ?>" name="quick-search-posttype-<?php echo $post_type_name; ?>" />
                <span class="spinner"></span>
                <?php submit_button( __( 'Search', 'the-restaurant' ), 'button-small quick-search-submit button-secondary hide-if-js', 'submit', false, array( 'id' => 'submit-quick-search-posttype-' . $post_type_name ) ); ?>
            </p>
 
            <ul id="<?php echo $post_type_name; ?>-search-checklist" data-wp-lists="list:<?php echo $post_type_name?>" class="categorychecklist form-no-clear">
            <?php if ( ! empty( $search_results ) && ! is_wp_error( $search_results ) ) : ?>
                <?php
                $args['walker'] = $walker;
                echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $search_results), 0, (object) $args );
                ?>
            <?php elseif ( is_wp_error( $search_results ) ) : ?>
                <li><?php echo $search_results->get_error_message(); ?></li>
            <?php elseif ( ! empty( $searched ) ) : ?>
                <li><?php _e('No results found.', 'the-restaurant'); ?></li>
            <?php endif; ?>
            </ul>
        </div><!-- /.tabs-panel -->
 
        <div id="<?php echo $post_type_name; ?>-all" class="tabs-panel tabs-panel-view-all <?php
            echo ( 'all' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' );
        ?>">
            <?php if ( ! empty( $page_links ) ) : ?>
                <div class="add-menu-item-pagelinks">
                    <?php echo $page_links; ?>
                </div>
            <?php endif; ?>
            <ul id="<?php echo $post_type_name; ?>checklist" data-wp-lists="list:<?php echo $post_type_name?>" class="categorychecklist form-no-clear">
                <?php
                $args['walker'] = $walker;
 
                /*
                 * If we're dealing with pages, let's put a checkbox for the front
                 * page at the top of the list.
                 */
                if ( 'page' == $post_type_name ) {
                    $front_page = 'page' == get_option('show_on_front') ? (int) get_option( 'page_on_front' ) : 0;
                    if ( ! empty( $front_page ) ) {
                        $front_page_obj = get_post( $front_page );
                        $front_page_obj->front_or_home = true;
                        array_unshift( $posts, $front_page_obj );
                    } else {
                        $_nav_menu_placeholder = ( 0 > $_nav_menu_placeholder ) ? intval($_nav_menu_placeholder) - 1 : -1;
                        array_unshift( $posts, (object) array(
                            'front_or_home' => true,
                            'ID' => 0,
                            'object_id' => $_nav_menu_placeholder,
                            'post_content' => '',
                            'post_excerpt' => '',
                            'post_parent' => '',
                            'post_title' => _x('Home', 'nav menu home label', 'the-restaurant'),
                            'post_type' => 'nav_menu_item',
                            'type' => 'custom',
                            'url' => home_url('/'),
                        ) );
                    }
                }
 
                /**
                 * Filter the posts displayed in the 'View All' tab of the current
                 * post type's menu items meta box.
                 *
                 * The dynamic portion of the hook name, `$post_type_name`, refers
                 * to the slug of the current post type.
                 *
                 * @since 3.2.0
                 *
                 * @see WP_Query::query()
                 *
                 * @param array  $posts     The posts for the current post type.
                 * @param array  $args      An array of WP_Query arguments.
                 * @param object $post_type The current post type object for this menu item meta box.
                 */
                $posts = apply_filters( "nav_menu_items_{$post_type_name}", $posts, $args, $post_type );
                $checkbox_items = walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $posts), 0, (object) $args );
 
                if ( 'all' == $current_tab && ! empty( $_REQUEST['selectall'] ) ) {
                    $checkbox_items = preg_replace('/(type=(.)checkbox(\2))/', '$1 checked=$2checked$2', $checkbox_items);
 
                }
 
                echo $checkbox_items;
                ?>
            </ul>
            <?php if ( ! empty( $page_links ) ) : ?>
                <div class="add-menu-item-pagelinks">
                    <?php echo $page_links; ?>
                </div>
            <?php endif; ?>
        </div><!-- /.tabs-panel -->
 
        <p class="button-controls">
            <span class="list-controls">
                <a href="<?php
                    echo esc_url( add_query_arg(
                        array(
                            $post_type_name . '-tab' => 'all',
                            'selectall' => 1,
                        ),
                        remove_query_arg( $removed_args )
                    ));
                ?>#posttype-<?php echo $post_type_name; ?>" class="select-all"><?php _e('Select All', 'the-restaurant'); ?></a>
            </span>
 
            <span class="add-to-menu">
                <input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu', 'the-restaurant' ); ?>" name="add-post-type-menu-item" id="<?php echo esc_attr( 'submit-posttype-' . $post_type_name ); ?>" />
                <span class="spinner"></span>
            </span>
        </p>
 
    </div><!-- /.posttypediv -->
    <?php
}
?>