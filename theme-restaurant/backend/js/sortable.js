jQuery(document).ready(function($){
		
	$(".sortable-list").sortable({
		cursor: 'move',
		items: '.sortable',
  		update: function( event, ui ) {}
	});
	
	$("#sectionsPage").sortable({
		//axis: 'y',
		cursor: 'move',
	    //items: "div:not(.unsortable)",
		items: 'div',
    	cancel: ".unsortable",
		connectWith: ".sortable-list",
  		update: function( event, ui ) {
			$(this).find('input[type=checkbox]:not(#pageContent)').attr("checked","checked");
		}
	}).disableSelection();
	
	$("#sectionsSort").sortable({
		//axis: 'y',
		cursor: 'move',
		items: '.sortable',
		connectWith: ".sortable-list",
  		update: function( event, ui ) {
			$(this).find('input[type=checkbox]').removeAttr("checked");
		}
	});
 	
});