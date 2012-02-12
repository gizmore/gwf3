<?php
final class Konzert_AddTermin extends GWF_Method
{
	public function getUserGroups() { return array('admin','staff'); }
	
	public function execute()
	{
		if (isset($_POST['add']))
		{
			return $this->onAdd();
		}
		return $this->templateAdd();
	}
	
	private function templateAdd()
	{
		$form = $this->formAdd();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_add')),
		);
		return $this->module->template('at_add.tpl', $tVars);
	}
	
	private function formAdd()
	{
		$data = array();
		$data['date'] = array(GWF_Form::DATE_FUTURE, '', $this->module->lang('th_date'), '', GWF_Date::LEN_DAY);
		$data['time'] = array(GWF_Form::TIME, '', $this->module->lang('th_time'));
		$data['prog'] = array(GWF_Form::STRING, '', $this->module->lang('th_prog'));
		$data['city'] = array(GWF_Form::STRING, '', $this->module->lang('th_city'));
		$data['location'] = array(GWF_Form::STRING, '', $this->module->lang('th_location'));
		$data['tickets'] = array(GWF_Form::STRING, '', $this->module->lang('th_tickets'));
		$data['add'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_add'));
		return new GWF_Form($this, $data);
	}
	
	public function validate_date($m, $arg) { return GWF_Validator::validateDate($m, 'date', $arg, GWF_Date::LEN_DAY, false); }
	public function validate_time($m, $arg) { return GWF_Validator::validateTime($m, 'time', $arg, false, true); }
	public function validate_prog($m, $arg) { return GWF_Validator::validateString($m, 'prog', $arg, 2, 128); }
	public function validate_city($m, $arg) { return GWF_Validator::validateString($m, 'city', $arg, 2, 63); }
	public function validate_location($m, $arg) { return GWF_Validator::validateString($m, 'location', $arg, 2, 128); }
	public function validate_tickets($m, $arg) { return GWF_Validator::validateString($m, 'tickets', $arg, 2, 128); }
	
	private function onAdd()
	{
		$form = $this->formAdd();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error.$this->templateAdd();
		}
		
		$termin = new Konzert_Termin(array(
			'kt_id' => 0,
			'kt_date' => $form->getVar('date'),
			'kt_time' => $form->getVar('time'),
			'kt_city' => $form->getVar('city'),
			'kt_prog' => $form->getVar('prog'),
			'kt_tickets' => $form->getVar('tickets'),
			'kt_location' => $form->getVar('location'),
			'kt_options' => Konzert_Termin::ENABLED,
		));
		
		if (false === $termin->insert())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateAdd();
		}
		
		return $this->module->message('msg_t_added');
	}
}
?>