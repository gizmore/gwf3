<?php

$lang = array(

	# Titles
	'ft_search' => 'Hae järjestystaulukko',

	# Admin Config
	'cfg_donations' => 'Hyväksy lahjoitukset?',
	'cfg_global_fee_buy' => 'Globaali ostokulu',
	'cfg_global_fee_sell' => 'Globaali myyntikulu',
	'cfg_local_fee_buy' => 'Paikallinen ostokulu',
	'cfg_local_fee_sell' => 'Paikallinen myyntikulu',
	'cfg_orders_per_page' => 'Ostoja per sivu',
	'cfg_currency' => 'Kaupan valuutta',
	'cfg_currencies' => 'Hyväksytyt valuutat',

	# Tooltips
	'tt_currency' => 'Isoista kirjaimista koostuva 3-kirjaiminen ISO-koodi',

	# Errors
	'err_country' => 'Maasi ei ole %s tukema.',
	'err_currency' => 'Tätä valuuttaa ei tueta %s toimesta.',
	'err_can_order' => 'Sinä et saa ostaa tätä.',
	'err_paysite' => 'Tämä maksuprosessori on tuntematon.',
	'err_order' => 'Ostosta ei löytynyt.',
	'err_token' => 'Antamasi '.GWF_SITENAME.' sivunimi on epäkelpo.',
	'err_xtoken' => 'Sinun %s merkki on epäkelpo.',
	'err_crit' => 'Tapahtui virhe käsiteltäessäsi ostostasi.<br/>Ole hyvä ja ota yhteyttä sivun ylläpitäjään ja kerro ostosi koodi: %s.',

	# Messages
	'msg_paid' => 'Kiitos maksustasi. Ostotapahtumasi on käsitelty onnistuneesti',
	'msg_executed' => 'Ostos on käsitelty manuaalisesti.',
	
	# Buttons
	'btn_show_cart' => 'Mene ostoskoriisi',
	'btn_add_to_cart' => 'Lisää ostoskoriisi',
	'btn_execute' => 'Suorita',

	# Table Headers
	'th_price' => 'Hinta',
	'th_fee_per' => 'Vero/Provisio',
	'th_price_total' => '<b>Yhteensä</b>',
	'th_order_id' => 'ID',
	'th_user_name' => 'Käyttäjänimi',
	'th_order_price' => 'Hinta',
	'th_order_price_total' => 'Hinta',
	'th_order_site' => 'Maksusivu',
	'th_order_email' => 'Maksusähköposti',
	'th_order_descr_admin' => 'Kuvaus',
	'th_order_date_ordered' => 'Tilattiin',
	'th_order_status' => 'Tilauksen status',
	'th_order_date_paid' => 'Maksettiin',
	'th_order_token' => 'Tunniste',

	# Status
	'status_created' => 'Luotiin',
	'status_ordered' => 'Tilattiin',
	'status_paid' => 'Maksettiin',
	'status_processed' => 'Käsiteltiin',

	# Info
	'payment_info' => 'Jokaisella maksuprosessoijalla voi olla erillinen vero/proviiso.<br/>Jos valitset Paypalin, sinun täytyy varmistaa maksu uudestaan ennenkuin suoritat maksun.',

	# Fixes
	'msg_pending' => 'Siirtoasi käsitellään. Saat sähköpostia, kun maksusi on suoritettu.',

	'err_already_done' => 'Your order has been executed already.',
);

?>