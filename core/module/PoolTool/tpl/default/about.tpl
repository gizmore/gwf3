<h1>{$lang->lang('pt_about')}</h1>
<p>{$lang->lang('about')}</p>
<h2>{$lang->lang('faq_info')}</h2>
<div>
{for $i=1 to 7}
	<p class="ptfaqq">{$lang->lang('faqq_'.$i)}</p>
	<p class="ptfaqa">{$lang->lang('faqa_'.$i)}</p>
{/for}
</div>
