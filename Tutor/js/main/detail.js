mui.ready(function() {
	document.getElementById("unitName").textContent=localStorage.getItem("u_unitName");
	document.getElementById("manager").textContent="负责人:"+localStorage.getItem("u_manager");
	document.getElementById("category").textContent="分类:"+localStorage.getItem("u_category");
	document.getElementById("introduction").textContent=localStorage.getItem("u_introduction");
	document.getElementById("buildDate").textContent="创立时间:"+localStorage.getItem("u_buildDate");
	document.getElementById("address").textContent="地址:"+localStorage.getItem("u_address");
	document.getElementById("phone").textContent="联系电话:"+localStorage.getItem("u_phone");
	document.getElementById("email").textContent="邮箱:"+localStorage.getItem("u_email");
	document.getElementById("remark").textContent="备注:"+localStorage.getItem("u_remark")
})