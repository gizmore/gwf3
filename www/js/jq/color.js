/**
 * Color interpolation.
 * @author gizmore
 * TODO: Optimize for speed.
 */
function Color()
{
};
Color.dec2hex = function(n)
{
	n = parseInt(n);
    var c = 'ABCDEF', b = n / 16, r = n % 16;
    b = b-(r/16); b = ((b>=0) && (b<=9)) ? b : c.charAt(b-10);    
    return ((r>=0) && (r<=9)) ? b+''+r : b+''+c.charAt(r-10);
};
Color.interpolate = function(hex1, hex2, fraction)
{
	var c1 = new Array(
		parseInt(hex1.substr(1, 2), 16),
		parseInt(hex1.substr(3, 2), 16),
		parseInt(hex1.substr(5, 2), 16)
	);
	var c2 = new Array(
		parseInt(hex2.substr(1, 2), 16),
		parseInt(hex2.substr(3, 2), 16),
		parseInt(hex2.substr(5, 2), 16)
	);
	var c3 = new Array(
		this._interpolate(c1[0], c2[0], fraction),
		this._interpolate(c1[1], c2[1], fraction),
		this._interpolate(c1[2], c2[2], fraction)
	);
	return '#'+this.dec2hex(c3[0])+this.dec2hex(c3[1])+this.dec2hex(c3[2]);
};
Color._interpolate = function(c1, c2, fraction)
{
	return ((c2-c1)*fraction)+c1;
};
