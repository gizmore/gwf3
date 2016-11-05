<div id="tgc-main-menu">
{* Both *}
	<div><a href="{$root}news">{Module_Tamagochi::instance()->lang('menu_news')}{GWF_Notice::getUnreadNews($user)}</a></div>
	<div><a href="{$root}tgc-game">{Module_Tamagochi::instance()->lang('menu_game')}</a></div>
	<div><a href="{$root}forum">{Module_Tamagochi::instance()->lang('menu_forum')}</a></div>

{* Member *}
{if $user->isLoggedIn()}
	<div><a href="{$root}pm">{Module_Tamagochi::instance()->lang('menu_pm')}</a></div>

{if $user->isStaff()}{/if}
{if $user->isAdmin()}
	<div><a href="{$root}nanny">{Module_Tamagochi::instance()->lang('menu_admin')}</a></div>
{/if}
	<div><a href="{$root}logout">{Module_Tamagochi::instance()->lang('menu_logout')}</a>[<a href="{$root}account">{$user->display('user_name')}</a>]</div>
{* Guest *}
{else}
	<div><a href="{$root}login">{Module_Tamagochi::instance()->lang('menu_login')}</a></div>
	<div><a href="{$root}register">{Module_Tamagochi::instance()->lang('menu_register')}</a></div>
{/if}
</div>
