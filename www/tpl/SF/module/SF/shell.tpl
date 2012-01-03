<div class="SF_Shell">
	<pre class="logo" id="shell_logo">
    .--.      _____________________________________________________________
   |o_o |    /    WELCOME TO       {$SF->lang($SF->getGreeting())}                            \
   |:_/ | --&lt;|       WWW.FLORIAN     {$SF->getDayinfos()}|
  //   \ \   \           BEST.DE !!!  Es ist {date('G:i:s')} Uhr                   / {*$days_to_weekend*} {*sternzeichen*}
 (|     | )   --------------------------------------------------------------
/'\_   _/`\ type in ´help´ for
\___)=(___/  a list of commands!
	</pre>
	<p class="shell">
			<span class="bold shell_{if $user->isAdmin()}admin{else}user{/if}">{$user->displayUsername()}@{$SF->getServerName()}</span>
			<span class="bold shell_dir">{$SF->getLastURL()}{if $user->isAdmin()} # {else} $ {/if}</span> {$lastCMD}
	</p>
	<p class="shell_output">
		{$output}
		<br/>
	</p>
	<form method="GET" action="{$root}index.php">
		<p class="shell">
			<span class="bold shell_{if $user->isAdmin()}admin{else}user{/if}">{$user->displayUsername()}@{$SF->getServerName()}</span>
			<span class="bold shell_dir">{$SF->getPath()}{if $user->isAdmin()} # {else} $ {/if}</span>
			<input type="text" size="8" value="cmd" name="cmd" class="shell border">
			<input type="hidden" name="mo" value="SF">
			<input type="hidden" name="me" value="Shell">
			<input type="submit" value=" " name="submit" class="shell">
			<br/><br/>
		</p>
	</form>
	
</div>
