{assign var='k' value=$gwf->Module()->loadModuleDB('Konzert', true, true)}
{$gwf->Website()->addJavascript("{$root}tpl/konz/js/konzert.js")}
{$gwf->Website()->addJavascriptInline('$(document).ready(function() { konzertContactData(); } );')}
<h1>{$lang->lang('contact_title')}</h1>

{*
<div class="box box_c">
	<p>{$lang->lang('list_admins', array($admin_profiles))}</p>
	<p>{$lang->lang('contact_info', array($email))}</p>
</div>
*}

<div class="box box_c ce">
	<h3>{$k->lang('name')}</h3>
	<p id="email_mg">Sie benötigen javascript</p>
	<p id="phone_mg">um weitere Informationen anzuzeigen</p>
</div>

<div class="box box_c">
	<div class="fl mugshot_outer">
		<a href="/tpl/konz/bild/131_large.jpg" class="fl mugshot"><img src="/tpl/konz/bild/131.jpg" title="{$k->lang('name')}" alt="{$k->lang('foto')}" class="mugshot" /></a>
	</div>
	<div>{$form}</div>
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
