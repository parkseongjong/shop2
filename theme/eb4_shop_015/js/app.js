var App = function() {
    function handleIEFixes() {
        //fix html5 placeholder attribute for ie7 & ie8
        if (jQuery.browser.msie && jQuery.browser.version.substr(0, 1) < 9) { // ie7&ie8
            $('input[placeholder], textarea[placeholder]').each(function () {
                var input = jQuery(this);
                $(input).val(input.attr('placeholder'));
                $(input).focus(function() {
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                });
                $(input).blur(function() {
                    if (input.val() == '' || input.val() == input.attr('placeholder')) {
                        input.val(input.attr('placeholder'));
                    }
                });
            });
        }
    }

    function handleBootstrap() {
        /*Bootstrap Carousel*/
        $('.carousel').carousel({
            interval: 15000,
            pause: 'hover'
        });
        /*Tooltips*/
        $('.tooltips').tooltip();
        $('.tooltips-show').tooltip('show');
        $('.tooltips-hide').tooltip('hide');
        $('.tooltips-toggle').tooltip('toggle');
        $('.tooltips-destroy').tooltip('destroy');
        /*Popovers*/
        $('.popovers').popover();
        $('.popovers-show').popover('show');
        $('.popovers-hide').popover('hide');
        $('.popovers-toggle').popover('toggle');
        $('.popovers-destroy').popover('destroy');
    }

    function handleToggle() {
        $('.list-toggle').on('click', function() {
            $(this).toggleClass('active');
        });
    }

    function handleSticky() {
	    // 헤더 높이 값 / basic-body의 margin-top 값
	    var headerHeight = parseInt($(".header").css("height"));
	    var headerNavHeight = parseInt($(".header-nav").css("height"));
	    var totalHeight = headerHeight - headerNavHeight;

        var stickyAddClass = function() {
            $(".header-fixed-on").addClass("fixed-trans");
        }
        var stickyRemoveClass = function() {
            $(".header-fixed-on").removeClass("fixed-trans");
        }

        $(window).scroll(function() {
            if ($(window).scrollTop()>totalHeight){ stickyAddClass(); } else { stickyRemoveClass(); }
        });
        
        // top-bnnr-close 클릭시 basic-body의 margin-top 값 수정
	    $(".top-bnnr-close .btn-close").click(function(){
            var headerHeight = parseInt($(".header").css("height"));
            var headerNavHeight = parseInt($(".header-nav").css("height"));
            var totalHeight = headerHeight - headerNavHeight;
            $(window).scroll(function() {
                if ($(window).scrollTop()>totalHeight){ stickyAddClass(); } else { stickyRemoveClass(); }
            });
	    });
    }

    function handleCategory() {
        if ($(window).width() >= 992) {
            var cateitem = 9;
            if (cateitem <= $("#nav_category > ul >li").length) {
                $('#nav_category > ul').append('<li class="navcate-load-more"><strong class="more-view">카테고리 더보기<i class="fa fa-plus margin-left-10"></i></strong></li>');
            }
            var show_cateitem = cateitem - 1;
            $('#nav_category > ul > li.item-vertical').each(function(i) {
                if (i > show_cateitem) {
                    $(this).css('display', 'none');
                }
            });
            $("#nav_category > ul > li.navcate-load-more").click(function () {
                if ($(this).hasClass('open')) {
                    $('#nav_category > ul > li.item-vertical').each(function(i) {
                        if (i > show_cateitem) {
                            $(this).slideUp(200);
                            $(this).css('display', 'none');
                        }
                    });
                    $(this).removeClass('open');
                    $('#nav_category > ul > li.navcate-load-more').html('<strong class="more-view">카테고리 더보기<i class="fa fa-plus margin-left-10"></i></strong>');
                } else {
                    $('#nav_category > ul > li.item-vertical').each(function(i) {
                        if (i > show_cateitem) {
                            $(this).slideDown(200);
                        }
                    });
                    $(this).addClass('open');
                    $('#nav_category > ul > li.navcate-load-more').html('<strong class="more-view">카테고리 닫기<i class="fa fa-minus margin-left-10"></i></strong>');
                }
            })
        } else {
            $('.item-vertical.dropdown').on('show.bs.dropdown', function(e) {
                $(this).find('.dropdown-menu').first().stop(true, true).slideDown(200);
            });
            $('.item-vertical.dropdown').on('hide.bs.dropdown', function(e) {
                $(this).find('.dropdown-menu').first().stop(true, true).slideUp(200);
            });
        }
    }

    function handleSidebar() {
        var sides = ["left", "top", "right", "bottom"];
        for (var i = 0; i < sides.length; ++i) {
            var cSide = sides[i];
            $(".sidebar." + cSide).sidebar({side: cSide});
        }
        $(".sidebar-left-trigger[data-action]").on("click", function() {
            var $this = $(this);
            var action = $this.attr("data-action");
            var side = $this.attr("data-side");
            $(".sidebar." + side).trigger("sidebar:" + action);
            $("html").toggleClass("overflow-hidden");
            $(".sidebar-left-mask, .sidebar-left-content").toggleClass("active");
            return false;
        });
        $(".sidebar-right-trigger[data-action]").on("click", function() {
            var $this = $(this);
            var action = $this.attr("data-action");
            var side = $this.attr("data-side");
            $(".sidebar." + side).trigger("sidebar:" + action);
            $("html").toggleClass("overflow-hidden");
            $(".sidebar-right-mask").toggleClass("active");
            return false;
        });
        $(".sidebar-shop-trigger").on("click", function() {
            $(".sidebar-shop-member").animate({width:"toggle"}, 200);
            $("html").toggleClass("overflow-hidden");
            $(".sidebar-shop-member-btn, .sidebar-shop-mask").toggleClass("active");
            return false;
        });
        $(".shop-member-box-btn").on("click", function() {
            $(this).next(".op-area").slideToggle(300).siblings(".op-area").slideUp();
        });
        setTimeout(function() {
            $(".sidebar").show();
        }, 500);
        $(window).resize(function() {
            $(".sidebar").show();
        });
    }

    function handleBackToTop() {
        $(document).ready(function() {
            $(".back-to-top").addClass("hidden-top");
                $(window).scroll(function() {
                if ($(this).scrollTop() === 0) {
                    $(".back-to-top").addClass("hidden-top")
                } else {
                    $(".back-to-top").removeClass("hidden-top")
                }
            });

            $('.back-to-top').click(function() {
                $('body,html').animate({scrollTop:0}, 1200);
                return false;
            });

            $(".bw-top-btm").addClass("show");
            $(window).scroll(function() {
                if ($(this).scrollTop() === 0) {
                    $(".bw-top-btm").addClass("show")
                } else {
                    $(".bw-top-btm").removeClass("show")
                }
            });

            $('.go-to-top').click(function() {
                $('body,html').animate({scrollTop:0}, 1200);
                return false;
            });

            $('.go-to-bottom').click(function() {
                $('body,html').animate({scrollTop: $(document).height() + $(window).height()}, 1200);
                return false;
            });

            $('.quick-scroll-btn.top-btn').click(function() {
                $('body,html').animate({scrollTop:0}, 1200);
                return false;
            });

            $('.quick-scroll-btn.down-btn').click(function() {
                $('body,html').animate({scrollTop:$(document).height()}, 1200);
                return false;
            });
        });
    }

    function handleTheme() {
        $(document).ready(function() {
	        // 고정 메뉴 클릭 액션
            $('.fix-navi-wrap h5 a.login').click(function() {
	            $(".fix-navi").toggleClass("active");
	            return false;
            });

			// 모바일 메뉴 버튼 클릭 액션
            $('.btn-mo-nav a').click(function() {
                $(".header-nav").toggleClass("active");
                return false;
            });

            // 최근본 상품 버튼 클릭 액션
            $('.btn-latest-goods a').click(function() {
                $(".latest-goods").toggleClass("active");
                return false;
            });
        });
    }

    return {
        init: function() {
            handleBootstrap();
            handleIEFixes();
            handleToggle();
            handleSticky();
            handleCategory();
            handleSidebar();
            handleBackToTop();
            handleTheme();
        }
    };

}();