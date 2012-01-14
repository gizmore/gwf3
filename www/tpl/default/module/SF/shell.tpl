<div class="SF_Shell">

	{$output}
	
	<form method="POST" action="{$root}index.php?mo=SF&me=Shell">
		<p class="shell">
			<span class="bold shell_{if $user->isAdmin()}admin{else}user{/if}">{$user->displayUsername()}@{$smarty.server['SERVER_NAME']}</span>
			<span class="bold shell_dir">{$module->getShellPath()}{if $user->isAdmin()} # {else} $ {/if}</span>
			<input type="text" size="8" value="cmd" name="cmd" class="shell border">
			<input type="submit" value=" " name="submit" class="shell">
			<br/><br/>
		</p>
	</form>
	
</div>
