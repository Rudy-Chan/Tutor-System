mui.ready(function() {
	var btn_sure = document.getElementById("btn_sure");
	var input_old = document.getElementById("old");
	var input_new = document.getElementById("new");
	
	btn_sure.addEventListener("click",function(){
		var oldPwd = input_old.value.trim();
		var newPwd = input_new.value.trim();
		//验证密码格式
		if(oldPwd=="" || newPwd==""){
			mui.toast("密码输入不能为空");
			return;
		}
		if(oldPwd.length<6 || oldPwd.length>16){
			mui.toast("密码复杂度不合要求");
			return;
		}
		if(oldPwd != newPwd){
			mui.toast("请检查输入的密码是否一致");
			return;
		}
		
		
		var token=localStorage.getItem("token");
		
		mui.ajax('http://localhost/account.php',{
			data:{
				action:'setPwd',
				newPwd:newPwd,
				token:token
			},
			dataType:'json',//服务器返回json格式数据
			type:'post',//HTTP请求类型
			timeout:10000,//超时时间设置为10秒；
			success:function(data){
				if(data.error==0){
					//获取键的值
					input_old.value=input_new.value="";
					mui.toast(data.msg);
				}
				else{
					mui.toast(data.msg);
				}		    
			},
			error:function(xhr,type,errorThrown){
				mui.toast("验证超时，请重试");
			}
		});
		
	});
})