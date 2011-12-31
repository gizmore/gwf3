<?php
/**
 * The smiley database.
 * @author gizmore
 */
final class LIVIN_Smile extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return 'wcc_livin_smile'; }
	public function getColumnDefines()
	{
		return array(
			'lvs_id' => array(GDO::AUTO_INCREMENT),
			'lvs_smiley' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
			'lvs_path' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
		);
	}
	
	public static function onAddSmiley($smiley, $path)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'lvs_id' => 0,
			'lvs_smiley' => $smiley,
			'lvs_path' => $path,
		));
	}
	
	/**
	 * Show all the smileys and rules we have in database. 
	 * @param WC_Challenge $chall
	 */
	public static function showAllSmiles(WC_Challenge $chall)
	{
		$input = $chall->lang('test_input_msg').PHP_EOL;
		$paths = array();
		$patterns = array();
		$table = self::table(__CLASS__);
		if (false === ($result = $table->select('lvs_path, lvs_smiley')))
		{
			return "ERROR 0815!";
		}
		while (false !== ($row = $table->fetch($result, GDO::ARRAY_N)))
		{
			$input .= $row[0];
			$paths[] = $row[0];
			$patterns[] = $row[1];
		}
		$table->free($result);
		
		$i = 0;
		$output = $input;
		foreach ($patterns as $pattern)
		{
			$output = self::replaceSmiley($pattern, $paths[$i++], $output);
		}
		
//		$back = GWF_Box::box($input, $chall->lang('all_smileys_input'));
		$back = GWF_Box::box($output, $chall->lang('all_smileys_output'));
		return $back;
	}
	
	public static function testSmiley(WC_Challenge $chall, $smiley, $path)
	{
		$back = true; # Test passed :S?
		
		# Generate test input :)
		$ues = str_replace('\\', '', $smiley);
		$ues = Common::regex('#/([^/]+)/#', $ues);
		
		$text = 'Test '.$ues.'. Test '.$ues;
		echo GWF_Box::box($text, $chall->lang('test_input'));
		
		# Generate test output :)
		if (NULL === ($out = self::replaceSmiley($smiley, $path, $text)))
		{
			$back = false;
			$out = $text;
		}
		
		# Output the test :)
		echo GWF_Box::box($out, $chall->lang('test_output'));
		
		return $back;
	}
	
	public static function imageExists($path)
	{
		if (0 === preg_match('/^<img src="([^"\'=\\(+:]+)" \\/>$/', $path, $matches))
		{
			return false;
		}
		$path = $matches[1];
		return Common::isFile(trim($path, '/'));
	}
		
	public static function looksHarmless($path)
	{
		return 1 === preg_match('/^<img src="[^"\'=\\(+:]+" \\/>$/', $path);
	}
	
	public static function replaceSmiley($smiley, $path, $text)
	{
		return preg_replace($smiley, $path, $text);
	}
	
	#############################
	### Your solution is near ###
	#############################
	public static function getSolution()
	{
		if (false === ($solution = GWF_Session::getOrDefault('LIV_SMI_SOL')))
		{
			return self::genSolution();
		}
		return $solution;
	}
	
	private static function genSolution()
	{
		$solution = GWF_Random::randomKey(32, Common::ALPHANUMUPLOW);
		GWF_Session::set('LIV_SMI_SOL', $solution);
		return $solution;
	}
}
?>