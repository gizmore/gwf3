<!--<span id="greeting" class="color" style="font-size:15px;">
{*$greeting*}
<br/> {*
Heute ist {$TAGNAME_HEUTE} der {$TAG_HEUTE}. {$MONATNAME} {$JAHR}.<br/>
{$zeitangaben}Es ist {$ZEIT_STUNDE} Uhr {$ZEIT_MINUTE} und {$ZEIT_SEKUNDE} Sekunden.<br/>
{$days_to_weekend}<br/> *}
</span>


{*include file='main/counter.tpl'*}
{*include file='main/surfer_infos.tpl'*}
{*include file='Form/design_switch.tpl'*}
-->
<table>
	<tr>
		<th>{strtoupper($SF->lang('server'))}</th>
		<th>{strtoupper($SF->lang('visitor'))}</th>
		<th>{strtoupper($SF->lang('surfer_infos'))}</th>
		{*<th>{strtoupper($SF->lang('statistics'))}</th>
		<th>{strtoupper($SF->lang('donations'))}</th>*}
	</tr>
	<tr>
		<td>
			SQL: {$timings['t_sql']|string_format:"%.03f"}s ({$timings['queries']} Queries);<br/>
			PHP: {$timings['t_php']|string_format:"%.03f"}s;<br/>
			TOTAL: {$timings['t_total']|string_format:"%.03f"}s;<br/>
			MEM PHP: {$timings['mem_php']|filesize:"2":"1024"};
			MEM USER: {$timings['mem_user']|filesize:"2":"1024"};
			MEM TOTAL: {$timings['mem_total']|filesize:"2":"1024"};<br/>
			SPACE FREE: {GWF_SF_Utils::umrechnung($timings['space_free'])}
			SPACE USED: {GWF_SF_Utils::umrechnung($timings['space_used'])}
			SPACE TOTAL: {GWF_SF_Utils::umrechnung($timings['space_total'])}<br/>
		</td>

		<td style="vertical-align: top;">
			{$SF->lang('ip')}: <span class="color">{GWF_SF_SurferInfos::get_ipaddress()}</span><br/>
			{$SF->lang('operating_system')}: <span class="color">{GWF_SF_SurferInfos::get_operatingsystem()}</span><br/>
			{$SF->lang('browser')}: <span class="color">{GWF_SF_SurferInfos::get_browser()}</span><br/>
			{$SF->lang('provider')}: <span class="color">{GWF_SF_SurferInfos::get_provider()}</span><br/>
			{$SF->lang('hostname')}: <span class="color" title="{GWF_SF_SurferInfos::get_hostname()}">{GWF_SF_SurferInfos::get_hostname()}</span><br/>
			{$SF->lang('referer')}: <span class="color" title="{GWF_SF_SurferInfos::get_referer()}">{GWF_SF_SurferInfos::get_referer()}</span><br/>
			{$SF->lang('user_agent')}: <span class="color" title="{GWF_SF_SurferInfos::get_useragent()}">{GWF_SF_SurferInfos::get_useragent()}</span>
		</td>{*
		<td style="vertical-align: top;">
			There are 5 new Challenges:<br/>
			3 in Cryptography<br/>
			2 in Steganography<br/>
		</td>
		<td style="vertical-align: top;">
			{$SF->lang('day')}: {$SF->lang('daynames', $server['day']['day'])}, {$server['day']['day']}<br/>
			{$SF->lang('month')}: {$SF->lang('monthnames', $server['day']['month'])} , {$server['day']['month']}<br/>
			{$SF->lang('year')}: {$server['day']['year']}<br/>
			sternzeichen
			{$SF->lang('hour')}: {$server['day']['hour']}<br/>
			{$SF->lang('minute')}: {$server['day']['minute']}<br/>
			{$SF->lang('second')}: {$server['day']['second']}<br/>
		</td>
		<td style="vertical-align: top;">
			No Donators, yet...<br/>
{include file='tpl/Form/donate.tpl'}
		</td>*}
	</tr>
</table>
