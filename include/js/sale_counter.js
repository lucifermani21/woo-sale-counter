jQuery(document).ready( function () {
	sale_countdown();
});
function sale_countdown(){
	jQuery(".countdown").each(function() {
		var endtimer = jQuery(this).attr("data-sale");
		var countDownDate = new Date( endtimer ).getTime();
		var $this = jQuery(this);
		var x = setInterval(function() {
			var now = new Date().getTime();
			var distance = countDownDate - now;
			const days = Math.floor(distance / (1000 * 60 * 60 * 24));
			const hours = Math.floor((distance - days * (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			const minutes = Math.floor((distance - days * (1000 * 60 * 60 * 24) - hours * (1000 * 60 * 60)) / (1000 * 60));
			const seconds = Math.floor((distance - days * (1000 * 60 * 60 * 24) - hours * (1000 * 60 * 60) - minutes * (1000 * 60)) / 1000);
			$this.text( `${days} Days ${hours} Hours ${minutes} Minutes ${seconds} Seconds` );
			if (distance < 0) {
				clearInterval(x);
				$this.text('');
			}
			}, 1000);
	});	
};