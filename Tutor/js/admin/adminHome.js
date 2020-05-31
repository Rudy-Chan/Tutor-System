mui.ready(function(){
	var token=localStorage.getItem("token");
	
	mui.ajax('http://localhost/admin.php',{
		data:{
			action:'getUserList',
			token:token
		},
		dataType:'json',//服务器返回json格式数据
		type:'post',//HTTP请求类型
		timeout:10000,//超时时间设置为10秒；
		success:function(data){
			if(data.error==0){
				var arr=data.data;
				var ul=document.getElementById("list_wrap");
				arr.forEach((item,index,array)=>{
				    var li=document.createElement("li");
					li.innerHTML='<li class="mui-table-view-cell findbythree"><a>'+
					'<image class="img_msg" src="http://localhost/upload/home.jpg"></image>'+
					'<div class="ml60"><h5 class="fs18 cor-000">'+
						arr[index].userName+'</h5><p>邮箱：'+
						arr[index].email+'</p>'+'</div></a></li>';
				    ul.appendChild(li);
					
					li.addEventListener("click",function(){
						mui.ajax('http://localhost/admin.php',{
							data:{
								action:'getUserDetail',
								userId:arr[index].userId,
								token:token
							},
							dataType:'json',//服务器返回json格式数据
							type:'post',//HTTP请求类型
							timeout:10000,//超时时间设置为10秒；
							success:function(data){
								if(data.error==0){
									localStorage.setItem("u_userId",arr[index].userId);
									localStorage.setItem("u_userName",arr[index].userName);
									localStorage.setItem("u_email",arr[index].email);
									localStorage.setItem("u_password",arr[index].password);
									localStorage.setItem("u_registerDate",arr[index].registerDate);
									localStorage.setItem("u_nickName",arr[index].nickName);
									localStorage.setItem("u_phone",arr[index].phone);
									mui.openWindow({
										url: 'userDetail.html',
										id: 'userDetail.html',
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
})