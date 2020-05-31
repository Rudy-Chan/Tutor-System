mui.ready(function() {
	var input_verifyCode = document.getElementById("input_verifyCode");
	var token=localStorage.getItem('token');
	
	btn_sure.addEventListener("click",function(){
		var code=input_verifyCode.value.trim();
		//验证码是否为空
		if(code==""){
			mui.toast("请输入验证码");
			return;
		}
	
		mui.ajax('http://localhost/account.php',{
			data:{
				action:'verify',
				verifyCode:code,
				token:token
			},
			dataType:'json',//服务器返回json格式数据
			type:'post',//HTTP请求类型
			timeout:10000,//超时时间设置为10秒；
			success:function(data){
				if(data.error==0){
					
					mui.openWindow({
						url: '../login/setPwd.html',
						id:'../login/setPwd.html',
					});
					
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
	});
})