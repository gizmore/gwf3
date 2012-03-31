<?php
final class GWF_FormValidator
{
	private static $SKIPPERS = array(
		GWF_Form::SUBMIT,
		GWF_Form::SUBMIT_IMG,
//		GWF_Form::SUBMITS,
//		GWF_Form::SUBMIT_IMGS,
		GWF_Form::CHECKBOX,
		GWF_Form::SSTRING,
		GWF_Form::STRING_NO_CHECK,
		GWF_Form::DIVIDER,
		GWF_Form::HEADLINE,
		GWF_Form::FILE_OPT,
		GWF_Form::FILE,
	);

	public static function validate($context, GWF_Form $form, $validator)
	{
		if (false === ($errors = self::validateB($context, $form, $validator)))
		{
			return false;
		}
		return $errors;
	}

	private static function validateB($context, GWF_Form $form, $validator)
	{
		$name = method_exists($context, 'getName') ? $context->getName() : 'unknown Name';
		if (false !== ($error = self::validateCSRF($context, $form, $validator)))
		{
			return GWF_HTML::error($name, $error, false);
		}

		if (false !== ($errors = self::validateMissingVars($context, $form, $validator)))
		{
			return GWF_HTML::error($name, $errors, false);
		}

		if (false !== ($errors = self::validateVars($context, $form, $validator)))
		{
			return GWF_HTML::error($name, $errors, false);
		}

		return false;
	}

	private static function validateCSRF($context, GWF_Form $form, $validator)
	{
		if (GWF_Form::CSRF_OFF === ($level = $form->getCSRFLevel()))
		{
		}
//		elseif ($level === GWF_Form::CSRF_WEAK)
//		{
//
//		}
		else#if ($level === GWF_Form::CSRF_STRONG)
		{
			if ( (false === ($token = GWF_CSRF::validateToken())) || ($token !== $form->getCSRFToken()) )
			{
				return GWF_HTML::lang('ERR_CSRF');
			}
		}
		return false;
	}

	private static function validateCaptcha($context, GWF_Form $form, $validator, $key)
	{
		if (GWF_Session::getOrDefault('php_captcha', false) !== strtoupper($form->getVar($key)))
		{
			$form->onNewCaptcha();
			return GWF_HTML::lang('ERR_WRONG_CAPTCHA');
		}
//		GWF_Session::remove('php_captcha');
		$form->onSolvedCaptcha();
		return false;
	}

	private static function validateMissingVars($context, GWF_Form $form, $validator)
	{
		$errors = array();
		$check_sent = $form->getMethod() === GWF_Form::METHOD_POST ? $_POST : $_GET;
		$check_need = array();

//		var_dump($_POST);

		foreach ($form->getFormData() as $key => $data)
		{
			if (in_array($data[0], self::$SKIPPERS, true))
			{
				unset($check_sent[$key]);
				continue;
			}

			switch ($data[0])
			{
				case GWF_Form::VALIDATOR:
					break;
		
				case GWF_Form::SELECT_A:
					unset($check_sent[$key]);
					break;
	
				case GWF_Form::TIME:
					$check_need[] = $key.'h';
					$check_need[] = $key.'i';
					break;
		
				case GWF_Form::DATE:
				case GWF_Form::DATE_FUTURE:
					switch ($data[4])
					{
						case 14: $check_need[] = $key.'s';
						case 12: $check_need[] = $key.'i';
						case 10: $check_need[] = $key.'h';
						case 8: $check_need[] = $key.'d';
						case 6: $check_need[] = $key.'m';
						case 4: $check_need[] = $key.'y';
							break;
						default: die('Date field is invalid in form!');
					}
					break;
		
				case GWF_Form::SUBMITS:
				case GWF_Form::SUBMIT_IMGS:
						foreach (array_keys($data[1]) as $key)
						{
//							if (false !== ($i = array_search($key, $check_sent, true))) {
//								unset ($check_sent[$i]);
//							}
							unset($check_sent[$key]);

						}
					break;
		
				case GWF_Form::FILE:
					if (false === GWF_Upload::getFile($key))
					{
						$check_need[] = $key;
					}
					break;
		
				case GWF_Form::INT:
				case GWF_Form::STRING:
					if (Common::endsWith($key, ']'))
					{
						$key = Common::substrUntil($key, '[');
						if (!in_array($key, $check_need))
						{
							$check_need[] = $key;
						}
						break;
					}
		
				default:
					$check_need[] = $key;
					break;
			}
		}

//		var_dump($check_need);

		foreach ($check_need as $key)
		{
			if (!isset($check_sent[$key]))
			{
				$errors[] = GWF_HTML::lang('ERR_MISSING_VAR', array(htmlspecialchars($key)));
			}
			else
			{
				unset ($check_sent[$key]);
			}
		}


		foreach ($check_sent as $key => $value)
		{
			$errors[] = GWF_HTML::lang('ERR_POST_VAR', array(htmlspecialchars($key)));
		}

		return count($errors) === 0 ? false : $errors;
	}

	private static function validateVars($context, GWF_Form $form, $validator)
	{
		$errors = array();

		$method = $form->getMethod();

		foreach ($form->getFormData() as $key => $data)
		{
			# Skippers
			if ( (in_array($data[0], self::$SKIPPERS, true)) || ($data[0] === GWF_Form::SUBMITS) || ($data[0] === GWF_Form::SUBMIT_IMGS) )
			{
				continue;
			}

			# Captcha
			if ($data[0] === GWF_Form::CAPTCHA)
			{
				if (false !== ($error = self::validateCaptcha($context, $form, $validator, $key)))
				{
					$errors[] = $error;
				}
				continue;
			}

			# Get forms do not validate mo/me
			if ($method === GWF_Form::METHOD_GET)
			{
				if ( ($key === 'mo') || ($key === 'me') )
				{
					continue;
				}
			}

			# Validators
			$func_name = 'validate_'.Common::substrUntil($key, '[', $key);
			$function = array($validator, $func_name);
			if (!method_exists($validator, $func_name))
			{
				$errors[] = GWF_HTML::lang('ERR_METHOD_MISSING', array($func_name, get_class($validator)));
			}
			elseif (false !== ($error = call_user_func($function, $context, $form->getVar($key))))
			{
				$errors[] = $error;
			}
		}

		return count($errors) === 0 ? false : $errors;
	}
}
