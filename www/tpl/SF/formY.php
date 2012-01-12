<?php printf('<form action="%s" method="%s" enctype="%s">', $tVars['action'], $tVars['method'], $tVars['enctype']); ?>
	<fieldset class="gwf3_formY">
		<legend><?php echo $tVars['title']; ?></legend>
		<ul>
<?php 
foreach ($tVars['data'] as $key => $data)
{
	if (NULL != ($tt = $data[3]))
	{
		$tt = GWF_Button::tooltip($tt);
	}
	#$data[4] === LEN??
	$req = '';
	if(true === isset($data[5]) && $data[5])
	{
		$have_required = true;
		$req = '(*)';
	}
	echo "\t\t\t";
	switch ($data[0])
	{
		case GWF_Form::HIDDEN:
			printf('<li class="form_hidden" style="display: none;"><input type="hidden" name="%s" value="%s"></li>'.PHP_EOL, $key, $data[1]);
			break;
			
		case GWF_Form::STRING:
		case GWF_Form::STRING_NO_CHECK:
			echo '<li class="form_text"><label for="lf_'.$key.'">'.$req.$data[2].$tt.'</label><input id="lf_'.$key.'" type="text" name="'.$key.'" value="'.$data[1].'"></li>'.PHP_EOL;
			break;
			
		case GWF_Form::INT:
		case GWF_Form::FLOAT:
			echo '<li class="form_number"><label for="lf_'.$key.'">'.$req.$data[2].$tt.'</label><input id="lf_'.$key.'" type="text" name="'.$key.'" size="8" value="'.$data[1].'"></li>'.PHP_EOL;
			break;
			
		case GWF_Form::PASSWORD:
			echo '<li class="form_password"><label for="lf_'.$key.'">'.$req.$data[2].$tt.'</label><input id="lf_'.$key.'" type="password" name="'.$key.'" value=""></li>'.PHP_EOL;
			break;
			
		case GWF_Form::CHECKBOX:
			echo '<li class="form_checkbox"><label for="lf_'.$key.'">'.$req.$data[2].$tt.'</label><input id="lf_'.$key.'" type="checkbox" name="'.$key.'"'.($data[1]!==false?' checked="checked"':' ').'value=""></li>'.PHP_EOL;
			break;
			
		case GWF_Form::SUBMIT:
			echo'<li class="form_submit"><input type="submit" name="'.$key.'" value="'.$data[1].'"></li>'.PHP_EOL;
			break;
			
		case GWF_Form::CAPTCHA:
			$foo = empty($data[1]) ? '' : '?chars='.$data[1];
			echo '<li class="form_captcha">'.GWF_HTML::lang('th_captcha1').GWF_Button::tooltip(GWF_HTML::lang('tt_captcha1')).'<img src="'.GWF_WEB_ROOT.'Captcha/'.$foo.'" onclick="this.src=\''.GWF_WEB_ROOT.'Captcha/?\'+(new Date()).getTime();" alt="Captcha"></li>'.PHP_EOL;
			printf('<li class="form_captcha form_text"><label for="lf_'.$key.'">%s%s</label><input id="lf_'.$key.'" type="text" name="%s" value="%s"></li>'.PHP_EOL, GWF_HTML::lang('th_captcha2'), GWF_Button::tooltip(GWF_HTML::lang('tt_captcha2')), $key, $data[1]);
			break;
			
		case GWF_Form::DATE:
		case GWF_Form::DATE_FUTURE:
		case GWF_Form::SELECT:
		case GWF_Form::SELECT_A:
			printf('<li class="form_"><label for="lf_'.$key.'">%s%s%s</label><span id="lf_'.$key.'">%s</span></li>'.PHP_EOL, $req, $data[2], $tt, $data[1]);
			break;

		case GWF_Form::SSTRING:
			echo $data[2], $data1;
			break;

		case GWF_Form::DIVIDER:
			echo '<hr class="form_hr">'.PHP_EOL;
			break;
			
		case GWF_Form::HEADLINE:
			if (isset($data[2]))
			{
				printf('<li class="form_headline"><label for="lf_'.$key.'">%s%s%s</label><span id="lf_'.$key.'">%s</span></li>'.PHP_EOL, $req, $data[2], $tt, $data[1]);
			}
			else
			{
				printf('<li class="headline">%s</li>'.PHP_EOL, $data[1]);
			}
			break;
			
		case GWF_Form::SUBMITS:
			foreach ($data[1] as $submitsk => $submitsv)
			{
				echo sprintf('<li class="form_submits"><input type="submit" name="%s" value="%s"></li>', $submitsk, $submitsv).PHP_EOL;
			}
			break;
				
		case GWF_Form::MESSAGE:
			echo '<li class="form_bbcode">' .GWF_Message::getCodeBar($key).'</li>'.PHP_EOL;
			### Fallthrough...
		case GWF_Form::MESSAGE_NOBB:
			printf('<li>%s</li>'.PHP_EOL, $data[2]);
			printf('<li class="form_textarea"><textarea id="%s" name="%s">%s</textarea></li>'.PHP_EOL, $key, $key, $data[1]);
		break;
				
		case GWF_Form::VALIDATOR:
			break;
			
		case GWF_Form::FILE:
		case GWF_Form::FILE_OPT:
			printf('<li class="form_file"><label for="lf_'.$key.'">%s%s%s</label><input id="lf_'.$key.'" type="file" name="%s" value="%s"></li>'.PHP_EOL, $req, $data[2], $tt, $key, $data[1]);
			break;
				
		default:
			var_dump($data);
			GWF3::logDie(sprintf('Your tpl/formY.php is missing datatype %d', $data[0]));
	}
}

if(true === isset($have_required))
{
	echo '<li class="form_required">'.GWF_HTML::lang('form_required', array('*')).'</li>'.PHP_EOL;
}
?>
		</ul>
	</fieldset>
</form>
