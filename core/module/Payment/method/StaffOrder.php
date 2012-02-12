<?php
final class Payment_StaffOrder extends GWF_Method
{
	public function getUserGroups() { return 'staff'; }
	
	public function execute()
	{
		if (false === ($order = GWF_Order::getByID(Common::getGet('oid')))) {
			return $this->module->error('err_order');
		}
		
		if (false !== (Common::getGet('mark_paid'))) {
			return $this->onMarkPaid($order).$this->templateOrder($order); #FIXME: {gizmore} method does not exists
		}

		if (false !== Common::getPost('exec')) {
			return $this->onExecute($order).$this->templateOrder($order);
		}
		
		if (false !== Common::getPost('edit')) {
			return $this->onEdit($order).$this->templateOrder($order);
		}
		
		return $this->templateOrder($order);
	}
	
	private function templateOrder(GWF_Order $order)
	{
		$form_exec = $this->getFormExec($order); 
		$form_edit = $this->getFormEdit($order); 
		
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
			'form_edit' => $form_edit->templateY($this->module->lang('ft_edit_order')),
		);
		return $this->module->templatePHP('staff_order.php', $tVars);
	}
	
	private function getFormExec(GWF_Order $order)
	{
		$data = array(
			'exec' => array(GWF_Form::SUBMIT, $this->module->lang('btn_execute')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function getFormEdit(GWF_Order $order)
	{
		$data = array(
			'edit' => array(GWF_Form::SUBMIT, $this->module->lang('btn_edit')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onExecute(GWF_Order $order)
	{
		$form_exec = $this->getFormExec($order);
		if (false !== ($errors = $form_exec->validate($this->module))) {
			return $errors;
		}
		
		$module2 = $order->getOrderModule();
		$module2->onInclude();
		$module2->onLoadLanguage();

		return Module_Payment::onExecuteOrderS($module2, $order);
	}
	
}
?>
