<?php
final class Baim_Hook_Dl
{
	public static function hook(GWF_User $user, GWF_Download $dl)
	{
		$dlid = $dl->getID();
		if ($dlid > 2) {
			return true;
		}
		
		$demo = $dlid == 2;
		
		if (false === ($row = BAIM_MC::generate($user, $demo)))
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$mime = $dl->getVar('dl_mime');
		$path = $dl->getDownloadPath();
		$temp_path = GWF_PATH.'extra/temp/baim/'.$user->getVar('user_id').'_'.$row->getToken();
		
		if (!Common::isFile($path))
		{
			return GWF_HTML::err('ERR_FILE_NOT_FOUND', htmlspecialchars($path));
		}
		
		if (Common::isFile($temp_path))
		{
			if (false === unlink($temp_path))
			{
				return GWF_HTML::err('ERR_WRITE_FILE', array( $temp_path));
			}
		}
		
		if ($mime === 'application/zip')
		{
			if (false === copy($path, $temp_path))
			{
				return GWF_HTML::err('ERR_WRITE_FILE', array( $temp_path));
			}
			$have_zip = true;
		}
		else
		{
			$have_zip = false;
		}

		
		$zip = new GWF_ZipArchive();
		if (false === ($zip->open($temp_path, GWF_ZipArchive::CREATE))) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( $temp_path));
		}
		if ($have_zip === false)
		{
			$filename = $dl->getVar('dl_filename');
			$zip->addFile($path, $filename);
			$dl->setCustomDownloadName($filename.'.zip');
		}
		
		if (false === ($zip->addFromString('B.AiM/key.dat', self::getIniContent($row)))) {
			return GWF_HTML::error('BAIM', 'The download slot is not a zip archive!');
		}
		$zip->addFromString('B.AiM/readme.txt', self::getReadmeContent($row));
		$zip->addFromString('B.AiM/release_notes.txt', self::getReleaseNotes($row));
		$zip->close();
		$dl->setCustomDownloadPath($temp_path);
		return '';
	}
	
	private static function getIniContent(BAIM_MC $row)
	{
		return Module_BAIM::getInstance()->lang('key.dat', array($row->getVar('bmc_uid')+1000, $row->getVar('bmc_token')));
	}

	private static function getReleaseNotes(BAIM_MC $row)
	{
		$user = GWF_Session::getUser();
		$s = Module_BAIM::getInstance()->lang('dl_info_b', array('1.Jan.2012', GWF_Time::humanDurationEN(BAIM_MC::CHANGE_TIMEOUT)));
		return str_replace('<br/>', "\r\n", $s);
	}

	private static function getReadmeContent(BAIM_MC $row)
	{
		$user = GWF_User::getStaticOrGuest();
		return Module_BAIM::getInstance()->lang('readme.txt', array($user->getVar('user_name')));
	}
}
?>