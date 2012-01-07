<h1>Intro</h1>
{if $playmusic}
<audio autoplay="autoplay">
	<source src="/tpl/konz/audio/intro.ogg" type="audio/ogg" />
	<source src="/tpl/konz/audio/intro.mp3" type="audio/mpeg" />
</audio>

{/if}
<div id="notenst">
	<div id="notenbu">
		<div id="notenbuc">{$gwff->module_Konzert_buchseite('motto','motto1','motto2')}</div>
	</div>
</div>
