<?php

//------------------------------------------

GFForms::include_addon_framework();

class GFImageChoices extends GFAddOn {

	protected $_version = GFIC_VERSION;
	protected $_min_gravityforms_version = '2.0';

	protected $_slug = GFIC_SLUG;
	protected $_path = 'gf-image-choices/gf-image-choices.php';
	protected $_full_path = __FILE__;
	protected $_title = GFIC_NAME;
	protected $_short_title = 'Image Choices';
	protected $_url = 'https://jetsloth.com/gravity-forms-image-choices/';

	/**
	 * Members plugin integration
	 */
	protected $_capabilities = array( 'gravityforms_edit_forms', 'gravityforms_edit_settings' );

	/**
	 * Permissions
	 */
	protected $_capabilities_settings_page = 'gravityforms_edit_settings';
	protected $_capabilities_form_settings = 'gravityforms_edit_forms';
	protected $_capabilities_uninstall = 'gravityforms_uninstall';

	private static $_instance = null;

	/**
	 * Get an instance of this class.
	 *
	 * @return GFImageChoices
	 */
	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new GFImageChoices();
		}

		return self::$_instance;
	}

	private function __clone() {
	} /* do nothing */

	/**
	 * Handles anything which requires early initialization.
	 */
	public function pre_init() {
		parent::pre_init();
	}

	/**
	 * Handles hooks and loading of language files.
	 */
	public function init() {

		// add a special class to relevant fields so we can identify them later
		add_action( 'gform_field_css_class', array( $this, 'add_custom_class' ), 10, 3 );
		add_filter( 'gform_field_choice_markup_pre_render', array( $this, 'add_image_options_markup' ), 10, 4 );

		// display on entry detail
		add_filter( 'gform_entry_field_value', array( $this, 'custom_entry_field_value' ), 20, 4 );
		add_filter( 'gform_order_summary', array( $this, 'custom_order_summary_entry_field_value' ), 10, 4 );

		add_filter('gform_register_init_scripts', array( $this, 'load_custom_css' ), 10, 4);

		parent::init();

	}

	/**
	 * Initialize the admin specific hooks.
	 */
	public function init_admin() {

		// form editor
		add_action( 'gform_field_standard_settings', array( $this, 'image_choice_field_settings' ), 10, 2 );
		add_filter( 'gform_tooltips', array( $this, 'add_image_choice_field_tooltips' ) );

		// display results on entry list
		add_filter( 'gform_entries_field_value', array( $this, 'entries_table_field_value' ), 10, 4 );

		$name = plugin_basename($this->_path);
		add_action( 'after_plugin_row_'.$name, array( $this, 'gf_plugin_row' ), 10, 2 );

		parent::init_admin();

	}

	/**
	 * The Image Choices add-on does not support logging.
	 *
	 * @param array $plugins The plugins which support logging.
	 *
	 * @return array
	 */
	public function set_logging_supported( $plugins ) {

		return $plugins;

	}


	// # SCRIPTS & STYLES -----------------------------------------------------------------------------------------------

	/**
	 * Return the scripts which should be enqueued.
	 *
	 * @return array
	 */
	public function scripts() {
		$gf_image_choices_js_deps = array( 'jquery', 'jquery-ui-sortable' );
		if ( wp_is_mobile() ) {
			$gf_image_choices_js_deps[] = 'jquery-touch-punch';
		}

		$scripts = array(
				array(
						'handle'   => 'gf_image_choices_form_editor_js',
						'src'      => $this->get_base_url() . '/js/gf_image_choices_form_editor.js',
						'version'  => $this->_version,
						'deps'     => array( 'jquery' ),
						'callback' => array( $this, 'localize_scripts' ),
						'enqueue'  => array(
								array( 'admin_page' => array( 'form_editor', 'plugin_settings', 'form_settings' ) ),
						),
				),
				array(
						'handle'   => 'gf_image_choices_ace_editor',
						'src'      => $this->get_base_url() . '/lib/ace/ace.js',
						'deps'     => array( 'jquery' ),
						'enqueue'  => array(
								array( 'admin_page' => array( 'plugin_settings', 'form_settings' ) ),
						),
				),
				array(
						'handle'  => 'gf_image_choices_js',
						'src'     => $this->get_base_url() . '/js/gf_image_choices.js',
						'version' => $this->_version,
						'deps'    => $gf_image_choices_js_deps,
						'enqueue' => array(
								array( 'admin_page' => array( 'form_editor', 'entry_view', 'entry_detail', 'entry_edit' ) ),
								array( 'field_types' => array( 'radio', 'checkbox', 'survey', 'poll', 'quiz', 'post_custom_field', 'product', 'option' ) ),
						),
				),
		);

		return array_merge( parent::scripts(), $scripts );
	}

	/**
	 * Return the stylesheets which should be enqueued.
	 *
	 * @return array
	 */
	public function styles() {

		$styles = array(
				array(
						'handle'  => 'gf_image_choices_form_editor_css',
						'src'     => $this->get_base_url() . '/css/gf_image_choices_form_editor.css',
						'version' => $this->_version,
						'enqueue' => array(
							array('admin_page' => array( 'form_editor', 'plugin_settings', 'form_settings', 'entry_view', 'entry_detail' )),
							array('query' => 'page=gf_entries&view=entry&id=_notempty_')
						),
				),
				array(
						'handle'  => 'gf_image_choices_css',
						'src'     => $this->get_base_url() . '/css/gf_image_choices.css',
						'version' => $this->_version,
						'media'   => 'screen',
						'enqueue' => array(
							array('admin_page' => array( 'form_editor', 'entry_view', 'entry_detail' )),
							array('field_types' => array( 'radio', 'checkbox', 'survey', 'poll', 'quiz', 'post_custom_field', 'product', 'option' )),
							array('query' => 'page=gf_entries&view=entry&id=_notempty_')
						),
				),
		);

		return array_merge( parent::styles(), $styles );
	}

	function load_custom_css($form) {

		require_once( dirname( __FILE__ ) . '/inc/php-html-css-js-minifier.php' );
		$minifier = PHP_HTML_CSS_JS_Minifier::get_instance();

		$form_settings = $this->get_form_settings($form);
		$form_css_value = (isset($form_settings['gf_image_choices_custom_css'])) ? $form_settings['gf_image_choices_custom_css'] : '';
		if (!empty($form_css_value)) {
			$form_css_value_min = $minifier->minify_css($form_css_value);
			$form_css_script = '(function(){ if (typeof window.gf_image_choices_custom_css_'.$form['id'].' === "undefined") window.gf_image_choices_custom_css_'.$form['id'].' = "'.addslashes($form_css_value_min).'"; })();';
			GFFormDisplay::add_init_script($form['id'], 'gf_image_choices_custom_css_script_'.$form['id'], GFFormDisplay::ON_PAGE_RENDER, $form_css_script);
		}

		$ignore_global_css_value = (isset($form_settings['gf_image_choices_ignore_global_css'])) ? $form_settings['gf_image_choices_ignore_global_css'] : 0;
		$ignore_global_css_value_script = '(function(){ if (typeof window.gf_image_choices_ignore_global_css_'.$form['id'].' === "undefined") window.gf_image_choices_ignore_global_css_'.$form['id'].' = '.$ignore_global_css_value.'; })();';
		GFFormDisplay::add_init_script($form['id'], 'gf_image_choices_ignore_global_css_'.$form['id'], GFFormDisplay::ON_PAGE_RENDER, $ignore_global_css_value_script);

		if (empty($ignore_global_css_value)) {
			$global_css_value = $this->get_plugin_setting('gf_image_choices_custom_css_global');
			if (!empty($global_css_value)) {
				$global_css_value_min = $minifier->minify_css($global_css_value);
				$global_css_script = '(function(){ if (typeof window.gf_image_choices_custom_css_global === "undefined") window.gf_image_choices_custom_css_global = "'.addslashes($global_css_value_min).'"; })();';
				GFFormDisplay::add_init_script($form['id'], 'gf_image_choices_custom_css_global_script', GFFormDisplay::ON_PAGE_RENDER, $global_css_script);
			}
		}

		return $form;
	}


	/**
	 * Localize the strings used by the scripts.
	 */
	public function localize_scripts() {

		// Get current page protocol
		$protocol = isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';
		// Output admin-ajax.php URL with same protocol as current page
		$params = array(
				'ajaxurl'   => admin_url( 'admin-ajax.php', $protocol ),
				//'imagesUrl' => $this->get_base_url() . '/images',
		);
		wp_localize_script( 'gf_image_choices_form_editor_js', 'imageChoicesFieldVars', $params );

		//localize strings for the js file
		$strings = array(
				'uploadImage'    => esc_html__( 'Upload image', GFIC_TEXT_DOMAIN ),
				'removeImage'    => esc_html__( 'Remove this image', GFIC_TEXT_DOMAIN ),
				'removeAllChoices'    => esc_html__( 'Remove All Choices', GFIC_TEXT_DOMAIN ),
				'entrySettingTitle'    => esc_html__( 'Image Choices Entry Display', GFIC_TEXT_DOMAIN ),
				'entrySettingForm'    => esc_html__( 'Use Form Setting', GFIC_TEXT_DOMAIN ),
				'entrySettingValue'    => esc_html__( 'Value', GFIC_TEXT_DOMAIN ),
				'entrySettingImage'    => esc_html__( 'Image', GFIC_TEXT_DOMAIN ),
				'entrySettingText'    => esc_html__( 'Label', GFIC_TEXT_DOMAIN ),
				'entrySettingImageText'    => esc_html__( 'Image and Label', GFIC_TEXT_DOMAIN ),
				'entrySettingImageValue'    => esc_html__( 'Image and Value', GFIC_TEXT_DOMAIN ),
				'showLabels'    => esc_html__( 'Show labels', GFIC_TEXT_DOMAIN ),
				'displaySettingsTitle'    => esc_html__( 'Image Choices Display', GFIC_TEXT_DOMAIN ),
				'imageSizeSettingTitle'    => esc_html__( 'Image Size', GFIC_TEXT_DOMAIN ),
				'imageSizeSettingForm'    => esc_html__( 'Use Form Setting', GFIC_TEXT_DOMAIN ),
				'imageSizeSettingThumbnail'    => esc_html__( 'Thumbnail', GFIC_TEXT_DOMAIN ),
				'imageSizeSettingMedium'    => esc_html__( 'Medium', GFIC_TEXT_DOMAIN ),
				'imageSizeSettingLarge'    => esc_html__( 'Large', GFIC_TEXT_DOMAIN ),
				'imageSizeSettingOriginal'    => esc_html__( 'Original (Full)', GFIC_TEXT_DOMAIN ),
				'showLabelsDescription'    => esc_html__( 'With this setting, the choices labels will be displayed along with the image', GFIC_TEXT_DOMAIN ),
				'selectLayout'    => esc_html__( 'Choices layout', GFIC_TEXT_DOMAIN ),
				'layoutHorizontal'    => esc_html__( 'Horizontal (inline)', GFIC_TEXT_DOMAIN ),
				'layoutVertical'    => esc_html__( 'Vertical (stacked)', GFIC_TEXT_DOMAIN ),
		);
		wp_localize_script( 'gf_image_choices_form_editor_js', 'imageChoicesFieldStrings', $strings );

	}


	/**
	 * Creates a settings page for this add-on.
	 */
	public function plugin_settings_fields() {

		$license = $this->get_plugin_setting('gf_image_choices_license_key');
		$status = get_option('gf_image_choices_license_status');

		$license_field = array(
			'name' => 'gf_image_choices_license_key',
			'tooltip' => esc_html__('Enter the license key you received after purchasing the plugin.', GFIC_TEXT_DOMAIN),
			'label' => esc_html__('License Key', GFIC_TEXT_DOMAIN),
			'type' => 'text',
			'input_type' => 'password',
			'class' => 'medium',
			'default_value' => '',
			'validation_callback' => array($this, 'license_validation'),
			'feedback_callback' => array($this, 'license_feedback'),
			'error_message' => esc_html__( 'Invalid license', GFIC_TEXT_DOMAIN ),
		);

		if (!empty($license) && !empty($status)) {
			$license_field['after_input'] = ($status == 'valid') ? ' License is valid' : ' Invalid or expired license';
		}

		$custom_css_global_value = $this->get_plugin_setting('gf_image_choices_custom_css_global');
		$custom_css_global_field = array(
			'name' => 'gf_image_choices_custom_css_global',
			'tooltip' => esc_html__('These styles will be loaded for all forms.<br/>Find examples at <a href="https://jetsloth.com/support/gravity-forms-image-choices/">https://jetsloth.com/support/gravity-forms-image-choices/</a>', GFIC_TEXT_DOMAIN),
			'label' => esc_html__('Custom CSS', GFIC_TEXT_DOMAIN),
			'type' => 'textarea',
			'class' => 'large',
			'default_value' => $custom_css_global_value
		);

		$fields = array(
			array(
				'title'  => esc_html__('To unlock plugin updates, please enter your license key below', GFIC_TEXT_DOMAIN),
				'fields' => array(
					$license_field
				)
			),
			array(
				'title'  => esc_html__('Enter your own css to style image choices', GFIC_TEXT_DOMAIN),
				'fields' => array(
					$custom_css_global_field
				)
			)
		);

		return $fields;
	}

	/**
	 * Configures the settings which should be rendered on the Form Settings > Image Choices tab.
	 *
	 * @return array
	 */
	public function form_settings_fields( $form ) {

		$settings = $this->get_form_settings( $form );

		$form_choices_entry_value = (isset($settings['gf_image_choices_entry_value'])) ? $settings['gf_image_choices_entry_value'] : 'value';
		$form_choices_entry_field = array(
			'name' => 'gf_image_choices_entry_value',
			//'tooltip' => esc_html__('The selected collapsible section will be opened by default when the form loads.', GFCS_TEXT_DOMAIN),
			'label' => esc_html__('Default Entry Display', GFIC_TEXT_DOMAIN),
			'type' => 'select',
			'class' => 'medium',
			'default_value' => 'value',
			'choices' => array(
				array(
					'value' => 'value',
					'label' => esc_html__('Value (Gravity Forms default)', GFIC_TEXT_DOMAIN)
				),
				array(
					'value' => 'image',
					'label' => esc_html__('Image', GFIC_TEXT_DOMAIN)
				),
				array(
					'value' => 'text',
					'label' => esc_html__('Label', GFIC_TEXT_DOMAIN)
				),
				array(
					'value' => 'image_text',
					'label' => esc_html__('Image and Label', GFIC_TEXT_DOMAIN)
				),
				array(
					'value' => 'image_value',
					'label' => esc_html__('Image and Value', GFIC_TEXT_DOMAIN)
				)
			)
		);
		if (!empty($form_choices_entry_value)) {
			$form_choices_entry_field['default_value'] = $form_choices_entry_value;
		}

		$form_custom_css_value = (isset($settings['gf_image_choices_custom_css'])) ? $settings['gf_image_choices_custom_css'] : '';
		$form_custom_css_field = array(
			'name' => 'gf_image_choices_custom_css',
			'tooltip' => esc_html__('These styles will be loaded for this form only.<br/>Find examples at <a href="https://jetsloth.com/support/gravity-forms-image-choices/">https://jetsloth.com/support/gravity-forms-image-choices/</a>', GFIC_TEXT_DOMAIN),
			'label' => esc_html__('Custom CSS', GFIC_TEXT_DOMAIN),
			'type' => 'textarea',
			'class' => 'large',
			'default_value' => $form_custom_css_value
		);

		$form_ignore_global_css_value = (isset($settings['gf_image_choices_ignore_global_css']) && $settings['gf_image_choices_ignore_global_css'] == 1) ? 1 : 0;
		$form_ignore_global_css_field = array(
			'name' => 'gf_image_choices_ignore_global_css',
			'label' => '',
			'type' => 'checkbox',
			'choices' => array(
				array(
					'label' => esc_html__('Ignore Global Custom CSS for this form?', GFIC_TEXT_DOMAIN),
					'tooltip' => esc_html__('If checked, the custom css entered in the global settings won\'t be loaded for this form.', GFIC_TEXT_DOMAIN),
					'name' => 'gf_image_choices_ignore_global_css'
				)
			)
		);
		if (!empty($form_ignore_global_css_value)) {
			$form_ignore_global_css_field['choices'][0]['default_value'] = 1;
		}

		return array(
			array(
				'title' => esc_html__( 'Image Choices', GFIC_TEXT_DOMAIN ),
				'fields' => array(
					$form_choices_entry_field,
					$form_custom_css_field,
					$form_ignore_global_css_field
				)
			)
		);

	}



	/**
	 * Format the field values for entry list page so they show the image instead of values.
	 *
	 * @param string|array $value The field value.
	 * @param int $form_id The ID of the form currently being processed.
	 * @param string $field_id The ID of the field currently being processed.
	 * @param array $entry The entry object currently being processed.
	 *
	 * @return string|array
	 */
	public function entries_table_field_value( $value, $form_id, $field_id, $entry ) {
		if ( ! rgblank( $value ) ) {
			$form_meta = RGFormsModel::get_form_meta( $form_id );
			$field     = RGFormsModel::get_field( $form_meta, $field_id );

			$form = GFAPI::get_form($form_id);

			return $this->maybe_format_field_values( $value, $field, $form, $entry );
		}

		return $value;
	}

	/**
	 * Format the field values on the entry detail page so they show the image instead of values.
	 *
	 * @param string|array $value The field value.
	 * @param GF_Field $field The field currently being processed.
	 * @param array $entry The entry object currently being processed.
	 * @param array $form The form object currently being processed.
	 *
	 * @return string|array
	 */
	public function custom_entry_field_value( $value, $field, $entry, $form ) {
		return ! rgblank( $value ) ? $this->maybe_format_field_values( $value, $field, $form, $entry ) : $value;
	}


	public function custom_order_summary_entry_field_value( $markup, $form, $entry, $order_summary, $format = 'html' ) {
		if ($format == 'text') {
			return $markup;
		}

		// Products by default display value (not text/label)
		// Eg: Selected Product Value
		// Product Options by default display both the main Field Label and the selected Choice Value
		// Eg: Product Option Field Label: Selected Option Value

		$contains_image_choices_fields = false;

		// ---------
		$settings = $this->get_form_settings( $form );
		$form_choices_entry_setting = (isset($settings['gf_image_choices_entry_value'])) ? $settings['gf_image_choices_entry_value'] : 'value';
		// ---------

		$fields_id_lookup = array();
		$fields_label_lookup = array();
		foreach($form['fields'] as $field) {
			$fields_id_lookup[$field->id] = $field;
			$fields_label_lookup[$field->label] = $field;
		}

		$product_summary_image_choices = array();
		foreach ($order_summary['products'] as $product_field_id => $product) {

			$data = array(
				'product_field_id' => $product_field_id,
				'product_field_label' => '',
				'product_summary_display_value' => $product['name'],
				'product_field_selected_value' => $product['name'],
				'product_field_selected_price' => $product['price'],
				'product_field_selected_label' => '',
				'product_field_selected_image' => '',
				'product_field_entry_value_type' => 'value',
				'options' => array()
			);
			
			if (isset($fields_id_lookup[$product_field_id])) {
				$field = $fields_id_lookup[$product_field_id];
				if ( is_object( $field ) && property_exists($field, 'imageChoices_enableImages') && $field->imageChoices_enableImages ) {
					$field_choices_entry_setting = (property_exists($field, 'imageChoices_entrySetting') && !empty($field->imageChoices_entrySetting)) ? $field->imageChoices_entrySetting : 'form_setting';
					$data['product_field_label'] = $field->label;
					$data['product_field_selected_label'] = RGFormsModel::get_choice_text($field, $data['product_field_selected_value']);
					$data['product_field_entry_value_type'] = ($field_choices_entry_setting == 'form_setting') ? $form_choices_entry_setting : $field_choices_entry_setting;
					$data['product_field_selected_image'] = $this->get_choice_image_src($field, $data['product_field_selected_value']);
					$contains_image_choices_fields = true;
				}
			}
			
			if (isset($product['options']) && !empty($product['options'])) {
				foreach($product['options'] as $option) {
					$option_field_label = $option['field_label'];
					$option_data = array(
						'option_field_label' => $option_field_label,
						'option_summary_display_value' => $option['option_label'],
						'option_field_selected_value' => $option['option_name'],
						'option_field_selected_price' => $option['price'],
						'option_field_selected_label' => '',
						'option_field_selected_image' => '',
						'option_field_entry_value_type' => 'value'
					);

					if (isset($fields_label_lookup[$option_field_label])) {
						$field = $fields_label_lookup[$option_field_label];
						if ( is_object( $field ) && property_exists($field, 'imageChoices_enableImages') && $field->imageChoices_enableImages ) {
							$field_choices_entry_setting = (property_exists($field, 'imageChoices_entrySetting') && !empty($field->imageChoices_entrySetting)) ? $field->imageChoices_entrySetting : 'form_setting';
							$option_data['option_field_selected_label'] = RGFormsModel::get_choice_text($field, $option_data['option_field_selected_value']);
							$option_data['option_field_entry_value_type'] = ($field_choices_entry_setting == 'form_setting') ? $form_choices_entry_setting : $field_choices_entry_setting;
							$option_data['option_field_selected_image'] = $this->get_choice_image_src($field, $option_data['option_field_selected_value']);
							$contains_image_choices_fields = true;
						}
					}

					array_push($data['options'], $option_data);
				}
			}
			array_push($product_summary_image_choices, $data);
		}

		if ($contains_image_choices_fields) {
			$image_entry_setting_values = array('image', 'image_text', 'image_value');

			foreach($product_summary_image_choices as $summary_item) {
				if (
				in_array($summary_item['product_field_entry_value_type'], $image_entry_setting_values)
				&& !empty($summary_item['product_field_selected_image'])) {

					$replacement_markup = '';

					if ($summary_item['product_field_entry_value_type'] == 'image') {
						$replacement_markup = '<div class="gf-image-choices-entry-choice-image" style="background-image:url('.$summary_item['product_field_selected_image'].')"></div>';
					}
					else if ($summary_item['product_field_entry_value_type'] == 'image_text') {
						$replacement_markup = '<div class="gf-image-choices-entry-choice-image" style="background-image:url('.$summary_item['product_field_selected_image'].')"></div><div class="product_name">'.$summary_item['product_field_selected_label'].'</div>';
					}
					else if ($summary_item['product_field_entry_value_type'] == 'image_value') {
						$replacement_markup = '<div class="gf-image-choices-entry-choice-image" style="background-image:url('.$summary_item['product_field_selected_image'].')"></div><div class="product_name">'.$summary_item['product_summary_display_value'].'</div>';
					}

					if (!empty($replacement_markup)) {
						$markup = str_replace(
							'<div class="product_name">'.$summary_item['product_summary_display_value'].'</div>',
							$replacement_markup,
							$markup
						);
					}

				}
				else if ($summary_item['product_field_entry_value_type'] == 'text') {
					// Text
					$markup = str_replace(
						$summary_item['product_summary_display_value'],
						//$summary_item['product_field_selected_label'] . ' (' . GFCommon::to_money( $summary_item['product_field_selected_price'], $entry['currency'] ) . ')',
						$summary_item['product_field_selected_label'],
						$markup
					);
				}


				foreach($summary_item['options'] as $option_item) {
					if (in_array($option_item['option_field_entry_value_type'], $image_entry_setting_values)) {
						$replacement_markup = '';
						if ($option_item['option_field_entry_value_type'] == 'image') {
							$replacement_markup = '<div class="gf-image-choices-entry-choice-image" style="background-image:url('.$option_item['option_field_selected_image'].')"></div>';
						}
						else if ($option_item['option_field_entry_value_type'] == 'image_text') {
							$replacement_markup = '<div class="gf-image-choices-entry-choice-image" style="background-image:url('.$option_item['option_field_selected_image'].')"></div><div class="product_option_name">'.$option_item['option_field_label'] . ': ' . $option_item['option_field_selected_label'].'</div>';
						}
						else if ($option_item['option_field_entry_value_type'] == 'image_value') {
							$replacement_markup = '<div class="gf-image-choices-entry-choice-image" style="background-image:url(' . $option_item['option_field_selected_image'] . ')"></div><div class="product_option_name">' . $option_item['option_summary_display_value'] . '</div>';
						}

						if (!empty($replacement_markup)) {
							$markup = str_replace(
								$option_item['option_summary_display_value'],
								$replacement_markup,
								$markup
							);
						}

					}
					else if ($option_item['option_field_entry_value_type'] == 'text') {
						$markup = str_replace(
							$option_item['option_summary_display_value'],
							//$option_item['option_field_label'] . ': ' . $option_item['option_field_selected_label'] . ' (' . GFCommon::to_money( $option_item['option_field_selected_price'], $entry['currency'] ) . ')',
							$option_item['option_field_label'] . ': ' . $option_item['option_field_selected_label'],
							$markup
						);
					}
				}
			}

		}

		return $markup;
	}



	public function get_choice_image_src($field, $value) {
		$img = '';
		foreach($field->choices as $choice) {
			if ($choice['value'] != $value) {
				continue;
			}
			if (!empty($choice['imageChoices_image'])) {
				$img = $choice['imageChoices_image'];
			}
		}
		return $img;
	}

	public function get_choice_image_item_markup($src = '', $text_value = '') {
		$markup = '<li class="gf-image-choices-entry-choice">';
		$markup .= '<span class="gf-image-choices-entry-choice-image" style="background-image:url('.$src.')"></span>';
		if (!empty($text_value)) {
			$markup .= '<span class="gf-image-choices-entry-choice-text">'.$text_value.'</span>';
		}
		$markup .= '</li>';
		return $markup;
	}

	public function wrap_choice_images_markup($choice_images_markup = array()) {
		array_unshift($choice_images_markup, '<ul class="gf-image-choices-entry">');
		array_push($choice_images_markup, '</ul>');
		return implode('', $choice_images_markup);
	}

	/**
	 * If the field has image choices then replace the choice value with the image preview.
	 *
	 * @param string $value The field value.
	 * @param GF_Field|null $field The field object being processed or null.
	 * @param array $form The form object currently being processed.
	 * @param array $entry The entry object currently being processed.
	 *
	 * @return string
	 */

	public function maybe_format_field_values( $value, $field, $form, $entry ) {

		if (!isset($field) || empty($field)) {
			return $value;
		}


		// ---------
		$settings = $this->get_form_settings( $form );
		$form_choices_entry_setting = (isset($settings['gf_image_choices_entry_value'])) ? $settings['gf_image_choices_entry_value'] : 'value';
		$field_choices_entry_setting = (property_exists($field, 'imageChoices_entrySetting') && !empty($field->imageChoices_entrySetting)) ? $field->imageChoices_entrySetting : 'form_setting';
		$field_entry_value_type = ($field_choices_entry_setting == 'form_setting') ? $form_choices_entry_setting : $field_choices_entry_setting;
		$image_entry_setting_values = array('image', 'image_text', 'image_value');
		// ---------

		$real_value = RGFormsModel::get_lead_field_value( $entry, $field );

		//if ( is_object( $field ) && property_exists($field, 'imageChoices_enableImages') && $field->imageChoices_enableImages && $field->type != 'product' && $field->type != 'option') {
		if ( is_object( $field ) && property_exists($field, 'imageChoices_enableImages') && $field->imageChoices_enableImages && $field_entry_value_type != 'value' ) {
			$type_property = ($field->type == 'survey' || $field->type == 'poll' || $field->type == 'quiz' || $field->type == 'post_custom_field' || $field->type == 'product' || $field->type == 'option') ? 'inputType' : 'type';

			// Product field doesn't have checkboxes, only radio
			// Option field has both

			if ($field[$type_property] == 'checkbox' && strpos($value, ', ') !== FALSE) {

				// multiple selections
				$ordered_values = (!empty($value)) ? explode(', ', $value) : '';
				if (is_array($ordered_values)) {
					$return_strings = array();
					$return_images = array();
					foreach ($ordered_values as $ordered_value) {
						if ($field->type != 'option') {
							$image = $this->get_choice_image_src($field, $ordered_value);
							$text = RGFormsModel::get_choice_text($field, $ordered_value);
							if ($field_entry_value_type == 'text') {
								array_push($return_strings, $text);
							}
							else if (in_array($field_entry_value_type, $image_entry_setting_values) && !empty($image)) {
								$image_item_markup = '';
								if ($field_entry_value_type == 'image') {
									$image_item_markup = $this->get_choice_image_item_markup($image);
								}
								else if ($field_entry_value_type == 'image_text') {
									$image_item_markup = $this->get_choice_image_item_markup($image, $text);
								}
								else if ($field_entry_value_type == 'image_value') {
									$image_item_markup = $this->get_choice_image_item_markup($image, $ordered_value);
								}
								array_push($return_images, $image_item_markup);
							}
						}
						else {
							// product option field CHECKBOX - saved as
							// Value|Price
							// Eg: Choice Value|0

							list($name, $price) = explode("|", $value);
							$image = $this->get_choice_image_src($field, $name);
							$text = RGFormsModel::get_choice_text($field, $name);

							if ($field_entry_value_type == 'text') {
								array_push($return_strings, $text);
							}
							else if (in_array($field_entry_value_type, $image_entry_setting_values) && !empty($image)) {
								$image_item_markup = '';
								if ($field_entry_value_type == 'image') {
									$image_item_markup = $this->get_choice_image_item_markup($image);
								}
								else if ($field_entry_value_type == 'image_text') {
									$image_item_markup = $this->get_choice_image_item_markup($image, $text);
								}
								else if ($field_entry_value_type == 'image_value') {
									$image_item_markup = $this->get_choice_image_item_markup($image, $name);
								}
								array_push($return_images, $image_item_markup);
							}

						}
					}

					if (in_array($field_entry_value_type, $image_entry_setting_values) && !empty($return_images)) {
						$value = $this->wrap_choice_images_markup($return_images);
					}
					else {
						$value = implode(', ', $return_strings);
					}
				}

			}
			else {

				// either a radio, or a checkbox with a single selection
				if ($field->type == 'checkbox') {

					// When on the View Entry page, checkbox field is unordered list HTML
					// so just grab the real values
					$checkbox_text_values = $field->get_value_entry_detail($real_value, '', true, 'text');

					$return_strings = array();
					$return_images = array();

					foreach ($real_value as $key => $choice_value) {
						if (!empty($choice_value)) {
							$image = $this->get_choice_image_src($field, $choice_value);
							$text = RGFormsModel::get_choice_text($field, $choice_value);
							if ($field_entry_value_type == 'text') {
								array_push($return_strings, $text);
							}
							else if (in_array($field_entry_value_type, $image_entry_setting_values) && !empty($image)) {
								$image_item_markup = '';
								if ($field_entry_value_type == 'image') {
									$image_item_markup = $this->get_choice_image_item_markup($image);
								}
								else if ($field_entry_value_type == 'image_text') {
									$image_item_markup = $this->get_choice_image_item_markup($image, $text);
								}
								else if ($field_entry_value_type == 'image_value') {
									$image_item_markup = $this->get_choice_image_item_markup($image, $choice_value);
								}
								array_push($return_images, $image_item_markup);
							}

						}
					}

					if (in_array($field_entry_value_type, $image_entry_setting_values) && !empty($return_images)) {
						$value = $this->wrap_choice_images_markup($return_images);
					}
					else {
						if (!empty($return_strings)) {
							$markup = '<ul class="bulleted">';
							foreach ($return_strings as $return_value) {
								$markup .= '<li>' . $return_value . '</li>';
							}
							$markup .= '</ul>';
							$value = $markup;
						}
						else {
							$value = implode(', ', $return_strings);
						}
					}

				}
				else if ($field->type == 'quiz' && $field->is_entry_detail()) {

					// Can only show text (choice label) or image, or both.
					// Can't show value - doesn't let user set it anyway, it's a unique id

					$choices_data = array();
					foreach ($field->choices as $choice) {
						array_push($choices_data, array(
							'text' => $choice['text'],
							'value' => $choice['value'],
							'image' => $choice['imageChoices_image']
						));
					}

					// Taken from GFQuiz::display_quiz_on_entry_detail (class-gf-quiz.php)
					$new_value = '';
					$new_value .= '<div class="gquiz_entry">';
					$results = gf_quiz()->get_quiz_results($form, $entry, false);
					$field_markup = '';

					foreach ($results['fields'] as $field_results) {
						if ($field_results['id'] == $field->id) {
							$field_markup = $field_results['markup'];
							break;
						}
					}

					if (in_array($field_entry_value_type, $image_entry_setting_values)) {
						// Modify the markup for image choices
						$field_markup = str_replace('<ul>', '<ul class="gf-image-choices-entry">', $field_markup);
						$field_markup = str_replace('<li>', '<li class="gf-image-choices-entry-choice">', $field_markup);
						foreach ($choices_data as $choice) {
							$replacement_markup = '';
							if ($field_entry_value_type == 'image') {
								$replacement_markup = '<span class="gf-image-choices-entry-choice-image" style="background-image:url(' . $choice['image'] . ')"></span>';
							}
							else if ($field_entry_value_type == 'image_text' || $field_entry_value_type == 'image_value') {
								$replacement_markup = '<span class="gf-image-choices-entry-choice-image" style="background-image:url(' . $choice['image'] . ')"></span><span class="gf-image-choices-entry-choice-text">' . $choice['text'] . '</span>';
							}
							$field_markup = str_replace($choice['text'], $replacement_markup, $field_markup);
						}
					}

					$new_value .= $field_markup;
					$new_value .= '</div>';

					$value = $new_value;

				}
				else if ($field->type == 'poll' && $field->is_entry_detail()) {

					$choices_data = array();
					foreach ($field->choices as $choice) {
						array_push($choices_data, array(
							'id' => $choice['id'],
							'text' => $choice['text'],
							'value' => $choice['value'],
							'image' => $choice['imageChoices_image']
						));
					}

					// Taken from GFPolls::display_poll_on_entry_detail (class-gf-polls.php)
					$results = gf_polls()->gpoll_get_results($form['id'], $field->id, 'green', true, true, $entry);
					$new_value = sprintf('<div class="gpoll_entry">%s</div>', rgar($results, 'summary'));
					gf_polls()->gpoll_add_scripts = true;

					//if original response is not in results display below
					$selected_values = gf_polls()->get_selected_values($form['id'], $field->id, $entry);
					$possible_choices = gf_polls()->get_possible_choices($form['id'], $field->id);
					foreach ($selected_values as $selected_value) {
						if (!in_array($selected_value, $possible_choices)) {
							$new_value = sprintf('%s<h2>%s</h2>%s', $new_value, esc_html__('Original Response', 'gravityformspolls'), $value);
							break;
						}
					}

					if (in_array($field_entry_value_type, $image_entry_setting_values)) {
						// Now modify the markup for image choices
						$new_value = str_replace('<div class="gpoll_entry">', '<div class="gpoll_entry gf-image-choices-entry">', $new_value);
						foreach ($choices_data as $choice) {
							$replacement_markup = '';
							if ($field_entry_value_type == 'image') {
								$replacement_markup = '<div class="gf-image-choices-entry-choice"><span class="gf-image-choices-entry-choice-image" style="background-image:url(' . $choice['image'] . ')"></span></div>';
							}
							else if ($field_entry_value_type == 'image_text' || $field_entry_value_type == 'image_value') {
								// Don't return value for poll fields. IF that's selected, use text
								$replacement_markup = '<div class="gf-image-choices-entry-choice"><span class="gf-image-choices-entry-choice-image" style="background-image:url(' . $choice['image'] . ')"></span><span class="gf-image-choices-entry-choice-text">' . $choice['text'] . '</span></div>';
							}
							$new_value = str_replace($choice['text'], $replacement_markup, $new_value);
						}
					}

					$value = $new_value;

				}
				else if ($field->type == 'survey' && $field->is_entry_detail()) {

					if ($field[$type_property] == 'checkbox') {

						$return_strings = array();
						$return_images = array();

						foreach ($real_value as $key => $choice_value) {
							if (!empty($choice_value)) {
								$image = $this->get_choice_image_src($field, $choice_value);
								$text = RGFormsModel::get_choice_text($field, $choice_value);
								if ($field_entry_value_type == 'text') {
									array_push($return_strings, $text);
								}
								else if (in_array($field_entry_value_type, $image_entry_setting_values) && !empty($image)) {
									$image_item_markup = '';
									if ($field_entry_value_type == 'image') {
										$image_item_markup = $this->get_choice_image_item_markup($image);
									}
									else if ($field_entry_value_type == 'image_text' || $field_entry_value_type == 'image_value') {
										// Don't return value for survey fields. IF that's selected, use text
										$image_item_markup = $this->get_choice_image_item_markup($image, $text);
									}
									/*
									else if ($field_entry_value_type == 'image_value') {
										$image_item_markup = $this->get_choice_image_item_markup($image, $choice_value);
									}
									*/
									array_push($return_images, $image_item_markup);
								}
							}
						}

						if (in_array($field_entry_value_type, $image_entry_setting_values) && !empty($return_images)) {
							$value = $this->wrap_choice_images_markup($return_images);
						}
						else {
							if (!empty($return_strings)) {
								$markup = '<ul class="bulleted">';
								foreach ($return_strings as $return_value) {
									$markup .= '<li>' . $return_value . '</li>';
								}
								$markup .= '</ul>';
								$value = $markup;
							}
							else {
								$value = implode(', ', $return_strings);
							}
						}

					}
					else {

						$image = $this->get_choice_image_src($field, $real_value);
						$text = RGFormsModel::get_choice_text($field, $real_value);

						if ($field_entry_value_type == 'text') {
							$value = $text;
						}
						else if (in_array($field_entry_value_type, $image_entry_setting_values) && !empty($image)) {
							$image_item_markup = '';
							if ($field_entry_value_type == 'image') {
								$image_item_markup = $this->get_choice_image_item_markup($image);
							}
							else if ($field_entry_value_type == 'image_text' || $field_entry_value_type == 'image_value') {
								// Don't return value for survey fields. IF that's selected, use text
								$image_item_markup = $this->get_choice_image_item_markup($image, $text);
							}
							/*
							else if ($field_entry_value_type == 'image_value') {
								$image_item_markup = $this->get_choice_image_item_markup($image, $real_value);
							}
							*/
							$value = $this->wrap_choice_images_markup(array($image_item_markup));
						}

					}

				}
				else if ($field->type == 'radio'
					|| $field->type == 'post_custom_field'
					|| ($field->type == 'quiz' && !$field->is_entry_detail())
					|| ($field->type == 'poll' && !$field->is_entry_detail())
					|| ($field->type == 'survey' && !$field->is_entry_detail())) {

					$image = $this->get_choice_image_src($field, $value);
					$text = RGFormsModel::get_choice_text($field, $value);

					// Don't show value for quiz, survey and poll fields
					$force_text_instead_of_value = ($field->type == 'quiz' || $field->type == 'poll' || $field->type == 'survey');

					if ($field_entry_value_type == 'text') {
						$value = $text;
					}
					else if (in_array($field_entry_value_type, $image_entry_setting_values) && !empty($image)) {
						$image_item_markup = '';
						if ($field_entry_value_type == 'image') {
							$image_item_markup = $this->get_choice_image_item_markup($image);
						}
						else if ($field_entry_value_type == 'image_text' || ($force_text_instead_of_value && $field_entry_value_type == 'image_value')) {
							$image_item_markup = $this->get_choice_image_item_markup($image, $text);
						}
						else if ($field_entry_value_type == 'image_value') {
							$image_item_markup = $this->get_choice_image_item_markup($image, $value);
						}
						$value = $this->wrap_choice_images_markup(array($image_item_markup));
					}

				}
				else if ($field->type == 'product') {

					// product field IF NOT FREE - single selection - saved as
					// Value ($Price)
					// Eg: Choice Value ($20.00)

					// product field IF FREE - single selection - saved as
					// Value
					// Eg: Choice Value

					if (strpos($value, '(') === FALSE && strpos($value, ')') === FALSE) {
						// FREE
						$image = $this->get_choice_image_src($field, $value);
						$text = RGFormsModel::get_choice_text($field, $value);
						if ($field_entry_value_type == 'text') {
							$value = $text;
						}
						else if (in_array($field_entry_value_type, $image_entry_setting_values) && !empty($image)) {
							$image_item_markup = '';
							if ($field_entry_value_type == 'image') {
								$image_item_markup = $this->get_choice_image_item_markup($image);
							}
							else if ($field_entry_value_type == 'image_text') {
								$image_item_markup = $this->get_choice_image_item_markup($image, $text);
							}
							else if ($field_entry_value_type == 'image_value') {
								$image_item_markup = $this->get_choice_image_item_markup($image, $value);
							}
							$value = $this->wrap_choice_images_markup(array($image_item_markup));
						}
					}
					else {
						// NOT FREE
						$value_without_price = trim(substr($value, 0, strrpos($value, '(')));
						$image = $this->get_choice_image_src($field, $value_without_price);
						$text = RGFormsModel::get_choice_text($field, $value_without_price);
						if ($field_entry_value_type == 'text') {
							$value = $text;
						}
						else if (in_array($field_entry_value_type, $image_entry_setting_values) && !empty($image)) {
							$image_item_markup = '';
							if ($field_entry_value_type == 'image') {
								$image_item_markup = $this->get_choice_image_item_markup($image);
							}
							else if ($field_entry_value_type == 'image_text') {
								$image_item_markup = $this->get_choice_image_item_markup($image, $text);
							}
							else if ($field_entry_value_type == 'image_value') {
								//$image_item_markup = $this->get_choice_image_item_markup($image, $value_without_price);
								$image_item_markup = $this->get_choice_image_item_markup($image, $value);
							}
							$value = $this->wrap_choice_images_markup(array($image_item_markup));
						}
					}
				}
				else if ($field->type == 'option') {

					// product option field RADIO - single selection - saved as
					// Value ($Price)
					// Eg: Choice Value ($20.00)

					// product option field CHECKBOX - single selection - saved as
					// Value|Price
					// Eg: Choice Value|0

					if (strpos($value, '|') === FALSE) {
						// RADIO
						$value_without_price = trim(substr($value, 0, strrpos($value, '(')));
						$image = $this->get_choice_image_src($field, $value_without_price);
						$text = RGFormsModel::get_choice_text($field, $value_without_price);
						if ($field_entry_value_type == 'text') {
							$value = $text;
						}
						else if (in_array($field_entry_value_type, $image_entry_setting_values) && !empty($image)) {
							$image_item_markup = '';
							if ($field_entry_value_type == 'image') {
								$image_item_markup = $this->get_choice_image_item_markup($image);
							}
							else if ($field_entry_value_type == 'image_text') {
								$image_item_markup = $this->get_choice_image_item_markup($image, $text);
							}
							else if ($field_entry_value_type == 'image_value') {
								//$image_item_markup = $this->get_choice_image_item_markup($image, $value_without_price);
								$image_item_markup = $this->get_choice_image_item_markup($image, $value);
							}
							$value = $this->wrap_choice_images_markup(array($image_item_markup));
						}
					}
					else {
						// CHECKBOX
						list($name, $price) = explode("|", $value);
						$image = $this->get_choice_image_src($field, $name);
						$text = RGFormsModel::get_choice_text($field, $name);

						if ($field_entry_value_type == 'text') {
							$value = $text;
						}
						else if (in_array($field_entry_value_type, $image_entry_setting_values) && !empty($image)) {
							$image_item_markup = '';
							if ($field_entry_value_type == 'image') {
								$image_item_markup = $this->get_choice_image_item_markup($image);
							}
							else if ($field_entry_value_type == 'image_text') {
								$image_item_markup = $this->get_choice_image_item_markup($image, $text);
							}
							else if ($field_entry_value_type == 'image_value') {
								$image_item_markup = $this->get_choice_image_item_markup($image, $name);
							}
							$value = $this->wrap_choice_images_markup(array($image_item_markup));
						}
					}

				}

			}

			return $value;
		}

		return $value;
	}

	/**
	 * Add the image-choices-field class to the fields where images are enabled.
	 *
	 * @param string $classes The CSS classes to be filtered, separated by empty spaces.
	 * @param GF_Field $field The field currently being processed.
	 * @param array $form The form currently being processed.
	 *
	 * @return string
	 */
	public function add_custom_class( $classes, $field, $form ) {
		if ( property_exists($field, 'imageChoices_enableImages') && $field->imageChoices_enableImages ) {
			$classes .= (GFCommon::is_form_editor()) ? ' image-choices-admin-field ' : ' image-choices-field ';
			$classes .= 'image-choices-use-images ';
			if ( property_exists($field, 'imageChoices_showLabels') && $field->imageChoices_showLabels ) {
				$classes .= 'image-choices-show-labels ';
			}
			/*
			if ( property_exists($field, 'imageChoices_choicesLayout') && $field->imageChoices_choicesLayout ) {
				$classes .= 'image-choices-layout-'.$field->imageChoices_choicesLayout.' ';
			}
			*/
		}

		return $classes;
	}

	/**
	 * Add the tooltips for the field.
	 *
	 * @param array $tooltips An associative array of tooltips where the key is the tooltip name and the value is the tooltip.
	 *
	 * @return array
	 */
	public function add_image_choice_field_tooltips( $tooltips ) {
		$tooltips['image_choices_use_images'] = '<h6>' . esc_html__( 'Use Images', GFIC_TEXT_DOMAIN ) . '</h6>' . esc_html__( 'Enable to use of images as choices.', GFIC_TEXT_DOMAIN );
		$tooltips['image_choices_show_labels'] = '<h6>' . esc_html__( 'Show Labels', GFIC_TEXT_DOMAIN ) . '</h6>' . esc_html__( 'Enable the display of the labels together with the image.', GFIC_TEXT_DOMAIN );
		return $tooltips;
	}

	/**
	 * Add the custom settings for the fields to the fields general tab.
	 *
	 * @param int $position The position the settings should be located at.
	 * @param int $form_id The ID of the form currently being edited.
	 */
	public function image_choice_field_settings( $position, $form_id ) {
		if ( $position == 1362 ) {
			wp_enqueue_media();// For Media Library
		}
	}


	public function add_image_options_markup( $choice_markup, $choice, $field, $value ) {
		if (  property_exists($field, 'imageChoices_enableImages') && $field->imageChoices_enableImages ) {
			$img = $choice['imageChoices_image'];
			if (empty($img)) {
				$img = '';
			}
			if ($field->type != 'option' || GFCommon::is_form_editor()) {
				$choice_markup = preg_replace('#<label\b([^>]*)>(.*?)</label\b[^>]*>#s', '<label ${1}><span class="image-choices-choice-image-wrap" style="background-image:url('.$img.')"><img src="'.$img.'" alt="${2}" class="image-choices-choice-image" /></span><span class="image-choices-choice-text">${2}</span></label>', $choice_markup);
			}
			else {
				$choice_markup = str_replace('<label', '<label data-img="'.$img.'"', $choice_markup);
			}
			return $choice_markup;
		}

		return $choice_markup;
	}


	/**
	 * Add custom messages after plugin row based on license status
	 */

	public function gf_plugin_row($plugin_file='', $plugin_data=array(), $status='') {
		$row = array();
		$license_key = trim($this->get_plugin_setting('gf_image_choices_license_key'));
		$license_status = get_option('gf_image_choices_license_status', '');
		if (empty($license_key) || empty($license_status)) {
			$row = array(
				'<tr class="plugin-update-tr">',
					'<td colspan="3" class="plugin-update gf_image_choices-plugin-update">',
						'<div class="update-message">',
							'<a href="' . admin_url('admin.php?page=gf_settings&subview=' . $this->_slug) . '">Activate</a> your license to receive plugin updates and support. Need a license key? <a href="' . $this->_url . '" target="_blank">Purchase one now</a>.',
						'</div>',
						'<style type="text/css">',
						'.plugin-update.gf_image_choices-plugin-update .update-message:before {',
							'content: "\f348";',
							'margin-top: 0;',
							'font-family: dashicons;',
							'font-size: 20px;',
							'position: relative;',
							'top: 5px;',
							'color: orange;',
							'margin-right: 8px;',
						'}',
						'.plugin-update.gf_image_choices-plugin-update {',
							'background-color: #fff6e5;',
						'}',
						'.plugin-update.gf_image_choices-plugin-update .update-message {',
							'margin: 0 20px 6px 40px !important;',
							'line-height: 28px;',
						'}',
						'</style>',
					'</td>',
				'</tr>'
			);
		}
		elseif(!empty($license_key) && $license_status != 'valid') {
			$row = array(
				'<tr class="plugin-update-tr">',
					'<td colspan="3" class="plugin-update gf_image_choices-plugin-update">',
						'<div class="update-message">',
							'Your license is invalid or expired. <a href="'.admin_url('admin.php?page=gf_settings&subview='.$this->_slug).'">Enter valid license key</a> or <a href="'.$this->_url.'" target="_blank">purchase a new one</a>.',
							'<style type="text/css">',
								'.plugin-update.gf_image_choices-plugin-update .update-message:before {',
									'content: "\f348";',
									'margin-top: 0;',
									'font-family: dashicons;',
									'font-size: 20px;',
									'position: relative;',
									'top: 5px;',
									'color: #d54e21;',
									'margin-right: 8px;',
								'}',
								'.plugin-update.gf_image_choices-plugin-update {',
									'background-color: #ffe5e5;',
								'}',
								'.plugin-update.gf_image_choices-plugin-update .update-message {',
									'margin: 0 20px 6px 40px !important;',
									'line-height: 28px;',
								'}',
							'</style>',
						'</div>',
					'</td>',
				'</tr>'
			);
		}

		echo implode('', $row);
	}



	/**
	 * Determine if the license key is valid so the appropriate icon can be displayed next to the field.
	 *
	 * @param string $value The current value of the license_key field.
	 * @param array $field The field properties.
	 *
	 * @return bool|null
	 */
	public function license_feedback( $value, $field ) {
		if ( empty( $value ) ) {
			return null;
		}

		// Send the remote request to check the license is valid
		$license_data = $this->perform_edd_license_request( 'check_license', $value );

		$valid = null;
		if ( empty( $license_data ) || $license_data->license == 'invalid' ) {
			$valid = false;
		}
		elseif ( $license_data->license == 'valid' ) {
			$valid = true;
		}

		if (!empty($license_data) && property_exists($license_data, 'license')) {
			update_option('gf_image_choices_license_status', $license_data->license);
		}

		return $valid;
	}


	/**
	 * Handle license key activation or deactivation.
	 *
	 * @param array $field The field properties.
	 * @param string $field_setting The submitted value of the license_key field.
	 */
	public function license_validation( $field, $field_setting ) {
		$old_license = $this->get_plugin_setting( 'gf_image_choices_license_key' );

		if ( $old_license && $field_setting != $old_license ) {
			// Send the remote request to deactivate the old license
			$response = $this->perform_edd_license_request( 'deactivate_license', $old_license );
			if ( property_exists($response, 'license') && $response->license == 'deactivated' ) {
				delete_option('gf_image_choices_license_status');
			}
		}

		if ( ! empty( $field_setting ) ) {
			// Send the remote request to activate the new license
			$response = $this->perform_edd_license_request( 'activate_license', $field_setting );
			if ( property_exists($response, 'license') ) {
				update_option('gf_image_choices_license_status', $response->license);
			}
		}
	}


	/**
	 * Send a request to the EDD store url.
	 *
	 * @param string $edd_action The action to perform (check_license, activate_license or deactivate_license).
	 * @param string $license The license key.
	 *
	 * @return object
	 */
	public function perform_edd_license_request( $edd_action, $license ) {
		// Prepare the request arguments
		$args = array(
			'timeout' => GFIC_TIMEOUT,
			'sslverify' => GFIC_SSL_VERIFY,
			'body' => array(
				'edd_action' => $edd_action,
				'license' => trim($license),
				'item_name' => urlencode(GFIC_NAME),
				'url' => home_url(),
			)
		);

		// Send the remote request
		$response = wp_remote_post(GFIC_HOME, $args);

		return json_decode( wp_remote_retrieve_body( $response ) );
	}


	public function debug_output($data = '', $background='black', $color='white') {
		echo '<pre style="padding:20px; background:'.$background.'; color:'.$color.';">';
			print_r($data);
		echo '</pre>';
	}


} // end class
