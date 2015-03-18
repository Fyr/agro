var flag = true;
$(document).ready(function(){
	$('#tags').css('left', -1000);
	
    $('.menu li a').click(function(){
        $(".header .menu li ul").stop().slideUp();
        if ( $(this).next().is('ul') ) {
            $(this).next('ul').stop().slideToggle();
        }
    });
    
	$(document).on('click touchstart', function(e) {
		if (!$.contains($(".header .menuDesktop").get(0), e.target)  ) {
			$(".header .menuDesktop li ul").stop().slideUp();
		}
        if (!$.contains($(".header .menuMobile").get(0), e.target)  ) {
			$(".header .menuMobile li ul").stop().slideUp();
		}
	});
	
	$('#catalog').find('.firstLevel').click(function(){
	    $(this).next().stop().slideToggle();
	    if ( $(this).next().is('ul') ) {
	        if( $(this).hasClass('active')) {
	            $(this).removeClass('active')
	        } else {
	            $(this).addClass('active');
	        }
	    }
	}).next().stop().hide();
	
	flag = true;        
    $(window).resize(function() {
        if ($(window).width() <= 1000 && $(window).width() > 720 ) {
            if (flag) {
			    $(".rightSidebar").appendTo($(".oneLeftSide"));
                flag = false;
            }
        } else {
			$(".rightSidebar").appendTo($(".mainColomn"));
            flag = true;
        }
    });
    
	$("#partnersParade").smoothDivScroll({ 
	    autoScrollingMode: "onStart", 
	    autoScrollingStep: 1, 
	    autoScrollingInterval: 20,
	    manualContinuousScrolling: true,
	    visibleHotSpotBackgrounds: "always",
	    hotSpotScrollingInterval: 30,
	    autoScrollingDirection: "endlessLoopRight",
	    mouseOverLeftHotSpot: function(eventObj, data) {
	        $(this).smoothDivScroll("option","autoScrollingDirection","endlessLoopLeft");
	    },
	    mouseOverRightHotSpot: function(eventObj, data) {
	        $(this).smoothDivScroll("option","autoScrollingDirection","endlessLoopRight");
	    }
	});
	
	// Logo parade event handlers
	$("#partnersParade").bind("mouseover", function() {
	    $(this).smoothDivScroll("stopAutoScrolling");
	}).bind("mouseout", function() {
	    $(this).smoothDivScroll("startAutoScrolling");
	});
});