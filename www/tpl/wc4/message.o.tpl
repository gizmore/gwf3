<div class="gwf_messages">
	<span class="gwf_msg_t">{$title}</span>
		<ul>
{foreach $messages as $message}
{foreach ($message['messages']) as $msg}
		<li>{$msg}</li>
{/foreach}
{/foreach}
		</ul>
</div>
<div class="cl"></div>
