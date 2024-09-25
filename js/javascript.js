/***********************************************************************************************************************
DOCUMENT: includes/javascript.js
DEVELOPED BY: Ryan Stemkoski
COMPANY: Zipline Interactive
EMAIL: ryan@gozipline.com
PHONE: 509-321-2849
DATE: 3/26/2009
UPDATED: 3/25/2010
DESCRIPTION: This is the JavaScript required to create the accordion style menu.  Requires jQuery library
NOTE: Because of a bug in jQuery with IE8 we had to add an IE stylesheet hack to get the system to work in all browsers. I hate hacks but had no choice :(.
************************************************************************************************************************/
$(document).ready(function() {
	 
	//ACCORDION BUTTON ACTION (ON CLICK DO THE FOLLOWING)
	$('.accordionButton').click(function() {

		//REMOVE THE ON CLASS FROM ALL BUTTONS
		$('.accordionButton').removeClass('on');
		  
		//NO MATTER WHAT WE CLOSE ALL OPEN SLIDES
	 	$('.accordionContent').slideUp('normal');
   
		//IF THE NEXT SLIDE WASN'T OPEN THEN OPEN IT
		if($(this).next().is(':hidden') == true) {
			
			//ADD THE ON CLASS TO THE BUTTON
			$(this).addClass('on');
			  
			//OPEN THE SLIDE
			$(this).next().slideDown('normal');
		 } 
		  
	 });
	  
	
	/*** REMOVE IF MOUSEOVER IS NOT REQUIRED ***/
	
	//ADDS THE .OVER CLASS FROM THE STYLESHEET ON MOUSEOVER 
	$('.accordionButton').mouseover(function() {
		$(this).addClass('over');
		
	//ON MOUSEOUT REMOVE THE OVER CLASS
	}).mouseout(function() {
		$(this).removeClass('over');										
	});
	
	/*** END REMOVE IF MOUSEOVER IS NOT REQUIRED ***/
	
	
	/********************************************************************************************************************
	CLOSES ALL S ON PAGE LOAD
	********************************************************************************************************************/	
	$('.accordionContent').hide();

});


WebFontConfig = {
    google: { families: [ 'Goudy+Bookletter+1911::latin', 'Raleway:400,300,500,700:latin', 'Open+Sans:400italic,400:latin' ] }
    };
    (function() {
    var wf = document.createElement('script');
    wf.src = 'js/webfont.js';
    console.log(wf.src);
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
})(); 

$(document).ready(function(){
    $(".inline").colorbox({inline:true, width:"53%"});
});

// Hide Header on on scroll down
var didScroll;
var lastScrollTop = 0;
var delta = 2;
var navbarHeight = $('header').outerHeight();
$(window).scroll(function(event){
    didScroll = true;
});
setInterval(function() {
    if (didScroll) {
     hasScrolled();
     didScroll = false;
    }
}, 250);
function hasScrolled() {
    var st = $(this).scrollTop();
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
     return;
    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight){
     // Scroll Down
     $('header').removeClass('nav-down').addClass('nav-up');
    } else {
     // Scroll Up
     if(st + $(window).height() < $(document).height()) {
         $('header').removeClass('nav-up').addClass('nav-down');
     }
    }
    lastScrollTop = st;
}

$(window).scroll(function() {
    $('#designIcon').each(function(){
    var imagePos = $(this).offset().top;
    var topOfWindow = $(window).scrollTop();
    	if (imagePos < topOfWindow+500) {
    		$(this).addClass("fadeIn");
    	}
    });
});

$(window).scroll(function() {
    $('#developmentIcon').each(function(){
    var imagePos = $(this).offset().top;
    var topOfWindow = $(window).scrollTop();
    	if (imagePos < topOfWindow+500) {
    		$(this).addClass("fadeIn2");
    	}
    });
});

$(window).scroll(function() {
    $('#newsletterIcon').each(function(){
    var imagePos = $(this).offset().top;
    var topOfWindow = $(window).scrollTop();
    	if (imagePos < topOfWindow+500) {
    		$(this).addClass("fadeIn3");
    	}
    });
});

$(window).scroll(function() {
    $('#socialIcon').each(function(){
    var imagePos = $(this).offset().top;
    var topOfWindow = $(window).scrollTop();
    	if (imagePos < topOfWindow+500) {
    		$(this).addClass("fadeIn4");
    	}
    });
});

$(window).scroll(function() {
    $('#twitterIcon').each(function(){
    var imagePos = $(this).offset().top;
    var topOfWindow = $(window).scrollTop();
    	if (imagePos < topOfWindow+500) {
    		$(this).addClass("fadeIn");
    	}
    });
});

(function( $ ){  
 	/* 
 	* Lazy Line Painter 1.4
 	* SVG Stroke animation.
 	*
 	* https://github.com/camoconnell/lazy-line-painter
 	*
 	* Copyright 2013 
 	* Cam O'Connell - http://www.camoconnell.com  http://www.behance.net/camoconnell 
 	* Released under the MIT license
 	*  
 	*/
 	// Define object containing your Raphael path data.
 	// goto http://lazylinepainter.info to convert your svg into a svgData object.
 	var svgData = { 
 		"demo" :
 		{ 
 			"strokepath" :
 			[ 
 				{   "path": "M392,577.8c0,0,3.6-27.4-11.3-37.3c-13-8.7-18.3-9.7-55-11  c-36.7-1.3-46-2.7-56.3-13c-10.3-10.3-10.7-45.7-10.7-45.7s2-37,4-54.7s3-26.3-14-32.7c-17-6.3-25.7-9.7-30-7  c-4.3,2.7-3.7,5.7-4.7,10.7s-2.7,9.7-8,14c-5.3,4.3-33.6,15.5-65-1c-28-14.7-29.7-43-19-61.3c9.3-16,33-17,38-14.3  c5,2.7,9.3,5.7,9,26.3c0,3-7.3,2-7.3,1s3-18-10.7-19c-13.7-1-17,16.7-17.3,26.7s7.3,32,27.3,33.3c20,1.3,29-12.3,31-30.7  c1.7-12.7,12.7-15.7,24.3-15.3c11.7,0.3,39-1.3,60.3,21c21.3,22.3,18.3,30.3,18.7,59c0.3,28.7,1,44,10,53s30,12.7,57.3,13.7  c27.3,1,48-2.3,61.7,9.7s12.3,16,15.3,23.7c3,7.7,2.7,22.7,3.7,31.3s2.7,18,2.7,18",
              "duration": 800
          },
          {
              "path": "M180,577.8c0,0-11-23.3-10.3-53.7c0.7-30.3,23.3-56.3,34-69.3  s29.4-28.3,43.7-71.8",
              "duration": 300
          },
          {
              "path": "M256.5,353.5c0,0,14.5-34.7-12.2-78.4s-55.7-40-55.7-40  s-15.3,1-32,12.3s-52.7,25.3-76.3,20.7s-35.7-29-37.7-45.7s19-49.3,32.3-68s30.7-39.7,30.3-64c-0.3-24.3-19-64.3-44-70  S35,21.8,35,21.8s-11.3,8-10.7,36.3s3.7,37.2,12,37.5s13.8-3.4,18.2-9.1c1.7-2.3,7.8,0.6,7.8,2.6c-6.7,13.3-28.7,21-37,21  s-19-1-23-25S1.7,38.8,5,23.5S22.7,0,46.3,0.5C65.1,1,94-0.1,99.3,12.8c5.8,13.9,13.3,26.3,19,38.3c5.7,12,19.3,28.7,21,45  c1.7,16.3-27.7,52-27.7,52l-31.3,42.7c0,0-23,29.7-6,47.3s41.7,1.3,41.7,1.3s16-4.3,30-25.3s39.3-20.3,58.3-19.3s59.7,2.7,80,51  s27.3,68.3,27.7,89.7c0.3,21.3-8.2,49.8-17.4,63.1",
              "duration": 900
          },
          {
               "path": "M259.4,458.5c0,0-19.4,24.9-21,41.6c-1.7,16.7-3,23.7,12.3,79.7",
              "duration": 300
          },
          {
              "path": "M297.7,579.8c0,0,0.3-16.7,17.3-29c17-12.3,33.4-20.2,33.4-20.2",
              "duration": 300
          },
          {
              "path": "M393,493.9c0,0,5.7-6.4,6.7-53.1c0.3-28-8.2-33.8-19.6-44.2  s-26.8-34.5-35.8-50.2c-9-15.7-15.3-52.3-4.7-90.7c10.7-38.3,36.6-73.7,75.9-71.7c30.7,1.7,39.1,27.3,39.4,46.3  c0.3,19-15.7,23.7-25.3,29.3c-9.7,5.7-21,12.3-24.3,35.7c-1.7,11.3,5.7,18,12.7,18.7s12.3-0.7,12.7-17.7c0-2.7,3.7,0.3,3.7,0.3  s8,26.4-16.7,26.5c-24.7,0.1-28-18.9-28.3-36.2s5.7-31,25-36.3c19.3-5.3,15.7-14.7,15.7-14.7s0.3-12.3-28.7-16.7  c-18-2.7-27.7,26.3-32,51.3s-6.3,58,13.7,71.7c20,13.7,43,17.7,53,33c10,15.3,14,38.9,14.3,75.1s-15.8,63.5-15.8,63.5",
              "duration": 800
          },
          {
              "path": "M388.3,549.7c0,0-7.7,5.1-8.3,13.8c-0.7,8.7,1.3,16.3,1.3,16.3",
              "duration": 200
          }
 			],  
 			"dimensions" : { "width": 456, "height":580 }
 		}
 	}
 	$(document).ready(function(){
 		// Setup your Lazy Line element.
 		// see README file for more settings
 		$('#demo').lazylinepainter({
 				'svgData' : svgData,
 				'strokeWidth':2,  
 				'strokeColor':'#ffffff',
 				'onComplete' : function(){
 					$(this).animate({'opacity':0},800);
 					}	
 			}
 		) 
 		// Paint your Lazy Line, that easy!
 		$('#demo').lazylinepainter('paint');
 	})
})( jQuery );

function showHide(shID) {
 	if (document.getElementById(shID)) {
 		if (document.getElementById(shID+'-show').style.display != 'none') {
 			document.getElementById(shID+'-show').style.display = 'none';
 			document.getElementById(shID).style.display = 'block';
 		}
 		else {
 			document.getElementById(shID+'-show').style.display = 'inline';
 			document.getElementById(shID).style.display = 'none';
 		}
 	}
}

// Cache selectors
var lastId;
var topMenu = $("#top-menu");
var topMenuHeight = topMenu.outerHeight()+15;
// All list items
var menuItems = topMenu.find("a.jump");
// Anchors corresponding to menu items
scrollItems = menuItems.map(function(){    
   var item = $($(this).attr("href"));
   if (item.length) { return item; }
});
// Bind click handler to menu items
// so we can get a fancy scroll animation
menuItems.click(function(e){
   var href = $(this).attr("href"),
       offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight+1;
   $('html, body').stop().animate({ 
       scrollTop: offsetTop
   }, 900);
   e.preventDefault();
});

 // Bind to scroll
$(window).scroll(function(){
    // Get container scroll position
    var fromTop = $(this).scrollTop()+topMenuHeight;
    // Get id of current scroll item
    var cur = scrollItems.map(function(){
      if ($(this).offset().top < fromTop)
        return this;
    });
    // Get the id of the current element
    cur = cur[cur.length-1];
    var id = cur && cur.length ? cur[0].id : "";
    if (lastId !== id) {
        lastId = id;
        // Set/remove active class
        menuItems
          .parent().removeClass("active")
          .end().filter("[href=#"+id+"]").parent().addClass("active");
    }                   
});


