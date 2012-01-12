<?php

/**
 * This is an imitated LinuxShell
 * @author spaceone
 */
final class SF_Shell extends GWF_Method
{
	private $module;
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^Shell/(.*+)$ index.php?mo=SF&me=Shell&cmd=$1'.PHP_EOL.
			$this->getHTAccessMethod();
	}
	public function execute(GWF_Module $module)
	{
		$this->module = $module;
		$cmd = Common::getRequestString('cmd');
		$output = $this->init($cmd);
		return $this->templateShell($this->_module, $output, htmlspecialchars($cmd));
	}
	
	public function init($cmdS) 
	{
		$module = $this->module;

		if($cmdS != NULL || $cmdS === false)
		{
			return $this->getMoMe() === array($_GET['mo'], $_GET['me']) ?
				$this->_module->error('err_no_command_given') : '';
		}
		
		$cmdA = explode(' ', trim($cmdS));
		$cmd = strtolower($cmdA[0]);
		unset($cmdA[0]);
		
		if(strpos($cmdS, '|'))
		{
			return $this->onPipe($cmdS);
		}

		$cmdS = implode(' ', $cmdA);
			
		# help command?
		if($cmd === 'help')
		{
			$foo = explode(' ', $cmdS);
			$c = count($cmdA);
			return $c > 0 ? $this->onHelp($foo[0]) : $this->onHelp();
		}
		elseif($cmd === 'echo')
		{
			return htmlspecialchars($cmdS); 
		}
		
		require_once GWF_CORE_PATH.'module/SF/SF_Function.php';
		
		if(strpos('.', $cmd) || strpos('/', $cmd))
		{
			return $this->_module->error('err_hacking_attemp');
		}
		
		$file = GWF_CORE_PATH.'module/SF/SF_Function.php';
		if(false === Common::isFile($file))
		{
			return $this->_module->error('err_no_function');
		}

		require_once $file;
		$class = 'SF_'.$cmd;

		if(class_exists($class))
		{
			$obj = new $class($cmdA);
			if(false === ($clone = $obj->isClone()))
			{
				return $obj->execute();
			}
			else
			{
				// TODO
			}
		}
		else
		{
			$this->_module->error('err_no_command', array($cmd));
		}
	}
	public function onPipe($cmdS)
	{
		$cmdA = explode('|', $cmdS);
		$c = count($cmdA);
		$ret = $this->init($cmdA[0]);
		
		######################################
		## TODO: test if error in thinking! ##
		return $ret;                        ##
		######################################
		
		for($i=1; $i<$c; $i++)
		{
			$ret = $this->init( trim($cmdA[$c].' '.$ret) );
		}
		
		return $this->init($ret);
	}
	public function onHelp($cmd=false)
	{
		if($cmd === false)
		{
			$functions = scandir(GWF_CORE_PATH.'module/SF/functions/');
			foreach($functions as $key => $function)
			{
				if(false === ($functions[$key] = Common::substrFrom(Common::substrUntil($function, '.php'), 'SF_', false)))
				{
					unset($functions[$key]);
				}
			}
			$tVars = array(
				'functions' => $functions,
			);
			return $this->_module->template('shellhelp.tpl', $tVars);
		}
		else
		{
			return $this->_module->lang('tt_'.$cmd);
		}
	}
	
	private function templateShell(Module_SF $module, $output, $lastCMD)
	{
		$tVars = array(
			'output' => $output,
			'lastCMD' => $lastCMD
		);
		return $this->_module->template('shell.tpl', $tVars);
	}
	
}
