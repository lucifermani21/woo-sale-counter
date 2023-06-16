<?php 
include_once 'class-sale_hooks.php' ;
if( class_exists( 'WOO_SALES_COUNTER_VAR' ). true ){
    class WOO_SALES_COUNTER_VAR extends WOO_SALES_COUNTER{
		
		public function product_hooks(){
			add_action('woocommerce_before_add_to_cart_form', array( $this, 'get_sale_var' ) );			
		}
		
		public function get_sale_var(){
			global $post;
			$meta_data = array(
				'meta_enable_sale' => get_post_meta($post->ID, "_input_checkbox_enable_sale_timer", true),
				'meta_sale_date' => get_post_meta($post->ID, "_input_sale_timer_date", true),
				'meta_sale_time' => get_post_meta($post->ID, "_input_sale_timer_time", true),
				'meta_sale_message' => get_post_meta($post->ID, "_input_sale_timer_textarea", true),
			);
			//var_dump($meta_data[ 'meta_sale_time' ]);
			
			if( $meta_data[ 'meta_enable_sale' ] == 'yes' ){
				echo "<div id='sale_counter'></div>";
			}
			?>
			<script>
			// Set the date we're counting down to
			var countDownDate = new Date("<?php echo $meta_data[ 'meta_sale_date' ];?> 15:37:25").getTime();

			// Update the count down every 1 second
			var x = setInterval(function() {

			  // Get today's date and time
			  var now = new Date().getTime();

			  // Find the distance between now and the count down date
			  var distance = countDownDate - now;

			  // Time calculations for days, hours, minutes and seconds
			  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			  // Display the result in the element with id="demo"
			  document.getElementById("sale_counter").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

			  // If the count down is finished, write some text
			  if (distance < 0) {
				clearInterval(x);
				document.getElementById("sale_counter").innerHTML = "EXPIRED";
			  }
			}, 1000);
			</script>			
			<?php
		}		
    }	
}    
$obj = new WOO_SALES_COUNTER_VAR();
$obj->product_hooks();