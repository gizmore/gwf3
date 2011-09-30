function Color()
{
	this.dec2hex = function(n)
	{
//	    n = parseInt(n);
	    var c = 'ABCDEF', b = n / 16, r = n % 16;
	    b = b-(r/16); b = ((b>=0) && (b<=9)) ? b : c.charAt(b-10);    
	    return ((r>=0) && (r<=9)) ? b+''+r : b+''+c.charAt(r-10);
	}
	
	this.Interpolate = function(hex1, hex2, fraction)
	{
		var c1 = new Array(
			hex2dec(hex1.substr(1, 2)),
			hex2dec(hex1.substr(3, 2)),
			hex2dec(hex1.substr(5, 2))
		);
		var c2 = new Array(
			hex2dec(hex2.substr(1, 2)),
			hex2dec(hex2.substr(3, 2)),
			hex2dec(hex2.substr(5, 2))
		);
		var c3 = new Array(
			_interpolate(c1[0], c2[0], fraction),
			_interpolate(c1[1], c2[1], fraction),
			_interpolate(c1[2], c2[2], fraction)
		);
		
		return '#'+c1[0].toString(16)
		
		return hex1;
	};
}