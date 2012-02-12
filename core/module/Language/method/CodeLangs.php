<?php
final class Language_CodeLangs extends GWF_Method
{
	public function execute()
	{
		if(false === Common::isFile(GWF_GESHI_PATH))
		{
			return ''; // FIXME: {gizmore} log it? GESHI_PATH is may not readable
		}
		require_once GWF_GESHI_PATH;
		$geshi = new GeSHi();
		$langs = $geshi->get_supported_languages(false);
		$key = htmlspecialchars(Common::getGetString('key', ''), ENT_QUOTES);
		sort($langs);
//		$this->niceArray($langs, false, '-------')
		$this->niceArray($langs, 'python', 'Python');
		$this->niceArray($langs, 'perl', 'Perl');
		$this->niceArray($langs, 'cpp', 'CPP');
		$this->niceArray($langs, 'php', 'PHP');
		
		$back = $this->module->lang('th_lang').':'.PHP_EOL;
		$back .= '<select id="bb_code_lang_sel_'.$key.'">'.PHP_EOL;
		$back .= '<option value="0">'.$this->module->lang('th_lang').'</option>'.PHP_EOL;
		foreach ($langs as $lang)
		{
			$back .= sprintf('<option value="%s">%s</option>', $lang, $lang).PHP_EOL;
		}
		$back .= '</select>'.PHP_EOL;
		$back .= $this->module->lang('th_title').': <input type="text" id="bb_code_title_'.$key.'" size="20" value="" />'.PHP_EOL;
		$back .= '<input type="submit" value="'.$this->module->lang('btn_code').'" onclick="return bbInsertCodeNow(\''.$key.'\');" />'.PHP_EOL;
		return $back;
	}
	
	private function niceArray(array &$array, $search, $replace)
	{
		if (false !== ($index = array_search($search, $array)))
		{
			unset($array[$index]);
			array_unshift($array, $replace);
		}
	}
}
?>
