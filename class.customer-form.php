<?php

if ( ! class_exists( 'Customer_Form' ) ) {
    /**
     * Customer Form Class
     */
    class Customer_Form {
        /**
         * Firstly add the hook init
         */
        function __construct() {
            add_action( 'init', [ $this, 'init' ] );
        }

        /**
         * Initialize hooks
         */
        function init() {
            // register post type for Customer
            $this->register_customer_post_type();

            // add the shortcode for the form in the front
            add_shortcode( 'customer_form', [ $this, 'customer_form_shortcode' ] );

            // execute when wp logged in
            add_action( 'wp_ajax_customer_form', [ $this, 'customer_form' ] );

            // execute when logged out
            add_action( 'wp_ajax_nopriv_customer_form', [ $this, 'customer_form' ] );
        }

        /**
         * Register Customer Post Type
         */
        function register_customer_post_type() {
            /**
             * Post Type: Customers.
             */
        
            $labels = [
                'name' => esc_html__( 'Customers', 'twentytwentythree' ),
                'singular_name' => esc_html__( 'Customer', 'twentytwentythree' ),
            ];
        
            $args = [
                'label' => esc_html__( 'Customers', 'twentytwentythree' ),
                'labels' => $labels,
                'description' => '',
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_rest' => true,
                'rest_base' => '',
                'rest_controller_class' => 'WP_REST_Posts_Controller',
                'rest_namespace' => 'wp/v2',
                'has_archive' => false,
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
                'delete_with_user' => false,
                'exclude_from_search' => false,
                'capability_type' => 'post',
                'map_meta_cap' => true,
                'hierarchical' => false,
                'can_export' => false,
                'rewrite' => [ 'slug' => 'customer', 'with_front' => true ],
                'query_var' => true,
                'menu_icon' => 'dashicons-groups',
                'supports' => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
                'show_in_graphql' => false,
            ];
        
            register_post_type( 'customer', $args );
        }

        /**
         * The [customer_form] shortcode.
         * 
         * Accepts attributes such labels, max length of the input and
         * message's rows&cols. It will output a 
         * form that includes: name, phone number, email,
         * desired budget, and message. It also has default
         * value already incase the user forgots to put
         * the necessary attributes.
         * 
         * @param array $atts Shortcode attributes. Default empty.
         * @return string Shortcode output
         */
        function customer_form_shortcode( $atts = [] ) {
            // queue style
            wp_enqueue_style( 'customer-form-style', plugins_url( 'assets/style.css', __FILE__ ) );
            
            // queue scripts
            wp_enqueue_script( 'customer-form-script', plugins_url( 'assets/form.js', __FILE__ ), array( 'jquery' ), null, true );
            wp_localize_script( 'customer-form-script', 'cf_obj', ['ajax_url' => admin_url( 'admin-ajax.php' )]);

            // Getting the attributes and adding a default value too.
            $default_val = [
                'name' => [
                    'label'     => 'Name',
                    'maxlength' => '',
                ],
                'number' =>  [
                    'label'     => 'Phone Number',
                    'maxlength' => '',
                ],
                'email' =>  [
                    'label'     => 'Email Address',
                    'maxlength' => '',
                ],
                'budget' =>  [
                    'label'     => 'Desired Budget',
                    'maxlength' => '',
                ],
                'message' => [
                    'label'     => 'Messages',
                    'maxlength' => '',
                    'rows'      => '6',
                    'cols'      => '5',
                ],
            ];

            $name_label = isset( $atts['name_label'] ) && !empty( $atts['name_label'] ) ? $atts['name_label'] : $default_val['name']['label'];
            $name_max = isset( $atts['name_maxlength'] ) && !empty( $atts['name_maxlength'] )  ? $atts['name_maxlength'] : $default_val['name']['maxlength'];
            $phone_label = isset( $atts['number_label'] ) && !empty( $atts['number_label'] )  ? $atts['number_label'] : $default_val['number']['label'];
            $phone_max = isset( $atts['number_maxlength'] ) && !empty( $atts['number_maxlength'] )  ? $atts['number_maxlength'] : $default_val['number']['maxlength'];
            $email_label = isset( $atts['email_label'] ) && !empty( $atts['email_label'] )  ? $atts['email_label'] : $default_val['email']['label'];
            $email_max = isset( $atts['email_maxlength'] ) && !empty( $atts['email_maxlength'] )  ? $atts['email_maxlength'] : $default_val['email']['maxlength'];
            $budget_label = isset( $atts['budget_label'] ) && !empty( $atts['budget_label'] )  ? $atts['budget_label'] : $default_val['budget']['label'];
            $budget_max = isset( $atts['budget_maxlength'] ) && !empty( $atts['budget_maxlength'] )  ? $atts['budget_maxlength'] : $default_val['budget']['maxlength'];
            $message_label = isset( $atts['message_label'] ) && !empty( $atts['message_label'] )  ? $atts['message_label'] : $default_val['message']['label'];
            $message_max = isset( $atts['message_maxlength'] ) && !empty( $atts['message_maxlength'] )  ? $atts['message_maxlength'] : $default_val['message']['maxlength'];
            $message_rows = isset( $atts['message_rows'] ) && !empty( $atts['message_rows'] )  ? $atts['message_rows'] : $default_val['message']['rows'];
            $message_cols = isset( $atts['message_cols'] ) && !empty( $atts['message_cols'] )  ? $atts['message_cols'] : $default_val['message']['cols'];

            $form_id =  mt_rand();

            $html = <<<HTML
<div class="customer-form">
    <div>
        <form method="post" action="" id="{$form_id}">
            <div class="mb-20">
                <div class="c-label"><span class="red">*</span> {$name_label}</div>
                <span class="name-err input-err">Please enter your name.</span>
                <input type="text" name="customer-name" class="name" maxlength="{$name_max}" required></input>
            </div>
            <div class="mb-20">
                <div class="c-label">{$phone_label}</div>
                <span class="phone-err input-err">asdfasdf</span>
                <input type="text" name="phone-number" maxlength="{$phone_max}"></input>
            </div>
            <div class="mb-20">
                <div class="c-label"><span class="red">*</span> {$email_label}</div>
                <span class="email-err input-err"></span>
                <input type="email" name="email-address" maxlength="{$email_max}" required></input>
            </div>
            <div class="mb-20">
                <div class="c-label">{$budget_label}</div>
                <input type="text" name="desired-budget" maxlength="{$budget_max}"></input>
            </div>
            <div class="mb-20">
                <div class="c-label">{$message_label}</div>
                <textarea id="message" name="message" rows="{$message_rows}" cols="{$message_cols}" maxlength="{$message_max}"></textarea>
            </div>
            <input type="button" class="register" value="Register">
            <div id="res_msg"></div>
        </form>
    </div>
</div>
HTML;
            return $html;
        }

        /**
         * Saving customer form
         * to customer post type
         */
        function customer_form() {
            $param = $_POST;

            $pid = wp_insert_post( [
                'post_title'    => $param['name'],
                'post_content'  => '',
                'post_status'   => 'private',
                'post_type'     => 'customer',
            ] );

            if ( $pid ) {
                update_post_meta( $pid, 'name', $param['name'] );
                update_post_meta( $pid, 'phone_number', $param['number'] );
                update_post_meta( $pid, 'email_address', $param['email']  );
                update_post_meta( $pid, 'desired_budget' , $param['budget'] );
                update_post_meta( $pid, 'message', $param['message'] );

                echo json_encode($res);
                exit;
            }

            $res['st'] = 'ng';
            $res['msg'] = 'Inserting new post has an error.';
            echo json_encode($res);
            exit;
        }
    }
}
