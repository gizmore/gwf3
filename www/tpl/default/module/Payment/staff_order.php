<?php
$order = $tVars['order']; $order instanceof GWF_Order;

$status = $order->getVar('order_status');
$status_text = $tLang->lang('status_'.$status);
switch ($status)
{
	case GWF_Order::CREATED:
	case GWF_Order::ORDERED:
		$status_link = GWF_HTML::anchor($tVars['href_paid'], $status_text);
		break;
	case GWF_Order::PAID:
	case GWF_Order::PROCESSED:
		$status_link = $status_text;
		break;
}

echo GWF_Table::start();
echo GWF_Table::rowStart();
echo sprintf('<td>%s</td>', $tLang->lang('th_order_id'));
echo sprintf('<td>%s</td>', $order->getVar('order_id'));
echo GWF_Table::rowEnd();
echo GWF_Table::rowStart();
echo sprintf('<td>%s</td>', $tLang->lang('th_order_token'));
echo sprintf('<td>%s</td>', $order->getVar('order_token'));
echo GWF_Table::rowEnd();
echo GWF_Table::rowStart();
echo sprintf('<td>%s</td>', $tLang->lang('th_user_name'));
echo sprintf('<td>%s</td>', $order->getOrderUser()->displayProfileLink());
echo GWF_Table::rowEnd();
echo GWF_Table::rowStart();
echo sprintf('<td>%s</td>', $tLang->lang('th_order_email'));
echo sprintf('<td>%s</td>', $order->getOrderPayEMail());
echo GWF_Table::rowEnd();
echo GWF_Table::rowStart();
echo sprintf('<td>%s</td>', $tLang->lang('th_order_date_ordered'));
echo sprintf('<td class="gwf_date">%s</td>', GWF_Time::displayDate($order->getVar('order_date_ordered')));
echo GWF_Table::rowEnd();
echo GWF_Table::rowStart();
echo sprintf('<td>%s</td>', $tLang->lang('th_order_date_paid'));
echo sprintf('<td class="gwf_date">%s</td>', GWF_Time::displayDate($order->getVar('order_date_paid')));
echo GWF_Table::rowEnd();
echo GWF_Table::rowStart();
echo sprintf('<td>%s</td>', $tLang->lang('th_order_site'));
echo sprintf('<td>%s</td>', $order->getPaymentModule()->getSiteName());
echo GWF_Table::rowEnd();
echo GWF_Table::rowStart();
echo sprintf('<td>%s</td>', $tLang->lang('th_order_status'));
echo sprintf('<td>%s</td>', $status_link);
echo GWF_Table::rowEnd();
echo GWF_Table::rowStart();
echo sprintf('<td>%s</td>', $tLang->lang('th_order_price_total'));
echo sprintf('<td>%s</td>', Module_Payment::displayPrice($order->getOrderPriceTotal()));
echo GWF_Table::rowEnd();
echo GWF_Table::end();

echo $tVars['form_exec'];

echo '<div>'.PHP_EOL;
echo $tVars['display'];
echo '</div>'.PHP_EOL;


//echo $tVars['form_edit'];


//echo sprintf('<div class="gwf_buttons">').PHP_EOL;
//if ($order->isCreated())
//{
//	echo GWF_Button::generic($tLang->lang('btn_mark_paid'), $tVars['href_paid']);	
//}
//echo '</div>'.PHP_EOL;
