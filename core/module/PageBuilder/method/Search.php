<?php
/**
 * Search all created and published PB pages.
 * @author gizmore
 */
final class PageBuilder_Search extends GWF_Method
{
	public function getHTAccess()
	{
		return
			'RewriteRule ^pages-with-([^\\-]+)-by-([^\\-]*)-([DEASC,]*)-page-(\d+).html/$ index.php?mo=PageBuilder&me=Search&term=$1&by=$2&dir=$3&page=$4'.PHP_EOL.
			'';
	}
	
	public function execute()
	{
		$form = $this->formQuicksearch();
		
		# I like typehinting :S
		$module = $this->module;
		$module instanceof Module_PageBuilder;
		
		$user = GWF_User::getStaticOrGuest();
		$ulid = GWF_Language::getCurrentID();
		
		$table = GDO::table('GWF_Page');
		$joins = NULL;
		$tablename = $table->getTableName();
		
		# Build where clause
		$term = '';
		$where = '1';
		$language = '';
		$languaged = '1';
		if (isset($_GET['quicksearch']))
		{
			# Termwhere
			if ('' !== ($term = Common::getGetString('term', '')))
			{
				$fields = array('page_author_name', 'page_title', 'page_content');
				if (false === ($where = GWF_QuickSearch::getQuickSearchConditions($table, $fields, $term)))
				{
					$where = '1';
				}
			}
			# Langwhere
			if (0 !== ($language = Common::getGetInt('lang', 0)))
			{
				if (GWF_LangSelect::isValidLanguage($language, false, GWF_Language::SUPPORTED))
				{
					$languaged = "(SELECT 1 FROM `$tablename` lt WHERE lt.page_otherid=t.page_otherid AND lt.page_lang={$language})";
				}
			}
		}
		$published = 'page_options&'.(GWF_Page::ENABLED|GWF_Page::LOCKED).'='.GWF_Page::ENABLED; 
		$permquery = '1'; # TODO: Check group permissions! 
		$where = "({$permquery}) AND ({$where}) AND ({$published}) AND ({$languaged})";

		# Setup pagemenu
		$ipp = 25;
		$nItems = $table->selectVar('COUNT(DISTINCT(page_otherid))', $where, '', $joins);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('page', 1), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		# Setup order
		$by = Common::getGetString('by', 'page_id');
		$dir = Common::getGetString('dir', 'ASC');
		$orderby = $table->getMultiOrderby($by, $dir);

		# Now query only page_otherids
		if (false === ($pageids = $table->selectColumn('DISTINCT(page_otherid)', $where, $orderby, $joins, $ipp, $from)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		# Setup page array		
		$pages = array();
		$languages = GWF_Language::getSupported();
		foreach ($pageids as $otherid)
		{
			$pagedata = $table->selectAll('page_id, page_lang, page_author_name, page_create_date, page_date, page_url, page_title', "page_otherid={$otherid}", "page_id={$otherid}");
			$title = '';
			$_langs = array();
			foreach ($pagedata as $data)
			{
				$pagelang = $data['page_lang'];
// 				echo "$pagelang<br/>";
				
				# English 2nd choice
				if ( ($pagelang === '1') && ($title === '') )
				{
					$title = $data['page_title'];
				}
				# Userlang 1st choice
				elseif ($data['page_lang'] === $ulid)
				{
					$title = $data['page_title'];
				}

				# Store for next loop
				$_langs[$pagelang] = array($data['page_url']/*,...*/);
			}
			
			# Build output flags
			$langstring = '';
			foreach ($languages as $language)
			{
				$language instanceof GWF_Language;
				$lid = $language->getID();
				if (isset($_langs[$lid]))
// 				if (in_array($lid, $lids, true))
				{
					$langstring .= sprintf('<a href="%s%s">%s</a>', GWF_WEB_ROOT, $_langs[$lid][0], $language->displayFlag(), $lid);
				}
				else
				{
					$langstring .= sprintf('<a href="%sindex.php?mo=PageBuilder&me=Translate&pageid=%s&to_lang_id=%s">%s</a>', GWF_WEB_ROOT, $otherid, $lid, GWF_Language::displayUnknownFlag($module->lang('translate_to', array($language->displayName()))));
				}
			}
			
			# Add as page row
			$pages[] = array(
				'page_id' => $pagedata[0]['page_id'],
				'page_otherid' => $otherid,
				'page_title' => $title,
				'page_url' => $pagedata[0]['page_url'],
				'languages' => $langstring,
				'page_date' => $pagedata[0]['page_date'],
				'page_create_date' => $pagedata[0]['page_create_date'],
				'page_author_name' => $pagedata[0]['page_author_name'],
			);
		}
		
		# Display
		$tVars = array(
			'quicksearch' => $form->templateX($this->module->lang('ft_search'), GWF_WEB_ROOT.'index.php'),
			'pages' => $pages,
			'languages' => $languages,
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'index.php?mo=Lamb&me=Links&term='.urlencode($term).'&by='.urlencode($by).'&dir='.urlencode($dir).'&page=%PAGE%'),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Lamb&me=Links&language='.$language.'&term='.urlencode($term).'&by=%BY%&dir=%DIR%&page='.$page,
		);

		return $module->template('search.tpl', $tVars);
	}
	
	private function formQuicksearch()
	{
		$data = array(
			'mo' => array(GWF_Form::HIDDEN, 'PageBuilder'),
			'me' => array(GWF_Form::HIDDEN, 'Search'),
			'lang' => array(GWF_Form::SELECT, GWF_LangSelect::single(GWF_Language::SUPPORTED, 'lang', Common::getGetInt('lang', 0))),
			'term' => array(GWF_Form::STRING_NO_CHECK, '', $this->module->lang('th_term')),
			'quicksearch' => array(GWF_Form::SUBMIT, $this->module->lang('btn_search')),
		);
		return new GWF_Form($this, $data, GWF_Form::METHOD_GET);
	}
}
?>