{if $mo eq 'Tamagochi' AND $me eq 'Home' }
<body ng-controller="TGCCtrl">
{else}
<body>
{include file='tpl/tamagochi/header.tpl'}
{include file='tpl/tamagochi/menu_top.tpl'}
<div id="errors">{$errors}</div>
{/if}
