/** SCORE VOTE **/
function gwfVoteScore(voteid, score)
{
	var url = GWF_WEB_ROOT+"index.php?mo=Votes&ajax=true&me=Vote&vsid="+voteid+"&score="+score+'&t='+new Date().getTime();
	var response = ajaxSync(url);
	if (gwfIsSuccess(response))
	{
//		gwfVoteScoreUpdateC(voteid, response);
		gwfVoteScoreUpdate(voteid);
	}		
	else
	{
//		alert(response);
		gwfDisplayMessage(response);
	}
}

function gwfVoteScoreUpdate(voteid)
{
	var url = GWF_WEB_ROOT+"index.php?mo=Votes&ajax=true&me=Ajax&vsid="+voteid+'&t='+new Date().getTime();
	var response = ajaxSync(url);
	if (gwfIsSuccess(response))
	{
		gwfVoteScoreUpdateB(voteid, response);
	}
	else
	{
		gwfDisplayMessage(response);
	}
}

function gwfVoteScoreUpdateB(voteid, response)
{
	var data = response.split(':');
	
	var cnt = data[1];
	var avg = data[2];
	var sum = data[3];
	var min = data[4];
	var max = data[5];
	
	var eid = 'gwf_vsbc_'+voteid;
	var e = document.getElementById(eid);
	if (e !== null) {
		e.innerHTML = cnt;
	}
	eid = 'gwf_vsba_'+voteid;
	e = document.getElementById(eid);
	if (e !== null) {
		e.innerHTML = sprintf('%.2f%%', (avg-min) / (max-min) * 100);
	}
	eid = 'gwf_vsbs_'+voteid;
	e = document.getElementById(eid);
	if (e !== null) {
		e.innerHTML = sum;
	}
}

function gwfVoteScoreUpdateC(voteid, response)
{
	var eid = 'gwf_vsb_'+voteid;
	var e = document.getElementById(eid);
	if (e !== null) {
		e.innerHTML = response;
	}
}

/** POLL VOTE **/
function gwfVoteMulti(id)
{
	var url = GWF_WEB_ROOT+"index.php?mo=Votes&ajax=true&me=VotePoll&vmid="+id+"&choice="+choices;
}
