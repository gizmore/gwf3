<span class="ssy_topspace"></span>
{foreach $messages as $type => $msgs}
<ul class="ssy_{$type}">
{foreach $msgs as $title => $msg}
	<li>
		<ul>
{foreach $msg as $message}
			<li>{$message}</li>
{/foreach}
		</ul>
	</li>
{/foreach}
</ul>
{/foreach}
