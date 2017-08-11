<?php
class WC_Product_Review_Sorting_Frontend {

	public function __construct() {
		//enqueue scripts
		add_action('wp_enqueue_scripts', array(&$this, 'frontend_scripts'));
		//enqueue styles
		add_action('wp_enqueue_scripts', array(&$this, 'frontend_styles'));

		//override single product template file
		add_filter('comments_template', array(&$this, 'override_single_product_review'), 100, 1);
	}

	function frontend_scripts() {
		global $WC_Product_Review_Sorting;
		$frontend_script_path = $WC_Product_Review_Sorting->plugin_url . 'assets/frontend/js/';
		
		// Enqueue your frontend javascript from here
		wp_enqueue_script( 'frontend_js_rating_sort', $frontend_script_path.'frontend.js', array('jquery'), $WC_Product_Review_Sorting->version, true);
	}

	function frontend_styles() {
		global $WC_Product_Review_Sorting;
		$frontend_style_path = $WC_Product_Review_Sorting->plugin_url . 'assets/frontend/css/';

		// Enqueue your frontend stylesheet from here
		wp_enqueue_style('frontend_css_rating_sort', $frontend_style_path.'frontend.css', array(), $WC_Product_Review_Sorting->version);
	}
	
	function override_single_product_review( $template ) {
		global $WC, $WC_Product_Review_Sorting;
		
		if ( get_post_type() !== 'product' ) {
			return $template;
		}
		
		$wc_product_review_sorting_settings = get_option('dc_wc_product_review_sorting_general_settings_name');
		
		if( $wc_product_review_sorting_settings ) {
			if( array_key_exists( 'is_enable', $wc_product_review_sorting_settings ) && $wc_product_review_sorting_settings['is_enable'] == 'Enable' ) {
				if( version_compare( get_option( 'woocommerce_db_version' ), '2.3.2', '>=' ) ) {
					if ( get_post_type() == "product" && file_exists( $WC_Product_Review_Sorting->plugin_path . "/templates/woocommerce-2.3/single-product-reviews.php" ) ) {
						return $WC_Product_Review_Sorting->plugin_path . "/templates/woocommerce-2.3/single-product-reviews.php";
					}
				} else if( version_compare( get_option( 'woocommerce_db_version' ), '2.1', '>=' ) ) {
					if ( get_post_type() == "product" && file_exists( $WC_Product_Review_Sorting->plugin_path . "/templates/woocommerce/single-product-reviews.php" ) ) {
						return $WC_Product_Review_Sorting->plugin_path . "/templates/woocommerce/single-product-reviews.php";
					}
				}
			}
		}
		return $template;
		
	}

}
