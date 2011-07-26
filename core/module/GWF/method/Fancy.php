<?php

/**
 * For Fancy Indexing
 * @author spaceone
 * @see http://httpd.apache.org/docs/2.0/mod/mod_autoindex.html
 */
final class GWF_Fancy extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		#PHP workability; please add to your vhosts if AllowOverride All is deactivated!
		$ret = 'AddType text/html .php'.PHP_EOL;
		$ret .= '<Files "*.php">'.PHP_EOL;
		$ret .= '    AddHandler application/x-httpd-php .php'.PHP_EOL;
		$ret .= '</Files>'.PHP_EOL.PHP_EOL;
		
		# The Fancy Options
		$ret .= 'IndexOptions FancyIndexing'.PHP_EOL;
		$ret .= 'IndexOptions';
		$ret .= ' NameWidth='.$module->cfgNameWidth(); 
		$ret .= ' DescriptionWidth='.$module->cfgDescriptionWidth();
		$ret .= ' IconHeight='.$module->cfgIconHeight();
		$ret .= ' IconWidth='.$module->cfgIconWidth().PHP_EOL;
		
		$ret .= 'IndexOptions ';
		$ret .= $module->cfgSuppressHTMLPreamble() ? 'SuppressHTMLPreamble ' : '';
		$ret .= $module->cfgFoldersFirst() ? 'FoldersFirst ' : '';
		$ret .= $module->cfgScanHTMLTitles() ? 'ScanHTMLTitles ' : '';
		$ret .= $module->cfgHTMLTable() ? 'HTMLTable ' : '';
		$ret .= $module->cfgSuppressDescription() ? 'SuppressDescription ' : '';
		$ret .= $module->cfgSuppressRules() ? 'SuppressRules '.PHP_EOL : PHP_EOL;
	
		# The Fancy URLs
		$ret .= 'HeaderName /index.php?mo=GWF&me=Fancy&fancy=head'.PHP_EOL;
		$ret .= 'ReadmeName /index.php?mo=GWF&me=Fancy&fancy=foot'.PHP_EOL;
		
		return $ret.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		GWF3::setDesign($module->cfgDesign());
		switch(Common::getGet('fancy', 'head'))
		{
			case 'head': 
				GWF_Website::addCSS(sprintf('/tpl/%s/css/fancy.css', GWF3::getDesign()));
				die(GWF3::onDisplayHead());
			break;
			case 'foot' : 
				die(GWF3::onDisplayFoot());
			break;
		}
	}	
}