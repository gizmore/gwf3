/* Piratery curse: the slippery lock, the answer field runs away when you try to type in it */
(function() {
	var input = document.querySelector('#wc_solutionbox input[name="answer"]');
	if (!input) { return; }
	function flee() {
		var x = Math.round(Math.random() * 420 - 20), y = Math.round(Math.random() * 120 - 60); // Mostly to the right, it starts on the left edge
		input.style.transform = 'translate(' + x + 'px,' + y + 'px)';
	}
	input.addEventListener('mouseenter', flee);
	input.addEventListener('focus', flee);
	input.addEventListener('keydown', flee);
})();
