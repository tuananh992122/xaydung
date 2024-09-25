(function ($) {
 "use strict";
	
    $(document).ready(function(){
    	
    /*----------------------------
     jQuery MeanMenu
    ------------------------------ */
  //jQuery('nav#dropdown').meanmenu(); 
      $('nav#dropdown').meanmenu({
        siteLogo: "<a href='http://xaydungtinduc.com'><img src='http://xaydungtinduc.com/img/logo1.png' /></a>"
      });

    /*-------------------------------------
    Project Jquery
    -------------------------------------*/
        $(".latest-project").owlCarousel({
         
            // Most important owl features
            items : 3,
            itemsDesktop : [1199,3],
            itemsDesktopSmall : [980,3],
            itemsTablet: [768,2],
            itemsTabletSmall: false,
            itemsMobile : [479,1],
            singleItem : false,
            itemsScaleUp : false,
            // Navigation
            navigation : true,
            navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
            // Responsive 
            responsive: true,
            pagination:false
         
        });
        
    /*-------------------------------------
    Testimonial jQuery
    -------------------------------------*/
        $(".testimonial").owlCarousel({
         
            // Most important owl features
            items : 1,
            itemsDesktop : [1199,1],
            itemsDesktopSmall : [980,1],
            itemsTablet: [768,1],
            itemsTabletSmall: false,
            itemsMobile : [479,1],
            singleItem : false,
            itemsScaleUp : false,
            // Navigation
            navigation : false,
            navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
            // Responsive 
            responsive: true,
            pagination:true
         
        });
    /*-------------------------------------
    About Comapny Jquery
    -------------------------------------*/
        $(".who-we-are-area").owlCarousel({
         
            // Most important owl features
            items : 1,
            itemsDesktop : [1199,1],
            itemsDesktopSmall : [980,1],
            itemsTablet: [768,1],
            itemsTabletSmall: false,
            itemsMobile : [479,1],
            singleItem : false,
            itemsScaleUp : false,
            // Navigation
            navigation : true,
            navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
            // Responsive 
            responsive: true,
            pagination:false,
         
        });	

    /*-------------------------------------
    About Comapny Jquery
    -------------------------------------*/
        $(".project-gallery").owlCarousel({
         
            // Most important owl features
            items : 1,
            itemsDesktop : [1199,1],
            itemsDesktopSmall : [980,1],
            itemsTablet: [768,1],
            itemsTabletSmall: false,
            itemsMobile : [479,1],
            singleItem : false,
            itemsScaleUp : false,
            // Navigation
            navigation : true,
            navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
            // Responsive 
            responsive: true,
            pagination:false,
         
        }); 
    	
    /*-------------------------------------
    jQuery Search Box customization
    -------------------------------------*/
    	$(".search-box .search-button").on('click',function(event){
            event.preventDefault();
            var v = $(this).prev('.search-text');
    		if(v.hasClass('active')){
                v.removeClass('active');
            }else{
                v.addClass('active');
            }
            return false;
    	});	

    /*-------------------------------------
    Accordion custom Code
    --------------------------------------- */    

    $('#accordion').children('.panel').children('.panel-collapse').each(function(){
        if($(this).hasClass('in')){
        $(this).parent('.panel').children('.panel-heading').addClass('active');
            var heading = $(this).parent('.panel').children('.panel-heading');
            heading.find('.heading-arrow i.fa').removeClass('fa-angle-down');
            heading.find('.heading-arrow i.fa').addClass('fa-angle-up');
        }
    });

    $('#accordion')
        .on('show.bs.collapse', function(e) {
            $(e.target).prev('.panel-heading').addClass('active');
            var heading = $(e.target).prev('.panel-heading');
            heading.find('.heading-arrow i.fa').removeClass('fa-angle-down');
            heading.find('.heading-arrow i.fa').addClass('fa-angle-up');
        })
        .on('hide.bs.collapse', function(e) {
            $(e.target).prev('.panel-heading').removeClass('active');
            var heading = $(e.target).prev('.panel-heading');
            heading.find('.heading-arrow i.fa').removeClass('fa-angle-up');
            heading.find('.heading-arrow i.fa').addClass('fa-angle-down');
        });

    /*-------------------------------------
    Home Page Team area jQuery activation
    -------------------------------------*/
        $(".home-page-team").owlCarousel({
         
            // Most important owl features
            items : 4,
            itemsDesktop : [1199,4],
            itemsDesktopSmall : [980,3],
            itemsTablet: [768,2],
            itemsTabletSmall: false,
            itemsMobile : [479,1],
            singleItem : false,
            itemsScaleUp : false,
            // Navigation
            navigation : true,
            navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
            // Responsive 
            responsive: true,
            pagination:false,
         
        });
        var w_w = $(window).width();
        if(w_w > 980){
            $(".project_solve").owlCarousel({
         
                // Most important owl features
                items : 4,
                itemsDesktop : [1199,4],
                itemsDesktopSmall : [980,1],
                itemsTablet: [768,1],
                itemsTabletSmall: false,
                itemsMobile : [479,1],
                singleItem : false,
                itemsScaleUp : false,
                // Navigation
                navigation : true,
                navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
                // Responsive 
                responsive: true,
                pagination:false,
             
            });
        }
        
    /*-------------------------------------
    Client logo jQuery activation code
    -------------------------------------*/
        $(".client-logo-area").owlCarousel({
         
            // Most important owl features
            items : 6,
            itemsDesktop : [1199,6],
            itemsDesktopSmall : [980,4],
            itemsTablet: [768,2],
            itemsTabletSmall: false,
            itemsMobile : [479,1],
            singleItem : false,
            itemsScaleUp : false,
            // Navigation
            navigation : true,
            navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
            // Responsive 
            responsive: true,
            pagination:false,
         
        });

    /*-------------------------------------
    scrollUp
    --------------------------------------- */    
        $.scrollUp({
            scrollText: '<i class="fa fa-angle-double-up"></i>',
            easingType: 'linear',
            scrollSpeed: 900,
            animation: 'fade'
        });
    /*-------------------------------------
    About Page jQuery activation code
    -------------------------------------*/
        $(".about-featured").owlCarousel({
         
            // Most important owl features
            items : 1,
            itemsDesktop : [1199,1],
            itemsDesktopSmall : [980,1],
            itemsTablet: [768,1],
            itemsTabletSmall: false,
            itemsMobile : [479,1],
            singleItem : false,
            itemsScaleUp : false,
            // Navigation
            navigation : false,
            navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
            // Responsive 
            responsive: true,
            pagination:true,
         
        });
        /*-------------------------------------
        Fancybox jquery activation Code
        -------------------------------------*/    
        $('.fancybox').fancybox();
    /*-------------------------------------
    Single Product jQuery activation code
    -------------------------------------*/
        $(".tab-image").owlCarousel({
         
            // Most important owl features
            items : 3,
            itemsDesktop : [1199,3],
            itemsDesktopSmall : [980,3],
            itemsTablet: [768,2],
            itemsTabletSmall: false,
            itemsMobile : [479,1],
            singleItem : false,
            itemsScaleUp : false,
            // Navigation
            navigation : true,
            navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
            // Responsive 
            responsive: true,
            pagination:false,
         
        });
    /*-------------------------------------
    Single Product Tab  activation code
    -------------------------------------*/

        $(".tab-image").on('click', 'li', function(event) {
            event.preventDefault();
            var displayTarget = $("#product-1");
            displayTarget.find('a').removeClass('active');
            var id = $(this).attr('data-id');
            // var targetUrl = $(this).find('a').attr('href');
            // console.log(displayTarget.html());
            var targetClass = ".product-gallery-img-"+id;
            console.log(targetClass);
            displayTarget.find(targetClass).addClass('active');
            // displayTarget.find('img').attr('src', targetUrl);
            /* Act on the event */
        });
    /*-------------------------------------
    Related Product jQuery activation code
    -------------------------------------*/
        $(".related-product").owlCarousel({
         
            // Most important owl features
            items : 4,
            itemsDesktop : [1199,4],
            itemsDesktopSmall : [980,3],
            itemsTablet: [768,2],
            itemsTabletSmall: false,
            itemsMobile : [479,1],
            singleItem : false,
            itemsScaleUp : false,
            // Navigation
            navigation : true,
            navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
            // Responsive 
            responsive: true,
            pagination:false,
         
        });

        //jquery Stiky Menu activation code

        $(window).on('scroll', function(){
            if( $(window).scrollTop()>100 ){
                 $('#sticker').addClass('stick');
            } else {
                $('#sticker').removeClass('stick');
            }
        });

    });

    equalHeight();
    $(window).load(equalHeight);
    $(window).resize(equalHeight);

    function equalHeight(){
        var windowWidth = $( window ).width();
        //console.log(windowWidth);
        if( windowWidth >= 768 ){
            var $h = 0;
            $(".home-service-area .single-service-area").height('auto');
            $(".home-service-area .single-service-area").each(function(){
                var thisHeight = $(this).outerHeight();
                if(thisHeight > $h){
                    $h = thisHeight;
                }
            });

            $(".home-service-area .single-service-area").height($h+'px');
        }else{
            $(".home-service-area .single-service-area").height('auto');
        }
    }

    if($("#googleMap").length){
        function initialize() {
        var mapOptions = {
        zoom: 15,
        scrollwheel: false,
        center: new google.maps.LatLng(-37.81618, 144.95692)
        };

        var map = new google.maps.Map(document.getElementById('googleMap'),
          mapOptions);


        var marker = new google.maps.Marker({
        position: map.getCenter(),
        animation:google.maps.Animation.BOUNCE,
        icon: 'img/map-marker.png',
        map: map
        });

        }

        google.maps.event.addDomListener(window, 'load', initialize);
    }



})(jQuery);

function do_contact(){
    var ck = 0;
    $('#contact .require').css('border','1px solid #000');
    $('#contact').find('.require').each(function(){
        if(jQuery(this).val() == ''){
            ck++;
            jQuery(this).css('border','1px solid red');
        }
    });
    if(ck > 0){
        jQuery('#thongbao_error').empty();
        jQuery('#thongbao_error').removeClass('hidden');
        jQuery('#thongbao_error').text('Bạn cần điền đầy đủ thông tin liên hệ');
        return false;
    };
    var email = jQuery('#email_contact').val();
    if(!checkEmail(email)){
        jQuery('#email_contact').css('border','1px solid red');
        jQuery('#thongbao_error').empty();
        jQuery('#thongbao_error').removeClass('hidden');
        jQuery('#thongbao_error').text('Email không đúng định dạng.');
        jQuery('#thongbao_error').show();
        return false;
    }
    
    return true;    
}
function do_search(){
    var keyword = $('#txt_search').val();
    if(keyword == '' || keyword == 'Nhập nội dung cần tìm')
        return false;
    var prefix = $('#prefix').html();
    window.location.href = prefix + 'tim-kiem/k='+encodeURI(keyword);
    return false;
}