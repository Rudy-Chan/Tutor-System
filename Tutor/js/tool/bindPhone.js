mui.ready(function() {
	document.getElementById("phoneNum").textContent=localStorage.getItem("phone");
	var btn_modify = document.getElementById("btn_modify");
	var input_phone = document.getElementById("input_phone");
	
	btn_modify.addEventListener("click",function(){
		var phone = input_phone.value.trim();
		//验证手机格式
		if(phone==""){
			mui.toast("手机号输入不能为空");
			return;
		}
		if(phone.length!=11){
			mui.toast("请检查输入格式是否正确");
			return;
		}
		
		var token=localStorage.getItem("token");
		mui.ajax('http://localhost/account.php',{
			data:{
				action:'setPhone',
				phone:phone,
				token:token
			},
			dataType:'json',//服务器返回json格式数据
			type:'post',//HTTP请求类型
			timeout:10000,//超时时间设置为10秒；
			success:function(data){
				if(data.error==0){
					//获取键的值
					document.getElementById("phoneNum").textContent=phone;
					localStorage.setItem("phone",phone);
					input_phone.value="";
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