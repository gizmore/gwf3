{assign var='k' value=$gwf->Module()->loadModuleDB('Konzert', true, true)}
{$gwf->Website()->addJavascript("{$root}tpl/konz/js/konzert.js")}
{$gwf->Website()->addJavascriptInline('$(document).ready(function() { konzertContactData(); } );')}

<h1>{$lang->lang('contact_title')}</h1>

<div id="contact">
	<div class="contact_img">{include file="{$core}module/Konzert/tpl/default/mugshot.tpl" small='/tpl/konz/bild/131.jpg' large='/tpl/konz/bild/131_large.jpg' title=$k->lang('name') alt=$k->lang('foto') text=''}</div>
	<div class="contact">{$form}</div>
	<div class="cb"></div>
</div>

<hr/>

<div class="box box_c ce">
	<h3>Management:</h3>
	<p>Edelgard Haferkamp</p>
	<p>Veranstaltungsorganisation</p>
	<p>Springwall 15</p>
	<p>47051 Duisburg</p>
	<p id="email_va">Sie benötigen javascript</p>
	<p id="phone_va">um weitere Informationen anzuzeigen</p>
</div>
