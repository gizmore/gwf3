<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Smile');
require_once('html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/livinskull/smile/index.php', false);
}

# Table and Helper :)
require_once 'challenge/livinskull/smile/LIVIN_Smile.php';

# Your solution is here :)
define('LIVINSKULL_SMILEY_SOLUTION', LIVIN_Smile::getSolution());


/**
 * The smiley form :)
 * @author gizmore
 */
class LivinForm
{
	private $chall;
	
	public function __construct(WC_Challenge $chall)
	{
		$this->chall = $chall;
	}
	
	# Sanitize pattern a bit
	public function validate_pattern($m, $arg)
	{
		if ($arg === '')
		{
			return $this->chall->lang('err_pattern');
		}
		if ($arg{0} !== '/')
		{
			$_POST['pattern'] = "/{$arg}/";
		}
		return false;
	}
	
	# Always valid
	public function validate_filename($m, $arg)
	{
		return false;
	}
	
	public function getForm(WC_Challenge $chall)
	{
		$data = array(
			'pattern' => array(GWF_Form::STRING, '', $chall->lang('th_pattern'), $chall->lang('tt_pattern')),
			'filename' => array(GWF_Form::STRING, $this->getRandomFilename(), $chall->lang('th_filename'), $chall->lang('tt_filename')),
			'image' => array(GWF_Form::FILE_OPT, '', $chall->lang('th_upload')),
			'upload' => array(GWF_Form::SUBMIT, $chall->lang('btn_upload')),
			'add' => array(GWF_Form::SUBMIT, $chall->lang('btn_add')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function getRandomFilename()
	{
		$directory = 'challenge/livinskull/smile/smiles';
		if (false === ($dir = scandir($directory)))
		{
			echo GWF_HTML::err('ERR_READ_FILE', array($directory));
			return '';
		}
		foreach ($dir as $i => $file)
		{
			if ( ($file === '.') || ($file === '..') )
			{
				unset($dir[$i]);
			}
		}
		$file = $dir[array_rand($dir)];
		return "<img src=\"/$directory/$file\" />";
	}
	
	public function onUpload(WC_Challenge $chall)
	{
		$module = Module_WeChall::instance();
		$form = $this->getForm($chall);
		if (false === ($file = $form->getVar('image')))
		{
			return GWF_HTML::error('Smile', $chall->lang('err_no_image'));
		}
		
		if (!GWF_Upload::isImageFile($file))
		{
			return GWF_HTML::error('Smile', $chall->lang('err_no_image'));
		}
		
		if (false === GWF_Upload::resizeImage($file, 64, 64, 16, 16))
		{
			return GWF_HTML::error('Smile', $chall->lang('err_no_image'));
		}
		
		$whitelist = array(
			'.jpg',
			'.gif',
			'.png',
		);
		$filename = $file['name'];
		$allowed = false;
		foreach ($whitelist as $allow)
		{
			if (Common::endsWith($filename, $allow))
			{
				$allowed = true;
				break;
			}
		}
		
		if (!$allowed)
		{
			return GWF_HTML::error('Smile', $chall->lang('err_no_image'));
		}
		
		$fullpath = "challenge/livinskull/smile/smiles/{$filename}";
		$efp = htmlspecialchars($fullpath);
		if (false === ($file = GWF_Upload::moveTo($file, $fullpath)))
		{
			return GWF_HTML::err('ERR_WRITE_FILE', array($efp));
		}
		
		$efp = htmlspecialchars($fullpath);
		$rule = htmlspecialchars("<img src=\"/{$efp}\" />");
		
		return GWF_HTML::message('Smile', $chall->lang('msg_uploaded', array($rule)));
	}
	
	public function onAdd(WC_Challenge $chall)
	{
		$module = Module_WeChall::instance();
		$form = $this->getForm($chall);
		if (false !== ($error = $form->validate($module)))
		{
			return $error;
		}
		
		$pattern = $form->getVar('pattern');
		$path = $form->getVar('filename');
		
		# Show a sample output for the new smiley :)
		if (!LIVIN_Smile::testSmiley($chall, $pattern, $path))
		{
			return GWF_HTML::error('Smile', $chall->lang('err_test'));
		}
		
		# If it looks valid we even add it globally :)
		if (!LIVIN_Smile::looksHarmless($path))
		{
			return GWF_HTML::error('Smile', $chall->lang('err_xss'));
		}
		if (!LIVIN_Smile::imageExists($path))
		{
			return GWF_HTML::error('Smile', $chall->lang('err_path'));
		}

		# Like this :)
		LIVIN_Smile::onAddSmiley($pattern, $path);
		return GWF_HTML::message('Smile', $chall->lang('msg_rule_added'));
	}
}

##################
### ACTION! :) ###
##################
# Weaken security a bit.
GWF_Debug::setDieOnError(false);

$form = new LivinForm($chall);

if (isset($_POST['add']))
{
	# This will stop you from exploiting too much! :p
	require_once 'challenge/livinskull/smile/secure.php';
	echo $form->onAdd($chall);
}

elseif (isset($_POST['upload']))
{
	# This will stop you from exploiting too much! :o
	require_once 'challenge/livinskull/smile/secure.php';
	echo $form->onUpload($chall);
}

# Show the form :)
echo $form->getForm($chall)->templateY($chall->lang('ft_add'));

# Show all smileys =)
echo LIVIN_Smile::showAllSmiles($chall);

require_once('html_foot.php');
?>