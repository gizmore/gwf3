<a href="{$root}profile/{$user->display('user_name')}" title="{$user->display('user_name')}'S Profile">{$user->display('user_name')}</a>: 
{$SF->imgCountry()}{$SF->getIP()}; 
{$SF->imgOS()}{$SF->getOS()}; 
{$SF->imgBrowser()}{$SF->getBrowser()};
{$SF->imgProvider()}{$SF->getProvider()}

<span style="float:right;">
<a title="Designfarbe: Rot" href="{$SF->getIndex('layoutcolor')}layoutcolor=red">
	<img src="{$root}img/SF/circle_red.png" style="height: 20px; border: 0px;" alt="Designfarbe:Rot">
</a>
<a title="Designfarbe: Blau" href="{$SF->getIndex('layoutcolor')}layoutcolor=blue">
     <img src="{$root}img/SF/circle_blue.png" style="height: 20px; border: 0px;" alt="Designfarbe:Blau">
</a>
<a title="Designfarbe: Grün" href="{$SF->getIndex('layoutcolor')}layoutcolor=green">
     <img src="{$root}img/SF/circle_green.png" style="height: 20px; border: 0px;" alt="Designfarbe:Grün">
</a>
<a title="Designfarbe: Orange" href="{$SF->getIndex('layoutcolor')}layoutcolor=orange">
     <img src="{$root}img/SF/circle_orange.png" style="height: 20px; border: 0px;" alt="Designfarbe:Orange">
</a>
<a href="{$SF->getIndex('details')}details=shown"><img style="margin: 10px 0; height: 10px;" src="{$root}img/{$iconset}/add.png" alt="[+]" title="Show Details"></a>
</span>
