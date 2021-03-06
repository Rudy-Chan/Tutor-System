mui.ready(function() {
	document.getElementById("userName").textContent=localStorage.getItem("u_userName");
	document.getElementById("nickName").textContent="昵称:"+localStorage.getItem("u_nickName");
	document.getElementById("registerDate").textContent=localStorage.getItem("u_registerDate");
	document.getElementById("phone").textContent="联系电话："+localStorage.getItem("u_phone");
	document.getElementById("email").textContent="邮箱:"+localStorage.getItem("u_email");
	
	var userId=localStorage.getItem("u_userId");
	var token=localStorage.getItem("token");
	document.getElementById("reject").addEventListener('click',function(){
		mui.ajax('http://localhost/admin.php',{
			data:{
				action:'rejectUser',
				userId:userId,
				token:token,
			},
			dataType:'json',//服务器返回json格式数据
			type:'post',//HTTP请求类型
			timeout:10000,//超时时间设置为10秒；
			success:function(data){
				if(data.error==0){
					mui.toast(data.msg);
				}
				else{
					mui.toast(data.msg);
				}
			},
			error:function(xhr,type,errorThrown){
				//异常处理
				mui.toast("验证超时，请重试");
			}
		});
	})
	
	document.getElementById("pass").addEventListener('click',function(){
		mui.ajax('http://localhost/admin.php',{
			data:{
				action:'passUser',
				userId:userId,
				token:token,
			},
			dataType:'json',//服务器返回json格式数据
			type:'post',//HTTP请求类型
			timeout:10000,//超时时间设置为10秒；
			success:function(data){
				if(data.error==0){
					mui.toast(data.msg);
				}
				else{
					mui.toast(data.msg);
				}
			},
			error:function(xhr,type,errorThrown){
				//异常处理
				mui.toast("验证超时，请重试");
			}
		});
	})
})
