<?php
function module_Heart_beat()
{
	if (false !== ($heart = GWF_Module::loadModuleDB('Heart'))) {
		printf('<span id="gwf_heartbeat">%s</span>', $heart->execute('Beat'));
	}
}
?>