function helpdeskInit()
{
	$('.gwf_faq_a').hide();
}

function helpdeskClick(id)
{
	var item = $('#gwf_faq_a_'+id);
	if (item.is(':visible'))
	{
		item.hide();
	}
	else
	{
		item.show();
	}
}