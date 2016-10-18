<?php
#https://embed.mibbit.com/?server=storm.psych0tik.net%3A%2B6697&channel=%23hbh&forcePrompt=true

GWF_Website::addJavascript(GWF_WEB_ROOT.'js/module/Chat/gwf_mibbit.js?v=1');
GWF_Website::addJavascriptInline("window.onload=gwfMibbitInit; window.onresize=gwfMibbitInit;");
?>

<h1><?php echo $tLang->lang('pt_irc_chat'). ' ( '.GWF_HTML::display($tVars['module']->cfgIRCURL()).' )'; ?></h1>

<?php
$buttons = '';
if ($tVars['gwf_chat'])
{
	$buttons .= GWF_Button::generic($tLang->lang('btn_webchat'), $tVars['href_webchat'], 'generic', '', false);
}
if ($tVars['mibbit'])
{
	$mib_url = $tVars['mibbit_url'];
	$onclick = "window.open('$mib_url', 'dummyname', 'height=undefined,width=undefined', false);";
	$buttons .= GWF_Button::generic($tLang->lang('btn_ircchat'), $tVars['href_ircchat'], 'generic', '', true);
	$buttons .= GWF_Button::generic($tLang->lang('btn_ircchat_full'), '#', 'generic', '', false, $onclick);
}
if ($buttons !== '') {
	echo '<div class="gwf_buttons_outer">'.GWF_HTML::div($buttons, 'gwf_buttons').'</div>'.PHP_EOL;
}
?>

<iframe id="gwf_mibbit" src="<?php echo $tVars['mibbit_url']; ?>">
<?php echo GWF_HTML::error('Chat', $tLang->lang('err_iframe'), false); ?>
</iframe>
