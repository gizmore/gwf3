<!--<span id="greeting" class="color" style="font-size:15px;">
{*$greeting*}
<br> {*
Heute ist {$TAGNAME_HEUTE} der {$TAG_HEUTE}. {$MONATNAME} {$JAHR}.<br>
{$zeitangaben}Es ist {$ZEIT_STUNDE} Uhr {$ZEIT_MINUTE} und {$ZEIT_SEKUNDE} Sekunden.<br>
{$days_to_weekend}<br> *}
</span>


{*include file='main/counter.tpl'*}
{*include file='main/surfer_infos.tpl'*}
{*include file='Form/design_switch.tpl'*}
-->
<table>
	<tr>
		<th>{strtoupper($lang->lang('visitor'))}</th>
		<th>{strtoupper($lang->lang('surfer_infos'))}</th>
		<th>{strtoupper($lang->lang('server'))}</th>
		<th>{strtoupper($lang->lang('statistics'))}</th>
		{*<th>{strtoupper($lang->lang('today'))}</th>*}
		<th>{strtoupper($lang->lang('donations'))}</th>
	</tr>
	<tr>
		<td style="vertical-align: top;">
			Online: {$gwff->module_Heart_beat()}<br>
			{$lang->lang('ct_vis_total')}: 5023<br>
			{$lang->lang('ct_vis_today')}: 23<br>
			{$lang->lang('ct_vis_yesterday')}: 12<br>
			{$lang->lang('ct_online_today')}: 7<br>
			{$lang->lang('ct_online_total')}: 49<br>
		</td>
		<td style="vertical-align: top;">
			{$lang->lang('ip')}: <span class="color">{GWF_SF_SurferInfos::get_ipaddress()}</span><br>
			{$lang->lang('operating_system')}: <span class="color">{GWF_SF_SurferInfos::get_operatingsystem()}</span><br>
			{$lang->lang('browser')}: <span class="color">{GWF_SF_SurferInfos::get_browser()}</span><br>
			{$lang->lang('provider')}: <span class="color">{GWF_SF_SurferInfos::get_provider()}</span><br>
			{$lang->lang('hostname')}: <span class="color" title="{GWF_SF_SurferInfos::get_hostname()}">{substr(GWF_SF_SurferInfos::get_hostname(), 0, 10)}...</span><br>
			{$lang->lang('referer')}: <span class="color" title="{GWF_SF_SurferInfos::get_referer()}">{substr(GWF_SF_SurferInfos::get_referer(), 0, 10)}...</span><br>
			{$lang->lang('user_agent')}: <span class="color" title="{GWF_SF_SurferInfos::get_useragent()}">{substr(GWF_SF_SurferInfos::get_useragent(), 0, 10)}...</span>
		</td>
		<td style="vertical-align: top;">
			{$lang->lang('space')}: <br>
			{$lang->lang('free_space')}: {$server['space']['free']}<br>
			{$lang->lang('total_space')}: {$server['space']['total']}<br>
			{$lang->lang('used_space')}: {$server['space']['used']}<br>
			{$lang->lang('admin')}: {$server['admin']}<br>
			{$lang->lang('mail')}: {$server['email']}
		</td>
		<td style="vertical-align: top;">
			There are 5 new Challenges:<br>
			3 in Cryptography<br>
			2 in Steganography<br>
		</td>{*
		<td style="vertical-align: top;">
			{$lang->lang('day')}: {$lang->lang('daynames', $server['day']['day'])}, {$server['day']['day']}<br>
			{$lang->lang('month')}: {$lang->lang('monthnames', $server['day']['month'])} , {$server['day']['month']}<br>
			{$lang->lang('year')}: {$server['day']['year']}<br>
			sternzeichen
			{$lang->lang('hour')}: {$server['day']['hour']}<br>
			{$lang->lang('minute')}: {$server['day']['minute']}<br>
			{$lang->lang('second')}: {$server['day']['second']}<br>
		</td>*}
		<td style="vertical-align: top;">
			No Donators, yet...<br>
			<a href="index.php?form=donate">Donate</a>
{include file='tpl/Form/donate.tpl'}
		</td>
	</tr>
</table>
