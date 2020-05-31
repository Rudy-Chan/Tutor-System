<?php 
//数据库配置信息
header("content-type:text/json;charset=utf-8"); //设置网页编码
$db_host = "localhost";//主机名
$db_user = "root";//用户名
$db_pass = "0013428248";//密码
$db_name = "tutor";//数据库名
$conn=@mysqli_connect($db_host, $db_user, $db_pass);
//设置客户端字符集对象
mysqli_set_charset($conn,"utf8");
//php连接mysql服务器
if (mysqli_connect_errno($conn)) {
    echo json_encode(array("error" => 2, "msg" => "数据库连接错误"));
    die();
}
//选择数据库
if (!mysqli_select_db($conn, $db_name)) {
    echo json_encode(array("error" => 3, "msg" => "数据库不存在"));
    die();
}
?>