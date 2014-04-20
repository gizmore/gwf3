<?php
$headers = array(
	array('<input type="checkbox" onclick="gwfMassToggler(this, \'.gwf_mass_toggle input\');" />'),
	array($tLang->lang('th_user_country'), 'country_name'),
	array($tLang->lang('th_user_name'), 'user_name'),
	array($tLang->lang('th_user_level'), 'user_level'),
	array($tLang->lang('th_date_added'), 'pw_date'),
// 	array($tLang->lang('th_user_poicount'), 'poicount'),
);

echo '<div class="fl">';
echo $tVars['form_settings']->templateX($tVars['module']->lang('ft_settings'));
echo '</div>'.PHP_EOL;
echo '<div class="fl">';
echo $tVars['form_add']->templateX($tLang->lang('ft_add_whitelist'));
echo '</div>'.PHP_EOL;
echo '<div class="fl">';
echo $tVars['form_clear']->templateX($tLang->lang('ft_clear_pois'));
echo '</div>'.PHP_EOL;

echo '<div class="cb"></div>'.PHP_EOL;

echo $tVars['page_menu'];

echo '<form method="post" action="'.htmlspecialchars($tVars['form_action']).'">'.PHP_EOL;
echo sprintf('<div>%s</div>', GWF_CSRF::hiddenForm('poi_whitelisting'));
echo GWF_Table::start('gwf_mass_toggle');
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);

$table = $tVars['table'];
$result = $table->select('user_id, user_countryid, country_name, user_name, user_level, pw_date', $tVars['where'], "{$tVars['by']} {$tVars['dir']}", array('userb', 'country'), $tVars['ipp'], $tVars['from']);
while (false !== ($row = $table->fetch($result, GDO::ARRAY_N)))
{
	echo GWF_Table::rowStart();
	echo GWF_Table::column('<input type="checkbox" name="user['.$row[0].']" />');
	echo GWF_Table::column(GWF_Country::displayFlagS2($row[1], $row[2]));
	echo GWF_Table::column(sprintf('<a href="%2$sprofile/%1$s">%1$s</a>', htmlspecialchars($row[3]), GWF_WEB_ROOT));
	echo GWF_Table::column($row[4], 'gwf_num');
	echo GWF_Table::column(GWF_Time::displayDate($row[5]), 'gwf_date');
	echo GWF_Table::rowEnd();
}

echo GWF_Table::end();

echo GWF_Button::wrapStart();
printf('<input type="submit" name="delete" value="%s" />', $tLang->lang('btn_rem_whitelist'));
echo GWF_Button::wrapEnd();


echo GWF_Form::end();

echo $tVars['page_menu'];
