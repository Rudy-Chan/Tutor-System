mui.ready(function() {
	mui.ajax('http://localhost/agreement.php',{
		dataType:'html',//服务器返回html格式数据
		type:'post',//HTTP请求类型
		timeout:10000,//超时时间设置为10秒；
		success:function(data){
			var div=document.createElement("div");
			div.innerHTML=data;
			content.appendChild(div);
				    
		},
		error:function(xhr,type,errorThrown){
			//异常处理
			var div=document.createElement("div");
			div.innerHTML="连接服务器出错，请稍后重试";
			content.appendChild(div);
		}
	});
})