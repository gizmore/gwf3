<ul class="shell_output">
{foreach $functions as $function}
	<li>{$function}: {$module->lang("tt_{$function}")}</li>
{/foreach}
</ul>
