<?php 
if( class_exists( 'WOO_SALES_COUNTER' ) ){
    class WOO_SALES_COUNTER{
        function  __construct(){
            add_action( 'admin_head', array( $this, 'MS_admin_sale_timer_CSS' ) );
            add_filter( 'woocommerce_product_data_tabs', array( $this, 'MS_custom_sales_counter_tab' ), 99 , 1 );
            add_action( 'woocommerce_product_data_panels', array( $this, 'MS_add_sale_timer_product_data_fields' ) );
            add_action( 'woocommerce_process_product_meta', array( $this, 'MS_sale_timer_product_meta_fields_save' ) );
        }

        function MS_admin_sale_timer_CSS(){
            echo '<style type="text/css">
                textarea#_input_sale_timer_textarea {float: inherit;height: auto;}
                .sale-counter_options a::before {content: "\f469" !important;}
            </style>';
        }

        public function MS_custom_sales_counter_tab( $product_data_tabs ) {
            $product_data_tabs['sale-counter'] = array(
                'label' => __( 'Sales Timer', 'my_theme_domain' ),
                'target' => 'products_sale_counter_date_and_timer',
            );
            return $product_data_tabs;
        }
        public function MS_add_sale_timer_product_data_fields() {     
            global $post;
            $post_id = $post->ID;
                   
            echo '<div id="products_sale_counter_date_and_timer" class="panel woocommerce_options_panel">';
            
                # Checkbox field
                woocommerce_wp_checkbox( array(
                    'id'            => '_input_checkbox_enable_sale_timer',
                    'wrapper_class' => 'form-row-full',
                    'label'         => __( 'Enable', WSALE_SETTING_TEXT_DOMAIN ),
                    'description'   => __( 'Enable if you wants to add Sale timer to the products.', WSALE_SETTING_TEXT_DOMAIN ),
                    'desc_tip'      => true,
                ) );
                
                # Date input field
                woocommerce_wp_text_input( array(
                    'id'            => '_input_sale_timer_date',
                    'wrapper_class' => 'form-row-first',
                    'label'         => __( 'Enter Date:', WSALE_SETTING_TEXT_DOMAIN ),
                    'description'   => __( 'Sale End Date', WSALE_SETTING_TEXT_DOMAIN ),
                    //'desc_tip'      => true,
                    'type'          => 'date',
                ) );
                
                # Time input field
                woocommerce_wp_text_input( array(
                    'id'            => '_input_sale_timer_time',
                    'wrapper_class' => 'form-row-last',
                    'label'         => __( 'Enter Time:', WSALE_SETTING_TEXT_DOMAIN ),
                    'description'   => __( 'Sale End Time', WSALE_SETTING_TEXT_DOMAIN ),
                    //'desc_tip'      => true,
                    'type'          => 'time',
                ) );
                
                # Textarea input field
                woocommerce_wp_textarea_input( array(
                    'id'            => '_input_sale_timer_textarea',
                    'class'         => 'widefat',
                    'wrapper_class' => 'form-row-full',
                    'placeholder'   => __( '', WSALE_SETTING_TEXT_DOMAIN ),
                    'label'         => __( 'Sale Timer Textarea', WSALE_SETTING_TEXT_DOMAIN ),
                    'description'   => __( 'Add text here for sale timer products, the text will show on the product details page after timer.', WSALE_SETTING_TEXT_DOMAIN ),
                    //'desc_tip'      => true,
                    'rows'          => 5,
                    'cols'          => 10,
                ) );    
            echo '</div>';
        }

        public function MS_sale_timer_product_meta_fields_save( $post_id ){
            global $post;
            $post_id = $post->ID;
            $enable_sale_option = $_POST['_input_checkbox_enable_sale_timer'];
            if( isset( $enable_sale_option ) )
                update_post_meta( $post_id, '_input_checkbox_enable_sale_timer', esc_attr( $enable_sale_option ) );
            
            $sale_date = $_POST['_input_sale_timer_date'];
            if( isset( $sale_date ) )
                update_post_meta( $post_id, '_input_sale_timer_date', esc_attr( $sale_date ) );
    
            $sale_time = $_POST['_input_sale_timer_time'];
            if( isset( $sale_time ) )
                update_post_meta( $post_id, '_input_sale_timer_time', esc_attr( $sale_time ) );

            $sale_textarea = $_POST['_input_sale_timer_textarea'];
            if( isset( $sale_textarea ) )
                update_post_meta( $post_id, '_input_sale_timer_textarea', esc_attr( $sale_textarea ) );
    
        }
        function activation(){
            flush_rewrite_rules();
		}
		
		function deactivation(){
			flush_rewrite_rules();
		}
    }
}
    
$sale_obj = new WOO_SALES_COUNTER();
register_activation_hook( __FILE__ , array( $sale_obj, 'activation' ) );
register_deactivation_hook( __FILE__ , array( $sale_obj, 'deactivation' ) );