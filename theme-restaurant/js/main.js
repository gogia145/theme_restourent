jQuery(document).ready(function($){



	// Add glyphicon to submenus
	jQuery('header').find('.mainnav > div > div > ul > li.menu-item-has-children > a').append('<i class="glyphicon glyphicon-chevron-down"></i>');
	


	// Add glyphicon to the mobile menu
	jQuery('nav.wp_nav_menu_mobile').find('li.menu-item-has-children > a').append('<i class="glyphicon glyphicon-chevron-right"></i>');



	// Mobile nav button
	jQuery('.mobile-nav-button').click(function(){
		jQuery(this).toggleClass('active');	
		jQuery('nav.wp_nav_menu_mobile').toggleClass('active');		
		return false;
	});
	
	
	
	// Activate perfect scrollbar for mobile
	jQuery(function() {
		jQuery('nav.wp_nav_menu_mobile').perfectScrollbar({
			suppressScrollX: true
		});
	});
	

	
	// Mobile submenu activation
	jQuery('nav.wp_nav_menu_mobile li.menu-item-has-children > a').click(function(){
		jQuery(this).parents('li.menu-item-has-children').toggleClass('active');
		jQuery(this).parents('nav.wp_nav_menu_mobile').toggleClass('show-submenu');
		return false;
	});
	jQuery('nav.wp_nav_menu_mobile').find('ul.sub-menu').prepend('<li class="toggle-submenu"><a href="#"></a></li>').find('.toggle-submenu').click(function(){
		jQuery(this).parents('li.menu-item-has-children').toggleClass('active');
		jQuery(this).parents('nav.wp_nav_menu_mobile').toggleClass('show-submenu');
	});



	// Handle sub sub menu positions
	jQuery('header').find('.mainnav ul.menu > li > ul li.menu-item-has-children').hover(function() {
		var submenu = jQuery(this).find('ul');
		var submenupos = submenu.offset().left;
		
		if (submenupos + submenu.outerWidth() > $(window).width()) {
			submenu.addClass('pos-left');
		}
	});



	// Sticky menu
	//jQuery('header').height(this.height());

	jQuery(window).scroll(function() {
		header = jQuery('#pageheader');
		headerHeight = header.height();
		mainnav = header.find('nav.mainnav');
		mainnavHeight = mainnav.height();

		var scrollspace = jQuery(window).scrollTop();
		if (scrollspace > (headerHeight - mainnavHeight)) {
			if (!jQuery('#pageheader nav.mainnav').hasClass('sticky')) {
				jQuery('#pageheader nav.mainnav').addClass('sticky');
				header.height(headerHeight);
			}			
		} else {
			if (jQuery('#pageheader nav.mainnav').hasClass('sticky')) {
				jQuery('#pageheader nav.mainnav').removeClass('sticky');
				//header.height(headerHeight);
			}
		}
	});



	var mySwiper = new Swiper('.swiper-container', {
		mode: 'horizontal',
		/*useCSS3Transforms: false,*/
		loop: true,
		/*pagination: '.swiper-pagination',*/
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		/*paginationClickable: true,*/
		autoplay: 5000
	});



	jQuery('.menucard-nav').click(function(){
		parent = jQuery(this).parents('.hentry');
		menucardContainer = parent.find('.menucard-slide-container');
		currentSlide = menucardContainer.attr('data');
		totalSlides = menucardContainer.find('.menucard-slide').length;

		if (jQuery(this).hasClass('menucard-nav-left') && currentSlide > 1) {
			currentSlide--;
		} else if (jQuery(this).hasClass('menucard-nav-right') && currentSlide < totalSlides) {
			currentSlide++;
		}

		menucardContainer.attr('data', currentSlide);

		menucardSlide(menucardContainer, currentSlide);

		return false;
	});

	jQuery('.menucard-cats').find('.btn').click(function(){
		parent = jQuery(this).parents('.hentry');
		menucardContainer = parent.find('.menucard-slide-container');
		currentSlide = jQuery(this).index() + 1;

		menucardContainer.attr('data', currentSlide);
		menucardSlide(menucardContainer, currentSlide);

		return false;
	});



	if (jQuery.browser.mobile) jQuery('body').addClass('ismobile');
	


	// Trigger resize
	jQuery(window).trigger('resize');
});



function menucardSlide(menucardContainer, currentSlide = 1) {
	menucardWidth = menucardContainer.parents('.menucard-slider').width();
	marginLeft = (currentSlide - 1) * menucardWidth * -1;
	menucardContainer.css('margin-left', marginLeft);

	menucardHeight = menucardContainer.find('.menucard-slide').eq(currentSlide - 1).height();
	menucardContainer.css('height', menucardHeight);

	parent = menucardContainer.parents('.hentry');
	totalSlides = menucardContainer.find('.menucard-slide').length;

	if (currentSlide == 1) {
		parent.find('.menucard-nav-left').addClass('fade');
		parent.find('.menucard-nav-right').removeClass('fade');
	} else if (currentSlide == totalSlides) {
		parent.find('.menucard-nav-left').removeClass('fade');
		parent.find('.menucard-nav-right').addClass('fade');
	} else {
		parent.find('.menucard-nav-left').removeClass('fade');
		parent.find('.menucard-nav-right').removeClass('fade');
	}
}



function menucardInit() {
	jQuery('.menucard-slide-container').each(function(){
		menucardSlides = jQuery(this).find('.menucard-slide');
		parent = jQuery(this).parents('.menucard-slider').width();

		menucardSlides.width(parent);

		currentSlide = jQuery(this).attr('data');
				
		menucardSlide(jQuery(this), currentSlide);
	});
}



jQuery( window ).resize(function() {		
	menucardInit();
});


/**
 * jQuery.browser.mobile (http://detectmobilebrowser.com/)
 * jQuery.browser.mobile will be true if the browser is a mobile device
 **/
(function(a){jQuery.browser.mobile=/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);
