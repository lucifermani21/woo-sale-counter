<?php 
include_once 'class-sale_hooks.php' ;
if( class_exists( 'WOO_SALES_COUNTER_VAR' ). true ){
    class WOO_SALES_COUNTER_VAR extends WOO_SALES_COUNTER{
		
		public function product_hooks(){
			add_action('woocommerce_before_add_to_cart_form', array( $this, 'MS_sale_counter_shop_detail_page' ) );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'MS_sale_loop_add_to_cart' ), 10 );
		}
		
		public function MS_sale_counter_shop_detail_page(){
			global $post;
			$meta_data = array(
				'meta_enable_sale' => get_post_meta($post->ID, "_input_checkbox_enable_sale_timer", true),
				'meta_sale_date' => get_post_meta($post->ID, "_input_sale_timer_date", true),
				'meta_sale_time' => get_post_meta($post->ID, "_input_sale_timer_time", true),
				'meta_sale_message' => get_post_meta($post->ID, "_input_sale_timer_textarea", true),
			);
			$meta_enable_sale = $meta_data[ 'meta_enable_sale' ];
			if( $meta_enable_sale == 'yes' ){
				$end_date = ( $meta_data[ 'meta_sale_date' ] ) ? $meta_data[ 'meta_sale_date' ] : '0000-00-00 ';
				$end_time = ( $meta_data[ 'meta_sale_time' ] ) ? $meta_data[ 'meta_sale_time' ] : '00:00:00';
				echo '<div class="countdown" data-sale="'. $end_date.' '.$end_time .'">
							<p><span id="days"></span></p>
							<p><span id="hours"></span></p>
							<p><span id="minutes"></span></p>
							<p><span id="seconds"></span></p>
						</div>';			
				$meta_sale_message = $meta_data[ 'meta_sale_message' ];
				if( !empty( $meta_sale_message ) ){
					echo '<hr/><div class="Sale_Message">'.$meta_sale_message.'</div><hr/>';
				}
			}
		}
		
		public function MS_sale_loop_add_to_cart(){
			global $post;
			$meta_data = array(
				'meta_enable_sale' => get_post_meta($post->ID, "_input_checkbox_enable_sale_timer", true),
				'meta_sale_date' => get_post_meta($post->ID, "_input_sale_timer_date", true),
				'meta_sale_time' => get_post_meta($post->ID, "_input_sale_timer_time", true),
				'meta_sale_message' => get_post_meta($post->ID, "_input_sale_timer_textarea", true),
			);
			$meta_enable_sale = $meta_data[ 'meta_enable_sale' ];
			if( $meta_enable_sale == 'yes' ){
				$end_date = ( $meta_data[ 'meta_sale_date' ] ) ? $meta_data[ 'meta_sale_date' ] : '0000-00-00 ';
				$end_time = ( $meta_data[ 'meta_sale_time' ] ) ? $meta_data[ 'meta_sale_time' ] : '00:00:00';
				echo '<div class="countdown" data-sale="'. $end_date.' '.$end_time .'">
						  <p><span id="days"></span></p>
						  <p><span id="hours"></span></p>
						  <p><span id="minutes"></span></p>
						  <p><span id="seconds"></span></p>
					</div>';			
				$meta_sale_message = $meta_data[ 'meta_sale_message' ];
				if( !empty( $meta_sale_message ) ){
					echo '<hr/><div class="Sale_Message">'.$meta_sale_message.'</div><hr/>';
				}
			}
		}
    }	
}    
$obj = new WOO_SALES_COUNTER_VAR();
$obj->product_hooks();