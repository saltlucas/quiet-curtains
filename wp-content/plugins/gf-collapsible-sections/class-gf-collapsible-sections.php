<?php

//------------------------------------------

GFForms::include_addon_framework();

class GFCollapsibleSections extends GFAddOn {

	protected $_version = GFCS_VERSION;
	protected $_min_gravityforms_version = '2.0';

	protected $_slug = GFCS_SLUG;
	protected $_path = 'gf-collapsible-sections/gf-collapsible-sections.php';
	protected $_full_path = __FILE__;
	protected $_title = GFCS_NAME;
	protected $_short_title = 'Collapsible Sections';
	protected $_url = 'https://jetsloth.com/gravity-forms-collapsible-sections/';

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
	 * @return GFCollapsibleSections
	 */
	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new GFCollapsibleSections();
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
		add_action( 'gform_field_css_class', array( $this, 'add_custom_field_class' ), 10, 3 );
		add_action( 'gform_pre_render', array( $this, 'add_custom_form_class' ), 10, 3 );

		add_filter('gform_register_init_scripts', array( $this, 'load_custom_css' ), 20, 4);// init later than Image Choices to avoid errors with dupe includes (eg php-html-css-js-minifier.php)

		parent::init();

	}

	/**
	 * Initialize the admin specific hooks.
	 */
	public function init_admin() {

		// form editor
		add_filter( 'gform_tooltips', array( $this, 'add_collapsible_sections_field_tooltips' ) );

		$name = plugin_basename($this->_path);
		add_action( 'after_plugin_row_'.$name, array( $this, 'gf_plugin_row' ), 10, 2 );

		parent::init_admin();

	}

	/**
	 * The Collapsible Sections add-on does not support logging.
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

		$gf_collapsible_sections_js_deps = array( 'jquery' );
		if ( wp_is_mobile() ) {
			$gf_collapsible_sections_js_deps[] = 'jquery-touch-punch';
		}

		$scripts = array(
				array(
						'handle'   => 'gf_collapsible_sections_form_editor_js',
						'src'      => $this->get_base_url() . '/js/gf_collapsible_sections_form_editor.js',
						'version'  => $this->_version,
						'deps'     => $gf_collapsible_sections_js_deps,
						'callback' => array( $this, 'localize_scripts' ),
						'enqueue'  => array(
								array( 'admin_page' => array( 'form_editor', 'plugin_settings', 'form_settings' ) ),
						),
				),
				array(
						'handle'   => 'jetsloth_ace_editor',
						'src'      => $this->get_base_url() . '/lib/ace/ace.js',
						'deps'     => $gf_collapsible_sections_js_deps,
						'enqueue'  => array(
								array( 'admin_page' => array( 'plugin_settings', 'form_settings' ) ),
						),
				),
				array(
						'handle'  => 'gf_collapsible_sections_js',
						'src'     => $this->get_base_url() . '/js/gf_collapsible_sections.js',
						'version' => $this->_version,
						'deps'    => $gf_collapsible_sections_js_deps,
						'enqueue' => array(
								array( 'admin_page' => array( 'form_editor' ) ),
								array( 'field_types' => array( 'section' ) ),
						),
				),
		);

		$all_scripts = array_merge( parent::scripts(), $scripts );

		return $all_scripts;
	}

	/**
	 * Return the stylesheets which should be enqueued.
	 *
	 * @return array
	 */
	public function styles() {

		$styles = array(
				array(
						'handle'  => 'gf_collapsible_sections_form_editor_css',
						'src'     => $this->get_base_url() . '/css/gf_collapsible_sections_form_editor.css',
						'version' => $this->_version,
						'enqueue' => array(
								array( 'admin_page' => array( 'form_editor', 'plugin_settings', 'form_settings' ) ),
						),
				),
				array(
						'handle'  => 'slothicons_css',
						'src'     => 'https://s3-us-west-2.amazonaws.com/jetsloth/assets/slothicons.css',
						'version' => $this->_version,
						'media'   => 'screen',
						'enqueue' => array(
								array( 'field_types' => array( 'section' ) ),
						),
				),
				array(
						'handle'  => 'gf_collapsible_sections_css',
						'src'     => $this->get_base_url() . '/css/gf_collapsible_sections.css',
						'version' => $this->_version,
						'media'   => 'screen',
						'enqueue' => array(
								array( 'admin_page' => array( 'form_editor' ) ),
								array( 'field_types' => array( 'section' ) ),
						),
				),
		);

		return array_merge( parent::styles(), $styles );
	}

	function load_custom_css($form) {

		require_once( dirname( __FILE__ ) . '/inc/php-html-css-js-minifier.php' );
		$minifier = PHP_HTML_CSS_JS_Minifier::get_instance();

		$form_settings = $this->get_form_settings($form);
		if (empty($form_settings)) {
			return;
		}

		$global_css_value = $this->get_plugin_setting('gf_collapsible_sections_custom_css_global');

		$ignore_global_css_value = 0;
		if (!empty($form_settings['gf_collapsible_sections_ignore_global_css'])) {
			$ignore_global_css_value = (isset($form_settings['gf_collapsible_sections_ignore_global_css'])) ? $form_settings['gf_collapsible_sections_ignore_global_css'] : 0;
			$ignore_global_css_value_script = '(function(){ if (typeof window.gf_collapsible_sections_ignore_global_css_'.$form['id'].' === "undefined") window.gf_collapsible_sections_ignore_global_css_'.$form['id'].' = '.$ignore_global_css_value.'; })();';
			GFFormDisplay::add_init_script($form['id'], 'gf_collapsible_sections_ignore_global_css_'.$form['id'], GFFormDisplay::ON_PAGE_RENDER, $ignore_global_css_value_script);
		}

		if (empty($ignore_global_css_value) && !empty($global_css_value)) {
			$global_css_value_min = $minifier->minify_css($global_css_value);
			$global_css_script = '(function(){ if (typeof window.gf_collapsible_sections_custom_css_global === "undefined") window.gf_collapsible_sections_custom_css_global = "'.addslashes($global_css_value_min).'"; })();';
			GFFormDisplay::add_init_script($form['id'], 'gf_collapsible_sections_custom_css_global_script', GFFormDisplay::ON_PAGE_RENDER, $global_css_script);
		}

		if (!empty($form_settings['gf_collapsible_sections_custom_css'])) {
			$form_css_value = (isset($form_settings['gf_collapsible_sections_custom_css'])) ? $form_settings['gf_collapsible_sections_custom_css'] : '';
			if (!empty($form_css_value)) {
				$form_css_value_min = $minifier->minify_css($form_css_value);
				$form_css_script = '(function(){ if (typeof window.gf_collapsible_sections_custom_css_'.$form['id'].' === "undefined") window.gf_collapsible_sections_custom_css_'.$form['id'].' = "'.addslashes($form_css_value_min).'"; })();';
				GFFormDisplay::add_init_script($form['id'], 'gf_collapsible_sections_custom_css_script_'.$form['id'], GFFormDisplay::ON_PAGE_RENDER, $form_css_script);
			}
		}

		// Other settings for JS
		if (!empty($form_settings['gf_collapsible_sections_scroll_to'])) {
			$scroll_offset_value = (isset($form_settings['gf_collapsible_sections_scroll_to_offset'])) ? (int) $form_settings['gf_collapsible_sections_scroll_to_offset'] : 0;
			$scroll_offset_duration = (isset($form_settings['gf_collapsible_sections_scroll_to_duration'])) ? (int) $form_settings['gf_collapsible_sections_scroll_to_duration'] : 400;
			$form_scroll_script = '(function(){ if (typeof window.gf_collapsible_sections_scroll_to_offset_'.$form['id'].' === "undefined") window.gf_collapsible_sections_scroll_to_offset_'.$form['id'].' = '.$scroll_offset_value.'; if (typeof window.gf_collapsible_sections_scroll_to_duration_'.$form['id'].' === "undefined") window.gf_collapsible_sections_scroll_to_duration_'.$form['id'].' = '.$scroll_offset_duration.'; })();';
			GFFormDisplay::add_init_script($form['id'], 'gf_collapsible_sections_scroll_'.$form['id'], GFFormDisplay::ON_PAGE_RENDER, $form_scroll_script);
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
		wp_localize_script( 'gf_collapsible_sections_form_editor_js', 'collapsibleSectionsFieldVars', $params );

		//localize strings for the js file
		$strings = array(
			'toggle' => esc_html__( 'Make this section collapsible', GFCS_TEXT_DOMAIN ),
			'toggleNone' => esc_html__( 'None (normal section)', GFCS_TEXT_DOMAIN ),
			'toggleStart' => esc_html__( 'Start collapsible section', GFCS_TEXT_DOMAIN ),
			'toggleEnd' => esc_html__( 'End previous collapsible section', GFCS_TEXT_DOMAIN ),
			'toggleEndDescription' => esc_html__( 'If selected, the field before this will be the last within a collapsible section and any fields from this one will appear outside.', GFCS_TEXT_DOMAIN ),

			'endSectionDisplay' => esc_html__( 'Display setting for this field', GFCS_TEXT_DOMAIN ),
			'endSectionDisplayDefault' => esc_html__( 'Show (normal section)', GFCS_TEXT_DOMAIN ),
			'endSectionDisplayHidden' => esc_html__( 'Hide (will purely be used to end previous collapsible section)', GFCS_TEXT_DOMAIN ),

			'descriptionPlacement' => esc_html__( 'Collapsible section description placement', GFCS_TEXT_DOMAIN ),
			'descriptionPlacementForm' => esc_html__( 'Use Form Setting', GFCS_TEXT_DOMAIN ),
			'descriptionPlacementInside' => esc_html__( 'Inside section', GFCS_TEXT_DOMAIN ),
			'descriptionPlacementTitle' => esc_html__( 'Below title', GFCS_TEXT_DOMAIN ),
			'showDescriptionInside' => esc_html__( 'Show description inside', GFCS_TEXT_DOMAIN ),
			'showDescriptionInsideText' => esc_html__( 'With this setting, the field description will be displayed inside the collapsible section and only visible when expanded.', GFCS_TEXT_DOMAIN )
		);
		wp_localize_script( 'gf_collapsible_sections_form_editor_js', 'collapsibleSectionsFieldStrings', $strings );

	}


	/**
	 * Creates a settings page for this add-on.
	 */
	public function plugin_settings_fields() {

		$license = $this->get_plugin_setting('gf_collapsible_sections_license_key');
		$status = get_option('gf_collapsible_sections_license_status');

		$license_field = array(
			'name' => 'gf_collapsible_sections_license_key',
			'tooltip' => esc_html__('Enter the license key you received after purchasing the plugin.', GFCS_TEXT_DOMAIN),
			'label' => esc_html__('License Key', GFCS_TEXT_DOMAIN),
			'type' => 'text',
			'input_type' => 'password',
			'class' => 'medium',
			'default_value' => '',
			'validation_callback' => array($this, 'license_validation'),
			'feedback_callback' => array($this, 'license_feedback'),
			'error_message' => esc_html__( 'Invalid license', GFCS_TEXT_DOMAIN ),
		);

		if (!empty($license) && !empty($status)) {
			$license_field['after_input'] = ($status == 'valid') ? ' License is valid' : ' Invalid or expired license';
		}

		$custom_css_global_value = $this->get_plugin_setting('gf_collapsible_sections_custom_css_global');
		$custom_css_global_field = array(
			'name' => 'gf_collapsible_sections_custom_css_global',
			'tooltip' => esc_html__('These styles will be loaded for all forms.<br/>Find examples at <a href="https://jetsloth.com/support/gravity-forms-collapsible-sections/">https://jetsloth.com/support/gravity-forms-collapsible-sections/</a>', GFCS_TEXT_DOMAIN),
			'label' => esc_html__('Custom CSS', GFCS_TEXT_DOMAIN),
			'type' => 'textarea',
			'class' => 'large',
			'default_value' => $custom_css_global_value
		);

		$fields = array(
			array(
				'title'  => esc_html__('To unlock plugin updates, please enter your license key below', GFCS_TEXT_DOMAIN),
				'fields' => array(
					$license_field
				)
			),
			array(
				'title'  => esc_html__('Enter your own css to style Collapsible Sections', GFCS_TEXT_DOMAIN),
				'fields' => array(
					$custom_css_global_field
				)
			)
		);

		return $fields;
	}

	/**
	 * Configures the settings which should be rendered on the Form Settings > Collapsible Sections tab.
	 *
	 * @return array
	 */
	public function form_settings_fields( $form ) {

		$settings = $this->get_form_settings( $form );

		$form_collapsible_description_placement_value = (isset($settings['gf_collapsible_sections_description_placement'])) ? $settings['gf_collapsible_sections_description_placement'] : '';
		$form_collapsible_description_placement_field = array(
			'name' => 'gf_collapsible_sections_description_placement',
			//'tooltip' => esc_html__('The selected collapsible section will be opened by default when the form loads.', GFCS_TEXT_DOMAIN),
			'label' => esc_html__('Description placement', GFCS_TEXT_DOMAIN),
			'type' => 'select',
			'class' => 'medium',
			'default_value' => 'title',
			'choices' => array(
				array(
					'value' => 'inside',
					'label' => esc_html__('Inside section', GFCS_TEXT_DOMAIN)
				),
				array(
					'value' => 'title',
					'label' => esc_html__('Below title', GFCS_TEXT_DOMAIN)
				)
			)
		);
		if (!empty($form_collapsible_description_placement_value)) {
			$form_collapsible_description_placement_field['default_value'] = $form_collapsible_description_placement_value;
		}

		$form_force_single_opens_value = (isset($settings['gf_collapsible_sections_force_single_opens']) && $settings['gf_collapsible_sections_force_single_opens'] == 1) ? 1 : 0;
		$form_force_single_opens_field = array(
			'name' => 'gf_collapsible_sections_force_single_opens',
			'label' => 'Behaviour',
			'type' => 'checkbox',
			'choices' => array(
				array(
					'label' => esc_html__('Force only one collapsible section to be open at a time?', GFCS_TEXT_DOMAIN),
					'tooltip' => esc_html__('If checked, when a user opens a collapsible section, the other collapsible sections will automatically close.', GFCS_TEXT_DOMAIN),
					'name' => 'gf_collapsible_sections_force_single_opens'
				)
			)
		);
		if (!empty($form_force_single_opens_value)) {
			$form_force_single_opens_field['choices'][0]['default_value'] = 1;
		}

		$collapsible_sections_select_choices = array(array(
			'value' => '',
			'label' => 'None (all sections closed by default)'
		));
		$collapsible_sections_checkbox_choices = array();
		$collapsible_sections_checkbox_choices_lookup = array();
		$i = 0;
		foreach($form['fields'] as $field) {
			if ($field->type == 'section' && property_exists($field, 'collapsibleSections_enableCollapsible') && $field->collapsibleSections_enableCollapsible == 'start') {
				array_push($collapsible_sections_select_choices, array(
					'value' => $field->id,
					'label' => $field->label
				));
				$checkbox_name = 'gf_collapsible_section_open_by_default_'.$field->id;
				array_push($collapsible_sections_checkbox_choices, array(
					'name' => $checkbox_name,
					'label' => $field->label
				));
				$collapsible_sections_checkbox_choices_lookup[$checkbox_name] = $i;
				$i++;
			}
		}

		$form_sections_single_open_by_default_value = (isset($settings['gf_collapsible_sections_single_open_by_default'])) ? $settings['gf_collapsible_sections_single_open_by_default'] : array();
		$form_sections_single_open_by_default_field = array(
			'name' => 'gf_collapsible_sections_single_open_by_default',
			'tooltip' => esc_html__('The selected collapsible section will be opened by default when the form loads.', GFCS_TEXT_DOMAIN),
			'label' => esc_html__('Open by default', GFCS_TEXT_DOMAIN),
			'type' => 'select',
			'class' => 'large',
			'choices' => $collapsible_sections_select_choices
		);
		if (!empty($form_sections_single_open_by_default_value)) {
			$form_sections_single_open_by_default_field['default_value'] = $form_sections_single_open_by_default_value;
		}

		$form_sections_open_by_default_value = (isset($settings['gf_collapsible_sections_open_by_default'])) ? $settings['gf_collapsible_sections_open_by_default'] : array();
		$form_sections_open_by_default_field = array(
			'name' => 'gf_collapsible_sections_open_by_default',
			'tooltip' => esc_html__('The selected collapsible sections will be opened by default when the form loads.', GFCS_TEXT_DOMAIN),
			'label' => esc_html__('Open by default', GFCS_TEXT_DOMAIN),
			'type' => 'checkbox',
			'choices' => $collapsible_sections_checkbox_choices
		);
		if (!empty($form_sections_open_by_default_value)) {
			foreach($form_sections_open_by_default_value as $value) {
				$choice_index = (isset($collapsible_sections_checkbox_choices_lookup[$value])) ? $collapsible_sections_checkbox_choices_lookup[$value] : -1;
				if ($choice_index != -1) {
					$form_sections_open_by_default_field['choices'][$choice_index]['default_value'] = 1;
				}
			}
		}

		$form_scroll_to_value = (isset($settings['gf_collapsible_sections_scroll_to']) && !empty($settings['gf_collapsible_sections_scroll_to'])) ? 1 : 0;
		$form_scroll_to_field = array(
			'name' => 'gf_collapsible_sections_scroll_to',
			'label' => 'Scrolling',
			'type' => 'checkbox',
			'choices' => array(
				array(
					'label' => esc_html__('Automatically scroll to top of opened sections?', GFCS_TEXT_DOMAIN),
					'tooltip' => esc_html__('If checked, when a user clicks to open a collapsible section, the page will scroll to the top of that section.', GFCS_TEXT_DOMAIN),
					'name' => 'gf_collapsible_sections_scroll_to'
				)
			)
		);
		$form_scroll_to_field['choices'][0]['default_value'] = $form_scroll_to_value;

		$form_scroll_to_offset_value = (isset($settings['gf_collapsible_sections_scroll_to_offset'])) ? $settings['gf_collapsible_sections_scroll_to_offset'] : '';
		$form_scroll_to_offset_field = array(
			'name' => 'gf_collapsible_sections_scroll_to_offset',
			'tooltip' => esc_html__('If you want to offset the scroll top (eg if you have a fixed header) set the offset amount here.', GFCS_TEXT_DOMAIN),
			'label' => esc_html__('Scroll top offset (px)', GFCS_TEXT_DOMAIN),
			'type' => 'text',
			'class' => 'small'
		);
		if (!empty($form_scroll_to_offset_value)) {
			$form_scroll_to_offset_field['default_value'] = $form_scroll_to_offset_value;
		}

		$form_scroll_to_duration_value = (isset($settings['gf_collapsible_sections_scroll_to_duration'])) ? $settings['gf_collapsible_sections_scroll_to_duration'] : 400;
		$form_scroll_to_duration_field = array(
			'name' => 'gf_collapsible_sections_scroll_to_duration',
			'label' => esc_html__('Scroll duration (milliseconds)', GFCS_TEXT_DOMAIN),
			'type' => 'text',
			'default_value' => 0,
			'class' => 'small'
		);
		if (!empty($form_scroll_to_duration_value)) {
			$form_scroll_to_duration_field['default_value'] = $form_scroll_to_duration_value;
		}


		$form_collapsible_footer_placement_value = (isset($settings['gf_collapsible_sections_footer_placement'])) ? $settings['gf_collapsible_sections_footer_placement'] : '';
		$form_collapsible_footer_placement_field = array(
			'name' => 'gf_collapsible_sections_footer_placement',
			//'tooltip' => esc_html__('The selected collapsible section will be opened by default when the form loads.', GFCS_TEXT_DOMAIN),
			'label' => esc_html__('Form footer placement', GFCS_TEXT_DOMAIN),
			'type' => 'select',
			'class' => 'medium',
			'default_value' => 'after_last',
			'choices' => array(
				array(
					'value' => 'after_last',
					'label' => esc_html__('After last section', GFCS_TEXT_DOMAIN)
				),
				array(
					'value' => 'inside_last',
					'label' => esc_html__('Inside last section', GFCS_TEXT_DOMAIN)
				)
			)
		);
		if (!empty($form_collapsible_footer_placement_value)) {
			$form_collapsible_footer_placement_field['default_value'] = $form_collapsible_footer_placement_value;
		}


		$form_custom_css_value = (isset($settings['gf_collapsible_sections_custom_css'])) ? $settings['gf_collapsible_sections_custom_css'] : '';
		$form_custom_css_field = array(
			'name' => 'gf_collapsible_sections_custom_css',
			'tooltip' => esc_html__('These styles will be loaded for this form only.<br/>Find examples at <a href="https://jetsloth.com/support/gravity-forms-collapsible-sections/">https://jetsloth.com/support/gravity-forms-collapsible-sections/</a>', GFCS_TEXT_DOMAIN),
			'label' => esc_html__('Custom CSS', GFCS_TEXT_DOMAIN),
			'type' => 'textarea',
			'class' => 'large',
			'default_value' => $form_custom_css_value
		);

		$form_ignore_global_css_value = (isset($settings['gf_collapsible_sections_ignore_global_css']) && $settings['gf_collapsible_sections_ignore_global_css'] == 1) ? 1 : 0;
		$form_ignore_global_css_field = array(
			'name' => 'gf_collapsible_sections_ignore_global_css',
			'label' => '',
			'type' => 'checkbox',
			'choices' => array(
				array(
					'label' => esc_html__('Ignore Global Custom CSS for this form?', GFCS_TEXT_DOMAIN),
					'tooltip' => esc_html__('If checked, the custom css entered in the global settings won\'t be loaded for this form.', GFCS_TEXT_DOMAIN),
					'name' => 'gf_collapsible_sections_ignore_global_css'
				)
			)
		);
		if (!empty($form_ignore_global_css_value)) {
			$form_ignore_global_css_field['choices'][0]['default_value'] = 1;
		}

		return array(
			array(
				'title' => esc_html__( 'Collapsible Sections', GFCS_TEXT_DOMAIN ),
				'fields' => array(
					$form_collapsible_description_placement_field,
					$form_force_single_opens_field,
					$form_sections_single_open_by_default_field,
					$form_sections_open_by_default_field,
					$form_scroll_to_field,
					$form_scroll_to_offset_field,
					$form_scroll_to_duration_field,
					$form_collapsible_footer_placement_field,
					$form_custom_css_field,
					$form_ignore_global_css_field
				)
			)
		);

	}



	/**
	 * Add custom class(es) to the section collapsible section fields
	 *
	 * @param string $classes The CSS classes to be filtered, separated by empty spaces.
	 * @param GF_Field $field The field currently being processed.
	 * @param array $form The form currently being processed.
	 *
	 * @return string
	 */
	public function add_custom_field_class( $classes, $field, $form ) {
		if ($field->type == 'section') {
			$settings = $this->get_form_settings( $form );

			if ( property_exists($field, 'collapsibleSections_enableCollapsible') && $field->collapsibleSections_enableCollapsible != 'none' ) {
				if (GFCommon::is_form_editor()) {
					$classes .= ' collapsible-sections-admin-field ';
				}
				else if ($field->collapsibleSections_enableCollapsible == 'end') {
					$classes .= ' collapsible-sections-end-field ';
				}
				else {
					$classes .= ' collapsible-sections-field ';
				}

				if ($field->collapsibleSections_enableCollapsible == 'start') {
					$description_placement = ( property_exists($field, 'collapsibleSections_descriptionPlacement') && !empty($field->collapsibleSections_descriptionPlacement) ) ? $field->collapsibleSections_descriptionPlacement : 'form_setting';
					if ($description_placement == 'form_setting') {
						$description_placement = (isset($settings['gf_collapsible_sections_description_placement'])) ? $settings['gf_collapsible_sections_description_placement'] : 'title';
					}
					$classes .= 'collapsible-sections-description-'.$description_placement.' ';

					$force_single_opens = (isset($settings['gf_collapsible_sections_force_single_opens']) && $settings['gf_collapsible_sections_force_single_opens'] == 1) ? 1 : 0;
					if (!empty($force_single_opens)) {
						// single opened by default only
						$section_open_by_default = (isset($settings['gf_collapsible_sections_single_open_by_default']) && !empty($settings['gf_collapsible_sections_single_open_by_default']) ) ? $settings['gf_collapsible_sections_single_open_by_default'] : 0;
						if (!empty($section_open_by_default) && $section_open_by_default == $field->id) {
							$classes .= 'collapsible-sections-open ';
						}
					}
					else if (!empty($settings)) {
						// multiples can be opened by default, see if this field is in the list
						foreach($settings as $setting_key => $setting_value) {
							if (strpos($setting_key, 'gf_collapsible_section_open_by_default_') !== FALSE) {
								$setting_field_id = (int) str_replace('gf_collapsible_section_open_by_default_', '', $setting_key);
								if ($setting_field_id == $field->id && !empty($setting_value)) {
									$classes .= 'collapsible-sections-open ';
									break;
								}
							}
						}
					}
				}
				else if ($field->collapsibleSections_enableCollapsible == 'end') {

					$end_section_display = ( property_exists($field, 'collapsibleSections_endSectionDisplay') && !empty($field->collapsibleSections_endSectionDisplay) ) ? $field->collapsibleSections_endSectionDisplay : 'default';
					if ($end_section_display == 'hidden') {
						$classes .= 'collapsible-sections-end-field-hidden ';
					}

				}

			}
		}

		return $classes;
	}


	/**
	 * Add custom class(es) to the form
	 *
	 * @param array $form The form currently being processed.
	 *
	 * @return array
	 */

	public function add_custom_form_class( $form ) {
		if (empty($form['cssClass'])) {
			$form['cssClass'] = '';
		}

		$has_collapsible_sections = false;
		foreach($form['fields'] as $field) {
			if ( property_exists($field, 'collapsibleSections_enableCollapsible') && $field->collapsibleSections_enableCollapsible == 'start' ) {
				$has_collapsible_sections = true;
				break;
			}
		}

		if ($has_collapsible_sections) {
			$form['cssClass'] .= (empty($form['cssClass'])) ? 'form-has-collapsible-sections ' : ' form-has-collapsible-sections ';

			$settings = $this->get_form_settings( $form );
			$force_single_opens = (isset($settings['gf_collapsible_sections_force_single_opens']) && $settings['gf_collapsible_sections_force_single_opens'] == 1) ? 1 : 0;
			if (!empty($force_single_opens)) {
				$form['cssClass'] .= (empty($form['cssClass'])) ? 'collapsible-sections-single-opens ' : ' collapsible-sections-single-opens ';
			}

			$form_collapsible_description_placement_value = (isset($settings['gf_collapsible_sections_description_placement'])) ? $settings['gf_collapsible_sections_description_placement'] : '';
			if (!empty($form_collapsible_description_placement_value)) {
				$form['cssClass'] .= (empty($form['cssClass'])) ? 'collapsible-sections-description-'.$form_collapsible_description_placement_value.' ' : ' collapsible-sections-description-'.$form_collapsible_description_placement_value.' ';
			}

			$form_collapsible_scroll_value = (isset($settings['gf_collapsible_sections_scroll_to'])) ? $settings['gf_collapsible_sections_scroll_to'] : 0;
			if (!empty($form_collapsible_scroll_value)) {
				$form['cssClass'] .= (empty($form['cssClass'])) ? 'collapsible-sections-scrollto ' : ' collapsible-sections-scrollto ';
			}

			$form_collapsible_footer_placement_value = (isset($settings['gf_collapsible_sections_footer_placement'])) ? $settings['gf_collapsible_sections_footer_placement'] : 'after_last';
			$form['cssClass'] .= (empty($form['cssClass'])) ? 'collapsible-sections-footer-'.$form_collapsible_footer_placement_value.' ' : ' collapsible-sections-footer-'.$form_collapsible_footer_placement_value.' ';

		}

		return $form;
	}

	/**
	 * Add the tooltips for the field.
	 *
	 * @param array $tooltips An associative array of tooltips where the key is the tooltip name and the value is the tooltip.
	 *
	 * @return array
	 */
	public function add_collapsible_sections_field_tooltips( $tooltips ) {
		$tooltips['collapsible_sections_show_description_inside'] = '<h6>' . esc_html__( 'Show description inside', GFCS_TEXT_DOMAIN ) . '</h6>' . esc_html__( 'Show the field description inside the collapsible section, only visible when expanded.', GFCS_TEXT_DOMAIN );
		return $tooltips;
	}


	/**
	 * Add custom messages after plugin row based on license status
	 */

	public function gf_plugin_row($plugin_file='', $plugin_data=array(), $status='') {
		$row = array();
		$license_key = trim($this->get_plugin_setting('gf_collapsible_sections_license_key'));
		$license_status = get_option('gf_collapsible_sections_license_status', '');
		if (empty($license_key) || empty($license_status)) {
			$row = array(
				'<tr class="plugin-update-tr">',
					'<td colspan="3" class="plugin-update gf_collapsible_sections-plugin-update">',
						'<div class="update-message">',
							'<a href="' . admin_url('admin.php?page=gf_settings&subview=' . $this->_slug) . '">Activate</a> your license to receive plugin updates and support. Need a license key? <a href="' . $this->_url . '" target="_blank">Purchase one now</a>.',
						'</div>',
						'<style type="text/css">',
							'.plugin-update.gf_collapsible_sections-plugin-update .update-message:before {',
								'content: "\f348";',
								'margin-top: 0;',
								'font-family: dashicons;',
								'font-size: 20px;',
								'position: relative;',
								'top: 5px;',
								'color: orange;',
								'margin-right: 8px;',
							'}',
							'.plugin-update.gf_collapsible_sections-plugin-update {',
								'background-color: #fff6e5;',
							'}',
							'.plugin-update.gf_collapsible_sections-plugin-update .update-message {',
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
					'<td colspan="3" class="plugin-update gf_collapsible_sections-plugin-update">',
						'<div class="update-message">',
							'Your license is invalid or expired. <a href="'.admin_url('admin.php?page=gf_settings&subview='.$this->_slug).'">Enter valid license key</a> or <a href="'.$this->_url.'" target="_blank">purchase a new one</a>.',
							'<style type="text/css">',
								'.plugin-update.gf_collapsible_sections-plugin-update .update-message:before {',
									'content: "\f348";',
									'margin-top: 0;',
									'font-family: dashicons;',
									'font-size: 20px;',
									'position: relative;',
									'top: 5px;',
									'color: #d54e21;',
									'margin-right: 8px;',
								'}',
								'.plugin-update.gf_collapsible_sections-plugin-update {',
									'background-color: #ffe5e5;',
								'}',
								'.plugin-update.gf_collapsible_sections-plugin-update .update-message {',
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
			update_option('gf_collapsible_sections_license_status', $license_data->license);
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
		$old_license = $this->get_plugin_setting( 'gf_collapsible_sections_license_key' );

		if ( $old_license && $field_setting != $old_license ) {
			// Send the remote request to deactivate the old license
			$response = $this->perform_edd_license_request( 'deactivate_license', $old_license );
			if ( property_exists($response, 'license') && $response->license == 'deactivated' ) {
				delete_option('gf_collapsible_sections_license_status');
			}
		}

		if ( ! empty( $field_setting ) ) {
			// Send the remote request to activate the new license
			$response = $this->perform_edd_license_request( 'activate_license', $field_setting );
			if ( property_exists($response, 'license') ) {
				update_option('gf_collapsible_sections_license_status', $response->license);
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
			'timeout' => GFCS_TIMEOUT,
			'sslverify' => GFCS_SSL_VERIFY,
			'body' => array(
				'edd_action' => $edd_action,
				'license' => trim($license),
				'item_name' => urlencode(GFCS_NAME),
				'url' => home_url(),
			)
		);

		// Send the remote request
		$response = wp_remote_post(GFCS_HOME, $args);

		return json_decode( wp_remote_retrieve_body( $response ) );
	}

	public function debug_output($data = '', $background='black', $color='white') {
		echo '<pre style="padding:20px; background:'.$background.'; color:'.$color.';">';
			print_r($data);
		echo '</pre>';
	}

} // end class
