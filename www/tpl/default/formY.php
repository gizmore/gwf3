<?php $required = "(*)"; $cols = 3; ?>
<div class="gwf3_formY">
	<form action="<?php echo $tVars['action']; ?>" method="<?php echo $tVars['method']; ?>" enctype="<?php echo $tVars['enctype']; ?>">
	<table>
		<thead><tr><th colspan="<?php echo $cols; ?>"><?php echo $tVars['title']; ?></th></tr></thead>
		<tbody>
		<?php foreach ($tVars['data'] as $key => $data) { ?>
		<?php
		$tt = '';
		if (!empty($data[3]))
		{
			$tt = GWF_Button::tooltip($data[3]);
		}
		#$data[4] === LEN??
		$req = '';
		if (isset($data[5]) && $data[5]) {
			$have_required = true;
			$req = $required;
		}

		switch ($data[0])
		{
			case GWF_Form::HIDDEN:
				printf('<tr><td colspan="%s"><input type="hidden" name="%s" value="%s" /></td></tr>'.PHP_EOL, $cols, $key, $data[1]);
				break;
				
			case GWF_Form::STRING:
			case GWF_Form::STRING_NO_CHECK:
				printf('<tr><td>%s%s</td><td>%s</td><td><input type="text" name="%s" value="%s" /></td></tr>'.PHP_EOL, $req, $data[2], $tt, $key, $data[1]);
				break;
				
			case GWF_Form::INT:
			case GWF_Form::FLOAT:
				printf('<tr><td>%s%s</td><td>%s</td><td><input type="text" name="%s" size="8" value="%s" /></td></tr>'.PHP_EOL, $req, $data[2], $tt, $key, $data[1]);
				break;
				
			case GWF_Form::PASSWORD:
				printf('<tr><td>%s%s</td><td>%s</td><td><input type="password" name="%s" value="" /></td></tr>'.PHP_EOL, $req, $data[2], $tt, $key);
				break;
				
			case GWF_Form::CHECKBOX:
				printf('<tr><td>%s%s</td><td>%s</td><td><input type="checkbox" name="%s"%s value="" /></td></tr>'.PHP_EOL, $req, $data[2], $tt, $key, ($data[1]!==false?' checked="checked"':''));
				break;
				
			case GWF_Form::SUBMIT:
				printf('<tr><td></td><td></td><td><input type="submit" name="%s" value="%s" /></td></tr>'.PHP_EOL, $key, $data[1]);
				break;
				
			case GWF_Form::CAPTCHA:
				$foo = empty($data[1]) ? '' : '/'.$data[1];
				printf('<tr><td>%s</td><td>%s</td><td><img src="%sCaptcha%s" onclick="this.src=\'%sCaptcha/?\'+(new Date()).getTime();" alt="Captcha" /></td></tr>'.PHP_EOL, GWF_HTML::lang('th_captcha1'), GWF_Button::tooltip(GWF_HTML::lang('tt_captcha1')), GWF_WEB_ROOT, $foo, GWF_WEB_ROOT);
				printf('<tr><td>%s</td><td>%s</td><td><input type="text" name="%s" value="%s" /></td></tr>'.PHP_EOL, GWF_HTML::lang('th_captcha2'), GWF_Button::tooltip(GWF_HTML::lang('tt_captcha2')), $key, $data[1]);
				break;
			
			case GWF_Form::ENUM:
			case GWF_Form::TIME:
			case GWF_Form::DATE:
			case GWF_Form::DATE_FUTURE:
			case GWF_Form::SELECT:
			case GWF_Form::SELECT_A:
			case GWF_Form::SSTRING:
				printf('<tr><td>%s%s</td><td>%s</td><td>%s</td></tr>'.PHP_EOL, $req, $data[2], $tt, $data[1]);
				break;
				
			case GWF_Form::DIVIDER:
				printf('<tr class="divider"><td colspan="%d"><hr/></td></tr>'.PHP_EOL, $cols);
				break;
				
			case GWF_Form::HEADLINE:
				if (isset($data[2]))
				{
					printf('<tr><td>%s%s</td><td>%s</td><td>%s</td></tr>'.PHP_EOL, $req, $data[2], $tt, $data[1]);
				}
				else
				{

					printf('<tr class="headline"><td colspan="%d">%s</td></tr>'.PHP_EOL, $cols, $data[1]);
				}
				break;
				
			case GWF_Form::SUBMITS:
				$buttons = '';
				foreach ($data[1] as $submitsk => $submitsv)
				{
					$buttons .= sprintf('<input type="submit" name="%s" value="%s" />', $submitsk, $submitsv);
				}
				printf('<tr><td></td><td></td><td>%s</td></tr>'.PHP_EOL, $buttons);
				break;
				
			case GWF_Form::MESSAGE:
				printf('<tr><td colspan="%d">%s</td></tr>'.PHP_EOL, $cols, GWF_Message::getCodeBar($key));
				### Fallthrough...
			case GWF_Form::MESSAGE_NOBB:
//				printf();
				printf('<tr><td colspan="%d">%s</td></tr>'.PHP_EOL, $cols, $data[2]);
				printf('<tr><td colspan="%d"><textarea id="%s" name="%s" cols="80" rows="8">%s</textarea></td></tr>'.PHP_EOL, $cols, $key, $key, $data[1]);
				break;
				
			case GWF_Form::VALIDATOR:
				break;
				
			case GWF_Form::FILE:
			case GWF_Form::FILE_OPT:
				printf('<tr><td>%s%s</td><td>%s</td><td><input type="file" name="%s" /></td></tr>'.PHP_EOL, $req, $data[2], $tt, $key);
				break;
			case GWF_Form::HTML:
				echo $data[1].PHP_EOL;
				break;
			default:
				var_dump($data);
				GWF3::logDie(sprintf('Your tpl/formY.php is missing datatype %d', $data[0]));
		}
		?>
		<?php } ?>
		</tbody>
	</table>
	</form>
	<?php if (isset($have_required)) { echo GWF_HTML::lang('form_required', array('*')); } ?>
</div>
