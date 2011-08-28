<?php
function module_Heart_beat()
{
	if (false !== ($heart = GWF_Module::loadModuleDB('Heart', false, false, true)))
	{
		printf('<span id="gwf_heartbeat">%s</span>', $heart->execute('Beat'));
	}
}
?>