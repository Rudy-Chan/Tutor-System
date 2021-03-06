mui.ready(function() {
	var btn_login = document.getElementById("btn_login");
	var input_email = document.getElementById("input_email");
	var input_pwd=document.getElementById("input_pwd");
	
	btn_login.addEventListener("click",function(){
		var email=input_email.value.trim();
		var password=input_pwd.value.trim();
		
		//验证邮箱格式
		if(email==""){
			mui.toast("邮箱地址不能为空");
			return;
		}
		if(!checkEmail(email)){
			mui.toast("请检查邮箱地址");
			return;
		}
		if(password==""){
			mui.toast("密码不能为空");
			return;
		}

		mui.ajax('http://localhost/account.php',{
			data:{
				action:'loginByPwd',
				email:email,
				password:password
			},
			dataType:'json',//服务器返回json格式数据
			type:'post',//HTTP请求类型
			timeout:10000,//超时时间设置为10秒；
			success:function(data){
				if(data.error==0){
					localStorage.clear(); //清除localstorage
					//获取键的值
					localStorage.setItem("userId", data.userId);
					localStorage.setItem("token", data.token);
					localStorage.setItem("nickName", data.nickName);
					localStorage.setItem("phone", data.phone);
					localStorage.setItem("privilege", data.privilege);
					if(data.privilege==0){
						mui.openWindow({
							url: '../main/home.html',
							id:'../main/home.html',
						});
					}
					else if(data.privilege==1){
						mui.openWindow({
							url: '../admin/adminHome.html',
							id:'../admin/adminHome.html',
						});
					}
					else{
						mui.openWindow({
							url: '../unit/unitHome.html',
							id:'../unit/unitHome.html',
						});
					}
				}
				else{
					mui.toast(data.msg);
				}		    
			},
			error:function(xhr,type,errorThrown){
				//异常处理
				mui.toast("验证超时，请重试");
			/*
			var s = JSON.parse(xhr['response']);
			mui.toast(s['message']);
			*/
			}
		});
	});
})

//检查邮箱格式
function checkEmail(formatEmail){
　　var myReg=/^[a-zA-Z0-9_-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/;
 
　　if(myReg.test(formatEmail)){
　　　　return true;
　　}else{
　　　　return false;
	}
}