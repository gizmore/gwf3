<?php
require_once GWF_CORE_PATH.'module/PageBuilder/GWF_PB_Rewrites.php';

/**
 * 
 * @author spaceone
 */
final class PageBuilder_Links extends GWF_Method
{
	protected $_tpl = 'links.tpl';

	public function getUserGroups() { return 'admin'; }
	public function getHTAccess(GWF_Module $module)
	{
		$this->_module->includeClass('GWF_PageLinks');
		$links = GDO::table('GWF_PageLinks')->selectAll('link_url, link_href', '', '', NULL, -1, -1, GDO::ARRAY_N);
		$back = '## Links ##'.PHP_EOL;
		$back .= 'RewriteRule ^PageBuilder/Links/delete/(.*?)$ index.php?mo=PageBuilder&me=Links&delete=$1'.PHP_EOL;
		$back .= 'RewriteRule ^PageBuilder/Links/?$ index.php?mo=PageBuilder&me=Links'.PHP_EOL;

		foreach ($links as $link)
		{
			$url = GWF_PB_Rewrites::replaceRewriteURL($link[0]);
			$href = GWF_PB_Rewrites::replaceRewriteURL($link[1]);
			$back .= "RewriteRule ^{$url}/?$ {$href}".PHP_EOL;
		}
		return $back;
	}

	public function execute(GWF_Module $module)
	{
		$back = '';
		$write = false;
		
		if(true === isset($_GET['delete']))
		{
			$write = true;
			if(false === GWF_PageLinks::deleteLink($_GET['delete']))
			{
				$back .= $this->_module->error('err_deleting_failed');
			}
		}

		if(true === isset($_POST['add']))
		{
			$url = Common::getPostString('url');
			$href = Common::getPostString('href');

			if(('' !== $url) && ('' !== $href))
			{
				if($url[0] === '/')
				{
					$url = substr($url, 1);
				}
				
				if(true === GWF_PB_Rewrites::matchURL(Common::substrUntil(GWF_PB_Rewrites::replaceRewriteURL($url), '/')))
				{
					$back .= $this->_module->error('err_url_exists');
				}
				else
				{
					$write = true;
					GWF_PageLinks::insertLink($url, $href);
				}
			}
			else
			{
				$back .= $this->_module->error('err_parame');
			}
		}
		
		if(true === $write && false === $this->_module->writeHTA())
		{
				$back .= $this->_module->error('err_htaccess_writing');
		}
		
		return $back.$this->templateLinks($this->_module);
	}

	public function formLinks()
	{
		$data = array(
			'url' => array(GWF_Form::STRING, '', 'URL: '),
			'href' => array(GWF_Form::STRING, '', 'HREF: '),
			'add' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_add_link'), ''),
		);
		
		return new GWF_Form($this, $data);
	}

	public function templateLinks()
	{
		if(false === ($links = GDO::table('GWF_PageLinks')->selectAll()))
		{
			$links = array();
		}
		
		$tVars = array('links' => $links, 'form' => $this->formLinks($this->_module));
		
		return $this->_module->template($this->_tpl, $tVars);
	}
}
