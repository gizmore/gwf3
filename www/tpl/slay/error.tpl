<div class="gwf_errors">
	<span class="gwf_err_t">{$title}</span>
	<ul>
{foreach ($errors) as $error}
{foreach ($error['messages']) as $msg}
		<li>{$msg}</li>
{/foreach}{/foreach}
	</ul>
</div>
