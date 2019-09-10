function collapsibleSections_UpdateFieldChoicesObject(){GetSelectedField(),collapsibleSections_getField()}function collapsibleSections_getField(){var e=GetSelectedField(),l=jQuery("#field_"+e.id);return l}function collapsibleSections_toggle(e){var l=GetSelectedField(),i=collapsibleSections_getField();void 0===e&&(e="none");var s=i.find('input.collapsible_sections_toggle[value="'+e+'"]'),t=i.find(".gfield_admin_header_title"),o=(t.html(),i.find(".gsection_collapsible"));SetFieldProperty("collapsibleSections_enableCollapsible",e),s.prop("checked",!0);var n=i.find(".collapsible-sections-field-description-setting"),c=i.find(".collapsible-sections-field-end-display-setting");if("none"!==e){if(i.addClass("collapsible-sections-admin-field"),"start"===e?(n.length&&n.slideDown(),c.length&&c.slideUp()):"end"===e&&(n.length&&n.slideUp(),c.length&&c.slideDown()),!o.length){var a="end"===e?"Collapsible End":"Collapsible Start";i.find(".gsection_title").before('<div class="gsection_collapsible gsection_collapsible_'+e+'"><span>'+a+"</span></div>")}l.hasOwnProperty("collapsibleSections_descriptionPlacement")&&""!==l.collapsibleSections_descriptionPlacement&&collapsibleSections_updateDescriptionSetting(l.collapsibleSections_descriptionPlacement),l.hasOwnProperty("collapsibleSections_endSectionDisplay")&&""!==l.collapsibleSections_endSectionDisplay&&collapsibleSections_updateEndSectionDisplaySetting(l.collapsibleSections_endSectionDisplay)}else i.removeClass("collapsible-sections-admin-field"),i.removeClass("collapsible-sections-description-default"),i.removeClass("collapsible-sections-description-inside"),i.removeClass("collapsible-sections-description-title"),o.length&&o.remove(),n.length&&n.slideUp(function(){var e=i.find(".collapsible-sections-description-placement");e.length&&e.val("form_setting").trigger("change")}),c.length&&c.slideUp(function(){var e=i.find(".collapsible-sections-field-end-display");e.length&&e.val("default").trigger("change")})}function collapsibleSections_updateEndSectionDisplaySetting(e){SetFieldProperty("collapsibleSections_endSectionDisplay",e)}function collapsibleSections_updateDescriptionSetting(e){SetFieldProperty("collapsibleSections_descriptionPlacement",e);var l=GetSelectedField(),i=jQuery("#field_"+l.id);i.removeClass("collapsible-sections-description-default"),i.removeClass("collapsible-sections-description-inside"),i.removeClass("collapsible-sections-description-title"),i.addClass("collapsible-sections-description-"+e)}var collapsibleSections_markup=function(){return{collapsibleToggle:function(e,l){var i=void 0!==e?e:"none";i===!0?i="start":i===!1&&(i="none");var s="none"===i?' checked="checked"':"",t="start"===i?' checked="checked"':"",o="end"===i?' checked="checked"':"";return['<li class="collapsible-sections-field-setting collapsible-sections-field-toggle-setting field_setting">','<label class="section_label">Collapsible Sections</label>','<label><input id="collapsible_sections_none_toggle_'+l+'" class="collapsible_sections_toggle" type="radio" '+s+' name="gf_collapsible_sections_toggle" value="none" onchange="collapsibleSections_toggle(this.value);"> '+collapsibleSectionsFieldStrings.toggleNone+"</label>",'<label><input id="collapsible_sections_start_toggle_'+l+'" class="collapsible_sections_toggle" type="radio" '+t+' name="gf_collapsible_sections_toggle" value="start" onchange="collapsibleSections_toggle(this.value);"> '+collapsibleSectionsFieldStrings.toggleStart+"</label>",'<label><input id="collapsible_sections_end_toggle_'+l+'" class="collapsible_sections_toggle" type="radio" '+o+' name="gf_collapsible_sections_toggle" value="end" onchange="collapsibleSections_toggle(this.value);"> '+collapsibleSectionsFieldStrings.toggleEnd+' <a href="#" onclick="return false;" onkeypress="return false;" class="gf_tooltip tooltip " title="'+collapsibleSectionsFieldStrings.toggleEndDescription+'"><i class="fa fa-question-circle"></i></a></label>',"</li>"].join("")},collapsibleEndSectionDisplayToggle:function(e,l){var i=GetSelectedField(),s=i.hasOwnProperty("collapsibleSections_enableCollapsible")&&"end"===i.collapsibleSections_enableCollapsible,t=s?"display:block;":"display:none",o=void 0!==e?e:"default",n="default"===o?' selected="selected"':"",c="hidden"===o?' selected="selected"':"";return['<li class="collapsible-sections-field-setting collapsible-sections-field-end-display-setting field_setting" style="'+t+'">','<label class="gfield_value_label" for="collapsible-sections-field-end-display-'+l+'">'+collapsibleSectionsFieldStrings.endSectionDisplay+"</label>",'<select id="collapsible-sections-field-end-display-'+l+'" class="collapsible-sections-field-end-display" onchange="collapsibleSections_updateEndSectionDisplaySetting(this.value);">','<option value="default"'+n+">"+collapsibleSectionsFieldStrings.endSectionDisplayDefault+"</option>",'<option value="hidden"'+c+">"+collapsibleSectionsFieldStrings.endSectionDisplayHidden+"</option>","</select>","</li>"].join("")},descriptionPlacementSelect:function(e,l){var i=GetSelectedField(),s=i.hasOwnProperty("collapsibleSections_enableCollapsible")&&"start"===i.collapsibleSections_enableCollapsible,t=s?"display:block;":"display:none",o=void 0!==e?e:"form_setting",n="";form.hasOwnProperty("gf-collapsible-sections")&&form["gf-collapsible-sections"].hasOwnProperty("gf_collapsible_sections_description_placement")&&(n=form["gf-collapsible-sections"].gf_collapsible_sections_description_placement);var c="";"inside"==n?c=" ("+collapsibleSectionsFieldStrings.descriptionPlacementInside+")":"title"==n&&(c=" ("+collapsibleSectionsFieldStrings.descriptionPlacementTitle+")");var a="form_setting"===o?' selected="selected"':"",d="inside"===o?' selected="selected"':"",p="title"===o?' selected="selected"':"";return['<li class="collapsible-sections-field-setting collapsible-sections-field-description-setting field_setting" style="'+t+'">','<label class="gfield_value_label" for="collapsible-sections-description-placement-'+l+'">'+collapsibleSectionsFieldStrings.descriptionPlacement+"</label>",'<select id="collapsible-sections-description-placement-'+l+'" class="collapsible-sections-description-placement" onchange="collapsibleSections_updateDescriptionSetting(this.value);">','<option value="form_setting"'+a+">"+collapsibleSectionsFieldStrings.descriptionPlacementForm+c+"</option>",'<option value="inside"'+d+">"+collapsibleSectionsFieldStrings.descriptionPlacementInside+"</option>",'<option value="title"'+p+">"+collapsibleSectionsFieldStrings.descriptionPlacementTitle+"</option>","</select>","</li>"].join("")}}}();jQuery(document).ready(function(e){"undefined"!=typeof form&&form.hasOwnProperty("fields")&&jQuery.each(form.fields,function(e,l){if("section"===l.type&&l.hasOwnProperty("collapsibleSections_enableCollapsible")&&"none"!==l.collapsibleSections_enableCollapsible){var i=l.collapsibleSections_enableCollapsible,s=jQuery("#field_"+l.id);if(s.length){var t=s.find(".gsection_collapsible");if(!t.length){var o="end"===i?"Collapsible End":"Collapsible Start";s.find(".gsection_title").before('<div class="gsection_collapsible gsection_collapsible_'+i+'"><span>'+o+"</span></div>")}}}});var l=jQuery(".gform_panel_form_settings#form_settings");if(l.length){var i=l.find('input[name="gf_collapsible_sections_force_single_opens"]'),s=l.find("#gaddon-setting-row-gf_collapsible_sections_single_open_by_default"),t=l.find("#gaddon-setting-row-gf_collapsible_sections_open_by_default");i.on("change",function(){jQuery(this).is(":checked")?(s.show(),t.hide()):(s.hide(),t.show())}),i.trigger("change");var o=l.find('input[name="gf_collapsible_sections_scroll_to"]'),n=l.find("#gaddon-setting-row-gf_collapsible_sections_scroll_to_offset"),c=l.find("#gaddon-setting-row-gf_collapsible_sections_scroll_to_duration");o.on("change",function(){jQuery(this).is(":checked")?(n.length&&n.show(),c.length&&c.show()):(n.length&&n.hide(),c.length&&c.hide())}),o.trigger("change")}}),jQuery(document).bind("gform_load_field_settings",function(e,l,i){if("section"===l.type)!function(e){setTimeout(function(){var l=jQuery("#field_"+e.id+" #field_settings"),i="undefined"!=typeof e.collapsibleSections_enableCollapsible?e.collapsibleSections_enableCollapsible:"none";if(i===!0?i="start":i===!1&&(i="none"),l.find(".collapsible-sections-field-toggle-setting").length){var s=l.find('input.collapsible_sections_toggle[value="'+i+'"]');s.length&&s.prop("checked",!0),"start"===i?l.find(".collapsible-sections-field-description-setting").show():"end"===i&&l.find(".collapsible-sections-field-end-display-setting").show()}else jQuery(".css_class_setting").after(collapsibleSections_markup.collapsibleToggle(i));l.find(".collapsible-sections-field-toggle-setting").show(),collapsibleSections_toggle(i);var t=void 0!==e.collapsibleSections_endSectionDisplay?e.collapsibleSections_endSectionDisplay:"default";if(l.find(".collapsible-sections-field-end-display").length){var o=l.find(".collapsible-sections-field-end-display");o.val(t),o.find("option[selected]").length&&o.find("option[selected]").removeAttr("selected"),o.find('option[value="'+t+'"]').prop("selected",!0)}else jQuery("#field_"+e.id+" #field_settings .collapsible-sections-field-toggle-setting").after(collapsibleSections_markup.collapsibleEndSectionDisplayToggle(t));collapsibleSections_updateEndSectionDisplaySetting(t);var n=void 0!==e.collapsibleSections_descriptionPlacement?e.collapsibleSections_descriptionPlacement:"form_setting";if(l.find(".collapsible-sections-description-placement").length){var c=l.find(".collapsible-sections-description-placement");c.val(n),c.find("option[selected]").length&&c.find("option[selected]").removeAttr("selected"),c.find('option[value="'+n+'"]').prop("selected",!0)}else jQuery("#field_"+e.id+" #field_settings .collapsible-sections-field-toggle-setting").after(collapsibleSections_markup.descriptionPlacementSelect(n));collapsibleSections_updateDescriptionSetting(n),"function"==typeof gform_initialize_tooltips&&gform_initialize_tooltips()},10)}(l);else{var s=jQuery("#field_"+l.id+" #field_settings");s.find(".collapsible-sections-field-setting").length&&(s.find(".collapsible-sections-field-setting").remove(),collapsibleSections_toggle("none"))}}),jQuery(document).ready(function(){var e,l=jQuery("#gf_collapsible_sections_custom_css_global");l.length&&(l.after('<div id="gf_collapsible_sections_custom_css_global_editor">'+l.text()+"</div>"),e=ace.edit("gf_collapsible_sections_custom_css_global_editor"),e.setOptions({showInvisibles:!1,showGutter:!0,showLineNumbers:!0,displayIndentGuides:!1,scrollPastEnd:!1,theme:"ace/theme/xcode"}),e.session.setMode("ace/mode/css"),e.getSession().on("change",function(){l.val(e.getSession().getValue())}));var i=jQuery("#gf_collapsible_sections_custom_css");i.length&&(i.after('<div id="gf_collapsible_sections_custom_css_editor">'+i.text()+"</div>"),e=ace.edit("gf_collapsible_sections_custom_css_editor"),e.setOptions({showInvisibles:!1,showGutter:!0,showLineNumbers:!0,showFoldWidgets:!1,displayIndentGuides:!1,scrollPastEnd:!1,theme:"ace/theme/xcode"}),e.session.setMode("ace/mode/css"),e.getSession().on("change",function(){i.val(e.getSession().getValue())}))});