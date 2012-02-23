<?php
/**
 *
 *
 */
class Navigation_Admin extends GWF_Method
{
	protected $_tpl = 'admin.tpl';

	public function getUserGroups() { return array('admin', 'staff'); }

	public function getHTAccess() 
	{
		$back  = 'RewriteRule ^navigation/admin/?$ index.php?mo=Navigation&me=Admin'.PHP_EOL;
		$back .= 'RewriteRule ^navigation/admin/(?:new|add)/?$ index.php?mo=Navigation&me=Edit&action=new'.PHP_EOL;
		$back .= 'RewriteRule ^navigation/admin/(delete|copy)/([0-9]+)(/[A-Za-z\s]*)?$ index.php?mo=Navigation&me=Admin&action=$1&nid=$2&nname=$3'.PHP_EOL;
		return $back;
	}

	/**
	 * @todo try to get Navi-Name
	 * @todo rethink
	 */
	public function execute()
	{
		$nid = Common::getGetInt('nid');
		$name = Common::getGetString('nname', 'unknown');

		$back = '';
		# Delete a Navigation?
		if ('delete' === ($action = Common::getGet('action')))
		{

			if ($nid <= 0 || false === $this->onDelete($nid))
			{
				# couldnt delete the navi! does it exists?
				$back = $this->module->error('err_delete', $name);
			}
			else
			{
				$back = $this->module->message('succ_delete', $name);
			}
		}
		elseif ('copy' === $action)
		{
			$back = $this->onCopy();
		}
		# multiple/Edit actions?
		elseif (false !== ($delete = Common::getPostArray('delete')))
		{
			$back .= $this->onEdit($delete);
		}
		return $back.$this->templateAdmin();
	}

	private function onDelete($nid)
	{
		return GWF_Navigations::deleteNavigation($nid);
	}

	private function onEdit(array $delete)
	{
		$back = '';
		
		foreach ($delete as $id)
		{
			$id = (int)$id;
			$name = $id;
			if(false === $this->onDelete($nid))
			{
				$back .= $this->module->error('err_delete', $name);
			}
			else
			{
				$back .= $this->module->message('succ_delete', $name);
			}
		}

		return $back;
	}

	private function templateAdmin()
	{
		$tVars = array(
			'navigations' => GWF_Navigations::getNavigations(),
		);
		
		return $this->module->template($this->_tpl, $tVars);
	}
	
}
