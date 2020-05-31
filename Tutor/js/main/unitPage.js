mui.ready(function() {
	document.getElementById("home").addEventListener("click",function(){
		mui.openWindow({
			url: 'unitHome.html',
			id:'home.html',
		});
	});
	document.getElementById("activity").addEventListener("click",function(){
		mui.openWindow({
			url: 'unitActivity.html',
			id:'unit.html',
		});
	});
	document.getElementById("message").addEventListener("click",function(){
		mui.openWindow({
			url: 'unitMessage.html',
			id:'message.html',
		});
	});
	document.getElementById("setting").addEventListener("click",function(){
		mui.openWindow({
			url: 'unitSetting.html',
			id:'setting.html',
		});
	});
})
