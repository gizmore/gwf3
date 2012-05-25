<?php
/**
 * Used in an old project where i better should have used JSON :)
 * @author gizmore
 * @deprecated
 */
final class GWF_GDOSerializer
{
	public static function serializeHTTP(GDO $gdo)
	{
		$back = '1:'.PHP_EOL;
		self::serializeHTTPGDO('', $gdo, $back);
		return $back;
	}
	
	public static function serializeHTTPGDO($key, GDO $gdo, &$back)
	{
		$gdo_data = $gdo->getGDOData();
		# GDO Header
		if ($key !== '') {
			$back .= sprintf('G:%s:%s:%d:'.PHP_EOL, $key, $gdo->getClassName(), count($gdo_data));
		}
		foreach ($gdo_data as $key => $value)
		{
			if (is_object($value)) { # Object
				$value->serializeHTTPGDOValue($back);
			}
			elseif(is_array($value)) { # Array
				self::serializeHTTPArray($key, $value, $back);
			}
			else { # Primitive
				self::serializeHTTPPrimitive($key, $value, $back);
			}
		}
	}
	
	public static function serializeHTTPArray($key, $value, &$back)
	{
		$back .= sprintf('A:%s:%d:'.PHP_EOL, $key, count($value));
		foreach ($value as $k => $v)
		{
			if (is_object($v)) {
				self::serializeHTTPGDO($k, $v, $back);
			}
			else if (is_array($v)) {
				self::serializeHTTPArray($k, $v, $back);
			} else {
				self::serializeHTTPPrimitive($k, $v, $back);
			}
		}
	}
	
	public static function serializeHTTPPrimitive($key, $value, &$back)
	{
		$back .= sprintf('D:%s:%d:%s'.PHP_EOL, $key, strlen($value), $value);
	}
}
?>
