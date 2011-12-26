{$SF->getWelcomeComment()}
<html lang="{$language}" dir="ltr">
<head>
	<title>{$page_title}</title>
{if $SF->isDisplayed('base')}
	<base href="http://{$smarty.server['SERVER_NAME']|escape}">
{/if}
	{$meta}
	<link rel="shortcut icon" href="{$root}tpl/{$design}/{$layout}/img/favicon.ico">
	<link rel="icon" href="{$root}tpl/{$design}/{$layout}/img/favicon.ico">
	<link rel="alternate stylesheet" href="{$root}tpl/{$design}/css/print.css" title="PrintView" type="text/css">
	<link rel="stylesheet" href="{$root}tpl/{$design}/css/print.css" type="text/css" media="print">
	{$css}
	<!--[if lt IE 8]>
		<link rel="stylesheet" type="text/css" href="{$root}tpl/{$design}/css/ie.css" />
	<![endif]-->
</head>
