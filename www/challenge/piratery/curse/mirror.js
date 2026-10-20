/* Piratery curse: the mirror of the deep, a <-> z, b <-> y, ... and 0 <-> 9, 1 <-> 8, ... */
(function() {
	var input = document.querySelector('#wc_solutionbox input[name="answer"]');
	if (!input) { return; }
	var abc = 'abcdefghijklmnopqrstuvwxyz', digits = '0123456789';
	function mirror(c) {
		var l = c.toLowerCase(), i = abc.indexOf(l);
		if (i >= 0) { var m = abc.charAt(25 - i); return c === l ? m : m.toUpperCase(); }
		i = digits.indexOf(c);
		return i >= 0 ? digits.charAt(9 - i) : c;
	}
	input.addEventListener('beforeinput', function(e) {
		if (e.inputType !== 'insertText' || !e.data) { return; }
		e.preventDefault();
		input.setRangeText(e.data.split('').map(mirror).join(''), input.selectionStart, input.selectionEnd, 'end');
	});
})();
