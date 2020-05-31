mui.ready(function() {
	document.getElementById("home").addEventListener("click",function(){
		mui.openWindow({
			url: 'adminHome.html',
			id:'home.html',
		});
	});
	document.getElementById("unit").addEventListener("click",function(){
		mui.openWindow({
			url: 'adminUnit.html',
			id:'unit.html',
		});
	});
	document.getElementById("message").addEventListener("click",function(){
		mui.openWindow({
			url: 'adminMessage.html',
			id:'message.html',
		});
	});
	document.getElementById("setting").addEventListener("click",function(){
		mui.openWindow({
			url: 'adminSetting.html',
			id:'setting.html',
		});
	});
})