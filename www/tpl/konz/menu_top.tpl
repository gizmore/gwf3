{assign var='user' value=$gwf->User()->getStaticOrGuest()}
{assign var='k' value=$gwf->Module()->loadModuleDB('Konzert', true, true)}
<div id="gwf3_topmenu">
	<ul>
{if $gwf->Language()->getCurrentISO() === 'en'}
		<li><a href="/de{$gwf->Session()->getCurrentURL()}"><img src="/img/country/17" width="24" height="16" alt="Deutsch" title="Deutsche Sprache auswählen" /></a></li>
{else}
		<li><a href="/en{$gwf->Session()->getCurrentURL()}"><img src="/img/country/2" width="24" height="16" alt="English" title="Select english language" /></a></li>
{/if}

		<li><a href="{$root}startseite.html">{$k->lang('menu_int')}</a></li>
		<li><a href="{$root}melanie_gobbo.html">{$k->lang('menu_ww')}</a></li>
		<li><a href="{$root}biography.html">{$k->lang('menu_bio')}</a></li>
		<li><a href="{$root}repertoire.html">{$k->lang('menu_rep')}</a></li>
		<li><a href="{$root}arrangements.html">{$k->lang('menu_arr')}</a></li>
		<li><a href="{$root}konzerttermine.html">{$k->lang('menu_ter')}</a></li>
		<li><a href="{$root}ensemble.html">{$k->lang('menu_ens')}</a></li>
		<li><a href="{$root}presseberichte.html">{$k->lang('menu_pre')}</a></li>
		<li><a href="{$root}hoehrproben.html">{$k->lang('menu_hoe')}</a></li>
		<li><a href="{$root}exklusiv.html">{$k->lang('menu_exk')}</a></li>
		<li><a href="{$root}kontakt.html">{$k->lang('menu_kon')}</a></li>
		<li><a href="{$root}impressum.html">{$k->lang('menu_imp')}</a></li>
		<li><a href="{$root}sponsoren.html">{$k->lang('menu_spo')}</a></li>

		{if $user->isAdmin()}
		<li><a href="{$root}nanny">Admin</a></li>
		{/if}
	</ul>
</div>
