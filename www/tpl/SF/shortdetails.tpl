			<p style="text-align: left; float: left; width: 50%;" class="copyright">
				<a href="{$root}profile/{$user->displayUsername()}" title="{$user->displayUsername()}'s Profile">{$user->displayUsername()}</a>: 
				{* TODO: Delete imgShit.. better way!!!*}
				{$SF->imgCountry()}{$SF->getIP()}; 
				{$SF->imgOS()}{$SF->getOS()}; 
				{$SF->imgBrowser()}{$SF->getBrowser()};
				{$SF->imgProvider()}{$SF->getProvider()}
			</p>
			<p class="copyright" style="text-align: right; float: left; width: 50%;">
{foreach $SF->getDesignColors() as $dc}
				<a title="{$SF->lang('designcolor', $SF->lang($dc))}" href="{$SF->getIndex('layoutcolor')}layoutcolor={$dc}">
					<img src="{$root}img/SF/circle_{$dc}.png" style="height: 20px; border: 0px;" alt="{$SF->lang('designcolor', $SF->lang($dc))}">
				</a>
{/foreach}
				<a href="{$SF->getIndex('details')}details=shown">
					<img style="/*margin: 10px 0; height: 10px;*/" src="{$root}img/{$iconset}/add.png" alt="[+]" title="Show Details">
				</a>
			</p>
