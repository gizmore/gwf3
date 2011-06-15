<html lang="{$language}" dir="ltr">
<head>
	<title>{$page_title}</title>
{if $SF->is_displayed('base')}
	<base href="http://{$smarty.server['SERVER_NAME']}">
{/if}
	{$meta}
	<link rel="shortcut icon" href="/templates/{$SF->design()}/{$SF->layout()}/images/favicon.ico">
	<link rel="alternate stylesheet" href="/templates/{$SF->design()}/css/print.css" title="PrintView" type="text/css">
	<link rel="stylesheet" href="/templates/{$SF->design()}/css/print.css" type="text/css" media="print">
	{$css}
	<!--[if lt IE 8]>
		<link rel="stylesheet" type="text/css" href="/templates/{$SF->design()}/css/ie.css" />
	<![endif]-->

</head>