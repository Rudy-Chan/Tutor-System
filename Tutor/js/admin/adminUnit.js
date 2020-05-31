mui.ready(function(){
	var token=localStorage.getItem("token");
	
	mui.ajax('http://localhost/admin.php',{
		data:{
			action:'getUnitList',
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
					'<image class="img_msg" src="http://localhost/upload/un.jpg"></image>'+
					'<div class="ml60"><h5 class="fs18 cor-000">'+
						arr[index].unitName+'</h5><p>邮箱：'+
						arr[index].email+'</p>'+'</div></a></li>';
				    ul.appendChild(li);
					
					li.addEventListener("click",function(){
						mui.ajax('http://localhost/admin.php',{
							data:{
								action:'getUnitDetail',
								unitId:arr[index].unitId,
								token:token
							},
							dataType:'json',//服务器返回json格式数据
							type:'post',//HTTP请求类型
							timeout:10000,//超时时间设置为10秒；
							success:function(data){
								if(data.error==0){
									localStorage.setItem("un_unitId",arr[index].unitId);
									localStorage.setItem("un_unitName",arr[index].unitName);
									localStorage.setItem("un_manager",arr[index].manager);
									localStorage.setItem("un_category",arr[index].category);
									localStorage.setItem("un_introduction",arr[index].introduction);
									localStorage.setItem("un_address",arr[index].address);
									localStorage.setItem("un_email",arr[index].email);
									localStorage.setItem("un_buildDate",arr[index].buildDate);
									localStorage.setItem("un_phone",arr[index].phone);
									mui.openWindow({
										url: 'unitDetail.html',
										id: 'unitDetail.html',
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