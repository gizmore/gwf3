<?php
/**
 * Order Table and Row.
 * @author gizmore
 */
final class GWF_Order extends GDO implements GWF_Sortable, GWF_Searchable
{
	const TOKEN_LEN = 12;
	const XTOKEN_LEN = 64;
	
	# order_status
	const CREATED = 'created';
	const ORDERED = 'ordered';
	const PAID = 'paid';
//	const PROCESSING = 'processing';
	const PROCESSED = 'processed';
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'order'; }
	public function getColumnDefines()
	{
		return array
		(
			'order_id' => array(GDO::AUTO_INCREMENT),
			'order_token' => array(GDO::TOKEN|GDO::INDEX, GDO::NOT_NULL, self::TOKEN_LEN),
			'order_xtoken' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S, GDO::NULL, self::XTOKEN_LEN),
			'order_uid' => array(GDO::OBJECT|GDO::INDEX, GDO::NOT_NULL, array('GWF_User', 'order_uid', 'user_id')),
			'order_cartid' => array(GDO::UINT|GDO::INDEX, 0),
		
			'order_date_paid' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'order_date_ordered' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			
			'order_amount' => array(GDO::UINT, 1),
			'order_price' => array(GDO::DECIMAL, GDO::NOT_NULL, array(9, 4)),
			'order_price_total' => array(GDO::DECIMAL, GDO::NOT_NULL, array(9, 4)),
			'order_currency' => array(GDO::TOKEN, GDO::NOT_NULL, 3),
			
			'order_email' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, GDO::NOT_NULL, GWF_User::EMAIL_LENGTH),
			'order_site' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, GDO::NOT_NULL, 16),
			
			'order_title' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'order_title_admin' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'order_descr' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'order_descr_admin' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
		
			'order_status' => array(GDO::ENUM, self::CREATED, array(self::CREATED, self::ORDERED, self::PAID, self::PROCESSED)),
		
			'order_data' => array(GDO::BLOB),
		
			'order_module' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 64),
		);
	}
	###################
	### Convinience ###
	###################
	public function getOrderID() { return $this->getVar('order_id'); }
	public function getOrderCartID() { return $this->getVar('order_cartid'); }
	public function getOrderUID() { return $this->getUser()->getID(); }
	public function getOrderUser() { return $this->getUser(); }
	public function getOrderToken() { return $this->getVar('order_token'); }
	public function getOrderXToken() { return $this->getVar('order_xtoken'); }
	public function getOrderAmount() { return $this->getVar('order_amount'); }
	public function getOrderPayDate() { return $this->getVar('order_date_paid'); }
	public function getOrderDate() { return $this->getVar('order_date_ordered'); }
	public function getOrderPrice() { return $this->getVar('order_price'); }
	public function getOrderPriceTotal($digits=2) { return round($this->getVar('order_price_total'), $digits); }
	public function getOrderCurrency() { return $this->getVar('order_currency'); }
	public function getOrderPayEMail() {  return $this->getVar('order_email'); }
	public function getOrderPaySite() { return $this->getVar('order_site'); }
	public function getOrderTitle() { return $this->getVar('order_title'); }
	public function getOrderTitleAdmin() { return $this->getVar('order_title_admin'); }
	public function getOrderDescription() { return $this->getVar('order_descr'); }
	public function getOrderDescrAdmin() { return $this->getVar('order_descr_admin'); }
	public function getOrderModulename() { return $this->getVar('order_module'); }
	
	/**
	 * @return GWF_Module
	 */
	public function getOrderModule()
	{
		$name = $this->getOrderModulename();
		if (false === ($module = GWF_Module::loadModuleDB($name))) {
			echo GWF_HTML::err('ERR_MODULE_MISSING', array( GWF_HTML::display($name)));
			return false;
		}
		
		$module->onInclude();
		$module->onLoadLanguage();
		
		return $module;
		
	}
	
	/**
	 * @return GWF_Orderable
	 */
	public function getOrderData()
	{
		if (false === ($module = $this->getOrderModule())) {
			return false;
		}
		$module->onInclude();
		return unserialize($this->getVar('order_data'));
	}
	
	public function getOrderFee() { return $this->getOrderPriceTotal() - $this->getOrderPrice(); }
	public function getOrderFeePercent() { return $this->getOrderFee() / $this->getOrderPrice() * 100; }
	
	public function getOrderStatus() { return $this->getVar('order_status'); }
	public function isPaid() { return $this->getVar('order_status') === self::PAID; }
	public function isCreated() { return $this->getVar('order_status') === self::CREATED; }
	public function isProcessed() { return $this->getVar('order_status') === self::PROCESSED; }
	
	/**
	 * @return GWF_User
	 */
	public function getUser()
	{
		if (false === ($user = $this->getVar('order_uid'))) {
			return GWF_Guest::getGuest();
		}
		$user->loadGroups();
		return $user;
	}
	/**
	 * @return GWF_PaymentModule
	 */
	public function getPaymentModule() { return GWF_PaymentModule::getPaymentModule($this->getVar('order_site')); }
	/**
	 * @return GWF_Currency
	 */
	public function getCurrency() { return GWF_Currency::getByISO($this->getVar('order_currency')); }
	
	######################
	### Static Getters ###
	######################
	public static function getByID($order_id) { return self::table(__CLASS__)->getRow($order_id); }
	
	/**
	 * @param string $token
	 * @return GWF_Order
	 */
	public static function getByToken($token) { return self::table(__CLASS__)->getBy('order_token', $token, GDO::ARRAY_O, array('order_uid')); }
	
	####################
	### GDO_Sortable ###
	####################
	public function getSortableDefaultBy(GWF_User $user) { return 'order_date_ordered'; }
	public function getSortableDefaultDir(GWF_User $user) { return 'DESC'; }
	public function getSortableFields(GWF_User $user)
	{
		if($user->isStaff())
		{
			return array(
				'order_id',
				'user_name',
				'order_price_total',
				'order_site',
				'order_email',
				'order_descr_admin',
				'order_date_ordered',
				'order_status',
				'order_date_paid',
				'order_site',
			);
		}
		else
		{
			return array(
				'order_descr',
				'order_date_ordered',
				'order_price_total',
				'order_date_paid',
				'order_status',
				'order_email',
			);
		}
	}
	
	######################
	### GDO_Searchable ###
	######################
	public function getSearchableActions(GWF_User $user) { return array('order_qsearch', 'order_search'); }
	public function getSearchableFields(GWF_User $user) { return $this->getColumnNamesExclusive(array('order_cartid')); }
	public function getSearchableFormData(GWF_User $user) { return array(); }
	
	#######################
	### GDO_Displayable ###
	#######################
	public function getDisplayableFields(GWF_User $user) { return $this->getColumnNamesExclusive(array('order_data', 'order_descr')); }
	public function displayColumn(GWF_Module $module, GWF_User $user, $col_name)
	{
		switch($col_name)
		{
			case 'order_id':
				return $this->getVar($col_name);
				
			case 'user_name':
				return $this->getUser()->display($col_name);
			
			case 'order_date_paid':
			case 'order_date_ordered':
				return GWF_Time::displayDate($this->getVar($col_name));
			
			case 'order_price':
			case 'order_price_total':
				return $this->getCurrency()->displayValue($this->getVar($col_name), true);
			
			case 'order_site':
				return GWF_HTML::display($this->getPaymentModule()->getSiteName());
			
			case 'order_status':
				$status = $this->getVar('order_status');
				$text = $module->lang('status_'.$status);
				switch($status)
				{
					case self::CREATED:
					case self::ORDERED:
					case self::PAID:
					case self::PROCESSED:
						$href = '#';
				}
				return GWF_HTML::anchor($href, $text);
		
			case 'order_data':
				return $this->getData()->displayOrder();
				
			case 'order_descr_admin':
				$text = $this->display($col_name);
				$href = GWF_WEB_ROOT.'index.php?mo=Payment&me=StaffOrder&oid='.$this->getID();
				return GWF_HTML::anchor($href, $text);
				
			default:
				return $this->display($col_name);
//				return sprintf('=[%s]=', $this->display($col_name));
		}
	}
	
	##################
	### Add Orders ###
	##################
	private static function generateToken()
	{
		do
		{
			$token = GWF_Random::randomKey(self::TOKEN_LEN);
		}
		while (self::getByToken($token)!==false);
		
		return $token;
	}
	
	public static function insertOrder(GWF_Module $module, GWF_Orderable $gdo, GWF_PaymentModule $paysite, GWF_User $user, $price_total, $cartid=0)
	{
		$token = self::generateToken();
		
		$order = new self(array(
			'order_cartid' => $cartid,
			'order_uid' => $user->getID(),
			'order_token' => $token,
			'order_xtoken' => '',
		
			'order_date_paid' => '00000000000000',
			'order_date_ordered' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			
			'order_price' => $gdo->getOrderPrice($user),
			'order_price_total' => $price_total,
			'order_currency' => Module_Payment::getShopCurrencyS(),
			
			'order_amount' => 1,
		
			'order_email' => '',
			'order_site' => $paysite->getSiteNameToken(),
			
			'order_title' => $gdo->getOrderItemName($module, GWF_Language::getCurrentISO()),
			'order_title_admin' => $gdo->getOrderItemName($module, GWF_LANG_ADMIN),
			
			'order_descr' => $gdo->getOrderDescr($module, GWF_Language::getCurrentISO()),
			'order_descr_admin' => $gdo->getOrderDescr($module, GWF_LANG_ADMIN),
		
			'order_status' => self::CREATED,
			'order_data' => serialize($gdo),
		
			'order_module' => $gdo->getOrderModuleName(),
		));
		
		if (false === ($order->insert())) {
			return false;
		}
		
		return $order;
	}

	###############
	### Execute ###
	###############
	public function execute()
	{
		// We try to execute, so its paid!
		if (false === $this->saveVars(array(
			'order_status' => self::PAID,
			'order_date_paid' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		))) {
			return false;
		}
		
		
		if (false === ($data = $this->getOrderData())) {
			return false;
		}
		if (!($data instanceof GWF_Orderable)) {
			return false;
		}
		
		$module = $this->getOrderModule();
		$module->onLoadLanguage();
		if (false === $data->executeOrder($module, $this->getUser())) {
			return false;
		}
		
		// We executed, all done, thx!
		return $this->saveVars(array(
			'order_status' => self::PROCESSED,
		));
	}
}

?>
