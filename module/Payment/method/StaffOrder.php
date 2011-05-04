<?php
final class Payment_StaffOrder extends GWF_Method
{
	public function getUserGroups() { return 'staff'; }
	
	public function execute(GWF_Module $module)
	{
		if (false === ($order = GWF_Order::getByID(Common::getGet('oid')))) {
			return $module->error('err_order');
		}
		
		if (false !== (Common::getGet('mark_paid'))) {
			return $this->onMarkPaid($module, $order).$this->templateOrder($module, $order);
		}

		if (false !== Common::getPost('exec')) {
			return $this->onExecute($module, $order).$this->templateOrder($module, $order);
		}
		
		if (false !== Common::getPost('edit')) {
			return $this->onEdit($module, $order).$this->templateOrder($module, $order);
		}
		
		return $this->templateOrder($module, $order);
	}
	
	private function templateOrder(Module_Payment $module, GWF_Order $order)
	{
		$form_exec = $this->getFormExec($module, $order); 
		$form_edit = $this->getFormEdit($module, $order); 
		
		$oid = $order->getID();
		
		$module2 = $order->getOrderModule();
		$module2->onInclude();
		$module2->onLoadLanguage();
		$gdo = $order->getOrderData(); 
		
		$tVars = array(
			'order' => $order,
			'display' => $gdo->displayOrder($module2),
			'href_paid' => GWF_WEB_ROOT.'index.php?mo=Payment&me=StaffOrder&oid='.$oid.'&mark_paid=true',
			'form_exec' => $form_exec->templateX(false, false),
			'form_edit' => $form_edit->templateY($module->lang('ft_edit_order')),
		);
		return $module->templatePHP('staff_order.php', $tVars);
	}
	
	private function getFormExec(Module_Payment $module, GWF_Order $order)
	{
		$data = array(
			'exec' => array(GWF_Form::SUBMIT, $module->lang('btn_execute')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function getFormEdit(Module_Payment $module, GWF_Order $order)
	{
		$data = array(
			'edit' => array(GWF_Form::SUBMIT, $module->lang('btn_edit')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onExecute(Module_Payment $module, GWF_Order $order)
	{
		$form_exec = $this->getFormExec($module, $order);
		if (false !== ($errors = $form_exec->validate($module))) {
			return $errors;
		}
		
		$module2 = $order->getOrderModule();
		$module2->onInclude();
		$module2->onLoadLanguage();

		return Module_Payment::onExecuteOrderS($module2, $order);
	}
	
}
?>