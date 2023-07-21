<?php
add_action( 'woocommerce_thankyou', 'add_gtag_purchase_event', 10, 4 );

/**
 * Conversion tracking for WC order
 */
function add_gtag_purchase_event( $order_id ) {

	if (! $order_id ) {
		return; // no order id
	}

	if ( $order = wc_get_order( $order_id ) ) {

		$script = "
<script>
gtag('event', 'conversion', {
	'send_to': 'AW-10818559065/WOdmCKLJo6UDENm42KYo',
	'value': {$order->get_total()},
	'currency': '{$order->get_currency()}',
	'transaction_id': '{$order_id}'
});
</script>
		";

		echo $script;

	}

}
