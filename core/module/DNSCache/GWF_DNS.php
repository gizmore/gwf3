<?php
final class GWF_DNS extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dns'; }
	public function getColumnDefines()
	{
		return array(
			'dns_host' => array(GDO::TEXT|GDO::INDEX),
			'dns_ip' => GWF_IP6::gdoDefine(GWF_IP_EXACT, GDO::NOT_NULL, GDO::INDEX),
		);
	}
	
}
?>