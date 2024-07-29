// global variables
var isIE8 = false;
var isIE9 = false;
var $windowWidth;
var $windowHeight;
var $pageArea;
var isMobile = false;
// Debounce Function
(function($, sr) {
	// debouncing function from John Hann
	// http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
	var debounce = function(func, threshold, execAsap) {
		var timeout;
		return function debounced() {
			var obj = this, args = arguments;

			function delayed() {
				if(!execAsap)
					func.apply(obj, args);
				timeout = null;
			};

			if(timeout)
				clearTimeout(timeout);
			else if(execAsap)
				func.apply(obj, args);

			timeout = setTimeout(delayed, threshold || 100);
		};
	};
	// smartresize
	jQuery.fn[sr] = function(fn) {
		return fn ? this.on('resize', debounce(fn)) : this.trigger(sr);
	};

})(jQuery, 'clipresize');

//Main Function
var Main = function() {
	//function to detect explorer browser and its version
	var runInit = function() {
		if(/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
			var ieversion = new Number(RegExp.$1);
			if(ieversion == 8) {
				isIE8 = true;
			} else if(ieversion == 9) {
				isIE9 = true;
			}
		}
		if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			isMobile = true;
		};
	};
	//function to adjust the template elements based on the window size
	var runElementsPosition = function() {
		$windowWidth = jQuery(window).width();
		$windowHeight = jQuery(window).height();
		$pageArea = $windowHeight - jQuery('body > .navbar').outerHeight() - jQuery('body > .footer').outerHeight();
		if(!isMobile) {
			jQuery('.sidebar-search input').removeAttr('style').removeClass('open');
		}
		runContainerHeight();

	};
	//function to adapt the Main Content height to the Main Navigation height
	var runContainerHeight = function() {
		mainContainer = jQuery('.main-content > .container');
		mainNavigation = jQuery('.main-navigation');
		if($pageArea < 760) {
			$pageArea = 760;
		}
		if(mainContainer.outerHeight() < mainNavigation.outerHeight() && mainNavigation.outerHeight() > $pageArea) {
			mainContainer.css('min-height', mainNavigation.outerHeight());
		} else {
			mainContainer.css('min-height', $pageArea);
		};
		if($windowWidth < 768) {
			mainNavigation.css('min-height', $windowHeight - jQuery('body > .navbar').outerHeight());
		}
		/*jQuery("#page-sidebar .sidebar-wrapper").css('height', $windowHeight - jQuery('body > .navbar').outerHeight()).scrollTop(0).perfectScrollbar('update');*/
	};
	//function to activate the ToDo list, if present
	var runToDoAction = function() {
		if(jQuery(".todo-actions").length) {
			jQuery(".todo-actions").click(function() {
				if(jQuery(this).find("i").hasClass("fa-square-o") || jQuery(this).find("i").hasClass("icon-check-empty")) {
					if(jQuery(this).find("i").hasClass("fa")) {
						jQuery(this).find("i").removeClass("fa-square-o").addClass("fa-check-square-o");
					} else {
						jQuery(this).find("i").removeClass("icon-check-empty").addClass("fa fa-check-square-o");
					};
					jQuery(this).parent().find("span").css({
						opacity: .25
					});
					jQuery(this).parent().find(".desc").css("text-decoration", "line-through");
				} else {
					jQuery(this).find("i").removeClass("fa-check-square-o").addClass("fa-square-o");
					jQuery(this).parent().find("span").css({
						opacity: 1
					});
					jQuery(this).parent().find(".desc").css("text-decoration", "none");
				}
				return !1;
			});
		}
	};
	//function to activate the Tooltips, if present
	var runTooltips = function() {
		if(jQuery(".tooltips").length) {
			jQuery('.tooltips').tooltip();
		}
	};
	//function to open quick sidebar
	var runQuickSideBar = function() {
		jQuery(".sb-toggle").on("click", function(e) {
			if(jQuery(this).hasClass("open")) {
				jQuery(this).not(".sidebar-toggler ").find(".fa-indent").removeClass("fa-indent").addClass("fa-outdent");
				jQuery(".sb-toggle").removeClass("open")
				jQuery("#page-sidebar").css({
					right: -jQuery("#page-sidebar").outerWidth()
				});
			} else {
				jQuery(this).not(".sidebar-toggler ").find(".fa-outdent").removeClass("fa-outdent").addClass("fa-indent");
				jQuery(".sb-toggle").addClass("open")
				jQuery("#page-sidebar").css({
					right: 0
				});
			}

			e.preventDefault();
		});
		jQuery("#page-sidebar .media a").on("click", function(e) {
			jQuery(this).closest(".tab-pane").css({
				right: jQuery("#page-sidebar").outerWidth()
			});
			e.preventDefault();
		});
		jQuery("#page-sidebar .sidebar-back").on("click", function(e) {
			jQuery(this).closest(".tab-pane").css({
				right: 0
			});
			e.preventDefault();
		});
		/*jQuery('#page-sidebar .sidebar-wrapper').perfectScrollbar({
			wheelSpeed: 50,
			minScrollbarLength: 20,
			suppressScrollX: true
		});*/
		jQuery('#sidebar-tab a').on('shown.bs.tab', function (e) {
		 
		 /*jQuery("#page-sidebar .sidebar-wrapper").perfectScrollbar('update');*/
		});
	};
	//function to activate the Popovers, if present
	var runPopovers = function() {
		if(jQuery(".popovers").length) {
			jQuery('.popovers').popover();
		}
	};
	//function to allow a button or a link to open a tab
	var runShowTab = function() {
		if(jQuery(".show-tab").length) {
			jQuery('.show-tab').on('click', function(e) {
				e.preventDefault();
				var tabToShow = jQuery(this).attr("href");
				if(jQuery(tabToShow).length) {
					jQuery('a[href="' + tabToShow + '"]').tab('show');
				}
			});
		};
		if(getParameterByName('tabId').length) {
			jQuery('a[href="#' + getParameterByName('tabId') + '"]').tab('show');
		}
	};
	var runPanelScroll = function() {
		if(jQuery(".panel-scroll").length) {
			jQuery('.panel-scroll').perfectScrollbar({
				wheelSpeed: 50,
				minScrollbarLength: 20,
				suppressScrollX: true
			});
		}
	};
	//function to extend the default settings of the Accordion
	var runAccordionFeatures = function() {
		if(jQuery('.accordion').length) {
			jQuery('.accordion .panel-collapse').each(function() {
				if(!jQuery(this).hasClass('in')) {
					jQuery(this).prev('.panel-heading').find('.accordion-toggle').addClass('collapsed');
				}
			});
		}
		jQuery(".accordion").collapse().height('auto');
		var lastClicked;

		jQuery('.accordion .accordion-toggle').on('click', function() {
			currentTab = jQuery(this);
			jQuery('html,body').animate({
				scrollTop: currentTab.offset().top - 100
			}, 1000);
		});
	};
	//function to reduce the size of the Main Menu
	var runNavigationToggler = function() {
		jQuery('.navigation-toggler').on('click', function() {
			if(!jQuery('body').hasClass('navigation-small')) {
				jQuery('body').addClass('navigation-small');
			} else {
				jQuery('body').removeClass('navigation-small');
			};
		});
	};
	//function to activate the panel tools
	var runModuleTools = function() {
		jQuery('.panel-tools .panel-expand').on('click', function(e) {
			jQuery('.panel-tools a').not(this).hide();
			jQuery('body').append('<div class="full-white-backdrop"></div>');
			jQuery('.main-container').removeAttr('style');
			backdrop = jQuery('.full-white-backdrop');
			wbox = jQuery(this).parents('.panel');
			wbox.removeAttr('style');
			if(wbox.hasClass('panel-full-screen')) {
				backdrop.fadeIn(200, function() {
					jQuery('.panel-tools a').show();
					wbox.removeClass('panel-full-screen');
					backdrop.fadeOut(200, function() {
						backdrop.remove();
					});
				});
			} else {
				jQuery('body').append('<div class="full-white-backdrop"></div>');
				backdrop.fadeIn(200, function() {
					jQuery('.main-container').css({
						'max-height': jQuery(window).outerHeight() - jQuery('header').outerHeight() - jQuery('.footer').outerHeight() - 100,
						'overflow': 'hidden'
					});
					backdrop.fadeOut(200);
					backdrop.remove();
					wbox.addClass('panel-full-screen').css({
						'max-height': jQuery(window).height(),
						'overflow': 'auto'
					});
				});
			}
		});
		jQuery('.panel-tools .panel-close').on('click', function(e) {
			jQuery(this).parents(".panel").remove();
			e.preventDefault();
		});
		jQuery('.panel-tools .panel-refresh').on('click', function(e) {
			var el = jQuery(this).parents(".panel");
			el.block({
				overlayCSS: {
					backgroundColor: '#fff'
				},
				message: '<img src="assets/images/loading.gif" /> Just a moment...',
				css: {
					border: 'none',
					color: '#333',
					background: 'none'
				}
			});
			window.setTimeout(function() {
				el.unblock();
			}, 1000);
			e.preventDefault();
		});
		jQuery('.panel-tools .panel-collapse').on('click', function(e) {
			e.preventDefault();
			var el = jQuery(this).parent().closest(".panel").children(".panel-body");
			if(jQuery(this).hasClass("collapses")) {
				jQuery(this).addClass("expand").removeClass("collapses");
				el.slideUp(200);
			} else {
				jQuery(this).addClass("collapses").removeClass("expand");
				el.slideDown(200);
			}
		});
	};
	//function to activate the 3rd and 4th level menus
	var runNavigationMenu = function() {
		jQuery('.main-navigation-menu li.active').addClass('open');
		jQuery('.main-navigation-menu > li a').on('click', function() {
			if(jQuery(this).parent().children('ul').hasClass('sub-menu') && ((!jQuery('body').hasClass('navigation-small') || $windowWidth < 767) || !jQuery(this).parent().parent().hasClass('main-navigation-menu'))) {
				if(!jQuery(this).parent().hasClass('open')) {
					jQuery(this).parent().addClass('open');
					jQuery(this).parent().parent().children('li.open').not(jQuery(this).parent()).not(jQuery('.main-navigation-menu > li.active')).removeClass('open').children('ul').slideUp(200);
					jQuery(this).parent().children('ul').slideDown(200, function() {
						runContainerHeight();
					});
				} else {
					if(!jQuery(this).parent().hasClass('active')) {
						jQuery(this).parent().parent().children('li.open').not(jQuery('.main-navigation-menu > li.active')).removeClass('open').children('ul').slideUp(200, function() {
							runContainerHeight();
						});
					} else {
						jQuery(this).parent().parent().children('li.open').removeClass('open').children('ul').slideUp(200, function() {
							runContainerHeight();
						});
					}
				}
			}
		});
	};
	//function to activate the Go-Top button
	var runGoTop = function() {
		jQuery('.go-top').on('click', function(e) {
			jQuery("html, body").animate({
				scrollTop: 0
			}, "slow");
			e.preventDefault();
		});
	};
	//function to avoid closing the dropdown on click
	var runDropdownEnduring = function() {
		if(jQuery('.dropdown-menu.dropdown-enduring').length) {
			jQuery('.dropdown-menu.dropdown-enduring').click(function(event) {
				event.stopPropagation();
			});
		}
	};
	//function to return the querystring parameter with a given name.
	var getParameterByName = function(name) {
		name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
		return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	};
	//function to activate the iCheck Plugin
	var runCustomCheck = function() {
		if(jQuery('input[type="checkbox"]').length || jQuery('input[type="radio"]').length) {
			jQuery('input[type="checkbox"].grey, input[type="radio"].grey').iCheck({
				checkboxClass: 'icheckbox_minimal-grey',
				radioClass: 'iradio_minimal-grey',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].red, input[type="radio"].red').iCheck({
				checkboxClass: 'icheckbox_minimal-red',
				radioClass: 'iradio_minimal-red',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].green, input[type="radio"].green').iCheck({
				checkboxClass: 'icheckbox_minimal-green',
				radioClass: 'iradio_minimal-green',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].teal, input[type="radio"].teal').iCheck({
				checkboxClass: 'icheckbox_minimal-aero',
				radioClass: 'iradio_minimal-aero',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].orange, input[type="radio"].orange').iCheck({
				checkboxClass: 'icheckbox_minimal-orange',
				radioClass: 'iradio_minimal-orange',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].purple, input[type="radio"].purple').iCheck({
				checkboxClass: 'icheckbox_minimal-purple',
				radioClass: 'iradio_minimal-purple',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].yellow, input[type="radio"].yellow').iCheck({
				checkboxClass: 'icheckbox_minimal-yellow',
				radioClass: 'iradio_minimal-yellow',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].square-black, input[type="radio"].square-black').iCheck({
				checkboxClass: 'icheckbox_square',
				radioClass: 'iradio_square',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].square-grey, input[type="radio"].square-grey').iCheck({
				checkboxClass: 'icheckbox_square-grey',
				radioClass: 'iradio_square-grey',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].square-red, input[type="radio"].square-red').iCheck({
				checkboxClass: 'icheckbox_square-red',
				radioClass: 'iradio_square-red',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].square-green, input[type="radio"].square-green').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].square-teal, input[type="radio"].square-teal').iCheck({
				checkboxClass: 'icheckbox_square-aero',
				radioClass: 'iradio_square-aero',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].square-orange, input[type="radio"].square-orange').iCheck({
				checkboxClass: 'icheckbox_square-orange',
				radioClass: 'iradio_square-orange',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].square-purple, input[type="radio"].square-purple').iCheck({
				checkboxClass: 'icheckbox_square-purple',
				radioClass: 'iradio_square-purple',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].square-yellow, input[type="radio"].square-yellow').iCheck({
				checkboxClass: 'icheckbox_square-yellow',
				radioClass: 'iradio_square-yellow',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].flat-black, input[type="radio"].flat-black').iCheck({
				checkboxClass: 'icheckbox_flat',
				radioClass: 'iradio_flat',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].flat-grey, input[type="radio"].flat-grey').iCheck({
				checkboxClass: 'icheckbox_flat-grey',
				radioClass: 'iradio_flat-grey',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
				checkboxClass: 'icheckbox_flat-red',
				radioClass: 'iradio_flat-red',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].flat-green, input[type="radio"].flat-green').iCheck({
				checkboxClass: 'icheckbox_flat-green',
				radioClass: 'iradio_flat-green',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].flat-teal, input[type="radio"].flat-teal').iCheck({
				checkboxClass: 'icheckbox_flat-aero',
				radioClass: 'iradio_flat-aero',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].flat-orange, input[type="radio"].flat-orange').iCheck({
				checkboxClass: 'icheckbox_flat-orange',
				radioClass: 'iradio_flat-orange',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].flat-purple, input[type="radio"].flat-purple').iCheck({
				checkboxClass: 'icheckbox_flat-purple',
				radioClass: 'iradio_flat-purple',
				increaseArea: '10%' // optional
			});
			jQuery('input[type="checkbox"].flat-yellow, input[type="radio"].flat-yellow').iCheck({
				checkboxClass: 'icheckbox_flat-yellow',
				radioClass: 'iradio_flat-yellow',
				increaseArea: '10%' // optional
			});
		};
	};
	//Search Input function
	var runSearchInput = function() {
		var search_input = jQuery('.sidebar-search input');
		var search_button = jQuery('.sidebar-search button');
		var search_form = jQuery('.sidebar-search');
		search_input.attr('data-default', jQuery(search_input).outerWidth()).focus(function() {
			jQuery(this).animate({
				width: 200
			}, 200);
		}).blur(function() {
			if(jQuery(this).val() == "") {
				if(jQuery(this).hasClass('open')) {
					jQuery(this).animate({
						width: 0,
						opacity: 0
					}, 200, function() {
						jQuery(this).hide();
					});
				} else {
					jQuery(this).animate({
						width: jQuery(this).attr('data-default')
					}, 200);
				}
			}
		});
		search_button.on('click', function() {
			if(jQuery(search_input).is(':hidden')) {
				jQuery(search_input).addClass('open').css({
					width: 0,
					opacity: 0
				}).show().animate({
					width: 200,
					opacity: 1
				}, 200).focus();
			} else if(jQuery(search_input).hasClass('open') && jQuery(search_input).val() == '') {
				jQuery(search_input).removeClass('open').animate({
					width: 0,
					opacity: 0
				}, 200, function() {
					jQuery(this).hide();
				});
			} else if(jQuery(search_input).val() != '') {
				return;
			} else
				jQuery(search_input).focus();
			return false;
		});
	};
	//Set of functions for Style Selector
	var runStyleSelector = function() {
		jQuery('.style-toggle').on('click', function() {
			if(jQuery(this).hasClass('open')) {
				jQuery(this).removeClass('open').addClass('close');
				jQuery('#style_selector_container').hide();
			} else {
				jQuery(this).removeClass('close').addClass('open');
				jQuery('#style_selector_container').show();
			}
		});
		setColorScheme();
		setLayoutStyle();
		setHeaderStyle();
		setFooterStyle();
		setBoxedBackgrounds();
	};
	/*jQuery('.drop-down-wrapper').perfectScrollbar({
		wheelSpeed: 50,
		minScrollbarLength: 20,
		suppressScrollX: true
	});*/
	/*jQuery('.navbar-tools .dropdown').on('shown.bs.dropdown', function() {
		jQuery(this).find('.drop-down-wrapper').scrollTop(0).perfectScrollbar('update');
	});*/
	var setColorScheme = function() {
		jQuery('.icons-color a').on('click', function() {
			jQuery('.icons-color img').each(function() {
				jQuery(this).removeClass('active');
			});
			jQuery(this).find('img').addClass('active');
			if(jQuery('#skin_color').attr("rel") == "stylesheet/less") {
				jQuery('#skin_color').next('style').remove();
				jQuery('#skin_color').attr("rel", "stylesheet");

			}
			jQuery('#skin_color').attr("href", "assets/css/theme_" + jQuery(this).attr('id') + ".css");

		});
	};
	var setBoxedBackgrounds = function() {
		jQuery('.boxed-patterns a').on('click', function() {
			if(jQuery('body').hasClass('layout-boxed')) {
				var classes = jQuery('body').attr("class").split(" ").filter(function(item) {
					return item.indexOf("bg_style_") === -1 ? item : "";
				});
				jQuery('body').attr("class", classes.join(" "));
				jQuery('.boxed-patterns img').each(function() {
					jQuery(this).removeClass('active');
				});
				jQuery(this).find('img').addClass('active');
				jQuery('body').addClass(jQuery(this).attr('id'));
			} else {
				alert('Select boxed layout');
			}
		});
	};
	var setLayoutStyle = function() {
		jQuery('select[name="layout"]').change(function() {
			if(jQuery('select[name="layout"] option:selected').val() == 'boxed')
				jQuery('body').addClass('layout-boxed');
			else
				jQuery('body').removeClass('layout-boxed');
		});
	};
	var setHeaderStyle = function() {
		jQuery('select[name="header"]').change(function() {
			if(jQuery('select[name="header"] option:selected').val() == 'default')
				jQuery('body').addClass('header-default');
			else
				jQuery('body').removeClass('header-default');
		});
	};
	var setFooterStyle = function() {
		jQuery('select[name="footer"]').change(function() {
			if(jQuery('select[name="footer"] option:selected').val() == 'fixed')
				jQuery('body').addClass('footer-fixed');
			else
				jQuery('body').removeClass('footer-fixed');
		});
	};
	var runColorPalette = function() {
		if(jQuery('.colorpalette').length) {
			jQuery('.colorpalette').colorPalette().on('selectColor', function(e) {
				jQuery(this).closest('ul').prev('a').children('i').css('background-color', e.color).end().closest('div').prev('input').val(e.color);
				runActivateLess();
			});
		};
	};

	//function to activate Less style
	var runActivateLess = function() {
		jQuery('		.icons-color img').removeClass('active');
		if(jQuery('#skin_color').attr("rel") == "stylesheet") {
			jQuery('#skin_color').attr("rel", "stylesheet/less").attr("href", "assets/less/styles.less");
			less.sheets.push(jQuery('link#skin_color')[0]);
			less.refresh();
		};
		less.modifyVars({
			'@base': jQuery('.color-base').val(),
			'@text': jQuery('.color-text').val(),
			'@badge': jQuery('.color-badge').val()
		});
	};

	//Window Resize Function
	var runWIndowResize = function(func, threshold, execAsap) {
		//wait until the user is done resizing the window, then execute
		jQuery(window).clipresize(function() {
			runElementsPosition();
		});
	};
	//function to save user settings
	var runSaveSetting = function() {
		jQuery('.save_style').on('click', function() {
			var clipSetting = new Object;
			if(jQuery('body').hasClass('rtl')) {
				clipSetting.rtl = true;
			} else {
				clipSetting.rtl = false;
			};
			if(jQuery('body').hasClass('layout-boxed')) {
				clipSetting.layoutBoxed = true;
				jQuery("body[class]").filter(function() {
					var classNames = this.className.split(/\s+/);
					for(var i = 0; i < classNames.length; ++i) {
						if(classNames[i].substr(0, 9) === "bg_style_") {
							clipSetting.bgStyle = classNames[i];
						}
					}

				});
			} else {
				clipSetting.layoutBoxed = false;
			};
			if(jQuery('body').hasClass('header-default')) {
				clipSetting.headerDefault = true;
			} else {
				clipSetting.headerDefault = false;
			};
			if(jQuery('body').hasClass('footer-fixed')) {
				clipSetting.footerDefault = false;
			} else {
				clipSetting.footerDefault = true;
			};
			if(jQuery('#skin_color').attr('rel') == 'stylesheet') {
				clipSetting.useLess = false;
			} else if(jQuery('#skin_color').attr('rel') == 'stylesheet/less') {
				clipSetting.useLess = true;
				clipSetting.baseColor = jQuery('.color-base').val();
				clipSetting.textColor = jQuery('.color-text').val();
				clipSetting.badgeColor = jQuery('.color-badge').val();
			}
			;
			clipSetting.skinClass = jQuery('#skin_color').attr('href');

			$.cookie("clip-setting", JSON.stringify(clipSetting));

			var el = jQuery('#style_selector_container');
			el.block({
				overlayCSS: {
					backgroundColor: '#fff'
				},
				message: '<img src="assets/images/loading.gif" /> Just a moment...',
				css: {
					border: 'none',
					color: '#333',
					background: 'none'
				}
			});
			window.setTimeout(function() {
				el.unblock();
			}, 1000);
		});
	};
	//function to load user settings
	var runCustomSetting = function() {
		if($.cookie("clip-setting")) {
			var loadSetting = jQuery.parseJSON($.cookie("clip-setting"));
			if(loadSetting.layoutBoxed) {

				jQuery('body').addClass('layout-boxed');
				jQuery('#style_selector select[name="layout"]').find('option[value="boxed"]').attr('selected', 'true');
			};
			if(loadSetting.headerDefault) {
				jQuery('body').addClass('header-default');
				jQuery('#style_selector select[name="header"]').find('option[value="default"]').attr('selected', 'true');
			};
			if(!loadSetting.footerDefault) {
				jQuery('body').addClass('footer-fixed');
				jQuery('#style_selector select[name="footer"]').find('option[value="fixed"]').attr('selected', 'true');
			};
			if(jQuery('#style_selector').length) {
				if(loadSetting.useLess) {

					jQuery('.color-base').val(loadSetting.baseColor).next('.dropdown').find('i').css('background-color', loadSetting.baseColor);
					jQuery('.color-text').val(loadSetting.textColor).next('.dropdown').find('i').css('background-color', loadSetting.textColor);
					jQuery('.color-badge').val(loadSetting.badgeColor).next('.dropdown').find('i').css('background-color', loadSetting.badgeColor);
					runActivateLess();
				} else {
					jQuery('.color-base').val('#FFFFFF').next('.dropdown').find('i').css('background-color', '#FFFFFF');
					jQuery('.color-text').val('#555555').next('.dropdown').find('i').css('background-color', '#555555');
					jQuery('.color-badge').val('#007AFF').next('.dropdown').find('i').css('background-color', '#007AFF');
					jQuery('#skin_color').attr('href', loadSetting.skinClass);
				};
			};
			jQuery('body').addClass(loadSetting.bgStyle);
		} else {
			runDefaultSetting();
		};
	};
	//function to clear user settings
	var runClearSetting = function() {
		jQuery('.clear_style').on('click', function() {
			$.removeCookie("clip-setting");
			jQuery('body').removeClass("layout-boxed header-default footer-fixed");
			jQuery('body')[0].className = jQuery('body')[0].className.replace(/\bbg_style_.*?\b/g, '');
			if(jQuery('#skin_color').attr("rel") == "stylesheet/less") {
				jQuery('#skin_color').next('style').remove();
				jQuery('#skin_color').attr("rel", "stylesheet");

			}

			jQuery('.icons-color img').first().trigger('click');
			runDefaultSetting();
		});
	};
	//function to restore user settings
	var runDefaultSetting = function() {
		jQuery('#style_selector select[name="layout"]').val('default');
		jQuery('#style_selector select[name="header"]').val('fixed');
		jQuery('#style_selector select[name="footer"]').val('default');
		jQuery('		.boxed-patterns img').removeClass('active');
		jQuery('.color-base').val('#FFFFFF').next('.dropdown').find('i').css('background-color', '#FFFFFF');
		jQuery('.color-text').val('#555555').next('.dropdown').find('i').css('background-color', '#555555');
		jQuery('.color-badge').val('#007AFF').next('.dropdown').find('i').css('background-color', '#007AFF');
	};
	return {
		//main function to initiate template pages
		init: function() {
			//runWIndowResize();
			runInit();
			//runStyleSelector();
			runSearchInput();
			runElementsPosition();
			//runToDoAction();
			runNavigationToggler();
			runNavigationMenu();
			runGoTop();
			runModuleTools();
			runDropdownEnduring();
			runTooltips();
			runPopovers();
			//runPanelScroll();
			runShowTab();
			//runAccordionFeatures();
			//runCustomCheck();
			//runColorPalette();
			//runSaveSetting();
			runCustomSetting();
			runClearSetting();
			runQuickSideBar();
		}
	};
}(); 