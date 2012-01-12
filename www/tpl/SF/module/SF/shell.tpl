<div class="SF_Shell">
{include file="tpl/SF/greeting.tpl" assign='greeting'}
{$greeting|indent:1}
	<p class="shell">
			<span class="bold shell_{if $user->isAdmin()}admin{else}user{/if}">{$user->displayUsername()}@{$smarty.server.SERVER_NAME}</span>
			<span class="bold shell_dir">{GWF_Session::getLastURL()|escape}{if $user->isAdmin()} # {else} $ {/if}</span> {$lastCMD}
	</p>
	<p class="shell_output">
		{$output}
		<br/>
	</p>
{include file="tpl/{$design}/module/SF/shortshell.tpl" assign='form'}
{$form|indent:1}
</div>
