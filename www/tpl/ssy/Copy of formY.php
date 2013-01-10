<div class="ssy_form_spacer"></div>
<span class="ssy_form_border">
<span class="ssy_form_wrap">
<object>
<?php
echo sprintf('<form action="%s" method="%s" enctype="%s">', $tVars['action'], $tVars['method'], $tVars['encoding']);
echo '<table>';
echo sprintf('<tr><th colspan="3">%s</th></tr>', $tVars['title']);
foreach($tVars['inputs'] as $input)
{
	$type = $input[0];
	$tooltip = empty($input[3]) ? '' : GWF_Button::tooltip($input[3]);
	switch($type)
	{
			case GWF_Form::INT:
			case GWF_Form::DECIMAL:
				echo sprintf('<tr><td class="gwf_form_numeric">%s</td><td>%s</td><td>%s</td></tr>', $input[2], $tooltip, $input[1]);
				break;
			case GWF_Form::DATE:
			case GWF_Form::DATE_CMP:
			case GWF_Form::STRING:
			case GWF_Form::GDO:
			case GWF_Form::FROM_GDO:
			case GWF_Form::OPTION:
			case GWF_Form::SUBMIT:
			case GWF_Form::SPECIAL:
			case GWF_Form::SPECIAL_OPT:
			case GWF_Form::STEXT:
			case GWF_Form::FILE:
			case GWF_Form::FILE_OPT:
				echo sprintf('<tr><td>%s</td><td>%s</td><td>%s</td></tr>', $input[2], $tooltip, $input[1]);
				break;
			case GWF_Form::MESSAGE:
				echo sprintf('<tr><td colspan="3">%s%s</td></tr>', $input[2], $tooltip);
				echo sprintf('<tr><td colspan="3">%s</td></tr>', $input[1]);
				break;
			case GWF_Form::PASSWORD:
				echo sprintf('<tr><td>%s</td><td>%s</td><td>%s</td></tr>', $input[2], GWF_Button::tooltip(GWF_HTML::lang('tt_password')), $input[1]);
				break;
			case GWF_Form::DIVIDER:
				echo sprintf('<tr><td class="gwf_form_div" colspan="3"></td></tr>');
				break;
			case GWF_Form::HEADLINE:
				echo sprintf('<tr><td class="gwf_form_head" colspan="3">%s%s</td></tr>', $input[2], $tooltip);
				break;
			case GWF_Form::SUBMITS:
				echo '<tr><td colspan="3">'.$input[1].'</td></tr>';
				break;
			case GWF_Form::CAPTCHA:
				echo sprintf('<tr><td>%s</td><td>%s</td><td>%s</td></tr>', GWF_HTML::lang('th_captcha1'), GWF_Button::tooltip(GWF_HTML::lang('tt_captcha1')), $input[1][1]);
				echo sprintf('<tr><td>%s</td><td>%s</td><td>%s</td></tr>', GWF_HTML::lang('th_captcha2'), GWF_Button::tooltip(GWF_HTML::lang('tt_captcha2')), $input[1][0]);
				break;
			case GWF_Form::CSRF:
			case GWF_Form::HIDDEN:
				echo sprintf('<tr style="display:hidden;"><td>%s</td></tr>', $input[1]);
				break;
	}
}
echo '</table>';
echo '</form>';
?>
</object>
</span>
</span>
