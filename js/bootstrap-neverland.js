/* Elements */
var $window = $(window);
var $sidebar = $("#navSidebarNeverland.fixed");
var $footer = $("#footerRow .navbar-bottom");
var $footerRow = $("#footerRow");
var $footerMarker = $("#footerRow");
var $tableFilter = $(".table-filtered");
var $popup = $("#modal-onload");
var $clear = $(".input-clear");

/* Components */
var componentFooter = true;
var componentSidebar = true;
var componentTableFilter = true;
var componentPopup = true;
var componentClearInput = true;

/* Variables */
var viewportHeight;
var footerHeight;
var footerTop;
var footerMargin;
var sidebarHeight;
var sidebarFloatPoint;
var sidebarFixPoint;

/* Triggers */
$(window).on("load", onLoadHandler);
$(window).on("resize", onResizeHandler);
$(window).on("scroll", onScrollHandler);

/* Event handlers */
function onLoadHandler() {
    doCheckComponents();
    doPrepareComponents();
    doCaptureInitialScreenData();
    doCaptureScreenData();
    doFloatingFooter();
    doTableFilters();
    doMessagePopup();
    doClearInput();
    doSmoothScroll();
    doElementToggle();
    doMoveSubmenu();
    doBlurSearchbox();
    doAdjustTopBar();
}

function onResizeHandler() {
    doCheckComponents();
    doCaptureScreenData();
    doFloatingFooter();
    doElementToggle();
    doMoveSubmenu();
    doAdjustTopBar();
}

function onScrollHandler() {
    doCheckComponents();
    doCaptureScreenData();
    doFloatingFooter();
    doElementToggle();
    doAdjustTopBar();
}

function doCheckComponents() {
    try {
        componentPopup = componentPopup ? $popup.length != 0 : false;
        componentFooter = componentFooter ? $footer.length != 0 && $footerRow.length != 0 : false;
        componentSidebar = componentSidebar ? $sidebar.length != 0 : false;
        componentClearInput = componentClearInput ? $clear.length != 0 : false;
        componentTableFilter = componentTableFilter ? $tableFilter.length != 0 && typeof($.fn.columnFilters) == "function" : false;
    } catch(e) {
        console.log("Error: " + e.message);
    }
}

function doPrepareComponents() {
    try {
        if (componentFooter) {
            $footerRow.before('<span id="neverland-footer-placeholder"></span>');
            $footerMarker = $("#neverland-footer-placeholder");
        }    

        $('.dropup').click(function(){
            $('.dropdown-menu').last().slideToggle();
        });
    } catch(e) {
        console.log("Error: " + e.message);
    }
}

function doCaptureInitialScreenData() {
    try {
        viewportHeight = $(window).height();
        
        if (componentFooter) {
            footerHeight = $footer.height();
            footerTop = $footerMarker.offset().top + footerHeight + 20;
        }

        if (componentFooter && componentSidebar) {
            sidebarHeight = $sidebar.height();
            sidebarFloatPoint = $sidebar.position().top;
            sidebarFixPoint = footerTop - sidebarHeight - 160;
        }
    } catch(e) {
        console.log("Error: " + e.message);
    }
}

function doCaptureScreenData() {
    try {
        if (componentFooter) {
            footerHeight = $footer.height();
            footerTop = $footerMarker.offset().top + footerHeight + 20;
        }
    } catch(e) {
        console.log("Error: " + e.message);
    }
}

function doFloatingFooter() {
    try {
        if (componentFooter) {
            var windowTop = $(window).scrollTop();
            var windowBottom = windowTop + viewportHeight;

          	if ($window.width() >= 768) {
          		if (windowBottom > footerTop) {
                	$footer.removeClass("fixed");
	            } else {
    	        	$footer.addClass("fixed");
            	}
            } else {
              	$footer.removeClass('fixed');
            }
        }
    } catch(e) {
        console.log("Error: " + e.message);
    }
}

function doTableFilters() {
    try {
        if (componentTableFilter) {
            var excludedColumns = new Array();

            $tableFilter.each(function() {
                var classesAry = $(this).attr("class").split(" ");

                for (classIndex in classesAry) {
                    if (classesAry[classIndex].trim().indexOf("filter-skip") == 0) {
                        var skipColumns = classesAry[classIndex].split("-");

                        for (skipIndex in skipColumns) {
                            if (!isNaN(skipColumns[skipIndex])) {
                                excludedColumns.push(parseInt(skipColumns[skipIndex]));
                            }
                        }
                    }
                }
            });

            $tableFilter.columnFilters({excludeColumns: excludedColumns});
        }
    } catch(e) {
        console.log("Error: " + e.message);
    }
}

function doMessagePopup() {
    try {
        if (componentPopup) {
            $popup.modal();
        }
    } catch(e) {
        console.log("Error: " + e.message);
    }
}

function doClearInput() {
    try {
        if (componentClearInput) {
            var counter = 1;

            $clear.each(function() {
                var group = "input-clear-group-" + counter.toString();
                var boxTop = $(this).offset().top;
                var boxLeft = $(this).offset().left;
                var boxHeight = $(this).innerHeight();
                var boxWidth = $(this).innerWidth();
                var padding = (boxHeight / 2) - 5;

                var clearTop = boxTop + padding;
                var clearLeft = boxLeft + boxWidth - padding - 10;
                var clearElement = '<i class="icon-remove input-clear-trigger ' + group + '" ' +
                                   'style="position:absolute; cursor:pointer; top:' + clearTop +
                                   'px; left:' + clearLeft + 'px; display:none;" data-target="' +
                                   group + '"></i>';

                $(this)
                    .addClass(group)
                    .attr("data-group", group)
                    .after(clearElement)
                    .keydown(function() {
                        if ($(this).val() != "") {
                            $("i." + group).fadeIn();
                        } else {
                            $("i." + group).fadeOut();
                        }
                    });

                counter++;
            });

            $("i.input-clear-trigger").click(function() {
                var target = $(this).attr("data-target");

                $("input." + target)
                    .val("")
                    .focus();

                $(this).fadeOut("fast");
            });
        }
    } catch(e) {
        console.log("Error: " + e.message);
    }
}

function doSmoothScroll() {
    try {
        $("a.smooth").on("click", function() {
            var href = $(this).attr("href");
            var pos = href.indexOf("#");
            var offset = 0;

            if (pos == 0) {
                offset = $(href).offset().top;

                $("html, body").animate({
                    scrollTop: offset
                });
            }
        });
    } catch(e) {
        console.log("Error: " + e.message);
    }
}

function doElementToggle() {
    try {
        $("[data-hide-for]").each(function() {
            var windowTop = $(window).scrollTop();
            var windowBottom = windowTop + viewportHeight;

            var hideFor = $(this).attr("data-hide-for");
            var hidePos = $(hideFor).offset().top + footerHeight;

            if (windowBottom > hidePos) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    } catch(e) {
        console.log("Error: " + e.message);
    }
}

function doMoveSubmenu() {
    try {
        if ( $window.width() <= 980 ) {
            $('#navSidebarNeverland').appendTo('#parent').removeClass();
        } else if ( $('#parent #navSidebarNeverland').length != 0 ) {
            console.log("ist vorhanden");
            $('#navSidebarNeverland').appendTo('#widget-area').addClass('nav nav-list Neverland');
        }
    } catch(e) {
        console.log("Error: " + e.message);
    }
}

function doBlurSearchbox() {
    try {
        if(!$('.search-query').val()) {
            $('.search-query').val("Search...");
        }
        
        $('.search-query').focus(function() {
            this.value = "";
        });

        $('.search-query').blur(function() {
            this.value = "Search...";
        });        
    } catch(e) {
        console.log("Error: " + e.message);
    }
}

function doAdjustTopBar() {
    try {
        if($window.height() <= 400) {
            $('header.navbar.Neverland').addClass('minified');
            $(".navbar-brand img").height("24px");
        } else {
            if($(window).scrollTop() > 0) {
                  $(".navbar-brand .globallinks").css("margin-top", "-3px");
                  $('header.navbar.Neverland').addClass('minified');
                  $(".navbar-brand img.logo").height("24px");
            } else {
                  $('header.navbar.Neverland').removeClass('minified');
                  $(".navbar-brand img.logo").height("43px");
                  $(".navbar-brand .globallinks").css("margin-top", "4px");
            }
        }    
    } catch(e) {
        console.log("Error: " + e.message);
    }
}
