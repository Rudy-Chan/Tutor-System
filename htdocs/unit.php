<?php
header("content-type:text/json;charset=utf-8"); //设置网页编码

include 'error.php';
if (empty($_POST['action'])) {
    paramsError();
}

include 'connect.php';

switch ($_POST["action"]) {
	case 'getUnitList':
		getUnitList();
		break;
	case 'getDetail':
		getDetail();
        break;
    case 'getCommentList':
        getCommentList();
        break;
	default:
		jsonError();
		break;
}

function getUnitList()
{
	global $conn;
	if (empty($_POST['token'])){
        paramsError();
    }
    $token=$_POST['token'];
    $sql = "SELECT * from account where token='$token'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $sql = "SELECT * from unit where status=1";
	    $query = mysqli_query($conn, $sql);
        if (mysqli_num_rows($query) > 0) {
            $list = mysqli_fetch_all($query, MYSQLI_ASSOC);
            echo json_encode(array("error" => 0, "data" => $list));
        }
        else{
            echo json_encode(array("error" => 13, "msg" => "机构列表为空"));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}


?>