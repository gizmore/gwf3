<html xmlns="http://www.w3.org/1999/xhtml" lang="{$language}">
<head>
	<title>{$page_title}</title>

	<meta name="robots" content="index, follow" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="generator" content="GWFv{$smarty.const.GWF_CORE_VERSION}" />

	{$meta}

{if $mo eq 'Tamagochi' AND $me eq 'Home' }
	<link rel="stylesheet" href="{$root}tpl/tamagochi/bower_components/angular-ui/build/angular-ui.css">
	<link rel="stylesheet" href="{$root}tpl/tamagochi/bower_components/angular-material/angular-material.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="{$root}tpl/tamagochi/css/tamagochi.css">
{else}
	<link rel="stylesheet" href="{$root}tpl/tamagochi/css/tamagochi-site.css">
{/if}

	{$head_links}

	{$js}

</head>
