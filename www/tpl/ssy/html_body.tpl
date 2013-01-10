<body>
<div id="ssy_wrap"{if SSYHTML::$wantFooter} style="margin-bottom: -30px;"{/if}' class="ssy1600h{if SSYHTML::$wantRightPanel}_faux{/if}">

{if SSYHTML::$wantRightPanel}
	<div id="ssy_right">
		{SSYHTML::getRosePlain()}
		<br/>
		{SSYHTML::getMenuS()}
	</div>
{/if}
	<div id="ssy_main"{SSYHTML::getFauxClass()}>
