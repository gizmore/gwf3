<?php

final class GWF_PaymentInstall
{
	public static function install(Module_Payment $module, $dropTable)
	{
		return
			GWF_ModuleLoader::installVars($module, array(
				'donations' => array(true, 'bool'),
				'currency' => array('EUR', 'text'),
				'currencies' => array('EUR:USD', 'script'),
//				'local_fee_buy' => array('1.00', 'float', '-50', '50'),
//				'local_fee_sell' => array('2.00', 'float', '-50', '50'),
				'global_fee_buy' => array('4.00', 'float', '-50', '50'),
				'global_fee_sell' => array('8.00', 'float', '-50', '50'),
				'orders_per_page' => array('50', 'int', '1', '500'),
			)).
			self::installCurrencies($module, $dropTable);
	}
	
	public static function installCurrencies(Module_Payment $module, $dropTable)
	{
		$path = GWF_CORE_PATH.'/module/Payment/install/_currencies.txt';
		if (false === ($fh = @fopen($path, 'r'))) {
			return GWF_HTML::err('ERR_FILE_NOT_FOUND', array( $path));
		}
		
		$n = 0;
		$errors = array();
		while (false !== ($line = fgets($fh)))
		{
			$n++;
			if ($line[0] === '#')
			{
				continue;
			}
			$cols = explode("\t", $line);
			$cols = array_map('trim', $cols);
			if (count($cols) < 6)
			{
				$errors[] = sprintf('Error in currency file %s line %d.', $path, $n);
				continue;
			}
			
			list($countryname, $currency, $char, $iso, $fracname, $multi) = $cols;
			if (false === ($c = GWF_Country::getByName(($countryname)))) {
				$errors[] = sprintf('Unknown Country %s in currency file %s line %d.', $countryname, $path, $n);
			}
			elseif ($currency == '') {
				$errors[] = sprintf('Unknown Currency for %s in currency file %s line %d.', $countryname, $path, $n);
			}
			elseif ($char == '') {
				$errors[] = sprintf('No Symbol for %s in currency file %s line %d.', $currency, $path, $n);
			}
			elseif (strlen($iso) !== 3) {
				continue;
				$errors[] = sprintf('No ISO for %s in currency file %s line %d.', $currency, $path, $n);
			}
			elseif ($fracname == '') {
				$errors[] = sprintf('No Fraction Name for %s in currency file %s line %d.', $currency, $path, $n);
			}
			elseif ($multi !== '1,000' && $multi !== '100' && $multi !== '10') {
				$errors[] = sprintf('Invalid Multiplier for %s in currency file %s line %d.', $currency, $path, $n);
			}
			else {
				$row = new GWF_Currency(array(
					'curr_iso' => $iso === 'None' ? sprintf('%03d', $n) : strtoupper($iso),
					'curr_cid' => $c->getID(),
					'curr_char' => $char,
					'curr_digits' => $multi === '100' ? 2 : ($multi === '1,000'?3:($multi === '10'?2:0)),
				));
				if (false === ($row->replace())) {
					$errors[] = GWF_HTML::lang('ERR_DATABASE', array( __FILE__, __LINE__));
					break;
				}
			}
		}
		fclose($fh);
		
		return GWF_HTML::error('Install Currencies', $errors);
	}
}