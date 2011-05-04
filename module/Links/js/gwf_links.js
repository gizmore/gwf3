function gwfLinksRedirect(link_id)
{
	var url = GWF_WEB_ROOT+'index.php?mo=Links&ajax=true&me=Redirect&lid='+link_id;
	
	var response = ajaxSync(url);
	
//	alert(response);
	
	return true;
} 
