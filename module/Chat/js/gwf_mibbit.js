/** Mibbit fullscreen **/
function gwfMibbitInit()
{
	var footer = document.getElementById('gwf_footer');
	if (footer === null) {
//		alert('Can not find element gwf_footer.');
		return;
	}
	
	var mibbit = document.getElementById('gwf_mibbit');
	if (mibbit === null) {
		alert('Can not find element gwf_mibbit.');
		return;
	}

	var mib_y = getDivPosY(mibbit);
	var foo_y = getDivPosY(footer);
	
	var h = document.height;
	
	if (foo_y > h) {
		foo_y = h;
	}

	mibbit.height = foo_y - mib_y - 48;
}
