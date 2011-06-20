<div class="gwf3_formY">
	<form action="<?php echo $tVars['action']; ?>" method="<?php echo $tVars['method']; ?>" enctype="<?php echo $tVars['enctype']; ?>">
		<fieldset class="SF_formY">
			<legend><?php echo $tVars['title']; ?></legend>
			<ul>
<?php 
$required = "(*)";
foreach ($tVars['data'] as $key => $data) {
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
	echo "\t\t\t\t";
	switch ($data[0])
	{
		case GWF_Form::HIDDEN:
			printf('<input type="hidden" name="%s" value="%s">'.PHP_EOL, $key, $data[1]);
			break;
			
		case GWF_Form::STRING:
		case GWF_Form::STRING_NO_CHECK:
			echo '<li><label for="lf_'.$key.'">'.$req.$data[2].$tt.'</label><input id="lf_'.$key.'" type="text" name="'.$key.'" value="'.$data[1].'"></li>'.PHP_EOL;
			break;
			
		case GWF_Form::INT:
		case GWF_Form::FLOAT:
			echo '<li><label for="lf_'.$key.'">'.$req.$data[2].$tt.'</label><input id="lf_'.$key.'" type="text" name="'.$key.'" size="8" value="'.$data[1].'"></li>'.PHP_EOL;
			break;
			
		case GWF_Form::PASSWORD:
			echo '<li><label for="lf_'.$key.'">'.$req.$data[2].$tt.'</label><input id="lf_'.$key.'" type="password" name="'.$key.'" value=""></li>'.PHP_EOL;
			break;
			
		case GWF_Form::CHECKBOX:
			echo '<li><label for="lf_'.$key.'">'.$req.$data[2].$tt.'</label><input id="lf_'.$key.'" type="checkbox" name="'.$key.'"'.($data[1]!==false?' checked="checked"':' ').'value=""></li>'.PHP_EOL;
			break;
			
		case GWF_Form::SUBMIT:
			echo'<li><input type="submit" name="'.$key.'" value="'.$data[1].'"></li>'.PHP_EOL;
			break;
			
		case GWF_Form::CAPTCHA:
			$foo = empty($data[1]) ? '' : '?chars='.$data[1];
			printf('<li><img src="%simg/captcha.php%s" onclick="this.src=\'%simg/captcha.php?\'+(new Date()).getTime();" alt="Captcha" /></li>'.PHP_EOL, GWF_HTML::lang('th_captcha1'), GWF_Button::tooltip(GWF_HTML::lang('tt_captcha1')), GWF_WEB_ROOT, $foo, GWF_WEB_ROOT);
			printf('<li><label for="lf_'.$key.'">%s%s</label><input id="lf_'.$key.'" type="text" name="%s" value="%s"></li>'.PHP_EOL, GWF_HTML::lang('th_captcha2'), GWF_Button::tooltip(GWF_HTML::lang('tt_captcha2')), $key, $data[1]);
			break;
			
		case GWF_Form::DATE:
		case GWF_Form::DATE_FUTURE:
		case GWF_Form::SELECT:
		case GWF_Form::SELECT_A:
		case GWF_Form::SSTRING:
			printf('<li><label for="lf_'.$key.'">%s%s%s</label><span id="lf_'.$key.'">%s</span></li>'.PHP_EOL, $req, $data[2], $tt, $data[1]);
			break;
			
		case GWF_Form::DIVIDER:
			echo '<hr class="form_hr">'.PHP_EOL;
			break;
			
		case GWF_Form::HEADLINE:
			if (isset($data[2]))
			{
				printf('<li><label for="lf_'.$key.'">%s%s%s</label><span id="lf_'.$key.'">%s</span></li>'.PHP_EOL, $req, $data[2], $tt, $data[1]);
			}
			else
			{
				printf('<li class="headline">%s</li>'.PHP_EOL, $data[1]);
			}
			break;
			
		case GWF_Form::SUBMITS:
			$buttons = '';
			foreach ($data[1] as $submitsk => $submitsv)
			{
				echo sprintf('<li><input type="submit" name="%s" value="%s"></li>', $submitsk, $submitsv).PHP_EOL;
			}
			break;
				
		case GWF_Form::MESSAGE:
			echo '<li>' .GWF_Message::getCodeBar($key) . PHP_EOL . '</li>';
			### Fallthrough...
		case GWF_Form::MESSAGE_NOBB:
			printf('<li>%s</li>'.PHP_EOL, $data[2]);
			printf('<li><textarea id="%s" name="%s" cols="20" rows="10">%s</textarea></li>'.PHP_EOL, $key, $key, $data[1]);
		break;
				
		case GWF_Form::VALIDATOR:
			break;
			
		case GWF_Form::FILE:
		case GWF_Form::FILE_OPT:
			printf('<li><label for="lf_'.$key.'">%s%s%s</label><input id="lf_'.$key.'" type="file" name="%s" value="%s"></li>'.PHP_EOL, $req, $data[2], $tt, $key, $data[1]);
			break;
				
		default:
			var_dump($data);
			die(sprintf('Your tpl/formY.php is missing datatype %d', $data[0]));
	}
}
?>
<?php if (isset($have_required)) {
	echo '<li class="last">'.GWF_HTML::lang('form_required', array('*')).'</li>';
}?>
			</ul>
		</fieldset>
	</form>
</div>