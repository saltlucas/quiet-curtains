jQuery(document).ready( function($) {
	
	$("#wpgf2pdcrm_test_connection_button_id").click(function(){
		
		$("#wpgf2pdcrm_test_connection_ajax_loader_id").css( "display", "inline-block" );
		var data = {
			action: 'wpgf2pdcrm_test_connection'
		};
		$.post( ajaxurl, data, function( response ){
			$("#wpgf2pdcrm_test_connection_ajax_loader_id").css( "display", "none" );
			if( response.indexOf('ERROR') != -1 ){
				alert(response);
			}else{
				alert('A deal has been created into your Pipe Drive CRM');
			}
		});
	});
	
	$("#wpgf2pdcrm_refresh_pipedrive_data_cache_button_id").click(function(){
		
		$("#wpgf2pdcrm_refresh_pipedrive_data_cache_ajax_loader_id").css( "display", "inline-block" );
		var data = {
			action: 'wpgf2pdcrm_refresh_pipedrive_data_cache'
		};
		$.post( ajaxurl, data, function( response ){
			$("#wpgf2pdcrm_refresh_pipedrive_data_cache_ajax_loader_id").css( "display", "none" );
			if( response.indexOf('ERROR') != -1 ){
				alert(response);
			}else{
				alert('Now you have the latest data (Pipeline, Stage, Fields) from your Pipedrive account. Enjoy!');
			}
		});
	});
	

	$(".wpgf2pdcrm-remote-feilds-selector").live("change", function(){
		var remote_fields_type = Array();
		var remote_fields_description = Array();
		remote_fields_type['title'] = Array('string');
		remote_fields_description['title'] = Array('Mandatory field.');

		remote_fields_type['value'] = Array('string');
		remote_fields_description['value'] = Array('If omitted, value will be set to 0.');
		
		remote_fields_type['currency'] = Array('string');
		remote_fields_description['currency'] = Array('Accepts a 3-character currency code. If omitted, currency will be set to the default currency of the authorized user.');
		
		remote_fields_type['user_id'] = Array('number');
		remote_fields_description['user_id'] = Array('ID of the user who will be marked as the owner of this deal. If omitted, the authorized user ID will be used.');
		
		remote_fields_type['person_id'] = Array('number');
		remote_fields_description['person_id'] = Array('ID of the person this deal will be associated with.');
		
		remote_fields_type['stage_id'] = Array('number');
		remote_fields_description['stage_id'] = Array('ID of the stage this deal will be placed in a pipeline (note that you can\'t supply the ID of the pipeline as this will be assigned automatically based on stage_id). If omitted, the deal will be placed in the first stage of the default pipeline.');
		
		remote_fields_type['status'] = Array('string');
		remote_fields_description['status'] = Array('open = Open, won = Won, lost = Lost, deleted = Deleted. If omitted, status will be set to open.');
		
		remote_fields_type['visible_to'] = Array('number');
		remote_fields_description['visible_to'] = Array('If omitted, visibility will be set to the default visibility setting of this item type for the authorized user. <br />0 = Entire team (public), 1 = Owner only (private)');
		
		remote_fields_type['add_time'] = Array('string');
		remote_fields_description['add_time'] = Array('Optional creation date & time of the deal in Universal Time Code (UTC). Requires admin user API token. <br />Format: YYYY-MM-DD HH:MM:SS.');
		
		remote_fields_type['lost_reason'] = Array('string');
		remote_fields_description['lost_reason'] = Array('Optional message about why the deal was lost (to be used when status=lost).');
		
		remote_fields_type['new_org'] = Array('string');
		remote_fields_description['new_org'] = Array('');
		
		remote_fields_type['org_id'] = Array('number');
		remote_fields_description['org_id'] = Array('The ID of an existing organisation in pipedrive');
		
		remote_fields_type['name'] = Array('string');
		remote_fields_description['name'] = Array('Create a new person in pipedrive with this field as their name.');
		
		remote_fields_type['email'] = Array('string');
		remote_fields_description['email'] = Array('The email address for a new person record.');
		
		remote_fields_type['phone'] = Array('string');
		remote_fields_description['phone'] = Array('The phone number for a new person record.');
		
		remote_fields_type['content'] = Array('string');
		remote_fields_description['content'] = Array('');
		
		remote_fields_type['file'] = Array('file');
		remote_fields_description['file'] = Array('Allow a visitor to upload a file and associate it with a Deal.');
		
		remote_fields_type['street'] = Array('string');
		remote_fields_description['street'] = Array('Up to 255 characters');
		
		remote_fields_type['addressline2'] = Array('string');
		remote_fields_description['addressline2'] = Array('Up to 255 characters');
		
		remote_fields_type['city'] = Array('string');
		remote_fields_description['city'] = Array('Up to 255 characters');
		
		remote_fields_type['state'] = Array('string');
		remote_fields_description['state'] = Array('Up to 255 characters');
		
		remote_fields_type['postcode'] = Array('string');
		remote_fields_description['postcode'] = Array('Up to 255 characters');
		
		remote_fields_type['country'] = Array('string');
		remote_fields_description['country'] = Array('Up to 255 characters');
		
		var field_value = $(this).val();
		var field_id = $(this).attr("rel");
		if( !field_id ){
			return false;
		}

		var type_td_id = 'wpgf2pdcrm_field_type_td_' + field_id + '_id';
		var description_td_id = 'wpgf2pdcrm_field_description_td_' + field_id + '_id';

		$("#" + type_td_id).html("");
		$("#" + description_td_id).html("");
		
		if( !field_value ){
			return false;
		}
		
		var type_of_the_field = '';
		var description_of_the_field = '';
		if( $("#deal_cf_type_" + field_value).length > 0 ){
			type_of_the_field = $("#deal_cf_type_" + field_value).val();
		}else{
			type_of_the_field = remote_fields_type[field_value];
		}
		if( $("#deal_cf_desc_" + field_value).length > 0 ){
			description_of_the_field = $("#deal_cf_desc_" + field_value).val();
		}else{
			description_of_the_field = remote_fields_description[field_value];
		}
		
		$("#" + type_td_id).html( type_of_the_field );
		$("#" + description_td_id).html( description_of_the_field );
	});
	
	//for dela title multiple fields
	
	$(".wpgf2pdcrm-deal-title-selector").change(function(){
	
		var deal_title_selector_val = $(this).val();
		var deal_title_selector_text = $(this).children(":selected").text()
		var deal_title_selector_id = $(this).attr("id");
		var deal_title_hidden_text_id = 'wpgf2pdcrm_deal_title_val_' + deal_title_selector_id;
		
		if( deal_title_selector_val == "" ){
			return false;
		}
		
		var deal_title_hidden_val = $("#" + deal_title_hidden_text_id).val();
		var deal_title_hidden_val_array = new Array();
		if( deal_title_hidden_val != "" ){
			deal_title_hidden_val_array = deal_title_hidden_val.split( ',' );
		}
		//check if the selected val exist or not
		if( deal_title_hidden_val_array.length > 0 ){
			for( i = 0; i < deal_title_hidden_val_array.length; i++ ){
				if( deal_title_hidden_val_array[i] == deal_title_selector_val ){
					return false;
				}
			}
		}
		deal_title_hidden_val_array.push( deal_title_selector_val );
		deal_title_hidden_val_appended = deal_title_hidden_val_array.join();

		$("#" + deal_title_hidden_text_id).val( deal_title_hidden_val_appended );
		
		var value_span = '<span style="display:inline-block; margin-right:10px;"><a style="cursor: pointer;" class="wpgf2pd-deal-title-values-list-del-icon" rel="' + deal_title_selector_val + '" relselectorid="' + deal_title_selector_id + '" style="margin-left:0;">X</a>&nbsp;' + deal_title_selector_text + '</span>';
		$(".wpgf2pd-deal-title-values-list-container").append( value_span );
	});
	
	$(".wpgf2pd-deal-title-values-list-del-icon").live("click", function(){
		if( $(this).hasClass( "deal-title-del-disabled" ) ){
			return false;
		}
		var deal_title_val_to_remove = $(this).attr("rel");
		var deal_title_selector_id = $(this).attr("relselectorid");
		var deal_title_del_icon = $(this);
		
		if( deal_title_val_to_remove == "" ){
			$(this).parent().remove();
		}
		
		if( deal_title_val_to_remove.indexOf( 'custom_text_' ) != -1 ){
			$(".wpgf2pd-deal-title-values-list-del-icon").addClass( "deal-title-del-disabled" );
			$(this).parent().css( 'color', '#CCC' );
			
			var data = {
				action: 'wpgf2pdcrm_deal_title_delete_custom_text',
				key: deal_title_val_to_remove
			};
			
			$.post( ajaxurl, data, function( response ){
				
				if( response.indexOf('ERROR') != -1 ){
					alert( response );
				}else{
					var deal_title_hidden_text_id = 'wpgf2pdcrm_deal_title_val_' + deal_title_selector_id;
					var deal_title_hidden_val = $("#" + deal_title_hidden_text_id).val();
					deal_title_hidden_val_array = deal_title_hidden_val.split( ',' );
					for( i = 0; i < deal_title_hidden_val_array.length; i++ ){
						if( deal_title_hidden_val_array[i] == deal_title_val_to_remove ){
							deal_title_hidden_val_array.splice( i, 1 );
						}
					}
					deal_title_hidden_val_appended = deal_title_hidden_val_array.join();
			
					$("#" + deal_title_hidden_text_id).val( deal_title_hidden_val_appended );
					deal_title_del_icon.parent().remove();
				}
				
				$(".wpgf2pd-deal-title-values-list-del-icon").removeClass( "deal-title-del-disabled" );
			});
		}else{
			var deal_title_hidden_text_id = 'wpgf2pdcrm_deal_title_val_' + deal_title_selector_id;
			var deal_title_hidden_val = $("#" + deal_title_hidden_text_id).val();
			deal_title_hidden_val_array = deal_title_hidden_val.split( ',' );
			for( i = 0; i < deal_title_hidden_val_array.length; i++ ){
				if( deal_title_hidden_val_array[i] == deal_title_val_to_remove ){
					deal_title_hidden_val_array.splice( i, 1 );
				}
			}
			deal_title_hidden_val_appended = deal_title_hidden_val_array.join();
	
			$("#" + deal_title_hidden_text_id).val( deal_title_hidden_val_appended );
			$(this).parent().remove();
		}
	});
	
	if( $(".wpgf2pd-deal-title-values-add-custom-text-input").length > 0 ){
		var deal_title_selector_id = $(".wpgf2pd-deal-title-values-add-custom-text-input").attr( "rel" );
		$(".wpgf2pd-deal-title-values-add-custom-text-input").css( "width", $("#" + deal_title_selector_id).width() );
	}
	
	$(".wpgf2pd-deal-title-values-add-custom-text-button").click(function(){
		var deal_title_selector_id = $(this).attr( "rel" );
		var custom_text = $("#wpgf2pdcrm_deal_title_custom_text_" + deal_title_selector_id).val();
		if( $.trim( custom_text ) == "" ){
			return false;
		}
		var ajax_loader_id = 'wpgf2pdcrm_deal_title_add_custom_text_ajax_loader_id_' + deal_title_selector_id;
		
		var data = {
			action: 'wpgf2pdcrm_deal_title_add_custom_text',
			text: custom_text
		};
		
		$("#" + ajax_loader_id).css( "display", "inline-block" );
		$.post( ajaxurl, data, function( response ){
			
			$("#" + ajax_loader_id).css( "display", "none" );
			
			if( response.indexOf('ERROR') != -1 ){
				alert( response );
			}else{
				//
				var deal_title_hidden_text_id = 'wpgf2pdcrm_deal_title_val_' + deal_title_selector_id;

				var deal_title_hidden_val = $("#" + deal_title_hidden_text_id).val();
				var deal_title_hidden_val_array = new Array();
				if( deal_title_hidden_val != "" ){
					deal_title_hidden_val_array = deal_title_hidden_val.split( ',' );
				}
				
				deal_title_hidden_val_array.push( response );
				deal_title_hidden_val_appended = deal_title_hidden_val_array.join();
		
				$("#" + deal_title_hidden_text_id).val( deal_title_hidden_val_appended );
				
				var value_span = '<span><a class="ntdelbutton wpgf2pd-deal-title-values-list-del-icon" rel="' + response + '" relselectorid="' + deal_title_selector_id + '">X</a>&nbsp;' + custom_text + '</span>';
				$(".wpgf2pd-deal-title-values-list-container").append( value_span );
				
				$("#wpgf2pdcrm_deal_title_custom_text_" + deal_title_selector_id).val( "" );
			}
		});
	});
	
	//for notes multiple fields
	$(".wpgf2pdcrm-deal-notes-selector").change(function(){
		var deal_notes_selector_val = $(this).val();
		var deal_notes_selector_text = $(this).children(":selected").text()
		var deal_notes_selector_id = $(this).attr("id");
		var deal_notes_hidden_text_id = 'wpgf2pdcrm_deal_notes_val_' + deal_notes_selector_id;
		
		if( deal_notes_selector_val == "" ){
			alert( 'bbbb' );
			return false;
		}
		
		var deal_notes_hidden_val = $("#" + deal_notes_hidden_text_id).val();
		var deal_notes_hidden_val_array = new Array();
		if( deal_notes_hidden_val != "" ){
			deal_notes_hidden_val_array = deal_notes_hidden_val.split( ',' );
		}
		//check if the selected val exist or not
		if( deal_notes_hidden_val_array.length > 0 ){
			for( i = 0; i < deal_notes_hidden_val_array.length; i++ ){
				if( deal_notes_hidden_val_array[i] == deal_notes_selector_val ){
					alert( 'cccc' );
					return false;
				}
			}
		}
		deal_notes_hidden_val_array.push( deal_notes_selector_val );
		deal_notes_hidden_val_appended = deal_notes_hidden_val_array.join();

		$("#" + deal_notes_hidden_text_id).val( deal_notes_hidden_val_appended );
		
		var value_span = '<span><a class="ntdelbutton wpgf2pd-deal-notes-values-list-del-icon" rel="' + deal_notes_selector_val + '" relselectorid="' + deal_notes_selector_id + '">X</a>&nbsp;' + deal_notes_selector_text + '</span>';
		$(".wpgf2pd-deal-notes-values-list-container").append( value_span );
	});
	
	$(".wpgf2pd-deal-notes-values-list-del-icon").live("click", function(){
		if( $(this).hasClass( "deal-notes-del-disabled" ) ){
			return false;
		}
		var deal_notes_val_to_remove = $(this).attr("rel");
		var deal_notes_selector_id = $(this).attr("relselectorid");
		var deal_notes_del_icon = $(this);
		
		if( deal_notes_val_to_remove == "" ){
			$(this).parent().remove();
		}
		
		var deal_notes_hidden_text_id = 'wpgf2pdcrm_deal_notes_val_' + deal_notes_selector_id;
		var deal_notes_hidden_val = $("#" + deal_notes_hidden_text_id).val();
		deal_notes_hidden_val_array = deal_notes_hidden_val.split( ',' );
		for( i = 0; i < deal_notes_hidden_val_array.length; i++ ){
			if( deal_notes_hidden_val_array[i] == deal_notes_val_to_remove ){
				deal_notes_hidden_val_array.splice( i, 1 );
			}
		}
		deal_notes_hidden_val_appended = deal_notes_hidden_val_array.join();

		$("#" + deal_notes_hidden_text_id).val( deal_notes_hidden_val_appended );
		$(this).parent().remove();
	});
	
	// for person to associate
	$(".wpgf2pd-deal-person-select-form-field").change(function(){
		var rel_data = $(this).attr( "rel" );
		var selected_form_field_id = $(this).val();
        
        //enable create new person fields
        $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-create-person-fields").find("select").removeAttr( "disabled" );
		if( selected_form_field_id != "" ){
			$("#wpgf2pd_deal_person_select_exist_person_id_" + rel_data ).val( "" );
            $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-create-person-fields").find("select").attr( "disabled", true );
		}
		$("#wpgf2pdcrm_deal_person_val_" + rel_data ).val( selected_form_field_id + '#' + 'GF' );
	});
	
	$(".wpgf2pd-deal-person-select-exist-person").change(function(){
		var rel_data = $(this).attr( "rel" );
		var selected_pipedrive_person_id = $(this).val();
        
        //enable create new person fields
        $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-create-person-fields").find("select").removeAttr( "disabled" );
		if( selected_pipedrive_person_id != "" ){
			$("#wpgf2pd_deal_person_select_form_field_id_" + rel_data ).val( "" );
            $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-create-person-fields").find("select").attr( "disabled", true );
		}
		$("#wpgf2pdcrm_deal_person_val_" + rel_data ).val( selected_pipedrive_person_id + '#' + 'PD' );
		
		if( selected_pipedrive_person_id.indexOf( '-' ) != -1 ){
			var person_id_array = selected_pipedrive_person_id.split( '-' );
			var org_id = '';
			if( person_id_array.length > 1 ){
				org_id = person_id_array[1];
			}
			if( org_id ){
				$(".wpgf2pd-deal-org-select-form-field" ).val( "" );
				$(".wpgf2pd-deal-org-select-exist-org" ).val( org_id );
				$(".wpgf2pd-deal-org-select-exist-org" ).each(function(index, element) {
                    var rel_data = $(this).attr( "rel" );
					$("#wpgf2pdcrm_deal_org_val_" + rel_data ).val( org_id + '#' + 'PD' );
                });
			}
		}
	});
    
    $("#pipedrive_map_name").change(function(){
        var selected_field_id_to_create_person = $(this).val();
        //enable associate person fields
        $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-assoicate-exist-person").find("select").removeAttr( "disabled" );
        if( selected_field_id_to_create_person != "" ){
            $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-assoicate-exist-person").find("select").attr( "disabled", true );
            $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-assoicate-exist-person").find("select").val( "" );
            $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-assoicate-exist-person").find("input").val( "" );
        }
    });
    
    if( $("#gform-settings").find("#pipedrive_map_name").val() ){
        $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-assoicate-exist-person").find("select").attr( "disabled", true );
        $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-assoicate-exist-person").find("select").val( "" );
        $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-assoicate-exist-person").find("input").val( "" );
    }else if( $("#gform-settings").find(".deal-assoicate-exist-person").find("input").val() ){
        $("#gform-settings").find(".deal-create-person-fields").find("select").attr( "disabled", true );
        $("#gform-settings").find(".deal-create-person-fields").find("select").val( "" );
    }
	
	/*
      * for organisation to associate
      */
	$(".wpgf2pd-deal-org-select-form-field").change(function(){
		var rel_data = $(this).attr( "rel" );
		var selected_form_field_id = $(this).val();
        
        //enable create new organisaton fields
        $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-create-organisations-fields").find("select").removeAttr( "disabled" );
		if( selected_form_field_id != "" ){
			$("#wpgf2pd_deal_org_select_exist_org_id_" + rel_data ).val( "" );
            $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-create-organisations-fields").find("select").attr( "disabled", true );
            $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-create-organisations-fields").find("select").val( "" );
		}
		$("#wpgf2pdcrm_deal_org_val_" + rel_data ).val( selected_form_field_id + '#' + 'GF' );
	});
	
	$(".wpgf2pd-deal-org-select-exist-org").change(function(){
		var rel_data = $(this).attr( "rel" );
		var selected_pipedrive_org_id = $(this).val();
        //enable create new organisaton fields
        $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-create-organisations-fields").find("select").removeAttr( "disabled" );
		if( selected_pipedrive_org_id != "" ){
			$("#wpgf2pd_deal_org_select_form_field_id_" + rel_data ).val( "" );
            $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-create-organisations-fields").find("select").attr( "disabled", true );
            $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-create-organisations-fields").find("select").val( "" );
		}
		$("#wpgf2pdcrm_deal_org_val_" + rel_data ).val( selected_pipedrive_org_id + '#' + 'PD' );
	});
    
    $("#pipedrive_map_new_org").change(function(){
        var selected_field_id_to_create_org = $(this).val();
        //enable associate organisaton fields
        $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-assoicate-exist-organisations").find("select").removeAttr( "disabled" );
        if( selected_field_id_to_create_org != "" ){
            $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-assoicate-exist-organisations").find("select").attr( "disabled", true );
            $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-assoicate-exist-organisations").find("select").val( "" );
            $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-assoicate-exist-organisations").find("input").val( "" );
        }
    });
    
    if( $("#gform-settings").find("#pipedrive_map_new_org").val() ){
        $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-assoicate-exist-organisations").find("select").attr( "disabled", true );
        $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-assoicate-exist-organisations").find("select").val( "" );
        $(this).parents('.wpgf2pdcrm-settings-filed-map').find(".deal-assoicate-exist-organisations").find("input").val( "" );
    }else if( $("#gform-settings").find(".deal-assoicate-exist-organisations").find("input").val() ){
        $("#gform-settings").find(".deal-create-organisations-fields").find("select").attr( "disabled", true );
        $("#gform-settings").find(".deal-create-organisations-fields").find("select").val( "" );
    }
	
	/*
      *for activity type
      */
	$(".wpgf2pd-activity-type-select-form-field").change(function(){
		var rel_data = $(this).attr( "rel" );
		var selected_form_field_id = $(this).val();
		if( selected_form_field_id != "" ){
			$("#wpgf2pd_activity_type_select_exist_type_id_" + rel_data ).val( "" );
		}
		$("#wpgf2pdcrm_activity_type_val_" + rel_data ).val( selected_form_field_id + '#' + 'GF' );
	});
	
	$(".wpgf2pd-activity-type-select-exist-type").change(function(){
		var rel_data = $(this).attr( "rel" );
		var selected_pipedrive_activity_type_id = $(this).val();
		if( selected_pipedrive_activity_type_id != "" ){
			$("#wpgf2pd_activity_type_select_form_field_id_" + rel_data ).val( "" );
		}
		$("#wpgf2pdcrm_activity_type_val_" + rel_data ).val( selected_pipedrive_activity_type_id + '#' + 'PD' );
	});
    
    /* 
      * for product to attact
      */
	$(".wpgf2pd-deal-product-select-form-field").change(function(){
		var rel_data = $(this).attr( "rel" );
		var selected_form_field_id = $(this).val();
		if( selected_form_field_id != "" ){
			$("#wpgf2pd_deal_product_select_exist_product_id_" + rel_data ).val( "" );
		}
		$("#wpgf2pdcrm_deal_product_val_" + rel_data ).val( selected_form_field_id + '#' + 'GF' );
	});
	
	$(".wpgf2pd-deal-product-select-exist-product").change(function(){
		var rel_data = $(this).attr( "rel" );
		var selected_pipedrive_product_id = $(this).val();
		if( selected_pipedrive_product_id != "" ){
			$("#wpgf2pd_deal_product_select_form_field_id_" + rel_data ).val( "" );
		}
		$("#wpgf2pdcrm_deal_product_val_" + rel_data ).val( selected_pipedrive_product_id + '#' + 'PD' );
	});
});

