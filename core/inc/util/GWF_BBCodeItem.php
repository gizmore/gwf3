<?php
/** 
 * Render the snippets.
 * Add your own code tags to the bottom.
 * @author gizmore
 * @version 3.0
 */
final class GWF_BBCodeItem
{
	private $parent = NULL;
	private $tag = NULL;
	private $fulltag = NULL;
	private $text = NULL;
	private $params = NULL;
	private $childs = NULL;

	##############
	### Adding ###
	##############
	public function setText($text) { $this->text = $text; }
	public function setTag($tag) { $this->tag = $tag; }
	public function setFullTag($full_tag) { $this->fulltag = $full_tag; }
	public function setParams($params) { $this->params = $params; }
	public function setParent(GWF_BBCodeItem $parent) { $this->parent = $parent; }

	public function addChild(GWF_BBCodeItem $child)
	{
		if ($this->childs === NULL)
		{
			$this->childs = array($child);
		}
		else
		{
			$this->childs[] = $child;
		}
	}

	public function addTextChild($text)
	{
		$child = new self();
		$child->setParent($this);
		$child->setText($text);
		$this->addChild($child);
	}

	###############
	### Closing ###
	###############
	public function close($tag)
	{
		if ($this->parent === NULL)
		{
			return NULL;
		}
		elseif ($this->tag === $tag)
		{
			return $this->parent;
		}
		else
		{
			return $this->parent->close($tag);
		}
	}

	###################
	### Render Main ###
	###################
	public function render($htmlspecial=true, $nl2br=true, $raw=false)
	{
		if ($this->tag !== NULL)
		{
			return $this->renderTag($htmlspecial, $nl2br, $raw);
		}
		elseif ($this->childs !== NULL)
		{
			return $this->renderChilds($htmlspecial, $nl2br, $raw);
		}
		else
		{
			return $this->renderText($htmlspecial, $nl2br, $raw);
		}
	}

	public function renderTag($htmlspecial=true, $nl2br=true, $raw=false)
	{
//		if ($this->tag === NULL)
//		{
//			return $this->renderText($htmlspecial, $nl2br);
//		}

		if ($raw)
		{
			return $this->fulltag.$this->renderChilds($htmlspecial, $nl2br, $raw);
		}

		$method_name = 'render_'.$this->tag;
		if (method_exists($this, $method_name))
		{
			return call_user_func(array($this, $method_name), $htmlspecial, $nl2br, $raw);
		}
		else
		{
			return $this->fulltag.$this->renderChilds($htmlspecial, $nl2br, $raw);
		}
	}

	public function renderChilds($htmlspecial=true,$nl2br=true, $raw=false)
	{
		$back = '';
		if ($this->childs !== NULL)
		{
			foreach ($this->childs as $child)
			{
				$child instanceof GWF_BBCodeItem;
				$back .= $child->render($htmlspecial, $nl2br, $raw);
			}
		}
		return $back;
	}

	public function renderText($htmlspecial=true, $nl2br=true, $raw=false)
	{
// 		$back = trim($this->text);
		$back = $this->text;

		if ($htmlspecial)
		{
			$back = htmlspecialchars($back);
		}

		$back = GWF_BBCode::highlight($back);

		if (!$raw)
		{
			$back = GWF_BBCode::replaceSmileys($back);
		}

		if ($nl2br)
		{
			$back = nl2br($back);
		}

		return $back;
	}

	##############
	### Helper ###
	##############
	private function filterHREF($href)
	{
		static $allow = array('http', 'https', 'ftp', 'ftps');

		if ('' === ($href = trim(htmlspecialchars($href))))
		{
			return false;
		}

		if ($href[0]==='/')
		{
			return GWF_WEB_ROOT.substr($href, 1);
		}

		if (false === ($pos = strpos($href, '://')))
		{
			return false;
		}

		$protocol = substr($href, 0, $pos);
		if (!in_array($protocol, $allow))
		{
			return false;
		}

		return $href;
	}

	private function filterURLText($text, $maxlen=48, $middle='...')
	{
		return $text;
		# shorten very very long urls
//		if (strlen($text) <= $maxlen) {
//			return $text;
//		}
//		$side = intval($maxlen / 2);
//		return substr($text, 0, $side).$middle.substr($text, -$side);
	}

	####################
	### Helper GeSHi ###
	####################
	private function renderCode($lang, $htmlspecial, $nl2br, $raw)
	{
		$lang = htmlspecialchars($lang);

		$title = '';
		if (isset($this->params['title']))
		{
			$title = $this->params['title'];
			$title = htmlspecialchars($title);
		}

		$head = $lang;
		$head .= ' '.GWF_HTML::lang('code');

		$head .= $title === '' ? '' : ' '.GWF_HTML::lang('for').' <cite>'.$title.'</cite>';

		if (!GWF_GESHI_PATH)
		{
			$pre = '<div class="gwf_bb_code">';
			$pre .= sprintf('<div>%s</div>', $head);
			$pre .= '<code>';
			$after = '</code></div>';
			return $pre.$this->renderChilds($htmlspecial, $nl2br, true).$after;
		}
		else
		{
			require_once GWF_GESHI_PATH;
			$source = $this->renderChilds(false, false, true);
			$geshi = new GeSHi($source, $lang);

//			$type = GESHI_HEADER_NONE;
//			$type = GESHI_HEADER_DIV;
//			$type = GESHI_HEADER_PRE;
//			$type = GESHI_HEADER_PRE_VALID;
			$type = GESHI_HEADER_PRE_TABLE;
			$geshi->set_header_type($type);

// 			$flag = GESHI_NORMAL_LINE_NUMBERS;
			$flag = GESHI_FANCY_LINE_NUMBERS;
			$geshi->enable_line_numbers($flag);

//			$geshi->start_line_numbers_at(1);
//			$geshi->enable_classes();

			$geshi_a = '<a href="http://qbnz.com/highlighter/">GeSHi</a>`ed ';
			$pre = '<div class="gwf_bb_code">';
			$pre .= sprintf('<div>%s%s</div>', $geshi_a, $head);
			$after = '</div>';
			return $pre.$geshi->parse_code().$after;
		}
	}	

	############
	### Tags ###
	############
	public function render_b($htmlspecial, $nl2br, $raw)
	{
		return '<strong>'.$this->renderChilds($htmlspecial, $nl2br, $raw).'</strong>';
	}

	public function render_u($htmlspecial, $nl2br, $raw)
	{
		return '<ins>'.$this->renderChilds($htmlspecial, $nl2br, $raw).'</ins>';
	}

	public function render_s($htmlspecial, $nl2br, $raw)
	{
		return '<del>'.$this->renderChilds($htmlspecial, $nl2br, $raw).'</del>';
	}

	public function render_i($htmlspecial, $nl2br, $raw)
	{
		return '<em>'.$this->renderChilds($htmlspecial, $nl2br, $raw).'</em>';
	}

	public function render_ul($htmlspecial, $nl2br, $raw)
	{
		return '<ul>'.$this->renderChilds($htmlspecial, $nl2br, $raw).'</ul>';
	}

	public function render_ol($htmlspecial, $nl2br, $raw)
	{
		return '<ol>'.$this->renderChilds($htmlspecial, $nl2br, $raw).'</ol>';
	}

	public function render_li($htmlspecial, $nl2br, $raw)
	{
		return '<li>'.$this->renderChilds($htmlspecial, $nl2br, $raw).'</li>';
	}

	public function render_colour($htmlspecial, $nl2br, $raw)
	{
		if (isset($this->params['colour']))
		{
			$this->params['color'] = $this->params['colour'];
		}
		return $this->render_color($htmlspecial, $nl2br, $raw);
	}

	public function render_color($htmlspecial, $nl2br, $raw)
	{
		if (!empty($this->params['color']))
		{
			$color = $this->params['color'];
			if ( (preg_match('/^[a-f0-9]{3}$/iD', $color)) || (preg_match('/^[a-f0-9]{6}$/iD', $color)) )
			{
				$the_color = $color;
			}
		}

		$text = $this->renderChilds($htmlspecial, $nl2br, $raw);

		if (isset($the_color))
		{
			return sprintf('<span style="color: #%s;">%s</span>', $the_color, $text);
		}
		else
		{
			return $text;
		}
	}

	public function render_size($htmlspecial, $nl2br, $raw)
	{
		if (!empty($this->params['size']))
		{
			$size = (int)$this->params['size'];
			if ($size >= 8 && $size <= 32)
			{
				$the_size = $size;
			}
		}

		$text = $this->renderChilds($htmlspecial, $nl2br, $raw);

		if (isset($the_size))
		{
			return sprintf('<span style="font-size: %spx;">%s</span>', $the_size, $text);
		}
		else
		{
			return $text;
		}
	}


	public function render_level($htmlspecial, $nl2br, $raw) { return $this->render_score($htmlspecial, $nl2br, $raw); }
	public function render_score($htmlspecial, $nl2br, $raw)
	{
		$score = isset($this->params['score']) ? intval($this->params['score']) : 1;
		if (GWF_User::getStaticOrGuest()->getLevel() <= $score)
		{
			return GWF_HTML::lang('err_bb_level', array($score));
		}
		else
		{
			return $this->renderChilds($htmlspecial, $nl2br, $raw);
		}
	}

	public function render_url($htmlspecial, $nl2br, $raw)
	{
		if (isset($this->params['url']) && !empty($this->params['url']))
		{
			$href = $this->params['url'];
			$text = $this->renderChilds($htmlspecial, $nl2br, $raw);
		}
		else
		{
			$href = $text = $this->renderChilds(false, false, false);
			$text = htmlspecialchars($text);
		}

		if (false === ($the_href = $this->filterHREF($href)))
		{
			$text = htmlspecialchars($href);
			$the_href = '#error';
		}

		$text = $this->filterURLText($text);
		
		return sprintf('<a href="%s">%s</a>', $the_href, $text);
	}

	public function render_php($htmlspecial, $nl2br, $raw)
	{
		return $this->renderCode('PHP', $htmlspecial, $nl2br, $raw);
	}

	public function render_code($htmlspecial, $nl2br, $raw)
	{
		if (isset($this->params['code']))
		{
			$lang = $this->params['code'];
		}
		elseif (isset($this->params['lang']))
		{
			$lang = $this->params['lang'];
		}
		else
		{
			$lang = 'Plaintext';
		}
		return $this->renderCode($lang, $htmlspecial, $nl2br, $raw);
	}

	public function render_quote($htmlspecial, $nl2br, $raw)
	{
		# Display the date of the original message.
		if (isset($this->params['date']))
		{
			$date = GWF_Time::displayDate($this->params['date']);
		}
		else
		{
			$date = '';
		}

		# Show from whom is the quote.
		$username = '';
		if (isset($this->params['quote']))
		{
			$username = $this->params['quote'];
		}
		elseif (isset($this->params['from']))
		{
			$username = $this->params['from'];
		}
		$username = htmlspecialchars($username);

		$pre = '<blockquote class="gwf_bb_quote">';
		if ($date !== '' || $username !== '')
		{
			$top = '';
			if ($username !== '')
			{
				$top .= sprintf('<span>%s</span>', GWF_HTML::lang('quote_from', array($username)));
			}
			if ($date !== '')
			{
				$top .= sprintf('<div class="gwf_date">%s</div>', $date);
			}
			if ($top !== '')
			{
				$pre .= '<div class="gwf_bb_quote_top">';
				$pre .= $top;
				$pre .= '</div>';
			}
		}

		$after = '</blockquote>';

		return $pre.$this->renderChilds($htmlspecial, $nl2br, $raw).$after;
	}

	public function render_spoiler($htmlspecial, $nl2br, $raw)
	{
		# No Javascript:
		if (isset($_GET['show_spoilers']))
		{
			return $this->renderChilds($htmlspecial, $nl2br, $raw);
		}

		# Javascript:
		static $spoil_id = 0; $spoil_id++;
		$id = 'gwf_bb_spoiler_'.$spoil_id;
		$link_txt = GWF_HTML::lang('bbspoiler_info');
		if (isset($_SERVER['REDIRECT_QUERY_STRING']))
		{
			$href_no_js = $_SERVER['REDIRECT_QUERY_STRING'];
		}
		elseif (isset($_SERVER['QUERY_STRING']))
		{
			$href_no_js = $_SERVER['QUERY_STRING'];
		}
		else
		{
			return $this->renderChilds($htmlspecial, $nl2br, $raw);
		}

		$href_no_js = htmlspecialchars(GWF_WEB_ROOT.'index.php?'.$href_no_js.'&show_spoilers=please');

		return
			'<nav><a href="'.$href_no_js.'" onclick="toggleHidden(\''.$id.'\'); return false;">'.$link_txt.'</a></nav>'.PHP_EOL.
			'<section class="gwf_bb_spoiler" id="'.$id.'">'.$this->renderChilds().'</section>'.PHP_EOL;
	}

	public function render_noparse($htmlspecial, $nl2br, $raw)
	{
		return $this->renderChilds(true, true, true);
	}

	public function render_youtube($htmlspecial, $nl2br, $raw)
	{
		$the_id = isset($this->params['youtube']) ? $this->params['youtube'] : $this->text;
		if (!preg_match('/^[-a-z0-9]{11,12}$/iD', $the_id))
		{
			return GWF_HTML::lang('err_youtube_id');
		}

		$title = isset($this->params['title']) ? $this->params['title'] : GWF_HTML::lang('youtube_title');

		return sprintf('<iframe title="%s" class="gwf_bb_youtube" type="text/html" width="640" height="390" src="http://www.youtube.com/embed/%s" frameborder="0" allowFullScreen="allowFullScreen"></iframe>', htmlspecialchars($title), $the_id);
	}

/*
	public function render_img($htmlspecial, $nl2br, $raw)
	{
		$href = $this->text;
		if ( (false === ($href = $this->filterHREF($href))) || (false !== strpos($href, '&')) )
		{
			return GWF_HTML::lang('err_bb_img');
		}

		$title = isset($this->params['title']) ? $this->params['title'] : GWF_HTML::lang('an_img');
		$width = isset($this->params['width']) ? (int)$this->params['width'] : NULL;
		$height = isset($this->params['height']) ? (int)$this->params['height'] : NULL;
		$w = $h = '';

		if ( ($width !== NULL) && ($width > 15) && ($width < 640) )
		{
			$w = " width=\"{$width}\"";
		}

		if ( ($height !== NULL) && ($height > 15) && ($height < 480) )
		{
			$h = " height=\"{$height}\"";
		}

		$title = htmlspecialchars($title);
		$alt = $title;

		return sprintf('<img class="gwf_bb_img" alt="%s" title="%s"%s%s src="%s" />', $alt, $title, $w, $h, $href);
	}
*/
}

