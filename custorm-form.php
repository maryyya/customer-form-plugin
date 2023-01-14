<?php
/**
 * Customer Form
 *
 * @package       CustomerForm
 * @author        Mary Padon
 *
 * @wordpress-plugin
 * Plugin Name: Customer Form
 * Plugin URI: https://github.com/maryyya/customer-form-plugin
 * Description: Generates a customer form shortcode.
 * Version: 1.0.0
 * Requires at least: 6.1.1
 * Requires PHP: 7.3.33
 * Author: Mary Padon
 * Text Domain: customer-form
 */

 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once plugin_dir_path( __FILE__ ) . 'class.customer-form.php';
new Customer_Form();
