<div id="topmenu">
		{* Both *}
		<a href="{$root}news">{Module_Wanda::instance()->lang('menu_news')}{GWF_Notice::getUnreadNews($user)}</a>
		<a href="{$root}downloads">{Module_Wanda::instance()->lang('menu_download')}</a>
		<a href="{$root}wanda/book/1/page/1">{Module_Wanda::instance()->lang('menu_book')}</a>

		{* Member *}
		{if $user->isLoggedIn()}
		{if $user->isStaff()}
		{/if}
		{if $user->isAdmin()}
		<a href="{$root}nanny">{Module_Wanda::instance()->lang('menu_admin')}</a>
		{/if}
		<a href="{$root}logout">{Module_Wanda::instance()->lang('menu_logout')}</a>[<a href="{$root}account">{$user->display('user_name')}</a>]
		{* Guest *}
		{else}
		<a href="{$root}login">{Module_Wanda::instance()->lang('menu_login')}</a>
		<a href="{$root}register">{Module_Wanda::instance()->lang('menu_register')}</a>
		{/if}
		
	</ul>
</div>
