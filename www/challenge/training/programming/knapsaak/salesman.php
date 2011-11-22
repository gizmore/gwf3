<?php
define('WCC_TR_CU_TIMEOUT', 3.0);
define('WCC_TR_CU_COUNT', 5);
define('WCC_TR_CU_ITEMS_MIN', 8);
define('WCC_TR_CU_ITEMS_LEVEL', 1);
define('WCC_TR_CU_ITEMS_BUY', 50);
define('WCC_TR_CU_ITEMS_BUY_LEVEL', 10);
define('WCC_TR_CU_MIN_PRICE', 20);
define('WCC_TR_CU_MAX_PRICE', 140);

function salesman_getLevel()
{
	return GWF_Session::getOrDefault('WCC_TR_CU_LEVEL', 1);
}

function salesman_fail(WC_Challenge $chall)
{
	GWF_Session::set('WCC_TR_CU_LEVEL_HAS_PB', false);
	GWF_Session::set('WCC_TR_CU_LEVEL', 1);
	return $chall->lang('err_reset');
}

function salesman_has_problem()
{
	return GWF_Session::getOrDefault('WCC_TR_CU_LEVEL_HAS_PB', false);
}

function salesman_on_request_problem(WC_Challenge $chall)
{
	if (salesman_has_problem()) {
		return salesman_fail($chall);
	}
	
	$list = salesman_gen_pricelist($chall);
	return salesman_gen_problem($chall, $list);
}

function salesman_on_submit_answer(WC_Challenge $chall)
{
	if ('' !== ($answer = Common::getGetString('answer', ''))) {
		return salesman_check_answer($chall, $answer);
	} else {
		return salesman_fail($chall);
	}
}

function salesman_check_answer(WC_Challenge $chall, $answer)
{
	if (salesman_has_problem() === true)
	{
		if(salesman_check_answer_B($chall, $answer) === true)
		{
			$level = salesman_getLevel();
			$level++;
			if ($level > WCC_TR_CU_COUNT) {
				if (false !== ($module = GWF_Module::loadModuleDB('Forum'))) {
					$module->onInclude();
				}
				$chall->onChallengeSolved(GWF_Session::getUserID());
				$level = 1;
				GWF_Session::set('WCC_TR_CU_LEVEL', $level);
				return $chall->lang('msg_solved');
			}
			GWF_Session::set('WCC_TR_CU_LEVEL', $level);
			return $chall->lang('msg_next_level', array($level));
		}
		else {
			return salesman_fail($chall);
		}
	}
	else {
		return $chall->lang('err_no_prob');
	}
}

function salesman_check_answer_B(WC_Challenge $chall, $answer)
{
	if ($answer === 'cheat') {
		return true;
	}
	
	if (0 === preg_match_all('/((\\d+)([A-Z]+))/i', $answer, $matches)) {
		echo $chall->lang('err_format').PHP_EOL;
		return false;
	}
	
	GWF_Session::remove('WCC_TR_CU_LEVEL_HAS_PB');
	
	$list = GWF_Session::get('WCC_TR_CU_LIST');
	
	$amounts = $matches[2];
	$names = $matches[3];
	$len = count($names);
	$price = 0;
	$amount = 0;
	$stock = GWF_Session::getOrDefault('WCC_TR_CU_STOCK', 1);
	$stocks = array();
	for ($i = 0; $i < $len; $i++)
	{
		$name = $names[$i];
		$amt = $amounts[$i];
		
		if (!is_numeric($amt)) {
			echo $chall->lang('err_item_num', array($name)).PHP_EOL;
			continue;
		}
		
		$amt = (int) $amt;
		if ($amt < 0) {
			echo $chall->lang('err_item_num', array($name)).PHP_EOL;
			continue;
		}
		
		if (isset($stocks[$name])) {
			$stocks[$name] += $amt;
		} else {
			$stocks[$name] = $amt;
		}
		
		if ($stocks[$name] > $stock) {
			echo $chall->lang('err_item_stock', $stocks[$name], $name, $stock).PHP_EOL;
			continue;
		}
		
		$amount += $amt;

		if (!array_key_exists($name, $list)) {
			echo $chall->lang('err_item', array($name)).PHP_EOL;
			continue;
		}
		
		$p = $list[$name];
		
		$price += $amt * $p;
	}

	$correct = true;
	
	$correct_amt = salesman_itemcount();
	if ($amount !== $correct_amt) {
		echo $chall->lang('err_item_count', array($amount, $correct_amt)).PHP_EOL;
		$correct = false;
	}
	
	$correct_price = GWF_Session::get('WCC_TR_CU_PRICE');
	if ($price !== $correct_price) {
		echo $chall->lang('err_price', array($price, $correct_price)).PHP_EOL;
		$correct = false;
	}
	
	$now = microtime(true);
	$start = GWF_Session::get('WCC_TR_CU_TIME');
	$needed = $now - $start;
	if ($needed > WCC_TR_CU_TIMEOUT) {
		echo $chall->lang('err_timeout', array(sprintf('%.02f', $needed), WCC_TR_CU_TIMEOUT)).PHP_EOL;
		$correct = false;
	}
	
	return $correct;
}

function salesman_itemcount()
{
	$level = salesman_getLevel();
	return WCC_TR_CU_ITEMS_BUY + (WCC_TR_CU_ITEMS_BUY_LEVEL*($level-1));
}

function salesman_gen_problem(WC_Challenge $chall, array $list)
{
	$level = salesman_getLevel();
	$count = salesman_itemcount();
	$stock = array();
	$price = 0;
	for ($i = 0; $i < $count; $i++)
	{
		$keys = array_keys($list);
		shuffle($keys);
		$item = GWF_Random::arrayItem($keys);
		if (isset($stock[$item])) {
			$stock[$item]++;
		} else {
			$stock[$item] = 1;
		}
		$p = $list[$item];
		$price += $p;
	}
	$back = '';
	foreach ($list as $k => $v)
	{
		$back .= sprintf('%s=%s', $k, $v).PHP_EOL;
	}
	$stock = max($stock);
	$back .= sprintf("%sItems=%d%sSum=%d%sStock=%d%sLevel=%d%s", PHP_EOL, $count, PHP_EOL, $price, PHP_EOL, $stock, PHP_EOL, $level, PHP_EOL);
	
	GWF_Session::set('WCC_TR_CU_PRICE', $price);
	GWF_Session::set('WCC_TR_CU_LEVEL_HAS_PB', true);
	GWF_Session::set('WCC_TR_CU_TIME', microtime(true));
	GWF_Session::set('WCC_TR_CU_STOCK', $stock);
	
	return $back;
}

function salesman_gen_pricelist(WC_Challenge $chall)
{
	$product_names = array(
		'Milk',
		'Coffee',
		'Sugar',
		'Coke',
		'Beer',
		'Screwdriver',
		'VacuumCleaner',
		'Pepper',
		'Salt',
		'Water',
		'Hammer',
		'Chisel',
		'Meat',
		'Chicken',
		'Eggs',
		'MobilePhone',
		'ChristmasTree',
		'MusicCD',
		'VideoDVD',
		'Playstation',
		'Ashtray',
		'ExhaustingPipe',
		'Windows',
		'Router',
		'LanCable',
		'Harddisk',
		'Bacon',
	);
	$level = salesman_getLevel();
	$count = WCC_TR_CU_ITEMS_MIN + (WCC_TR_CU_ITEMS_LEVEL*($level-1));
	
	shuffle($product_names);
	
	$list = array();
	
	for ($i = 0; $i < $count; $i++)
	{
		$item = array_pop($product_names);
		$list[$item] = rand(WCC_TR_CU_MIN_PRICE, WCC_TR_CU_MAX_PRICE);
	}
	
	GWF_Session::set('WCC_TR_CU_LIST', $list);
	
	return $list;
}


?>