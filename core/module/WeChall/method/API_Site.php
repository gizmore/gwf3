<?php
final class WeChall_API_Site extends GWF_Method
{
	public function execute()
	{
		GWF_Website::plaintext();
		
		if (false === (Common::getGet('no_session'))) {
			die('The mandatory parameter \'no_session\' is not set. Try \'&no_session=1\'.');
		}
		if (false === ($sitename = Common::getGet('sitename'))) {
			die($this->showAllSites());
		}
		if ( (false === ($site = WC_Site::getByName($sitename))) && (false === ($site = WC_Site::getByClassName($sitename))) ) {
			die($this->module->lang('err_site'));
		}
		die($this->showSite($site));
	}
	
	private function showAllSites()
	{
		if (false === ($sites = WC_Site::getSites('site_name ASC'))) {
			return GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$back = '';
		foreach ($sites as $site)
		{
			$site instanceof WC_Site;
			if ($site->getURL() !== '')
			{
				$back .= $this->showSite($site);
			}
		}
		return $back;
	}

	private function showSite(WC_Site $site)
	{
		# Sitename::Classname::Status::
		# URL::ProfileURL::
		# Usercount::Linkcount::Challcount::
		# Basescore::Average::Score
		return sprintf('%s::%s::%s::%s::%s::%s::%s::%s::%s::%.02f%%::%s',
			$this->escapeCSV($site->getVar('site_name')),
			$this->escapeCSV($site->getVar('site_classname')),
			$site->getVar('site_status'),
			
			$this->escapeCSV($site->getVar('site_url')),
			$this->escapeCSV($site->getVar('site_url_profile')),
			
			$site->getVar('site_usercount'),
			$site->getVar('site_linkcount'),
			$site->getVar('site_challcount'),
			
			$site->getVar('site_basescore'),
			$site->getVar('site_avg')*100,
			$site->getVar('site_score')
			
		).PHP_EOL;
	}
	
	private function escapeCSV($string)
	{
		return str_replace(array(':', "\n"), array('\\:', "\\\n"), $string);
	}
}
?>