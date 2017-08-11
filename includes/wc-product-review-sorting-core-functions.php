<?php
if(!function_exists('get_product_review_sorting_settings')) {
  function get_product_review_sorting_settings($name = '', $tab = '') {
    if(empty($tab) && empty($name)) return '';
    if(empty($tab)) return get_option($name);
    if(empty($name)) return get_option("dc_{$tab}_settings_name");
    $settings = get_option("dc_{$tab}_settings_name");
    if(!isset($settings[$name])) return '';
    return $settings[$name];
  }
}

if(!function_exists('woocommerce_inactive_notice')) {
  function woocommerce_inactive_notice() {
    ?>
    <div id="message" class="error">
      <p><?php printf( __( '%sWoocommerce Product Review Sorting is inactive.%s The %sWooCommerce plugin%s must be active for the Woocommerce Product Review Sorting to work. Please %sinstall & activate WooCommerce%s', WCS_TEXT_DOMAIN ), '<strong>', '</strong>', '<a target="_blank" href="http://wordpress.org/extend/plugins/woocommerce/">', '</a>', '<a href="' . admin_url( 'plugins.php' ) . '">', '&nbsp;&raquo;</a>' ); ?></p>
    </div>
		<?php
  }
}

if(!function_exists('woocommerce_version_compatibility')) {
  function woocommerce_version_compatibility() {
    ?>
    <div id="message" class="error">
      <p><?php printf( __( '%sWoocommerce Product Review Sorting is inactive.%s The %sWooCommerce plugin%s version must be greater than 2.1 for the Woocommerce Product Review Sorting to work. Please %sinstall & activate WooCommerce%s', WCS_TEXT_DOMAIN ), '<strong>', '</strong>', '<a target="_blank" href="http://wordpress.org/extend/plugins/woocommerce/">', '</a>', '<a href="' . admin_url( 'plugins.php' ) . '">', '&nbsp;&raquo;</a>' ); ?></p>
    </div>
		<?php
  }
}

?>
