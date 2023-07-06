<?php 
include_once 'class-sale_hooks.php' ;
if( class_exists( 'WOO_SALES_COUNTER_VAR' ). true ){
    class WOO_SALES_COUNTER_VAR extends WOO_SALES_COUNTER{
		
		public function product_hooks(){
			add_action('woocommerce_before_add_to_cart_form', array( $this, 'MS_sale_counter_shop_detail_page' ) );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'MS_sale_loop_add_to_cart' ), 10 );
		}
		
		public function sale_timer_html( $ed, $et ){
			echo '<div class="countdown" data-sale="'.$ed.' '.$et.'">
					<span id="days"></span>
					<span id="hours"></span>
					<span id="minutes"></span>
					<span id="seconds"></span>
				</div>';
		}
		
		public function MS_sale_counter_shop_detail_page(){
			$meta_data = $this->get_meta_array_data();
			$meta_enable_sale = $meta_data[ 'meta_enable_sale' ];
			if( $meta_enable_sale == 'yes' ){
				$end_date = ( $meta_data[ 'meta_sale_date' ] ) ? $meta_data[ 'meta_sale_date' ] : '0000-00-00 ';
				$end_time = ( $meta_data[ 'meta_sale_time' ] ) ? $meta_data[ 'meta_sale_time' ] : '00:00:00';
				$this->sale_timer_html( $end_date, $end_time );
				$meta_sale_message = $meta_data[ 'meta_sale_message' ];
				if( !empty( $meta_sale_message ) ){
					echo '<hr/><div class="Sale_Message">'.$meta_sale_message.'</div><hr/>';
				}
			}
		}
		
		public function MS_sale_loop_add_to_cart(){
			$meta_data = $this->get_meta_array_data();
			$meta_enable_sale = $meta_data[ 'meta_enable_sale' ];
			if( $meta_enable_sale == 'yes' ){
				$end_date = ( $meta_data[ 'meta_sale_date' ] ) ? $meta_data[ 'meta_sale_date' ] : '0000-00-00 ';
				$end_time = ( $meta_data[ 'meta_sale_time' ] ) ? $meta_data[ 'meta_sale_time' ] : '00:00:00';
				$this->sale_timer_html( $end_date, $end_time );	
			}
		}
    }	
}    
$obj = new WOO_SALES_COUNTER_VAR();
$obj->product_hooks();