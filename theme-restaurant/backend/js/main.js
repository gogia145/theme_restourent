jQuery(function(){
	// Page content Check add/remove Class
	jQuery('#pageContent').on( "click", function(event) {
		if(jQuery(this).prop('checked')){
			jQuery(this).parent().removeClass('off');
			jQuery('#postdivrich').slideDown();
		}
		else{
			jQuery(this).parent().addClass('off');
			jQuery('#postdivrich').slideUp();
		}
		jQuery(window).trigger('resize');
	});
	
	//
	if(jQuery('#pageContent').length && !jQuery('#pageContent').prop('checked')){
		jQuery('#postdivrich').slideUp();
	}
	
	(function(){ var tb_show_temp = window.tb_show; window.tb_show = function(){ tb_show_temp.apply(null, arguments);
		var iframe = jQuery('#TB_iframeContent');
		iframe.load(function(){
			var iframeDoc = iframe[0].contentWindow.document;
			var iframeJQuery = iframe[0].contentWindow.jQuery;
			
			// of jQuery in iframe is loaded
			if(iframe[0].contentWindow.jQuery){
				
				// Add iframe to 'move to trash link'
				iframeJQuery('.submitdelete').attr('href', function() {
					return this.href + '&iframe=1';
				});
			}
		});
	 }})();

});

// Build event lisner
var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
var eventer = window[eventMethod];
var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

// Listen to message from child window
eventer(messageEvent,function(e) {
    var key = e.message ? "message" : "data";
    var data = e[key];

	if(e.data.action=='closeUpdateIfame'){
		closeUpdateIfame(e.data);
	}
},false);


function closeUpdateIfame(post){
	// Remove thickbox iframe popup
	tb_remove();
	
	// Check if sortable item exsists
	if(jQuery('#sortable-'+post.id).length){
		
		if(post.post_status=='trash'){
			jQuery('#sortable-'+post.id)
				.slideUp('slow')
				.remove();
			jQuery(".sortable-list").sortable("refresh");
		}
		else{
			jQuery('#sortable-'+post.id)
				.removeClass()
				.addClass('sortable dashicons-after wp-menu-image icon-'+post.sectiontype);
			jQuery('#sortable-'+post.id+'> a').text(post.post_title);	
		}
	}
	// Add sortable item on top and refresh
	else{
		jQuery("#sectionsPage").append('<div id="sortable-'+post.id+'" class="sortable dashicons-after wp-menu-image icon-'+post.sectiontype+'"><input type="checkbox" checked name="sections[]" id="sections" value="'+post.id+'" /><a class="thickbox" href="post.php?post='+post.id+'&action=edit&iframe=1&#038;width=800&#038;height=800&#038;TB_iframe=true&#038;">'+post.post_title+'</a></div>');
		jQuery(".sortable-list").sortable("refresh");
	}
	
	// Animate just changed effect
	jQuery('#sortable-'+post.id).css({backgroundColor: '#FFF896'}).animate({backgroundColor: '#F1F1F1'},2500);
}
