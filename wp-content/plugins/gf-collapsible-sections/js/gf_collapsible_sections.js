function collapsibleSections_loadCustomCss(e){var l=jQuery("head"),s=jQuery("body"),i=s.find("#gf_collapsible_sections_css-css").length?s:l;"undefined"==typeof window.gf_collapsible_sections_custom_css_global||jQuery("#gf_collapsible_sections_global_custom_css").length||i.append('<style id="gf_collapsible_sections_global_custom_css">'+window.gf_collapsible_sections_custom_css_global+"</style>");var o="gf_collapsible_sections_custom_css_"+e;window.hasOwnProperty(o)&&!jQuery("#"+o).length&&i.append('<style id="'+o+'">'+window[o]+"</style>")}function collapsibleSections_fieldFocus(e){var l=jQuery(e.target);l.on("keydown",collapsibleSections_fieldKeyPress)}function collapsibleSections_fieldBlur(e){var l=jQuery(e.target);l.off("keydown",collapsibleSections_fieldKeyPress)}function collapsibleSections_openAndFocusInput(e,l){if(e.hasClass("collapsible-sections-field")){"previous"!==l&&(l="next"),e.hasClass("collapsible-sections-open")?"function"==typeof window.collapsibleSections_Scrollto&&window.collapsibleSections_Scrollto(e):e.trigger("click");var s="previous"===l?":last-of-type":":first",i=e.next(".collapsible-sections-collapsible-body").find(".gfield"+s+" .ginput_container");i.find("> input").length?i.find("> input:first").focus():i.find("> textarea").length?i.find("> textarea:first").focus():i.find("> select").length?i.find("> select:first").focus():i.hasClass("ginput_complex")?i.find("> span"+s+" > input:first").focus():(i.hasClass("ginput_container_checkbox")||i.hasClass("ginput_container_radio"))&&i.find("> ul > li"+s+" > input:first").focus()}}function collapsibleSections_fieldKeyPress(e){var l=9,s=jQuery(e.target);if(e.keyCode===l){var i,o,t,n,c=e.shiftKey?"previous":"next",a=s.closest(".ginput_container"),p=s.closest(".gfield");a.hasClass("ginput_complex")?(i=p.closest(".collapsible-sections-collapsible-body"),o=s.closest("span"),i.length&&"previous"===c&&o.is(":first-child")&&p.is(":first-child")?(t=i.prev(".gfield").prev(".collapsible-sections-collapsible-body"),n=t.length?t.prev(".gfield"):i.prev(".gfield").prev(".gfield"),n.length&&n.hasClass("collapsible-sections-field")&&(e.preventDefault(),collapsibleSections_openAndFocusInput(n,c))):i.length&&"next"===c&&o.is(":last-of-type")&&p.is(":last-child")&&i.next(".gfield").length&&i.next(".gfield").hasClass("collapsible-sections-field")&&(e.preventDefault(),collapsibleSections_openAndFocusInput(i.next(".gfield"),c))):p.hasClass("image-choices-field")?"next"===c&&p.is(":last-child")?(i=p.closest(".collapsible-sections-collapsible-body"),i.length&&i.next(".gfield").length&&i.next(".gfield").hasClass("collapsible-sections-field")&&(e.preventDefault(),collapsibleSections_openAndFocusInput(i.next(".gfield"),c))):"previous"===c&&p.is(":first-child")&&(i=p.closest(".collapsible-sections-collapsible-body"),i.length&&(t=i.prev(".gfield").prev(".collapsible-sections-collapsible-body"),n=t.length?t.prev(".gfield"):i.prev(".gfield").prev(".gfield"),n.length&&n.hasClass("collapsible-sections-field")&&(e.preventDefault(),collapsibleSections_openAndFocusInput(n,c)))):"previous"===c&&p.is(":first-child")?(i=p.closest(".collapsible-sections-collapsible-body"),i.length&&(t=i.prev(".gfield").prev(".collapsible-sections-collapsible-body"),n=t.length?t.prev(".gfield"):i.prev(".gfield").prev(".gfield"),n.length&&n.hasClass("collapsible-sections-field")&&(e.preventDefault(),collapsibleSections_openAndFocusInput(n,c)))):"next"===c&&p.is(":last-child")&&(i=p.closest(".collapsible-sections-collapsible-body"),i.length&&i.next(".gfield").length&&i.next(".gfield").hasClass("collapsible-sections-field")&&(e.preventDefault(),collapsibleSections_openAndFocusInput(i.next(".gfield"),c)))}}function collapsibleSections_Scrollto(e){if(collapsibleSections_ignoreScroll===!0)return!1;var l=jQuery(e),s=l.closest(".gform_wrapper"),i=s.attr("id").replace("gform_wrapper_","");if(l.length){var o=window.hasOwnProperty("gf_collapsible_sections_scroll_to_offset_"+i)?window["gf_collapsible_sections_scroll_to_offset_"+i]:0,t=window.hasOwnProperty("gf_collapsible_sections_scroll_to_duration_"+i)?window["gf_collapsible_sections_scroll_to_duration_"+i]:400,n=l.offset().top,c=n-o;jQuery("html,body").animate({scrollTop:c},t)}}function collapsibleSections_SetUp(e,l){var s=jQuery("#gform_wrapper_"+e),i=s.find(".collapsible-sections-field");if(i.length){if(i.each(function(l,s){var i=jQuery(this),o="collapsible-section_"+e+"_"+l;i.data("target","#"+o);var t=i.nextUntil(".collapsible-sections-field"),n=i.nextUntil(".collapsible-sections-end-field"),c=n.length<t.length?n:t;c.detach();var a=jQuery('<div class="collapsible-sections-collapsible-body" id="'+o+'" />');if(i.hasClass("collapsible-sections-open")||a.hide(),i.hasClass("collapsible-sections-description-inside")){var p=i.find(".gsection_description");p.length&&p.detach().appendTo(a)}a.append(c),a.insertAfter(i)}),s.hasClass("collapsible-sections-footer-inside_last_wrapper")){var o=s.find(".collapsible-sections-collapsible-body:last");s.find(".gform_footer").detach().appendTo(o)}var t=s.find(".gfield_error");if(t.length){collapsibleSections_ignoreScroll=!0;var n=window.hasOwnProperty("gf_collapsible_sections_scroll_to_duration_"+e)?window["gf_collapsible_sections_scroll_to_duration_"+e]:400;n+=100,setTimeout(function(){collapsibleSections_ignoreScroll=!1},n),t.each(function(){var e=jQuery(this).closest(".collapsible-sections-collapsible-body");e.prev(".collapsible-sections-field").addClass("collapsible-sections-section-error")});var c=s.find(".collapsible-sections-section-error"),a=s.find(".collapsible-sections-open");s.hasClass("collapsible-sections-single-opens_wrapper")&&c.length?(a.length&&!a.first().hasClass("collapsible-sections-section-error")&&a.first().trigger("click"),c.first().trigger("click")):!s.hasClass("collapsible-sections-single-opens_wrapper")&&c.length&&(a.each(function(){var e=jQuery(this);e.hasClass("collapsible-sections-section-error")||e.trigger("click")}),c.each(function(){jQuery(this).trigger("click")}))}s.find("input").on("focus",collapsibleSections_fieldFocus),s.find("input").on("blur",collapsibleSections_fieldBlur)}}var collapsibleSections_classes={open:"collapsible-sections-open"},collapsibleSections_ignoreScroll=!1;jQuery(document).bind("gform_post_render",function(e,l,s){collapsibleSections_SetUp(l,s),setTimeout(function(){collapsibleSections_loadCustomCss(l)},100)}),jQuery(document).ready(function(){jQuery("body").on("click",".collapsible-sections-field",function(e){e.preventDefault();var l=jQuery(this),s=l.data("target"),i=jQuery(s);if(i.length)if(i.is(":visible"))i.slideUp("fast",function(){l.removeClass("collapsible-sections-open")});else{var o=i.closest(".gform_wrapper");o.length&&o.hasClass("collapsible-sections-single-opens_wrapper")&&o.find(".collapsible-sections-field:visible").not(i).each(function(){var e=jQuery(this),l=e.data("target"),s=jQuery(l);s.length&&s.slideUp("fast",function(){e.removeClass("collapsible-sections-open")})}),l.addClass("collapsible-sections-open"),i.slideDown("fast",function(){o.hasClass("collapsible-sections-scrollto_wrapper")&&collapsibleSections_Scrollto(l)})}})});