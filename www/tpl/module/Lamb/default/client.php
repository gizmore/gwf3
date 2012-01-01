<div><?php echo $tVars['select_account']; ?></div>
<?php if ($tVars['player'] === false) { return; } ?>
<div class="fl">
	<div id="sl4_equipment"><?php echo $tVars['equipment']; ?></div>
	<div id="sl4_inventory"><?php echo $tVars['inventory']; ?></div>
	<div id="sl4_cyberware"><?php echo $tVars['cyberware']; ?></div>
</div>
<div class="oa">
	<div id="sl4_stats"><?php echo $tVars['stats']; ?></div>
	<div id="sl4_party"><?php echo $tVars['party']; ?></div>
<pre id="sl4_messages">
</pre>
	<div id="sl4_cmdbar"><?php echo $tVars['commands']; ?></div>
	<div><input type="text" name="sl4_command" /><input type="submit" name="submit" value="RAW" onclick="sl4SendRaw(); return false;" /><input type="submit" name="sl4Clear" value="Clear console" onclick="return sl4ClearMessages();" /></div>
</div>
<div class="cl"></div>

<div id="sl4_item"></div>
<div id="sl4_sitem"></div>
<div id="sl4_locations"><?php echo $tVars['locations']; ?></div>
<div id="sl4_talkbox"></div>