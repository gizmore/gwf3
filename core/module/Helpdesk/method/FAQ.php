<?php
final class Helpdesk_FAQ extends GWF_Method
{
	private function onGenerate(Module_Helpdesk $module) { require_once 'core/module/Helpdesk/GWF_FAQ_Generator.php'; return GWF_FAQ_Generator::generate($module); }
	
	public function execute(Module_Helpdesk $module)
	{
		$back = '';
		
		GWF_Website::addJavascript($module->getModuleFilePath('js/helpdesk.js'));
		GWF_Website::addJavascriptInline("$(document).ready(function() { helpdeskInit(); } );");
		
		if (Common::getGetString('generate') === 'now') {
			$back .= $this->onGenerate($module);
		}
		
		return $back.$this->templateFAQ($module);
	}
	
	public function templateFAQ(Module_Helpdesk $module)
	{
		$tVars = array(
			'href_add' => $module->getMethodURL('FAQAdd'),
			'href_generate' => $this->getMethodHREF('&generate=now'),
			'faq' => $this->buildFAQ($module),
		);
		return $module->template('faq.tpl', $tVars);
	}
	
	private function buildFAQ(Module_Helpdesk $module)
	{
		$back = array();
		$faq = GDO::table('GWF_HelpdeskFAQ');
		
		$lid = GWF_Language::getCurrentID();
		$where = "(hdf_langid=0 OR hdf_langid=$lid)";
		
		if (false === ($result = $faq->select('*', $where, '', NULL))) {
			return $back;
		}
		
		while (false !== ($row = $faq->fetch($result, GDO::ARRAY_A)))
		{
			$back[] = $this->buildFAQRow($module, $row);
		}
		
		$faq->free($result);
		
		return $back;
	}
	
	private function buildFAQRow(Module_Helpdesk $module, $row)
	{
		$back = array();
		$back['id'] = $row['hdf_id'];
		if ($row['hdf_tid'] > 0)
		{
			$faq = GWF_HelpdeskMsg::FAQ;
			$tid = $row['hdf_tid'];
			$back['q'] = $row['hdf_question'];
			$back['a'] = GDO::table('GWF_HelpdeskMsg')->selectColumn('hdm_message', "hdm_tid=$tid and hdm_options&$faq", "hdm_date ASC");
			foreach ($back['a'] as $i => $a)
			{
				$back['a'][$i] = GWF_Message::display($a);
			}
			$back['a'][] = GWF_Message::display($row['hdf_answer']);
		}
		else
		{
			$back['q'] = $row['hdf_question'];
			$back['a'] = array(GWF_Message::display($row['hdf_answer']));
		}
		$back['href_edit'] = $module->getMethodURL('FAQEdit', '&faqid='.$row['hdf_id']);
		return $back;
	}
}
?>