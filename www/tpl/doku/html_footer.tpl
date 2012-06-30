<div id="gwf3_footmenu">
	{include file='tpl/default/menu_foot.tpl'}
</div>

<div id="gwf3_debug_foot">
<div class="fl">
	<div id="oos_gwf3">GWF-3</div>
	<div>Logged in as {$user->display('user_name')}</div>
	<div>&copy;2009-2012 gizmore</div>
</div>

{assign var="timings" value=GWF_DebugInfo::getTimings()}
<div class="fl">
	<div>SQL: {$timings['t_sql']|string_format:"%.03f"}s ({$timings['queries']} Queries)</div>
	<div>PHP: {$timings['t_php']|string_format:"%.03f"}s</div>
	<div>TOTAL: {$timings['t_total']|string_format:"%.03f"}s</div>
</div>

<div class="fl">
	<div>MEM PHP: {$timings['mem_php']|filesize:"2":"1024"}</div>
	<div>MEM USER: {$timings['mem_user']|filesize:"2":"1024"}</div>
	<div>MEM TOTAL: {$timings['mem_total']|filesize:"2":"1024"}</div>
</div>

<div class="fl">
{*
	<div>SQL_OPENED: {$db->getQueriesOpened()}</div>
	<div>SQL_CLOSED: {$db->getQueriesClosed()}</div>
*}
	<div>MODULES LOADED: {GWF_Module::getModulesLoaded()}</div>
</div>
{* COMMENT
<div class="fl">
	<div>PAGE SIZE: Unknown</div>
	<div>PAGES SERVED: {GWF_Counter::getAndCount(gwf3_pagecount)}</div>
</div>
*}

</div>
