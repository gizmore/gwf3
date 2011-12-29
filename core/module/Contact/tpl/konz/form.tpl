{assign var='k' value={GWF_Module::loadModuleDB('Konzert', true, true)}}
{GWF_Website::addJavascript("{$root}tpl/konz/js/konzert.js")}
{GWF_Website::addJavascriptOnload('konzertContactData();')}
{$k->setNextHREF("{$root}impressum.html")}

<h1>{$lang->lang('contact_title')}</h1>

<div id="contact">
	<div class="contact_img">{include file="{$core}module/Konzert/tpl/default/mugshot.tpl" small='/tpl/konz/bild/196.jpg' large='/tpl/konz/bild/196_large.jpg' title=$k->lang('name') alt=$k->lang('foto') text=''}</div>
	<div class="contact">{$form}</div>
	<div class="cb"></div>
</div>

<hr/>

<div>
	<div class="contact_img">{include file="{$core}module/Konzert/tpl/default/mugshot.tpl" small='/tpl/konz/bild/717.jpg' large='/tpl/konz/bild/717_large.jpg' title=$k->lang('name') alt=$k->lang('foto') text=''}</div>
	<div class="contact">
		<h3>Management:</h3>
		<p>Edelgard Haferkamp</p>
		<p>Veranstaltungsorganisation</p>
		<p>Springwall 15</p>
		<p>47051 Duisburg</p>
		<p id="email_va">Sie benötigen javascript</p>
		<p id="phone_va">um weitere Informationen anzuzeigen</p>
	</div>
</div>

<div class="cb"></div>
