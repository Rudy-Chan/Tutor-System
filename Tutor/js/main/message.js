mui.ready(function(){
	var notify=document.getElementById("notify");
	var sys=document.getElementById("system");
	
	notify.addEventListener("click",function(){
		mui.openWindow({
			url: '../main/msgList.html',
			id: 'msgList.html',
		});
	});
	system.addEventListener("click",function(){
		mui.openWindow({
			url: '../main/noticeList.html',
			id: 'noticeList.html',
		});
	});
	
})