<div>
	<div>
		<h3><a href="{$href_history|htmlspecialchars}">&lt;&lt;</a>&nbsp;{$lang->lang('previously_played')}</h3>
{foreach from=$history item=h}
		{include file="tpl/default/module/Slaytags/songbox.tpl" song=$h playing=false left=-1}
{/foreach}
	</div>
	<div>
		<h2>{$lang->lang('now_playing')}</h2>
		{include file="tpl/default/module/Slaytags/songbox.tpl" song=$now playing=true left=$left}
	</div>
</div>

<div><a href="view-source:http://www.slayradio.org/ajax/gateway/playing/now">Check Slayradio API</a></div>