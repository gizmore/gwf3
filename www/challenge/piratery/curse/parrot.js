/* Piratery curse: the scream of the parrot, random YAAAR alerts */
(function() {
	var cries = ['YAAAR!', 'YAAAAAAAR!', 'Yo ho ho... YAAAR!', 'Arrr... YAAAR!', 'YAAAR, landlubber!'];
	(function cry() {
		setTimeout(function() { alert(cries[Math.floor(Math.random() * cries.length)]); cry(); }, 2000 + Math.random() * 6000);
	})();
})();
