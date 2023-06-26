<?php 

if( class_exists( 'WOO_SALES_COUNTER' ). true ){
    class WOO_SALES_COUNTER{
        function __construct(){
            add_action( 'admin_head', array( $this, 'MS_admin_sale_timer_CSS' ) );
            add_filter( 'woocommerce_product_data_tabs', array( $this, 'MS_custom_sales_counter_tab' ), 99 , 1 );
			add_action( 'wp_footer', array( $this, 'MS_js_code_sale_counter' ) );
	    }
		
		function init(){			
            add_action( 'woocommerce_product_data_panels', array( $this, 'MS_add_sale_timer_product_data_fields' ) );
            add_action( 'woocommerce_process_product_meta', array( $this, 'MS_sale_timer_product_meta_fields_save' ) );
	    }

        function MS_admin_sale_timer_CSS(){
            echo '<style type="text/css">
				#sale_date_time {display: flex;}
				#sale_date_time .short{width:100% !important;}
				#sale_date_time label{float: inherit;margin: auto;font-size: 14px;font-weight: 500;}
				textarea#_input_sale_timer_textarea {float: inherit;height: auto;width: 100%;}
				.sale-counter_options a::before {content: "\f469" !important;}
			</style>';
        }
		
        public function MS_custom_sales_counter_tab( $product_data_tabs ) {
            $product_data_tabs['sale-counter'] = array(
                'label' => __( 'Sale Timer', WSALE_SETTING_TEXT_DOMAIN ),
                'target' => 'products_sale_counter_date_and_timer',
            );
            return $product_data_tabs;
        }
        public function MS_add_sale_timer_product_data_fields() {     
            global $post;
            echo '<div id="products_sale_counter_date_and_timer" class="panel woocommerce_options_panel">';            
					# Checkbox field
					woocommerce_wp_checkbox( array(
						'id'            => '_input_checkbox_enable_sale_timer',
						'wrapper_class' => 'form-row-full',
						'label'         => __( 'Enable', WSALE_SETTING_TEXT_DOMAIN ),
						'description'   => __( 'Enable if you wants to add Sale timer to this products.', WSALE_SETTING_TEXT_DOMAIN ),
						'desc_tip'      => true,
					) );
            echo '<div id="sale_date_time" class="sale_panel">';
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
            echo '</div>';
					# Textarea input field
					woocommerce_wp_textarea_input( array(
						'id'            => '_input_sale_timer_textarea',
						'class'         => 'widefat',
						'wrapper_class' => 'form-row-full',
						'placeholder'   => __( '', WSALE_SETTING_TEXT_DOMAIN ),
						'label'         => __( 'Sale Message', WSALE_SETTING_TEXT_DOMAIN ),
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
            if( isset( $enable_sale_option ) ){
				update_post_meta( $post_id, '_input_checkbox_enable_sale_timer', esc_attr( $enable_sale_option ) );
			} else {
				update_post_meta( $post_id, '_input_checkbox_enable_sale_timer', 0 );
			}
			
            $sale_date = $_POST['_input_sale_timer_date'];
            if( isset( $sale_date ) ){
				update_post_meta( $post_id, '_input_sale_timer_date', esc_attr( $sale_date ) );
			}
			
            $sale_time = $_POST['_input_sale_timer_time'];
            if( isset( $sale_time ) ){
				update_post_meta( $post_id, '_input_sale_timer_time', esc_attr( $sale_time ) );
			}                

            $sale_textarea = $_POST['_input_sale_timer_textarea'];
            if( isset( $sale_textarea ) ){
				update_post_meta( $post_id, '_input_sale_timer_textarea', esc_attr( $sale_textarea ) );
			}
        }
		
		function MS_js_code_sale_counter(){
			//$version  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'js/custom.js' ));
			$version  = WSALE_SETTING_VERSION;
			wp_enqueue_script( 'sale-timer-script', plugins_url( 'js/sale_counter.js', __FILE__ ), array(), $version );
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