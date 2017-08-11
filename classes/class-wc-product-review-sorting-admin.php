<?php
class WC_Product_Review_Sorting_Admin {
  
  public $settings;

	public function __construct() {
		//admin script and style
		add_action('admin_enqueue_scripts', array(&$this, 'enqueue_admin_script'));
		
		add_action('wc_product_review_sorting_dualcube_admin_footer', array(&$this, 'dualcube_admin_footer_for_wc_product_review_sorting'));

		$this->load_class('settings');
		$this->settings = new WC_Product_Review_Sorting_Settings();
	}

	function load_class($class_name = '') {
	  global $WC_Product_Review_Sorting;
		if ('' != $class_name) {
			require_once ($WC_Product_Review_Sorting->plugin_path . '/admin/class-' . esc_attr($WC_Product_Review_Sorting->token) . '-' . esc_attr($class_name) . '.php');
		} // End If Statement
	}// End load_class()
	
	function dualcube_admin_footer_for_wc_product_review_sorting() {
    global $WC_Product_Review_Sorting;
    ?>
    <div style="clear: both"></div>
    <div id="dc_admin_footer">
      <?php _e('Powered by', $WC_Product_Review_Sorting->text_domain); ?> <a href="http://dualcube.com" target="_blank"><img src="<?php echo $WC_Product_Review_Sorting->plugin_url.'/assets/images/dualcube.png'; ?>"></a><?php _e('Dualcube', $WC_Product_Review_Sorting->text_domain); ?> &copy; <?php echo date('Y');?>
    </div>
    <?php
	}

	/**
	 * Admin Scripts
	 */
	public function enqueue_admin_script() {
		global $WC_Product_Review_Sorting;
		$screen = get_current_screen();
		
		// Enqueue admin script and stylesheet from here
		if (in_array( $screen->id, array( 'woocommerce_page_wc-product-review-sorting-setting-admin' ))) :
			$WC_Product_Review_Sorting->library->load_qtip_lib();
		  wp_enqueue_script('admin_js', $WC_Product_Review_Sorting->plugin_url.'assets/admin/js/admin.js', array('jquery'), $WC_Product_Review_Sorting->version, true);
		  wp_enqueue_style('admin_css',  $WC_Product_Review_Sorting->plugin_url.'assets/admin/css/admin.css', array(), $WC_Product_Review_Sorting->version);
	  endif;
	}
}