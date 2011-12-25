<table>
	<tr>
		<th>{$SF->lang('visitor')|upper}</th>
		<th>{$SF->lang('surfer_infos')|upper}</th>
		{*<th>{$SF->lang('statistics')|upper}</th>
<th>{$SF->lang('server')|upper}</th>
		<th>{$SF->lang('donations')|upper}</th>*}
	</tr>
	<tr>
		<td>
			{$SF->lang('ct_online_atm', array($SF->getOnlineUsers()))}<br>
			{$SF->lang('ct_vis_total')}<br>
			{$SF->lang('ct_vis_today')}<br>
			{$SF->lang('ct_vis_yesterday')}<br>
			{$SF->lang('ct_online_today')}<br>
			{$SF->lang('ct_online_total')}<br>
		</td>
		<td>
            {*$lang['screen_resolution']}: <span class="color"><script language="JavaScript"> <!-- document.write(screen.width+'x'+screen.height) //--> </script> Pixel</span><br> {*}
			<span class="color">{$SF->langA('si', 'country', array($SF->imgCountry(), $SF->getCountry()))}</span><br/>
			<span class="color">{$SF->langA('si', 'ip', array($SF->getIP()))}</span><br/>
			<span class="color">{$SF->langA('si', 'operating_system', array($SF->imgOS(), $SF->getOS()))}</span><br/>
			<span class="color">{$SF->langA('si', 'browser', array($SF->imgBrowser(), $SF->getBrowser()))}</span><br/>
			<span class="color">{$SF->langA('si', 'provider', array($SF->imgProvider(), $SF->getProvider()))}</span><br/>
			<span class="color">{$SF->langA('si', 'hostname', array($SF->getHostname()))}</span><br/>
			<span class="color">{$SF->langA('si', 'referer', array($SF->getReferer()))}</span><br/>
			<span class="color">{$SF->langA('si', 'user_agent', array($SF->getUserAgent()))}</span>
		</td>{*
		<td>
			There are 5 new Challenges:<br/>
			3 in Cryptography<br/>
			2 in Steganography<br/>
		</td>
		<td>
			No Donators, yet...<br/>
{include file='tpl/Form/donate.tpl'}
		</td
Designswitch
>*}
	</tr>
</table>