<?php
class WC_Product_Review_Sorting {

	public $plugin_url;

	public $plugin_path;

	public $version;

	public $token;
	
	public $text_domain;
	
	public $library;

	public $admin;

	public $frontend;

	public $ajax;

	private $file;
	
	public $settings;
	
	public $dc_wp_fields;

	public function __construct($file) {

		$this->file = $file;
		$this->plugin_url = trailingslashit(plugins_url('', $plugin = $file));
		$this->plugin_path = trailingslashit(dirname($file));
		$this->token = WC_PRODUCT_REVIEW_SORTING_PLUGIN_TOKEN;
		$this->text_domain = WC_PRODUCT_REVIEW_SORTING_TEXT_DOMAIN;
		$this->version = WC_PRODUCT_REVIEW_SORTING_PLUGIN_VERSION;
		
		add_action('init', array(&$this, 'init'), 0);
	}
	
	/**
	 * initilize plugin on WP init
	 */
	function init() {
		
		// Init Text Domain
		$this->load_plugin_textdomain();
		
		// Init library
		$this->load_class('library');
		$this->library = new WC_Product_Review_Sorting_Library();

		// Init ajax
		if(defined('DOING_AJAX')) {
      $this->load_class('ajax');
      $this->ajax = new  WC_Product_Review_Sorting_Ajax();
    }

		if (is_admin()) {
			$this->load_class('admin');
			$this->admin = new WC_Product_Review_Sorting_Admin();
		}

		if (!is_admin() || defined('DOING_AJAX')) {
			$this->load_class('frontend');
			$this->frontend = new WC_Product_Review_Sorting_Frontend();
			
		}

		// DC Wp Fields
		$this->dc_wp_fields = $this->library->load_wp_fields();
	}
	
	/**
   * Load Localisation files.
   *
   * Note: the first-loaded translation file overrides any following ones if the same translation is present
   *
   * @access public
   * @return void
   */
  public function load_plugin_textdomain() {
    $locale = apply_filters( 'plugin_locale', get_locale(), $this->token );

    load_textdomain( $this->text_domain, WP_LANG_DIR . "/wc-product-review-sorting/wc-product-review-sorting-$locale.mo" );
    load_textdomain( $this->text_domain, $this->plugin_path . "/languages/wc-product-review-sorting-$locale.mo" );
  }

	public function load_class($class_name = '') {
		if ('' != $class_name && '' != $this->token) {
			require_once ('class-' . esc_attr($this->token) . '-' . esc_attr($class_name) . '.php');
		} // End If Statement
	}// End load_class()
	
	/** Cache Helpers *********************************************************/

	/**
	 * Sets a constant preventing some caching plugins from caching a page. Used on dynamic pages
	 *
	 * @access public
	 * @return void
	 */
	function nocache() {
		if (!defined('DONOTCACHEPAGE'))
			define("DONOTCACHEPAGE", "true");
		// WP Super Cache constant
	}

}
