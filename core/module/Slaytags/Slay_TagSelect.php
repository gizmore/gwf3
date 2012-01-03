<?php
final class Slay_TagSelect
{
	public static function singleSelect($name='searchtag', $selected=true)
	{
		$selected = $selected === true ? Common::getRequestString($name, '0') : (string)$selected;
		
		$data = array(array('0', 'Tagfilter'));
		
		$table = GDO::table('Slay_Tag');
		if (false !== ($result = $table->select('st_id, st_name', '', 'st_name ASC')))
		{
			while (false !== ($row = $table->fetch($result, GDO::ARRAY_N)))
			{
				$data[] = array($row[0], $row[1]);
			}
			$table->free($result);
		}
		
		return GWF_Select::display($name, $data, $selected);
	}

	public static function validateTag(Module_Slaytags $module, $tagid, $allowEmpty=true, $blank=true, $name='searchtag')
	{
		if ($allowEmpty && ($tagid == 0))
		{
			return false;
		}
		if (false === Slay_Tag::getByID($tagid))
		{
			if ($blank)
			{
				unset($_POST[$name]);
			}
			return $module->lang('err_searchtag');
		}
		return false;
	}
}
?>