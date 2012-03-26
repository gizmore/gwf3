function gwfPMToggleAll(value)
{
	var form = document.getElementById('gwf_pm_form');
	if (form === null)
	{
		return;
	}
	for (i = 0; i < form.length; i++)
	{
		if (form[i].name.substr(0, 2) == 'pm')
		{
			form[i].checked = value;
		}
	}
	return true;
	
}

function gwfPMGoogleTrans()
{
	var id ='';
	gwfGoogleTrans(id);
}