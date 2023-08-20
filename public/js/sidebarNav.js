$(document).ready(function() {       
    
    var mobileQuery = "56em";
    var fullMobileQuery = "40em";
    
    // Allows expanding/contracting of sidebar nav
    $(".secondary_nav li > a").filter($(".plus_wrapper").prev("a")).click(function(e) {
        e.preventDefault();
        var li = $(this).parent("li");
        var ul = li.parent("ul");
        var plusWrapper = $(this).next();
        var showHideArea = plusWrapper.next("ul");
        closeSecondaryNav(ul, li);
        toggleSecondaryNav(li, plusWrapper, showHideArea);
    });
    $(".secondary_nav li > .plus_wrapper").click(function() {
        var li = $(this).parent("li");
        var ul = li.parent("ul");
        var plusWrapper = $(this);
        var showHideArea = plusWrapper.next("ul");
        closeSecondaryNav(ul, li);
        toggleSecondaryNav(li, plusWrapper, showHideArea);
    });
    
    function toggleSecondaryNav(li, plusWrapper, showHideArea){
        console.log("toggleSecondaryNav", li);
        var expandableArea = showHideArea;
        var parent = li;
        var speed = "fast";

        if (expandableArea.is(":visible")){
            plusWrapper.removeClass("minus").addClass("open-icon").removeClass("close-icon");
            parent.removeClass("active_section_transition");
            expandableArea.slideUp(speed);
        } else {
            plusWrapper.addClass("minus").addClass("close-icon").removeClass("open-icon");
            parent.addClass("active_section_transition");
            expandableArea.slideDown(speed);
        }
    }
    
    function closeSecondaryNav(ul, li, mobileNav){
        console.log("closeSecondaryNav", li);
        mobileNav = typeof mobileNav !== 'undefined' ?  mobileNav : false;
        
        var baseSelector;
        if (mobileNav)
            baseSelector = "#mobile_high_council_chamber";
        else
            baseSelector = ".secondary_nav";
        
        // don't close anything if opening a third-tier
        if (ul.hasClass("second_tier"))
            return;
        
        // close everything except for the one you just clicked
        var lis = $(baseSelector+" li.active_section_transition, "+baseSelector+" li.active_section").not(li);
        var childUls = lis.children("ul");
        var plusWrapper = lis.children(".plus_wrapper");
        childUls.slideUp("fast");
        lis.removeClass("active_section_transition");
        plusWrapper.removeClass("minus").addClass("open-icon").removeClass("close-icon");
    }

    // Auto-expand current desktop nav section on load
    var active = $(".secondary_nav .active");
    var activeParent = active.parent("ul");
    if (activeParent.hasClass("third_tier")){
        activeParent.show();
        activeParent.prev(".plus_wrapper").addClass("minus");

        var rootWrapper = activeParent.parent("li").parent("ul");
        rootWrapper.show();
        rootWrapper.prev(".plus_wrapper").addClass("minus");
    }
    else if (activeParent.hasClass("second_tier")){
        activeParent.show();
        activeParent.prev(".plus_wrapper").addClass("minus");
    } else {
        var childUl = active.children("ul");
        if (childUl.length > 0){
            childUl.show();
            active.children(".plus_wrapper").addClass("minus");
        }
    }


});


(function () { GLOBAL_scriptsLoaded.push( 'sidebarNav.js' ) })();