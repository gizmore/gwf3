<?php
final class GWF_FAQ_Generator
{
	public static function generate(Module_Helpdesk $module)
	{
		return 
		self::addNewFAQ($module).
		self::remOldFAQ($module);
	}
	
	private static function addNewFAQ(Module_Helpdesk $module)
	{
		$faq = GWF_HelpdeskTicket::VISIBLE_FAQ;
		if (false === ($tickets = GDO::table('GWF_HelpdeskTicket')->selectAll('*', "hdt_options&$faq"))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$back = '';
		foreach ($tickets as $ticket)
		{
			$back .= self::addNewFAQTicket($module, $ticket);
		}
		
		return $back;
	}
	
	private static function addNewFAQTicket(Module_Helpdesk $module, array $ticket)
	{
		if (false === ($faq = GDO::table('GWF_HelpdeskFAQ')->getByTID($ticket['hdt_id']))) {
			$faq = new GWF_HelpdeskFAQ(array(
				'hdf_id' => 0,
				'hdf_tid' => $ticket['hdt_id'],
				'hdf_question' => $ticket['hdt_other'] === '' ? 'DEFAULT TITLE' : '',
				'hdf_answer' => '',
				'hdf_langid' => 0,
			));
			if (false === $faq->insert()) {
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			return $module->message('msg_new_faq');
		} else {
//			if (false === $faq->saveVars(array(
//			))) {
//				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
//			}
		}
		return '';
	}
	
	private static function remOldFAQ(Module_Helpdesk $module)
	{
		
	}
}
?>