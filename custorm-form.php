<?php
/**
 * Customer Form
 *
 * @package       CustomerForm
 * @author        Mary Padon
 *
 * @wordpress-plugin
 * Plugin Name:   Customer Form
 * Description:   Generates a customer form shortcode.
 * Version:       1.0.0
 * Author:        Mary Padon
 * Text Domain:   customer-form
 */

 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once plugin_dir_path( __FILE__ ) . 'class.customer-form.php';
new Customer_Form();
