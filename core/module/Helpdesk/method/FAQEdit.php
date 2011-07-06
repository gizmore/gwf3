<?php
final class Helpdesk_FAQEdit extends GWF_Method
{
	public function getUserGroups() { return array('admin','staff'); }
	public function validate_lang($m, $arg) { return GWF_LangSelect::validate_langid($arg, true); }
	public function validate_question($m, $arg) { return GWF_Validator::validateString($m, 'question', $arg, 4, $m->cfgMaxTitleLen(), false); }
	public function validate_answer($m, $arg) { return GWF_Validator::validateString($m, 'answer', $arg, 8, $m->cfgMaxMessageLen(), false); }
	public function validate_delete_confirm_v($m, $arg) { return (!isset($_POST['delete'])) ? false : (isset($_POST['delete_confirm'])?false:$m->lang('err_confirm_delete')); }
	
	public function execute(Module_Helpdesk $module)
	{
		if (false === ($faq = GWF_HelpdeskFAQ::getByID(Common::getGetString('faqid')))) {
			return $module->error('err_faq');
		}
		
		if (isset($_POST['edit'])) {
			return $this->onEdit($module, $faq);
		}
		if (isset($_POST['delete'])) {
			return $this->onDelete($module, $faq);
		}
		
		return $this->templateEdit($module, $faq);
	}
	
	private function templateEdit(Module_Helpdesk $module, GWF_HelpdeskFAQ $faq)
	{
		$form = $this->formEdit($module, $faq);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_edit_faq')),
		);
		return $module->template('faq_edit.tpl', $tVars);
	}

	private function formEdit(Module_Helpdesk $module, GWF_HelpdeskFAQ $faq)
	{
		$data = array(
			'lang' => array(GWF_Form::SELECT, GWF_LangSelect::single(1, 'lang', $faq->getVar('hdf_langid')), $module->lang('th_lang'), $module->lang('tt_lang')),
			'question' => array(GWF_Form::STRING, $faq->getVar('hdf_question'), $module->lang('th_question')),
			'answer' => array(GWF_Form::MESSAGE, $faq->getVar('hdf_answer'), $module->lang('th_answer')),
			'delete_confirm' => array(GWF_Form::CHECKBOX, false, $module->lang('th_confirm_del')),
			'delete_confirm_v' => array(GWF_Form::VALIDATOR),
			'add' => array(GWF_Form::SUBMITS, array('edit'=>$module->lang('btn_edit_faq'),'delete'=>$module->lang('btn_rem_faq'))),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onEdit(Module_Helpdesk $module, GWF_HelpdeskFAQ $faq)
	{
		$form = $this->formEdit($module, $faq);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateEdit($module, $faq);
		}
		
		if (false === $faq->saveVars(array(
			'hdf_question' => $form->getVar('question'),
			'hdf_answer' => $form->getVar('answer'),
			'hdf_langid' => $form->getVar('lang'),
		))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $module->message('msg_faq_edit').$this->templateEdit($module, $faq);
	}
	
	private function onDelete(Module_Helpdesk $module, GWF_HelpdeskFAQ $faq)
	{
		$form = $this->formEdit($module, $faq);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateEdit($module, $faq);
		}
		
		return $module->message('msg_faq_del').$module->execute('FAQ');
	}
	
}
?>