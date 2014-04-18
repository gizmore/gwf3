<?php
final class Profile_POISRemove extends GWF_Method
{
	public function execute()
	{
		GWF_Website::plaintext();
		GWF3::setConfig('store_last_url', false);
		
		$id = Common::getGetInt('pp_id');
		if (!GWF_ProfilePOI::changeAllowed($id, GWF_Session::getUserID()))
		{
			$this->module->ajaxError('Permission error!');
		}
		
		GDO::table('GWF_ProfilePOI')->deleteWhere("pp_id = $id");
		
		die("$id");
	}
}
