<?php
class WC_Product_Review_Sorting_Settings_Gneral {
  /**
   * Holds the values to be used in the fields callbacks
   */
  private $options;
  
  private $tab;

  /**
   * Start up
   */
  public function __construct($tab) {
    $this->tab = $tab;
    $this->options = get_option( "dc_{$this->tab}_settings_name" );
    $this->settings_page_init();
  }
  
  /**
   * Register and add settings
   */
  public function settings_page_init() {
    global $WC_Product_Review_Sorting;
    
    $settings_tab_options = array("tab" => "{$this->tab}",
                                  "ref" => &$this,
                                  "sections" => array(
                                                      "default_settings_section" => array("title" =>  __('Plugin Activation', $WC_Product_Review_Sorting->text_domain), // Section one
                                                                                         "fields" => array("is_enable" => array('title' => __('Enable Review Sorting Plugin', $WC_Product_Review_Sorting->text_domain), 'type' => 'checkbox', 'id' => 'is_enable', 'label_for' => 'is_enable', 'name' => 'is_enable', 'value' => 'Enable'), // Checkbox
                                                                                                           )
                                                                                         ), 
                                  										"rating_settings_section" => array("title" =>  __('Rating Dropdown Text', $WC_Product_Review_Sorting->text_domain), // Section two
                                                                                         "fields" => array( "rating_5" => array('title' => __('Label For 5 stars ratings', $WC_Product_Review_Sorting->text_domain), 'type' => 'text', 'hints' => __('Enter your own label for 5 star', $WC_Product_Review_Sorting->text_domain), 'desc' => __('Default: "5 Stars"', $WC_Product_Review_Sorting->text_domain)), // Text
                                                                                         	 									"rating_4" => array('title' => __('Label For 4 stars ratings', $WC_Product_Review_Sorting->text_domain), 'type' => 'text', 'hints' => __('Enter your own label for 4 star', $WC_Product_Review_Sorting->text_domain), 'desc' => __('Default: "4 Stars"', $WC_Product_Review_Sorting->text_domain)), // Text
                                                                                         	 									"rating_3" => array('title' => __('Label For 3 stars ratings', $WC_Product_Review_Sorting->text_domain), 'type' => 'text', 'hints' => __('Enter your own label for 3 star', $WC_Product_Review_Sorting->text_domain), 'desc' => __('Default: "3 Stars"', $WC_Product_Review_Sorting->text_domain)), // Text
                                                                                         	 									"rating_2" => array('title' => __('Label For 2 stars ratings', $WC_Product_Review_Sorting->text_domain), 'type' => 'text', 'hints' => __('Enter your own label for 2 star', $WC_Product_Review_Sorting->text_domain), 'desc' => __('Default: "2 Stars"', $WC_Product_Review_Sorting->text_domain)), // Text
                                                                                         	 									"rating_1" => array('title' => __('Label For 1 stars ratings', $WC_Product_Review_Sorting->text_domain), 'type' => 'text', 'hints' => __('Enter your own label for 1 star', $WC_Product_Review_Sorting->text_domain), 'desc' => __('Default: "1 Stars"', $WC_Product_Review_Sorting->text_domain)), // Text
                                                                                                           )
                                                                                         ),
                                                      "time_settings_section" => array("title" =>  __('Date Dropdown Text', $WC_Product_Review_Sorting->text_domain), // Section three
                                                                                         "fields" => array( "newest" => array('title' => __('Label For Newest reviews', $WC_Product_Review_Sorting->text_domain), 'type' => 'text', 'hints' => __('Enter your own label for newest reviews first', $WC_Product_Review_Sorting->text_domain), 'desc' => __('Default: "Newest"', $WC_Product_Review_Sorting->text_domain)), // Text
                                                                                         	 									"oldest" => array('title' => __('Label For Oldest reviews', $WC_Product_Review_Sorting->text_domain), 'type' => 'text', 'hints' => __('Enter your own label for oldest reviews first', $WC_Product_Review_Sorting->text_domain), 'desc' => __('Default: "Oldest"', $WC_Product_Review_Sorting->text_domain)), // Text
                                                                                                           )
                                                                                         ),
                                                      )
                                  );
    
    $WC_Product_Review_Sorting->admin->settings->settings_field_init(apply_filters("settings_{$this->tab}_tab_options", $settings_tab_options));
  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  public function dc_wc_product_review_sorting_general_settings_sanitize( $input ) {
    global $WC_Product_Review_Sorting;
    $new_input = array();
    
    if( isset( $input['is_enable'] ) )
      $new_input['is_enable'] = sanitize_text_field( $input['is_enable'] );
    
    if( isset( $input['rating_5'] ) )
      $new_input['rating_5'] = sanitize_text_field( $input['rating_5'] );
    
    if( isset( $input['rating_4'] ) )
      $new_input['rating_4'] = sanitize_text_field( $input['rating_4'] );
    
    if( isset( $input['rating_3'] ) )
      $new_input['rating_3'] = sanitize_text_field( $input['rating_3'] );
    
    if( isset( $input['rating_2'] ) )
      $new_input['rating_2'] = sanitize_text_field( $input['rating_2'] );
    
    if( isset( $input['rating_1'] ) )
      $new_input['rating_1'] = sanitize_text_field( $input['rating_1'] );
    
    if( isset( $input['newest'] ) )
      $new_input['newest'] = sanitize_text_field( $input['newest'] );
    
    if( isset( $input['oldest'] ) )
      $new_input['oldest'] = sanitize_text_field( $input['oldest'] );
    
    if(!$hasError) {
      add_settings_error(
        "dc_{$this->tab}_settings_name",
        esc_attr( "dc_{$this->tab}_settings_admin_updated" ),
        __('Settings updated', $WC_Product_Review_Sorting->text_domain),
        'updated'
      );
    }

    return $new_input;
  }

  /** 
   * Print the Section text
   */
  public function default_settings_section_info() {
    global $WC_Product_Review_Sorting;
    _e('', $WC_Product_Review_Sorting->text_domain);
  }
  
  /** 
   * Print the Section text
   */
  public function rating_settings_section_info() {
    global $WC_Product_Review_Sorting;
    _e('', $WC_Product_Review_Sorting->text_domain);
  }
  
  /** 
   * Print the Section text
   */
  public function time_settings_section_info() {
    global $WC_Product_Review_Sorting;
    _e('', $WC_Product_Review_Sorting->text_domain);
  }
  
}