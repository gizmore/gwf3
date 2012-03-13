<h2 class="ghost">{$text}</h2>

<div class="ce">
	<div class="fh ib">
	<div class="fh ib fl">{include file="tpl/default/module/Konzert/mugshot.tpl" small='/tpl/konz/bild/131.jpg' large='/tpl/konz/bild/131_large.jpg' title=$t1 alt=$altimg text=''}</div>
	<div class="fh ib">
		<ul class="le">
	{foreach from=$rep item=r}
			<li>{$r}</li>
	{/foreach}
		</ul>
	</div>
	</div>
</div>
