<?php
class WC_Product_Review_Sorting_Library {
  
  public $lib_path;
  
  public $lib_url;
  
  public $php_lib_path;
  
  public $php_lib_url;
  
	public function __construct() {
		global $WC_Product_Review_Sorting;
		
		$this->lib_path = $WC_Product_Review_Sorting->plugin_path . 'lib/';
  	
  	$this->lib_url = $WC_Product_Review_Sorting->plugin_url . 'lib/';
  	
  	$this->php_lib_path = $this->lib_path . 'php/';
  	
  	$this->php_lib_url = $this->lib_url . 'php/';
  	
  	$this->jquery_lib_path = $this->lib_path . 'jquery/';
    
    $this->jquery_lib_url = $this->lib_url . 'jquery/';
	}
	
	/**
	 * PHP WP fields Library
	 */
	public function load_wp_fields() {
	  global $WC_Product_Review_Sorting;
	  if ( ! class_exists( 'DC_WP_Fields' ) )
	    require_once ($this->php_lib_path . 'class-dc-wp-fields.php');
	  $DC_WP_Fields = new DC_WP_Fields(); 
	  return $DC_WP_Fields;
	}
	
	/**
	 * Jquery qTip library
	 */
	public function load_qtip_lib() {
	  global $WC_Product_Review_Sorting;
	  wp_enqueue_script('qtip_js', $this->jquery_lib_url . 'qtip/qtip.js', array('jquery'), $WC_Product_Review_Sorting->version, true);
		wp_enqueue_style('qtip_css',  $this->jquery_lib_url . 'qtip/qtip.css', array(), $WC_Product_Review_Sorting->version);
	}
}
