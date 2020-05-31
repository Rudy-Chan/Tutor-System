mui.ready(function(){
	var btn_release=document.getElementById("release")
	var input_theme=document.getElementById("theme");
	var input_keywords=document.getElementById("keywords");
	var input_location=document.getElementById("location");
	var input_startDate=document.getElementById("startDate");
	var input_endDate=document.getElementById("endDate");
	var input_hour=document.getElementById("hour");
	var input_score=document.getElementById("score");
	var input_needNum=document.getElementById("needNum");
	var input_introduction=document.getElementById("introduction");
	var input_token=localStorage.getItem("token");
	
	btn_release.addEventListener("click",function(){
		var theme=input_theme.value.trim();
		var keywords=input_keywords.value.trim();
		var location=input_location.value.trim();
		var startDate=input_startDate.value.trim();
		var endDate=input_endDate.value.trim();
		var score=input_score.value.trim();
		var hour=input_hour.value.trim();
		var needNum=input_needNum.value.trim();
		var introduction=input_introduction.value.trim();

		if(theme=="" || keywords=="" || location=="" || startDate=="" || endDate==""
			|| score=="" || hour=="" || needNum=="" || introduction==""){
			mui.toast("请填写完整的信息");
			return;
		}
		
		var token=localStorage.getItem("token");
		mui.ajax('http://localhost/activity.php',{
			data:{
				action:'addActivity',
				token:token,
				theme:theme,
				keywords:keywords,
				location:location,
				startDate:startDate,
				endDate:endDate,
				score:score,
				hour:hour,
				needNum:needNum,
				introduction:introduction
			},
			dataType:'json',//服务器返回json格式数据
			type:'post',//HTTP请求类型
			timeout:10000,//超时时间设置为10秒；
			success:function(data){
				if(data.error==0){
					mui.toast(data.msg);
					input_theme.value="";
					input_keywords.value="";
					input_location.value="";
					input_startDate.value="";
					input_endDate.value="";
					input_score.value="";
					input_hour.value="";
					input_needNum.value="";
					input_introduction.value="";
				}
				else{
					mui.toast(data.msg);
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
	});
	
	
})