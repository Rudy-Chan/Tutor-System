mui.ready(function() {
	document.getElementById("theme").textContent=localStorage.getItem("a_theme");
	document.getElementById("keywords").textContent="关键词:"+localStorage.getItem("a_keywords");
	document.getElementById("relationUnit").textContent=localStorage.getItem("a_relationUnit");
	document.getElementById("publishDate").textContent=localStorage.getItem("a_publishDate");
	document.getElementById("introduction").textContent="活动简介:"+localStorage.getItem("a_introduction");
	document.getElementById("manager").textContent="负责人:"+localStorage.getItem("a_manager");
	document.getElementById("startDate").textContent="活动开始时间:"+localStorage.getItem("a_startDate");
	document.getElementById("endDate").textContent="活动结束时间:"+localStorage.getItem("a_endDate");
	document.getElementById("hour").textContent="工时:"+localStorage.getItem("a_hour");
	document.getElementById("score").textContent="学分:"+localStorage.getItem("a_score")
	document.getElementById("location").textContent="活动地点:"+localStorage.getItem("a_location")
	document.getElementById("needNum").textContent="招募人数:"+localStorage.getItem("a_needNum")
	document.getElementById("actualNum").textContent="参与人数:"+localStorage.getItem("a_actualNum")
	document.getElementById("remark").textContent="备注:"+localStorage.getItem("a_remark")
	
	
	document.getElementById("commentBtn").addEventListener('tap', function() {
		commentType = 0;
		document.getElementById("edit").placeholder = '写评论';
		document.getElementById("bottomTag").style.display = 'none';
		document.getElementById("commentInput").style.display = 'block';
		document.getElementById("edit").focus();
	});
	
	var activityId=localStorage.getItem("a_activityId");
	var token=localStorage.getItem("token");
	mui.ajax('http://localhost/activity.php',{
		data:{
			action:'getCommentList',
			activityId:activityId,
			token:token
		},
		dataType:'json',//服务器返回json格式数据
		type:'post',//HTTP请求类型
		timeout:10000,//超时时间设置为10秒；
		success:function(data){
			if(data.error==0){
				var arr=data.data;
				var list=document.getElementById("commentList");
				
				arr.forEach((item,index,array)=>{
				    var div=document.createElement("div");
				    div.innerHTML='<div class="commentDetails">'+
						'<p class="bottom0 padding15 font12">'+
						'<img class="avatar2 mui-pull-left" src="../../images/logo.jpg" />'+
						arr[index].nickName+'<p class="font12 posi">'+arr[index].time+
						'</p></p><p class="col333 commentText padding15">'+
						arr[index].content+'</p></div>';
				     list.appendChild(div);
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
	
	document.getElementById("edit").addEventListener('focus', function() {
		this.rows = 5;
		document.getElementById("bottomTag").style.display = 'none';
	});
	
	
	document.getElementById("edit").addEventListener('input', function() {
		if(this.value == '') {
			document.getElementById("submit").setAttribute('class', 'commentBtn');
		} else {
			document.getElementById("submit").setAttribute('class', 'commentBtn active');
		}
	});
	
	document.getElementById("submit").addEventListener('click',function(){
		
		var text=document.getElementById('edit').value.trim();
		
		if(text==""){
			document.getElementById("bottomTag").style.display = 'block';
			document.getElementById("commentInput").style.display = 'none';
			return;
		}
		mui.ajax('http://localhost/activity.php',{
			data:{
				action:'addComment',
				activityId:activityId,
				token:token,
				content:text
			},
			dataType:'json',//服务器返回json格式数据
			type:'post',//HTTP请求类型
			timeout:10000,//超时时间设置为10秒；
			success:function(data){
				if(data.error==0){
					mui.toast("评论成功");
				}
				else{
					mui.toast(data.msg);
				}
				document.getElementById("bottomTag").style.display = 'block';
				document.getElementById("commentInput").style.display = 'none';
			},
			error:function(xhr,type,errorThrown){
				//异常处理
				document.getElementById("bottomTag").style.display = 'block';
				document.getElementById("commentInput").style.display = 'none';
				mui.toast("验证超时，请重试");
			}
		});
	})
	
	document.getElementById("apply").addEventListener('click',function(){
		mui.ajax('http://localhost/activity.php',{
			data:{
				action:'applyOne',
				activityId:activityId,
				token:token,
			},
			dataType:'json',//服务器返回json格式数据
			type:'post',//HTTP请求类型
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
	})
})
