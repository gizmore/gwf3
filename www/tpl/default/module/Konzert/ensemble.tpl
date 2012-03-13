<h1>{$title}</h1>
<p class="ghost">{$text}</p>
<div class="ce">
	<div class="ib" style="padding-top: 30px;">
		<div class="fl">{include file="tpl/default/module/Konzert/mugshot.tpl" small='/tpl/konz/bild/218.jpg' large='/tpl/konz/bild/218_large.jpg' title=$t1 alt=$altimg1 text=$t1}</div>
		<div class="fl">{include file="tpl/default/module/Konzert/mugshot.tpl" small='/tpl/konz/bild/Trio_3.jpg' large='/tpl/konz/bild/Trio_3_large.jpg' title=$t2 alt=$altimg2 text=$t2}</div>
		<div class="cl"></div>
	</div>
</div>
<p>{$text2}</p>
<ol>
{foreach from=$types item=li}
	<li>{$li}</li>
{/foreach}
</ol>
<p>{$other}</p>
