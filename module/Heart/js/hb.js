function gwf_heartbeat(ms)
{
	var url = GWF_WEB_ROOT+'index.php?mo=Heart&me=Beat&time='+new Date().getTime();
	setTimeout('gwf_heartbeat('+ms+');', ms);
	ajaxUpdate('gwf_heartbeat', url);
}
