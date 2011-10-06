/**
 * Javascript includes
 * @author gizmore
 */
function Includer()
{
	this.once = new Array();
	this.include_once = function(url) { return in_array(url, this.once) ? true : this.include(url); };
	this.include = function(url)
	{
		var result = ajaxSync(url);
		if (result === false) return false;
		try { eval(result); } catch (e) { alert(e); return false; }
		this.once.push(url);
		return true;
	};
	
	this.require_once = function(url) { return in_array(url, this.once) ? true : this.require(url); };
	this.require = function(url)
	{
		var result = ajaxSync(url);
		if (result === false)
		{
			throw "Includer.require: no such file: "+url;
			return false;
		}
		try
		{
			eval(result);
		}
		catch (e)
		{
			throw "Includer.require: errorneus javascript in: "+url;
			return false;
		}
		this.once.push(url);
		return true;
	};
}
