<?php

/**
 * Smarty plugin
 * -------------------------------------------------------------
 * File:          block.geshi.php
 * Type:          block
 * Name:          geshi
 * Version:       1.0, Oct 25th 2008
 * Author:        Ben Keen (ben.keen@gmail.com), see: http://www.benjaminkeen.com
 * Purpose:       Render a block of text using GeSHi (Generic Syntax Highlighter). See:
 *                http://qbnz.com/highlighter/
 * Requirements:  you must have installed geshi on your server, and update the require_once() line
 *                below in order to get it configured.
 *
 *                Example usage:
 *
 *                  {geshi lang="php" show_line_numbers=true start_line_numbers_at=5}
 *                    function my_funct()
 *                    {
 *                      echo "chicken!";
 *                      return true;
 *                    }
 *                  {/geshi}
 *
 * Parameters:    This function takes the following parameters:
 *                   "lang": This determines the programming language with which to highlight the
 *                           text. You can specify any languages available for Geshi.
 *                   "show_line_numbers": if included, will show the line numbers
 *                   "start_line_numbers_at": the line number starting number (default 1)
 * -------------------------------------------------------------
 */
function smarty_block_geshi($params, $content, &$smarty)
{
	require_once('/opt/php/geshi/geshi.php');

  if (empty($params["lang"]))
  {
	  $smarty->trigger_error("assign: missing 'lang' parameter. Geshi needs this value to know which language to render the code with.");
    return;
  }
  $lang = $params["lang"];

  if (is_null($content))
    return;

  // trim the content to prevent any extra newlines appearing at the start and end
  $geshi = new GeSHi(trim($content), $lang);

  if (!empty($params["show_line_numbers"]) && $params["show_line_numbers"])
  	$geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);

  if (!empty($params["start_line_numbers_at"]) && is_numeric($params["start_line_numbers_at"]))
  	$geshi->start_line_numbers_at($params["start_line_numbers_at"]);

  echo $geshi->parse_code();
}
