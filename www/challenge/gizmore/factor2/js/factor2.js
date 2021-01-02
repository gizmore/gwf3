"use strict";
/**
 * (c)2019 Failsoft
 */
window.gurroga = {};

window.gurroga.api = {
	login: '../backend/api/login.php',
	auth: '../backend/api/authenticate.php',
}

window.gurroga.USER = null;
window.gurroga.ARTICLES = null;

window.gurroga.init = function() {
	console.log('init()');
	window.jsGrid.locale("de");
};

window.gurroga.showMessage = function(message) {
	console.log('showMessage()', message);
	$('#successmessage').html(message);
	$('#successpopup').popup();
	$('#successpopup').popup("open");
};

window.gurroga.showError = function(errorMessage) {
	console.log('showError()', errorMessage);
	$('#errormessage').text(errorMessage);
	$('#errorpopup').popup();
	$('#errorpopup').popup("open");
};

window.gurroga.goto = function(page) {
	console.log('goto()', page);
	$.mobile.changePage(page);
};

window.gurroga.disable = function(selector) {
	var input = $(selector);
	input.prop('disabled', true)
	input.parent().addClass("ui-state-disabled");
};

window.gurroga.enable = function(selector) {
	var input = $(selector);
	input.prop('disabled', false)
	input.parent().removeClass("ui-state-disabled");
};

window.gurroga.login = function() {
	console.log('login()');
	if (window.gurroga.USER) {
		window.gurroga.authenticate();
	}
	else {
		var username = $('#username').val();
		var password = $('#password').val();
		var postData = {username: username, password: password};
		$.post(window.gurroga.api.login, postData)
		.done(function(result){
			console.log(result);
			window.gurroga.USER = result.user;
			window.gurroga.ARTICLES = result.artikel;
			$('.username').text(result.user.vorname + ' ' + result.user.nachname);
			window.gurroga.disable('#username');
			window.gurroga.disable('#password');
			window.gurroga.enable('#authtoken');
			window.gurroga.buildArticles(result.artikel);
		})
		.fail(function(result){
			console.error(result);
			window.gurroga.showError(result.responseJSON.message);
		});
	}
};

window.gurroga.logout = function() {
	console.log('logout()');
	window.gurroga.USER = null;
	window.gurroga.ARTICLES = null;
}

window.gurroga.authenticate = function() {
	console.log('authenticate()');
	var token = $('#authtoken').val();
	var postData = {user: window.gurroga.USER.id, token: token};
	$.post(window.gurroga.api.auth, postData)
	.done(function(result){
		console.log(result);
		window.gurroga.goto('#welcome');
	})
	.fail(function(result){
		console.error(result);
		window.gurroga.showError(result.responseJSON.message);
	});
};

window.gurroga.buildArticles = function(artikel) {
	console.log('buildArticles()', artikel);
	$('#bestellartikel').empty();
	for (var a in artikel) {
		var b = artikel[a];
		$('#bestellartikel').append($('<option />').text(b.title).val(b.id));
	}
};

$(window.document).on('pagechange', function(event, args) {
	var funcname = 'changeTo_'+args.toPage[0].id;
	console.log('pagechange()', funcname);
	var func = window.gurroga[funcname];
	if (func) {
		func();
	}
});

window.gurroga.changeTo_login = function() {
	console.log('changeTo_login()');
	window.gurroga.enable('#username');
	window.gurroga.enable('#password');
	window.gurroga.disable('#authtoken');
};


window.gurroga.changeTo_historie = function() {
	console.log('changeTo_historie()');
	$('#historygrid').jsGrid({
		width: '100%',
		sorting: true,
		paging: false,
		autoload: true,
		controller: {
			loadData: function() {
				var d = $.Deferred();
				$.ajax({
					url: "../backend/api/bestellhistorie.php?user="+window.gurroga.USER.id,
					dataType: "json"
				}).done(function(response) {
					d.resolve(response.result);
				});
				return d.promise();
			}
		},
		fields: [
			{name: "article.title", type: "text", title: "Artikel"},
			{name: "article.amt", type: "text", title: "Stückzahl"},
			{name: "amt", type: "text", title: "Bestellmenge"},
			{name: "ordered_at", type: "text", title: "Bestelldatum"},
			{name: "delivered_at", type: "text", title: "Lieferdatum"},
		]
  	});
}

window.gurroga.order = function() {
	console.log('order()');
	var article = $('#bestellartikel').val();
	var amount = $('#bestellmenge').val();
	var postData = {user: window.gurroga.USER.id, id: article, amt: amount};
	$.post('../backend/api/bestellen.php', postData)
	.done(function(result){
		console.log(result);
		window.gurroga.showMessage(result);
	})
	.fail(function(result){
		console.error(result);
		window.gurroga.showError(result.responseText);
	});
};

