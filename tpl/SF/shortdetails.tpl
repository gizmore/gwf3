<a href="{$root}profile/{$user->display('user_name')}" title="{$user->display('user_name')}'S Profile">{$user->display('user_name')}</a>: 
{$SF->imgCountry()}{$SF->getIP()}; 
{$SF->imgOS()}{$SF->getOS()}; 
{$SF->imgBrowser()}{$SF->getBrowser()};
{$SF->imgProvider()}{$SF->getProvider()}

<span style="float:right;">
<a href="{$SF->getIndex('details')}details=shown"><img style="margin: 10px 0; height: 10px;" src="{$root}img/{$iconset}/add.png" alt="[+]" title="Show Details"></a>
</span>