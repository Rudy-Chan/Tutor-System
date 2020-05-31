mui.ready(function(){
	var token = localStorage.getItem('token');
	mui.ajax('http://localhost/unit.php',{
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
				var list=document.getElementById("list_unit");
				
				arr.forEach((item,index,array)=>{
				    var div=document.createElement("div");
					div.innerHTML='<div class="mui-card">'+
						'<div class="mui-card-header mui-card-media">'+
						'<img class="avatar mui-pull-left" src="http://localhost/upload/un.jpg"/>'+
						'<div class="mui-media-body">'+
						arr[index].unitName+'<p>创立时间:'+arr[index].buildDate+
						'</p></div></div><div class="mui-card-content mui-card-media" style="height:40vw;'+
						'background-image:url(http://localhost/upload/unit.jpg)">'+
						'</div><div class="mui-card-footer"><h5>'+
						arr[index].introduction+'</h5></div></div>';
				    list.appendChild(div);
					
					div.addEventListener("click",function(){
						mui.ajax('http://localhost/activity.php',{
							data:{
								action:'getDetail',
								activityId:arr[index].unitId,
								token:token
							},
							dataType:'json',//服务器返回json格式数据
							type:'post',//HTTP请求类型
							timeout:10000,//超时时间设置为10秒；
							success:function(data){
								if(data.error==0){
									localStorage.setItem("u_unitId",arr[index].unitId);
									localStorage.setItem("u_unitName",arr[index].unitName);
									localStorage.setItem("u_manager",arr[index].manager);
									localStorage.setItem("u_category",arr[index].category);
									localStorage.setItem("u_introduction",arr[index].introduction);
									localStorage.setItem("u_buildDate",arr[index].buildDate);
									localStorage.setItem("u_address",arr[index].address);
									localStorage.setItem("u_phone",arr[index].phone);
									localStorage.setItem("u_email",arr[index].email);
									localStorage.setItem("u_status",arr[index].status);
									localStorage.setItem("u_remark",arr[index].remark);
									mui.openWindow({
										url: 'detail.html',
										id: 'detail.html',
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
				mui.openWindow({
					url: '../main/error.html',
					id:'error.html',
				});
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
})