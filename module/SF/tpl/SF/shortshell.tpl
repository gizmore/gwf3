<pre class="logo" id="shell_logo">
    .--.      _____________________________________________________________
   |o_o |    /    WELCOME TO       {$SF->lang($SF->getGreeting())}                            \
   |:_/ | --&lt;|       WWW.FLORIAN     {$SF->getDayinfos()}|
  //   \ \   \           BEST.DE !!!  Es ist {date('G:i:s')} Uhr                   /
 (|     | )   --------------------------------------------------------------
/'\_   _/`\ type in ´help´ for
\___)=(___/  a list of commands!
</pre>
<form method="GET" action="{$SF->getFormaction('shell')}">
	<p class="shell">
		<span class="bold shell_{if $user->isAdmin()}admin{else}user{/if}">{$user->displayUsername()}@{$SF->getServerName()}</span>
		<span class="bold shell_dir">{$SF->getPath()}{if $user->isAdmin()} # {else} $ {/if}</span>
		<input type="hidden" name="mo" value="SF">
		<input type="hidden" name="me" value="Shell">
		<input type="text" size="8" value="cmd" name="cmd" class="shell border">
		<input type="submit" value=" " name="submit" class="shell">
		<br/><br/>
	</p>
</form>