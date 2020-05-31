mui.ready(function() {
	document.getElementById("home").addEventListener("click",function(){
		mui.openWindow({
			url: 'home.html',
			id:'home.html',
		});
	});
	document.getElementById("unit").addEventListener("click",function(){
		mui.openWindow({
			url: 'unit.html',
			id:'unit.html',
		});
	});
	document.getElementById("message").addEventListener("click",function(){
		mui.openWindow({
			url: 'message.html',
			id:'message.html',
		});
	});
	document.getElementById("setting").addEventListener("click",function(){
		mui.openWindow({
			url: 'setting.html',
			id:'setting.html',
		});
	});
})
