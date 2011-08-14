<div class="gwf_errors">
	<span class="gwf_err_t">Error</span>
	<ul>
{foreach ($errors) as $error}
{foreach ($error['messages']) as $msg}
		<li>{$error['title']}: {$msg}</li>
{/foreach}{/foreach}
	</ul>
</div>
<div class="cl"></div>