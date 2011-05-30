<html lang="{$language}" dir="ltr">

<head>
	<title>{$page_title}</title>
	<base href="http://{$smarty.server['SERVER_NAME']}">

	{*<meta name="keywords" content="{$meta_tags}" />
	<meta name="description" content="{$meta_descr}" />*}
	{$meta}
	<link rel="shortcut icon" href="/templates/{$smarty.const.GWF_DEFAULT_DESIGN}/{$settings['template']['layout']}/images/favicon.ico">
	<link rel="alternate stylesheet" href="/templates/{$smarty.const.GWF_DEFAULT_DESIGN}/css/print.css" title="PrintView" type="text/css">
	<link rel="stylesheet" href="/templates/{$smarty.const.GWF_DEFAULT_DESIGN}/css/print.css" type="text/css" media="print">
	{$css}
	<!--[if lt IE 8]>
		<link rel="stylesheet" type="text/css" href="/templates/{$smarty.const.GWF_DEFAULT_DESIGN}/css/ie.css" />
	<![endif]-->

</head>