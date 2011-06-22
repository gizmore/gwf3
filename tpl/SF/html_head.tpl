<html lang="{$language}" dir="ltr">
<head>
	<title>{$page_title}</title>
{if $SF->is_displayed('base')}
	<base href="http://{$smarty.server['SERVER_NAME']}">
{/if}
	{$meta}
	<link rel="shortcut icon" href="/templates/{$SF->getDesign()}/{$SF->getLayout()}/images/favicon.ico">
	<link rel="alternate stylesheet" href="/templates/{$SF->getDesign()}/css/print.css" title="PrintView" type="text/css">
	<link rel="stylesheet" href="/templates/{$SF->getDesign()}/css/print.css" type="text/css" media="print">
	{$css}
	<!--[if lt IE 8]>
		<link rel="stylesheet" type="text/css" href="/templates/{$SF->getDesign()}/css/ie.css" />
	<![endif]-->

</head>