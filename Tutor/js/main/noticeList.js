mui.ready(function(){
	var token=localStorage.getItem("token");
	mui.ajax('http://localhost/admin.php',{
		data:{
			action:'getNoticeList',
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
						arr[index].title+'</h4><p>发布者：'+
						arr[index].userName+'</p><h5 style="word-wrap:break-word;">'+
						arr[index].content+'</h5><p mui-pull-right>发布时间：'+
						arr[index].publishTime+'</p></li>';
				    
				    ul.appendChild(li);
					
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