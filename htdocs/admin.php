<?php
header("content-type:text/json;charset=utf-8"); //设置网页编码

include 'error.php';
if (empty($_POST['action'])) {
    paramsError();
}

include 'connect.php';

switch ($_POST["action"]) {
	case 'getUserList':
		getUserList();
        break;
    case 'getUserDetail':
        getUserDetail();
        break;
	case 'passUser':
		passUser();
        break;
    case 'rejectUser':
        rejectUser();
        break;
    case 'getUnitList':
        getUnitList();
        break;
    case 'getUnitDetail':
        getUnitDetail();
        break;
    case 'passUnit':
        passUnit();
        break;
    case 'rejectUnit':
        rejectUnit();
        break;
    case 'addNotice':
        addNotice();
        break;
    case 'getNoticeList':
        getNoticeList();
        break;
	default:
		jsonError();
		break;
}

mysqli_close($conn);

function getUserList(){
    global $conn;
	if (empty($_POST['token'])){
        paramsError();
    }
    $token=$_POST['token'];
    $sql = "SELECT privilege from account where token='$token' and status=1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_array($query);
        $privilege=$row['privilege'];
        if($privilege ==1){
            $sql = "SELECT * from account where privilege=1 and status=0 ";
            $query = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query) > 0){
                $list = mysqli_fetch_all($query, MYSQLI_ASSOC);
                echo json_encode(array("error" => 0, "data" => $list));
            }
            else{
                echo json_encode(array("error" => 12, "msg" => "没有用户申请记录"));
            }
        }
        else{
            echo json_encode(array("error" => 13, "msg" => "没有访问权限"));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询用户失败"));
    }
}

function getUserDetail()
{
	global $conn;
	if (empty($_POST['token']) || empty($_POST['userId'])){
        paramsError();
    }
    $token=$_POST['token'];
    $userId=$_POST['userId'];
    $sql = "SELECT userId from account where token='$token'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $sql = "SELECT * from account where userId='$userId'";
	    $query = mysqli_query($conn, $sql);
        if (mysqli_num_rows($query) > 0) {
            $item = mysqli_fetch_all($query, MYSQLI_ASSOC);
            echo json_encode(array("error" => 0, "data" => $item));
        }
        else{
            echo json_encode(array("error" => 11, "msg" => "用户不存在"));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}

function passUser(){
    global $conn;
	if (empty($_POST['token']) || empty($_POST['userId'])){
        paramsError();
    }
    $token=$_POST['token'];
    $userId=$_POST['userId'];
    $sql = "SELECT userId from account where token='$token'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        $sql = "SELECT userId,status from account where userId='$userId'";
        $query=mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($query);
        $status=$row['status'];
        if($status == 0){
            $sql = "update account set status=1 where userId='$userId'";
            $query=mysqli_query($conn,$sql);
            if (mysqli_affected_rows($conn) < 1){
                echo json_encode(array("error" => 5, "msg" => "数据库更新失败"));
            }
            else{
                echo json_encode(array("error" => 0, "msg" => "已通过"));
            }
        }
        else{
            echo json_encode(array("error" => 0, "msg" => "该用户已授权"));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}


function rejectUser(){
    global $conn;
	if (empty($_POST['token']) || empty($_POST['userId'])){
        paramsError();
    }
    $token=$_POST['token'];
    $userId=$_POST['userId'];
    $sql = "SELECT userId from account where token='$token'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        $sql = "SELECT userId,status from account where userId='$userId'";
        $query=mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($query);
        $status=$row['status'];
        if($status == 1){
            $sql = "update account set status=0 where userId='$userId'";
            $query=mysqli_query($conn,$sql);
            if (mysqli_affected_rows($conn) < 1){
                echo json_encode(array("error" => 5, "msg" => "数据库更新失败"));
            }
            else{
                echo json_encode(array("error" => 0, "msg" => "已拒绝"));
            }
        }
        else{
            echo json_encode(array("error" => 0, "msg" => "该用户已授权"));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}

function getUnitList(){
    global $conn;
	if (empty($_POST['token'])){
        paramsError();
    }
    $token=$_POST['token'];
    $sql = "SELECT privilege from account where token='$token' and status=1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_array($query);
        $privilege=$row['privilege'];
        if($privilege ==1){
            $sql = "SELECT * from unit where status=0 ";
            $query = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query) > 0){
                $list = mysqli_fetch_all($query, MYSQLI_ASSOC);
                echo json_encode(array("error" => 0, "data" => $list));
            }
            else{
                echo json_encode(array("error" => 12, "msg" => "没有机构申请记录"));
            }
        }
        else{
            echo json_encode(array("error" => 13, "msg" => "没有访问权限"));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询机构失败"));
    }
}

function getUnitDetail()
{
	global $conn;
	if (empty($_POST['token']) || empty($_POST['unitId'])){
        paramsError();
    }
    $token=$_POST['token'];
    $unitId=$_POST['unitId'];
    $sql = "SELECT userId from account where token='$token'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $sql = "SELECT * from unit where unitId='$unitId'";
	    $query = mysqli_query($conn, $sql);
        if (mysqli_num_rows($query) > 0) {
            $item = mysqli_fetch_all($query, MYSQLI_ASSOC);
            echo json_encode(array("error" => 0, "data" => $item));
        }
        else{
            echo json_encode(array("error" => 11, "msg" => "机构不存在"));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}

function passUnit(){
    global $conn;
	if (empty($_POST['token']) || empty($_POST['unitId'])){
        paramsError();
    }
    $token=$_POST['token'];
    $unitId=$_POST['unitId'];
    $sql = "SELECT userId from account where token='$token'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        $sql = "SELECT unitId,email,status from unit where unitId='$unitId'";
        $query=mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($query);
        $status=$row['status'];
        $email=$row['email'];
        if($status == 0){
            $sql = "update unit,account set unit.status=1,account.status=1 where unit.unitId='$unitId' and account.email='$email'";
            $query=mysqli_query($conn,$sql);
            if (mysqli_affected_rows($conn) < 1){
                echo json_encode(array("error" => 5, "msg" => "数据库更新失败"));
            }
            else{
                echo json_encode(array("error" => 0, "msg" => "已通过"));
            }
        }
        else{
            echo json_encode(array("error" => 0, "msg" => "该机构已授权"));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}


function rejectUnit(){
    global $conn;
	if (empty($_POST['token']) || empty($_POST['unitId'])){
        paramsError();
    }
    $token=$_POST['token'];
    $unitId=$_POST['unitId'];
    $sql = "SELECT userId from account where token='$token'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        $sql = "SELECT unitId,status from unit where unitId='$unitId'";
        $query=mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($query);
        $status=$row['status'];
        if($status == 1){
            $sql = "update unit set status=0 where unitId='$unitId'";
            $query=mysqli_query($conn,$sql);
            if (mysqli_affected_rows($conn) < 1){
                echo json_encode(array("error" => 5, "msg" => "数据库更新失败"));
            }
            else{
                echo json_encode(array("error" => 0, "msg" => "已拒绝"));
            }
        }
        else{
            echo json_encode(array("error" => 0, "msg" => "该机构已授权"));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}

function addNotice(){
    global $conn;
    if (empty($_POST['token']) || empty($_POST['title']) || empty($_POST['content'])){
        paramsError();
    }
    $token=$_POST['token'];
    $title=$_POST['title'];
    $content=$_POST['content'];
    $sql = "SELECT * from account where token='$token' and status=1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_array($query);
        $authorId=$row['userId'];
        $temp=mysqli_query($conn, "select noticeId from notice");
        $num=(string)(mysqli_num_rows($temp)+1);
        $publishTime=date("Y-m-d H:i:s", time());
        $sql = "insert into notice values ('$num', '$title', '$content', '$authorId', '$publishTime', 1, NULL)";
        $query=mysqli_query($conn, $sql);
        if (!$query){
            echo json_encode(array("error" => 5, "msg" => "数据库插入失败"));
        }
        else{
            echo json_encode(array("error" => 0, "msg" => "信息已发布"));
        } 
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}

function getNoticeList(){
    global $conn;
	if (empty($_POST['token'])){
        paramsError();
    }
    $token=$_POST['token'];
    $sql = "SELECT userId from account where token='$token' and status=1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $sql = "SELECT notice.*,account.userName from notice,account where notice.status=1 and account.userId=notice.authorId";
        $query = mysqli_query($conn, $sql);
        if (mysqli_num_rows($query) > 0){
            $list = mysqli_fetch_all($query, MYSQLI_ASSOC);
            echo json_encode(array("error" => 0, "data" => $list));
        }
        else{
            echo json_encode(array("error" => 11, "msg" => "没有系统公告"));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询用户失败"));
    }
}

?>