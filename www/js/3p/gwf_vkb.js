var cmvkb_activeTF;
var cmvkb_form;
var cmvkb_IDs = new Array();

function cmvkb_setTF(textfield)
{
	cmvkb_activeTF = textfield;
}

function cmvkb_addID(id)
{
	var len = cmvkb_IDs.length;
	cmvkb_IDs[len] = id;
}

function cmvkb_nextID()
{
	var curr = cmvkb_activeTF.id;
	var len = cmvkb_IDs.length;
	for (var i =0; i < len; i++)
	{
		if (cmvkb_IDs[i] == curr) {
			break;
		}
	}

	if (i == len) {
		return false;
	} else if (i == len-1) {
		cmvkb_form.submit();
		return true;
	}
	cmvkb_activeTF = document.getElementById(cmvkb_IDs[i+1]);
	cmvkb_activeTF.focus();
	return true;
}

function cmvkb_toggleLock(id, img)
{
	var tf = document.getElementById(id);

	var newtype = '';
	var imgsrc = '';
	switch (tf.type)
	{
	case 'password':
		newtype = 'text';
		imgsrc = '/templates/gg/icons/lock_unlock.png';
		break;
	case 'text':
		newtype = 'password';
		imgsrc = '/templates/gg/icons/lock.png';
		break;
	default: return false; 
	}

	tf.type = newtype;
	img.src = imgsrc;
	return true;
}


function cmvkb_callback(ch)
{
	var text = cmvkb_activeTF, val = text.value;

	switch(ch)
	{
		case "BackSpace":
			var min = (val.charCodeAt(val.length - 1) == 10) ? 2 : 1;
			text.value = val.substr(0, val.length - min);
			break;
		case "Enter":
			//text.value += "\n";
			cmvkb_nextID();
			break;
		default:
			text.value += ch;
	}
}
