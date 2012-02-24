<?php
final class Helpdesk_FAQAdd extends GWF_Method
{
	public function getUserGroups() { return array('admin','staff'); }
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'index.php?mo=Helpdesk&mo=FAQAdd',
						'page_title' => 'Add FAQ',
						'page_meta_desc' => 'Add a new FAQ',
				),
		);
	}
	
	public function execute()
	{
		if (isset($_POST['add'])) {
			return $this->onAdd();
		}
		return $this->templateAdd();
	}

	private function templateAdd()
	{
		$form = $this->formAdd();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_add_faq')),
		);
		return $this->module->template('faq_add.tpl', $tVars);
	}
	
	private function formAdd()
	{
		$data = array(
			'lang' => array(GWF_Form::SELECT, GWF_LangSelect::single(1, 'lang', Common::getPostString('lang')), $this->module->lang('th_lang'), $this->module->lang('tt_lang')),
			'question' => array(GWF_Form::STRING, '', $this->module->lang('th_question')),
			'answer' => array(GWF_Form::MESSAGE, '', $this->module->lang('th_answer')),
			'add' => array(GWF_Form::SUBMIT, $this->module->lang('btn_add_faq')),
		);
		return new GWF_Form($this, $data);
	}

	public function validate_lang($m, $arg) { return GWF_LangSelect::validate_langid($arg, true); }
	public function validate_question($m, $arg) { return GWF_Validator::validateString($m, 'question', $arg, 4, $m->cfgMaxTitleLen(), false); }
	public function validate_answer($m, $arg) { return GWF_Validator::validateString($m, 'answer', $arg, 8, $m->cfgMaxMessageLen(), false); }
	
	private function onAdd()
	{
		$form = $this->formAdd();
		if (false !== ($error = $form->validate($this->module))) {
			return $error.$this->templateAdd();
		}
		
		$faq = new GWF_HelpdeskFAQ(array(
			'hdf_id' => 0,
			'hdf_tid' => 0,
			'hdf_question' => $form->getVar('question'),
			'hdf_answer' => $form->getVar('answer'),
			'hdf_langid' => $form->getVar('lang'),
		));
		
		if (false === ($faq->insert())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateAdd();
		}
		
		return $this->module->message('msg_faq_add');
	}
}
?>