<?php

$lang = array(

	# Titles
	'ft_search' => 'Search the Order Database',

	# Admin Config
	'cfg_donations' => 'Accept Donations?',
	'cfg_global_fee_buy' => 'Global Purchase Fee',
	'cfg_global_fee_sell' => 'Global Sell Fee',
	'cfg_local_fee_buy' => 'Local Purchase Fee',
	'cfg_local_fee_sell' => 'Local Sell Fee',
	'cfg_orders_per_page' => 'Orders Per Page',
	'cfg_currency' => 'Shop Currency',
	'cfg_currencies' => 'Accepted Currencies',

	# Tooltips
	'tt_currency' => 'Uppercase 3 letter ISO code',

	# Errors
	'err_country' => 'Your country is not supported by %s.',
	'err_currency' => 'This currency is not supported by %s.',
	'err_can_order' => 'You are not allowed to order this.',
	'err_paysite' => 'This Payment Processor is unknown.',
	'err_order' => 'The Order could not be found.',
	'err_token' => 'Your '.GWF_SITENAME.' token is invalid.',
	'err_xtoken' => 'Your %s token is invalid.',
	'err_crit' => 'An error occured while we executed your order.<br/>Please contact the site admin and mention your order token: %s.',

	# Messages
	'msg_paid' => 'Thank you for your purchase. Your order has been executed successfully.',
	'msg_executed' => 'The order has been executed manually.',
	
	# Buttons
	'btn_show_cart' => 'Go to your Shopping Cart',
	'btn_add_to_cart' => 'Add to Shopping Cart',
	'btn_execute' => 'Execute',

	# Table Headers
	'th_price' => 'Price',
	'th_fee_per' => 'Tax/Fee',
	'th_price_total' => '<b>Total</b>',
	'th_order_id' => 'ID',
	'th_user_name' => 'Username',
	'th_order_price' => 'Price',
	'th_order_price_total' => 'Price',
	'th_order_site' => 'Paysite',
	'th_order_email' => 'PayMail',
	'th_order_descr_admin' => 'Description',
	'th_order_date_ordered' => 'Ordered At',
	'th_order_status' => 'Status',
	'th_order_date_paid' => 'Paid At',
	'th_order_token' => 'Token',

	# Status
	'status_created' => 'Created',
	'status_ordered' => 'Ordered',
	'status_paid' => 'Paid',
	'status_processed' => 'Processed',

	# Info
	'payment_info' => 'Each payment processers may have an individual tax/fee.<br/>If you chose Paypal, you have to confirm the payment here again before any transaction is made.',

	# Fixes
	'msg_pending' => 'Your transaction is pending. You will receive email with instructions, when the payment has been completed.',

	'err_already_done' => 'Your order has been executed already.',
);

?>