<?php

final class SF_who extends SF_Function
{
	public function execute()
	{
		// TODO.
		if (false !== ($heart = GWF_Module::loadModuleDB('Heart')))
		{
			return sprintf('<span id="gwf_heartbeat">%s</span>', $heart->execute('Beat'));
		}
		else
		{
			return 'nobody';
		}
	}
}
