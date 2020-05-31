mui.ready(function(){
	var token = localStorage.getItem('token');
	mui.ajax('http://localhost/activity.php',{
		data:{
			action:'getActivityList',
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
				    li.innerHTML='<li class="detail"><h4>'+
						arr[index].theme+'</h4><p class="mui-pull-right">工时：'+
						arr[index].hour+'</p><p class="mui-push-left">关键字：'+
						arr[index].keywords+'</p><div class="newsimgbox">'+
				    	'<img class="loadthumb" src="http://localhost/upload/home.jpg"/>'+
				    	'</div><h5>'+
						arr[index].relationUnit+'</h5><p class="mui-pull-right">招募人数：'+
						arr[index].needNum+'</p><p>发布时间：'+
						arr[index].publishDate+'</p></li>';
				    ul.appendChild(li);
					
					li.addEventListener("click",function(){
						mui.ajax('http://localhost/activity.php',{
							data:{
								action:'getDetail',
								activityId:arr[index].activityId,
								token:token
							},
							dataType:'json',//服务器返回json格式数据
							type:'post',//HTTP请求类型
							timeout:10000,//超时时间设置为10秒；
							success:function(data){
								if(data.error==0){
									localStorage.setItem("a_activityId",arr[index].activityId);
									localStorage.setItem("a_theme",arr[index].theme);
									localStorage.setItem("a_keywords",arr[index].keywords);
									localStorage.setItem("a_introduction",arr[index].introduction);
									localStorage.setItem("a_relationUnit",arr[index].relationUnit);
									localStorage.setItem("a_manager",arr[index].manager);
									localStorage.setItem("a_publishDate",arr[index].publishDate);
									localStorage.setItem("a_startDate",arr[index].startDate);
									localStorage.setItem("a_endDate",arr[index].endDate);
									localStorage.setItem("a_hour",arr[index].hour);
									localStorage.setItem("a_score",arr[index].score);
									localStorage.setItem("a_location",arr[index].location);
									localStorage.setItem("a_needNum",arr[index].needNum);
									localStorage.setItem("a_actualNum",arr[index].actualNum);
									localStorage.setItem("a_remark",arr[index].remark);
									mui.openWindow({
										url: '../main/content.html',
										id: 'content.html',
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