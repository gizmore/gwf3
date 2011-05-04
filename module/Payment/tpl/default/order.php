<?php
$box_c = '';
if (!isset($tVars['no_info']))
{
	$box_c .= sprintf('<p>%s</p>', $tLang->lang('payment_info'));
}
if (isset($tVars['paymodule_info']) && $tVars['paymodule_info'] !== '')
{
	$box_c .= sprintf('<p>%s</p>', $tVars['paymodule_info']);
}
echo GWF_Box::box($box_c);

echo sprintf('<p>%s</p>', $tVars['order']);
?>
<table>
<?php
	echo sprintf('%s<td colspan="2">%s</td><td>%s</td>%s', GWF_Table::rowStart(), $tLang->lang('th_price'), $tVars['price'], GWF_Table::rowEnd());
if ($tVars['has_fee']) {
	echo sprintf('%s<td>%s</td><td>%s</td><td>%s</td>%s', GWF_Table::rowStart(), $tLang->lang('th_fee_per'), $tVars['fee_percent'], $tVars['fee'], GWF_Table::rowEnd());
	echo sprintf('%s<td colspan="2">%s</td><td>%s</td>%s', GWF_Table::rowStart(), $tLang->lang('th_price_total'), $tVars['price_total'], GWF_Table::rowEnd());
}
	echo sprintf('<tr><td colspan="3">%s</td></tr>', $tVars['buttons']);
?>
</table>
