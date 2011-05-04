<?php

final class GWF_ShoppingCart extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'order_cart'; }
	public function getColumnDefines()
	{
		return array(
			'orderc_id' => array(GDO::AUTO_INCREMENT),
			'orderc_uid' => array(GDO::UINT, 0),
			'orderc_sessid' => GWF_Session::gdoDefine(GDO::INDEX),
		);
	}
	
	#####################
	### Static Getter ###
	#####################
	public static function getCart()
	{
		$sessid = GWF_Session::getSessID();
		if (false !== ($cart = self::table(__CLASS__)->selectFirst("orderc_sessid='$sessid'")))
		{
			return $cart;
		}
		else
		{
			$cart = new self(array(
				'orderc_uid' => GWF_Session::getUserID(),
				'orderc_sessid' => $sessid,
			));
			if (false === ($cart->insert())) {
				return false;
			}
			return $cart;
		}
	}
}

?>
