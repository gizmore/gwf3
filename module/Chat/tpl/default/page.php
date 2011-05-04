<h1><?php echo $tLang->lang('pt_chat'); ?></h1>

<?php
$buttons = '';
if ($tVars['gwf_chat'])
{
	$buttons .= GWF_Button::generic($tLang->lang('btn_webchat'), $tVars['href_webchat'], 'generic', '', true);
}
if ($tVars['mibbit'])
{
	$mib_url = $tVars['mibbit_url'];
	$onclick = "window.open('$mib_url', 'dummyname', 'height=undefined,width=undefined', false);";
	$buttons .= GWF_Button::generic($tLang->lang('btn_ircchat'), $tVars['href_ircchat'], 'generic', '', false);
	$buttons .= GWF_Button::generic($tLang->lang('btn_ircchat_full'), '#', 'generic', '', false, $onclick);
}
if ($buttons !== '') {
	echo '<div class="gwf_buttons_outer">'.GWF_HTML::div($buttons, 'gwf_buttons').'</div>'.PHP_EOL;
}

if (!$tVars['gwf_chat']) {
	return;
}
?>

<p><?php echo $tLang->lang('pi_chat'); ?></p>
<p><a href="<?php echo $tVars['href_history']; ?>"><?php echo $tLang->lang('btn_history'); ?></a></p>

<div id="gwfchat_online" class="fl ib">
<?php foreach ($tVars['online'] as $online) { ?>
	<div><?php echo $online->display('chaton_name'); ?></div>
<?php } ?>
</div>

<div class="t">
<?php
//if (count($tVars['privmsgs']) === 0) {
//$tVars['privmsgs'] = array(GWF_ChatMsg::fakeMessage('Welcome', 'Guest', 'Please post hi and choose a nickname.'));
//}
?>
<h3><?php echo $tLang->lang('privmsgs')?></h3>
<table id="gwfchat_privmsg" class="t" border="1">
	<thead>
		<tr>
			<th>DATE</th>
			<th>FROM</th>
			<th>TO</th>
			<th>MSG</th>
		</tr>
	</thead>

	<tbody>
<?php if (count($tVars['privmsgs']) === 0 ) { ?>
		<tr><td>---</td><td>---</td><td>---</td><td>---</td></tr>
<?php } ?>
<?php foreach ($tVars['privmsgs'] as $msg) { ?>
		<tr>
			<td></td>
			<td><?php echo $msg->displayFrom(); ?></td>
			<td><?php echo $msg->displayTo(); ?></td>
			<td><?php echo $msg->displayMessage(); ?></td>
		</tr>
<?php } ?>
	</tbody>
</table>
<hr/>
<h3><?php echo $tLang->lang('pubmsgs')?></h3>
<table id="gwfchat_pubmsg" class="t" border="2">
	<thead>
		<tr>
			<th>DATE</th>
			<th>FROM</th>
			<th>TO</th>
			<th>MSG</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($tVars['msgs'] as $msg) { ?>
	<tr>
		<td></td>
		<td><?php echo $msg->displayFrom(); ?></td>
		<td></td>
		<td><?php echo $msg->displayMessage(); ?></td>
	</tr>
<?php } ?>
	</tbody>
</table>
</div>

<div><?php echo $tVars['form']; ?></div>

<!-- Javascript stuff below here, see also gwf_chat.js -->
<?php
# Convert some stuff to javascript
$convert = array();
foreach ($tVars['msgs'] as $msg)
{
	$convert[] = $msg->getVar('chatmsg_time');
}
$jsaPub = GWF_Javascript::toJavascriptArray($convert);

$convert = array();
foreach ($tVars['privmsgs'] as $msg)
{
	$convert[] = $msg->getVar('chatmsg_time');
}
$jsaPriv = GWF_Javascript::toJavascriptArray($convert);

$convert = array();
foreach ($tVars['online'] as $online)
{
	$convert[] = $online->display('chaton_name');
}
$onlinelist = GWF_Javascript::toJavascriptArray($convert);
?>

<?php 
if (GWF_Browser::isGecko())
{
	$script_html = 'window.onload = function() { ';
	$script_html.= sprintf('gwfchatInit(%d, %d, "%s", %d, %s);'.PHP_EOL, $tVars['maxmsg_pub'], $tVars['maxmsg_priv'], $tVars['nickname'], $tVars['peaktime'], $onlinelist);
	$script_html.= sprintf('gwfchatInitPub(%s);'.PHP_EOL, $jsaPub);
	$script_html.= sprintf('gwfchatInitPriv(%s);'.PHP_EOL, $jsaPriv);
	$script_html.= '};';
}
else
{
	$script_html = 'window.onload = function() { ';
	$script_html.= sprintf('gwfchatInitLaggy(%d, %d, "%s", %d, %s, %d);'.PHP_EOL, $tVars['maxmsg_pub'], $tVars['maxmsg_priv'], $tVars['nickname'], $tVars['peaktime'], $onlinelist, $tVars['lagtime']);
	$script_html.= sprintf('gwfchatInitPub(%s);'.PHP_EOL, $jsaPub);
	$script_html.= sprintf('gwfchatInitPriv(%s);'.PHP_EOL, $jsaPriv);
	$script_html.= '};';
}
GWF_Website::addJavascriptInline($script_html);
?>
