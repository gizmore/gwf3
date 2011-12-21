<?php

final class SF_md5 extends SF_Function
{
	public function execute()
	{
		$args = $this->parseArgs();
		// The md5Sum for %s is %s.
		return $lang->lang('md5', htmlspecialchars($args[0]), $md5($args[0]);
	}
}
