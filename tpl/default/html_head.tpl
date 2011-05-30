<head>
	<title>{$page_title}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="{$language}" /> {* w3c validator says: NO *}
	<meta name="robots" content="index, follow" />
	{$meta}
	<meta name="generator" content="GWFv{$smarty.const.GWF_CORE_VERSION}" />
	<link rel="shortcut icon" href="{$favicon}" />
	<link rel="stylesheet" type="text/css" href="{$root}tpl/default/css/gwf3.css" />
	<script type="text/javascript" src="{$root}js/gwf3.js?v=1"></script>
	{*find a better way with GWF_Website::includeJquerry into $css*}
	<script type="text/javascript" src="{$root}js/jquery-1.4.2.min.js"></script>
	{$js}
	{$css}
	{$feeds}
</head>
