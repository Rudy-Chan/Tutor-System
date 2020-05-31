mui.ready(function() {
	var btn_register = document.getElementById("btn_register");
	var input_user = document.getElementById("input_user");
	var input_password = document.getElementById("input_password");
	var input_phone = document.getElementById("input_phone");
	var input_email = document.getElementById("input_email");
	var input_file=document.getElementById("input_file");
	
	btn_register.addEventListener("click",function(){
		var name=input_user.value.trim();
		var password=input_password.value.trim();
		var phone=input_phone.value.trim();
		var email=input_email.value.trim();
		
		//验证格式
		if(name=="" || password=="" || phone=="" || email==""){
			mui.toast("注册信息不能为空");
			return;
		}
		if(!checkEmail(email)){
			mui.toast("请检查邮箱地址");
			return;
		}
		var fileObj = input_file.files[0]; // js 获取文件对象
		if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
		    mui.toast("请选择文件");
			return;
		}
		
		var data = new FormData();
		data.append("action", "adminRegister");  
		data.append("userName", name);
		data.append("password", password);
		data.append("phone", phone);
		data.append("email", email);
		data.append("file", fileObj);
		
		mui.ajax('http://localhost/file.php',{
			data:data,
			dataType:'json',//服务器返回json格式数据
			type:'post',//HTTP请求类型
			processData: false,
			contentType: false,
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