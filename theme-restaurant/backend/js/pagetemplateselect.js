jQuery(document).ready(function($){
	
	var sectionTemplate = jQuery('#sectiontype').val();
	sectionTemplateOption(sectionTemplate);
	
	jQuery("#sectiontype").change(function() {
		sectionTemplate = jQuery(this).val();
		sectionTemplateOption(sectionTemplate);
	});
	
	console.log(rfthemedata);
	
	function sectionTemplateOption(sectionTemplate){
		if (sectionTemplate) {
			sectionTemplate = sectionTemplate.replace(" ", "-").toLowerCase();
			jQuery('#my-custom-fields').find('.form-field:not(.general)').fadeOut(500);
			jQuery('#my-custom-fields').find('.form-field.'+sectionTemplate).fadeIn(500);
			
			if (sectionTemplate == 'portfolio' || sectionTemplate == 'widget-area' || sectionTemplate == 'blog-tiles') {
				jQuery('#postdivrich, .composer-switch').fadeOut(0);
			} else {
				jQuery('#postdivrich, .composer-switch').fadeIn(0);
			}
		}
	}
	
});