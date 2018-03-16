<?php
class rf_ControlPanel {
	var $optionlist = array();
	
	function __construct($optionlistArray) {
		global $rf_theme_name;
		
				
		// Set var array in object
		$this->optionlist = $optionlistArray;
		
		add_action('admin_menu', array(&$this, 'admin_menu'));
		if (!is_array(get_option($rf_theme_name))) {
			$default_settings = $this->setDefaults();
			add_option($rf_theme_name, $default_settings);
			$this->options = get_option($rf_theme_name);
		}
		$this->options = get_option($rf_theme_name);
	}
  
	function setDefaults() {
		$default_settings = array();
		foreach($this->optionlist as $menuitem) {
			foreach($menuitem['options'] as $theme_option) {
				if (isset($theme_option['default'])) $default_settings[$theme_option['id']] = $theme_option['default'];
			}
		}
		return $default_settings;
	}
	
	function admin_menu() {
	  	add_theme_page('theme settings', 'Theme Settings', 'edit_theme_options', "theme_settings", array(&$this, 'optionsmenu'));
	}
	
	function optionsmenu() {
		global $rf_theme_name;
		
		// Save the settings
		if (isset($_POST['ss_action']) && $_POST['ss_action'] == 'save') {
			foreach($this->optionlist as $menuitem) {
				foreach($menuitem['options'] as $theme_option) {
					if (isset($theme_option['id']) && empty($_POST[$theme_option['id']])) {
						$option_value = false;
					} elseif (isset($theme_option['id'])) {
						$option_value = $_POST[$theme_option['id']];
					}
				  	if (isset($theme_option['id']) && isset($option_value)) $this->options[$theme_option['id']] = $option_value;
				}
			}
			update_option($rf_theme_name, $this->options);
			echo '<div class="updated fade" id="message" style="background-color: rgb(255, 251, 204); width: 300px; margin-left: 20px"><p>Settings <strong>saved</strong>.</p></div>';
		} ?>
		
		<div class="wrap rm_wrap">
			<h2>Theme Settings</h2>
			<p>To easily use the theme, use the options below.</p>
			<div id="theme-menu">
				<?php foreach($this->optionlist as $menuitem) { ?>
				<a href="#item-<?php echo $menuitem['id']; ?>" class="menu-item menu-item-<?php echo $menuitem['id']; ?>" item="item-<?php echo $menuitem['id']; ?>"><?php echo $menuitem['name']; ?></a>
				<?php } ?>
			</div>
			<div class="rm_opts">
				<form action="" method="post" class="themeform">
					<input type="hidden" id="ss_action" name="ss_action" value="save">
					<?php foreach($this->optionlist as $menuitem) { ?>
					<div class="rm_section item-<?php echo $menuitem['id']; ?>">
						<?php foreach($menuitem['options'] as $theme_option) {
							switch($theme_option['type']) {
								case 'title': ?>
									<div class="rm_title">
										<h3><?php echo $theme_option['name']; ?></h3>
										<span class="submit">
											<input type="submit" value="Save Changes" name="cp_save"/>
										</span>
										<div class="clearfix"></div>
									</div>
									<?php break;
								case 'upload': ?>
									<div class="rm_input rm_text">
										<label for="<?php echo $theme_option['id']; ?>"><?php echo $theme_option['name']; ?></label>
										<input type="text" name="<?php echo $theme_option['id']; ?>" id="<?php echo $theme_option['id']; ?>" class="upload_field" value="<?php if (isset($this->options[$theme_option['id']])) echo $this->options[$theme_option['id']]; ?>" />
										<small><input class="upload_button" type="button" value="Browse" /></small><div class="clearfix"></div>
									</div>
									<?php break;
								case 'dropdown': ?>
									<div class="rm_input rm_select">
										<label for="<?php echo $theme_option['id']; ?>"><?php echo $theme_option['name']; ?></label>
										<select name="<?php echo $theme_option['id']; ?>" id="<?php echo $theme_option['id']; ?>">
											<?php foreach($theme_option['options'] as $key => $value) { 
											if (is_numeric($key)) $key = $value; ?>
											<option <?php if (isset($this->options[$theme_option['id']]) && $this->options[$theme_option['id']] == $key) { ?>selected="selected"<?php } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
											<?php } ?>
										</select>
										<small><?php echo $theme_option['desc']; ?></small><div class="clearfix"></div>
									</div>
									<?php break;
								case 'checkbox': ?>
									<div class="rm_input rm_text">
										<label for="<?php echo $theme_option['id']; ?>"><?php echo $theme_option['name']; ?></label>
										<input type="checkbox" <?php if (isset($this->options[$theme_option['id']]) && $this->options[$theme_option['id']] == '1') { echo 'checked'; } ?>  name="<?php echo $theme_option['id']; ?>" id="<?php echo $theme_option['id']; ?>" value="1" />
										<small><?php echo $theme_option['desc']; ?></small><div class="clearfix"></div>
									</div>
									<?php break;
								case 'textarea': ?>
									<div class="rm_input rm_text">
										<label for="<?php echo $theme_option['id']; ?>"><?php echo $theme_option['name']; ?></label>
										<textarea rows="5" cols="50" name="<?php echo $theme_option['id']; ?>" id="<?php echo $theme_option['id']; ?>"><?php if (isset($this->options[$theme_option['id']])) echo stripslashes(htmlspecialchars($this->options[$theme_option['id']])); ?></textarea>
										<small><?php echo $theme_option['desc']; ?></small><div class="clearfix"></div>
									</div>
									<?php break;
								case 'colorpicker':
								//<div class="colorexample" style="background:#<?php if (isset($this->options[$theme_option['id']])) echo $this->options[$theme_option['id']]; ?/>;"></div> ?>
									<div class="rm_input rm_text rm_color">
										<label for="<?php echo $theme_option['id']; ?>"><?php echo $theme_option['name']; ?></label>
                                        
										<input type="text" name="<?php echo $theme_option['id']; ?>" id="<?php echo $theme_option['id']; ?>" class="cp_colorpicker" value="<?php if (isset($this->options[$theme_option['id']])) echo $this->options[$theme_option['id']]; ?>" data-alpha="true" />
										<small><?php echo $theme_option['desc']; ?></small><div class="clearfix"></div>
									</div>
									<?php break;
								case 'slider': ?>
									<div class="rm_input rm_text">
										<label for="<?php echo $theme_option['id']; ?>"><?php echo $theme_option['name']; ?></label>
                                        <input type="hidden" name="<?php echo $theme_option['id']; ?>" class="cp_slider" id="<?php echo $theme_option['id']; ?>" value="<?php if (isset($this->options[$theme_option['id']])) echo $this->options[$theme_option['id']]; ?>" />
                                        <div class="slidervalue"><?php if (isset($this->options[$theme_option['id']])) echo ($this->options[$theme_option['id']] * 100); ?>%</div>
                                        <div class="valueslider"></div>
                                        <small><?php echo $theme_option['desc']; ?></small><div class="clearfix"></div>
									</div>
									<?php break;
								 case "selector": {
									?>
                                    <div class="rm_input rm_selector">
                                    <label for="<?php echo $theme_option['id']; ?>"><?php echo $theme_option['name']; ?></label>
                                    <ul class="radio-list">
                                     <?php
									
									// Get checked posts
									$all_pages = new WP_Query( array( 
														'post_type' 		=> 'page',
														'posts_per_page' 	=> -1,
														'orderby' 			=> 'title',
														'order'   			=> 'DESC',
														));
														
									if (isset($this->options[$theme_option['id']])){
										$set_page = $this->options[$theme_option['id']];
									}
									else{
										$set_page = 0;
									}
														
									// Loop posts
 									while ( $all_pages->have_posts() ) : $all_pages->the_post();
									
										// Set checked or don't
										if($set_page == get_the_ID()){
											$pagechecked = 'checked';
										}
										else{
											$pagechecked = '';
										}
										
										echo '<li class="radiolist">';
										echo '<input type="radio" '.$pagechecked.' name="' . $theme_option['id'] . '" id="' . $theme_option['id'] . '" value="' . get_the_ID() .'" />' . get_the_title();
										echo '</li>';
									endwhile;
									?>
                                    	</ul><small><?php echo $theme_option['desc']; ?></small><div class="clearfix"></div>
 									</div>
                                    <?php
									
									break;
								}
								default: ?>
									<div class="rm_input rm_text">
										<label for="<?php echo $theme_option['id']; ?>"><?php echo $theme_option['name']; ?></label>
										<input type="text" name="<?php echo $theme_option['id']; ?>" id="<?php echo $theme_option['id']; ?>" value="<?php if (isset($this->options[$theme_option['id']])) echo stripslashes(htmlspecialchars($this->options[$theme_option['id']])); ?>" />
										<small><?php echo $theme_option['desc']; ?></small><div class="clearfix"></div>
									</div>
									<?php break;
							}
						} ?>
					</div>
					<?php } ?>
				</form>
			</div>
		</div>
		<?php
	}
}
?>