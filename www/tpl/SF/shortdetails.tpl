<p class="copyright fl" style="text-align: left; width: 50%;">
	{$user->displayProfileLink()}
	{$SF->imgCountry()}{GWF_ClientInfo::getIPAddress()}; 
	{GWF_ClientInfo::imgOperatingSystem()}{GWF_ClientInfo::displayOperatingSystem()}; 
	{GWF_ClientInfo::imgBrowser()}{GWF_ClientInfo::displayBrowser()};
	{GWF_ClientInfo::imgProvider()}{GWF_ClientInfo::displayProvider()}
</p>
<p class="copyright fl" style="text-align: right; width: 50%;">
{foreach $SF->getDesignColors() as $dc}
	<a title="{$SF->lang('designcolor', $SF->lang($dc))}" href="{$SF->getIndex('layoutcolor')}layoutcolor={$dc}">
		<img src="{$root}img/SF/circle_{$dc}.png" style="height: 20px; border: 0px;" alt="{$SF->lang('designcolor', $SF->lang($dc))}">
	</a>
{/foreach}
	<a href="{$SF->getIndex('details')}details=shown">
		<img style="/*margin: 10px 0; height: 10px;*/" src="{$root}img/{$iconset}/add.png" alt="[+]" title="Show Details">
	</a>
</p>
