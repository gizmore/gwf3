{foreach $messages as $type => $msgs}
<ul class="gwf_{$type}">
{foreach $msgs as $title => $msg}
	<li><span class="gwf_err_t">{$title}</span>
		<ul>
{foreach $msg as $message}
			<li>{$message}</li>
{/foreach}
		</ul>
	</li>
{/foreach}
</ul>
{/foreach}
