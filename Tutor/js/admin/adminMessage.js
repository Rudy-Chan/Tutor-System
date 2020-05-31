mui.ready(function(){
	var btn_release=document.getElementById("release")
	var noticeTitle=document.getElementById("noticeTitle");
	var noticeBody=document.getElementById("noticeBody");
	var token=localStorage.getItem("token");

	
	btn_release.addEventListener("click",function(){
		var title=noticeTitle.value.trim();
		var content=noticeBody.value.trim();
		if(title=="" || content==""){
			mui.toast("请填写完整的信息");
			return;
		}
		mui.ajax('http://localhost/admin.php',{
			data:{
				action:'addNotice',
				title:title,
				content:content,
				token:token
			},
			dataType:'json',//服务器返回json格式数据
			type:'post',//HTTP请求类型
			timeout:10000,//超时时间设置为10秒；
			success:function(data){
				if(data.error==0){
					mui.toast(data.msg);
					noticeTitle.value="";
					noticeBody.value="";
				}
				else{
					mui.toast(data.msg);
				}		    
			},
			error:function(xhr,type,errorThrown){
				//异常处理
				mui.openWindow({
					url: '../main/error.html',
					id:'error.html',
				});
			}
		});
	});
	
	
})