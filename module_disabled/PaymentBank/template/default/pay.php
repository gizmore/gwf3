<?php $m = $tVars['module']; $m instanceof Module_PaymentBank; $o = $tVars['order_c']; $o instanceof GWF_Order; ?>

<p><?php echo $tVars['lang']->lang('pay_info', $m->cfgFirstName(), $m->cfgLastName(), $m->cfgBIC(), $m->cfgIBAN()); ?></p>
<p><?php echo $tVars['lang']->lang('pay_reason', $o->getOrderToken(), $o->getOrderModulename()); ?></p>
<p><?php echo $tVars['lang']->lang('pay_info2'); ?></p>
<p><?php echo $tVars['lang']->lang('pay_info3'); ?></p>

<?php echo $tVars['order']; ?>