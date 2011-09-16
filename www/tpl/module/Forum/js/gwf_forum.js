/**
 * Update a forum post by google translate
 * @param postid
 */
function gwfForumTrans(postid)
{
	var eid = 'gwf_forum_post_'+postid;
	gwfGoogleTrans(eid);
	return false;
}


/**
 * Thank for a post.
 * @param postid
 */
function gwfForumThanks(postid)
{
	var url = GWF_WEB_ROOT+"index.php?mo=Forum&me=Thanks&ajax=true&pid="+postid;
	var response = ajaxSync(url);
	
	if (gwfIsSuccess(response))
	{
		gwfForumThanked(postid, response);
	}
	else
	{
		gwfDisplayMessage(response);
	}
}

function gwfForumThanked(postid, response)
{
	var id = 'gwf_post_thx_'+postid;
	var e = document.getElementById(id);
	if (e !== null) {
		e.innerHTML = response.substr(2);
	}
}

/**
 * @param postid int
 * @param up int 0 or 1
 */
function gwfForumVote(postid, up)
{
	if (up !== 0 && up !== 1) {
		alert('NoNoNo ;)');
	}
	var updown = up === 1 ? '&dir=up' : '&dir=down';
	var url = GWF_WEB_ROOT+"index.php?mo=Forum&me=Vote&ajax=true&pid="+postid+updown;
	var response = ajaxSync(url);
	
	if (gwfIsSuccess(response))
	{
		gwfForumVoted(postid, response);
	}
	else
	{
		gwfDisplayMessage(response);
	}
}

function gwfForumVoted(postid, response)
{
	var v = response.split(':');
	var e = document.getElementById('gwf_post_up_'+postid);
	if (e !== null) {
		e.innerHTML = v[1];
	}
	e = document.getElementById('gwf_post_down_'+postid);
	if (e !== null) {
		e.innerHTML = v[2];
	}
}

