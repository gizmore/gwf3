<?php
/**
 * Execute PHP Code for debugging purposes
 * @author spaceone
 */
final class SF_Debug extends GWF_Method
{
	public function getUserGroups() { return 'admin'; }

	public function execute() 
	{
		if(!$this->module->cfgDebugEnabled())
		{
			return $this->module->error('ERR_DISABLED');
		}

		$form = $this->debugForm();
		# gizmore: TODO: validate should work without GWF_Module $module
		//$form->validate($this);

		$back = '';
		if (isset($_POST['debug']))
		{
			if( false !== ($phpcode = $form->getVar('phpcode', false) ))
			{
				//Common::var_dump($phpcode);
				$back .= (string)$this->evalPHP($this->validate_phpcode($phpcode));
			}
		}

		return $back.$form->templateY('Execute GWF-PHP-Code for debugging!');
	}
	public function evalPHP($phpcode)
	{
		# own method because of namespace
		return eval($phpcode);
	}

	public function debugForm()
	{
		$data = array(
			'phpcode' => array(GWF_Form::MESSAGE_NOBB, '', 'PHP-Code', '', NULL, true),
			'debug' => array(GWF_Form::SUBMIT, 'Evaluate'),
		);
		
		return new GWF_Form($this->module, $data, GWF_Form::METHOD_POST, GWF_FORM::CSRF_STRONG);
	}
	public function validate_phpcode($phpcode)
	{
		# TODO: Check for syntax errors, replace autostrings
		return $phpcode;
	}
}
