<?php
header("content-type:text/json;charset=utf-8"); //设置网页编码

include 'error.php';
if (empty($_POST['action'])) {
    paramsError();
}

include 'connect.php';

switch ($_POST["action"]) {
	case 'getActivityList':
		getActivityList();
		break;
	case 'getDetail':
		getDetail();
        break;
    case 'getCommentList':
        getCommentList();
        break;
    case 'addActivity':
        addActivity();
        break;
    case 'addComment':
        addComment();
        break;
    case 'applyOne':
        applyOne();
        break;
    case 'getNotifyList':
        getNotifyList();
        break;
	default:
		jsonError();
		break;
}

mysqli_close($conn);

function getActivityList()
{
	global $conn;
	if (empty($_POST['token'])){
        paramsError();
    }
    $token=$_POST['token'];
    $sql = "SELECT * from account where token='$token'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $sql = "SELECT * from activity where status=1";
	    $query = mysqli_query($conn, $sql);
        if (mysqli_num_rows($query) > 0) {
            $list = mysqli_fetch_all($query, MYSQLI_ASSOC);
            echo json_encode(array("error" => 0, "data" => $list));
        }
        else{
            echo json_encode(array("error" => 11, "msg" => "活动列表为空"));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}

function getDetail()
{
	global $conn;
	if (empty($_POST['token']) || empty($_POST['activityId'])){
        paramsError();
    }
    $token=$_POST['token'];
    $activityId=$_POST['activityId'];
    $sql = "SELECT * from account where token='$token'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $sql = "SELECT * from activity where activityId='$activityId' and status=1";
	    $query = mysqli_query($conn, $sql);
        if (mysqli_num_rows($query) > 0) {
            $item = mysqli_fetch_all($query, MYSQLI_ASSOC);
            echo json_encode(array("error" => 0, "data" => $item));
        }
        else{
            echo json_encode(array("error" => 11, "msg" => "活动不存在"));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}

function getCommentList(){
    global $conn;
	if (empty($_POST['token']) || empty($_POST['activityId'])){
        paramsError();
    }
    $token=$_POST['token'];
    $activityId=$_POST['activityId'];
    $sql = "SELECT * from account where token='$token'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $sql = "SELECT * from comment where activityId='$activityId' and status=1";
	    $query = mysqli_query($conn, $sql);
        if (mysqli_num_rows($query) > 0) {
            $list = mysqli_fetch_all($query, MYSQLI_ASSOC);
            echo json_encode(array("error" => 0, "data" => $list));
        }
        else{
            echo json_encode(array("error" => 12, "msg" => "评论列表为空"));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}

function addActivity(){
    global $conn;
    if (empty($_POST['token']) || empty($_POST['theme']) || empty($_POST['keywords']) || empty($_POST['location'])
        || empty($_POST['startDate']) || empty($_POST['endDate']) || empty($_POST['score'])
        || empty($_POST['hour']) || empty($_POST['needNum']) || empty($_POST['introduction'])){
        paramsError();
    }

    $token=$_POST['token'];
    $sql = "SELECT * from account where token='$token'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_array($query);
        $privilege=$row['privilege'];
        $email=$row['email'];
        if($privilege != 2){
            echo json_encode(array("error" => 6, "msg" => "该用户没有权限"));
        }
        else{
            $sql = "SELECT * from unit where email='$email'";
            $query = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_array($query);
                $temp=mysqli_query($conn, "select activityId from activity");
                $num=(string)(mysqli_num_rows($temp)+1);
                $theme=$_POST['theme'];
                $keywords=$_POST['keywords'];
                $location=$_POST['location'];
                $startDate=$_POST['startDate'];
                $endDate=$_POST['endDate'];
                $score=$_POST['score'];
                $hour=$_POST['hour'];
                $needNum=$_POST['needNum'];
                $introduction=$_POST['introduction'];
                $publishDate=date("Y-m-d H:i:s", time());
                $relationUnit=$row['unitName'];
                $manager=$row['manager'];

                $sql = "insert into activity values('$num', '$theme','$keywords', '$introduction', '$relationUnit', '$manager', '$publishDate', '$startDate', '$endDate', $hour, $score, '$location', $needNum, 0, 1, NULL)";
	            $query = mysqli_query($conn, $sql);
                if (!$query){
                    echo json_encode(array("error" => 11, "msg" => "数据库插入失败"));
                }
                else{
                    echo json_encode(array("error" => 0, "msg" => "活动发布成功"));
                }
            }
            else{
                echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
            }  
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}

function addComment(){
    global $conn;
	if (empty($_POST['token']) || empty($_POST['activityId'])){
        paramsError();
    }
    $token=$_POST['token'];
    $activityId=$_POST['activityId'];
    $content=$_POST['content'];
    $sql = "SELECT * from account where token='$token'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_array($query);
        $userId=$row['userId'];
        $nickName=$row['nickName'];
        $time=date("Y-m-d H:i:s", time());
        $temp=mysqli_query($conn, "select commentId from comment");
        $num=(string)(mysqli_num_rows($temp)+1);
        $sql = "insert into comment(commentId,activityId,userId,nickName,content,time,relationId,status)values ('$num', '$activityId','$userId', '$nickName', '$content', '$time', '0', 1)";
	    $query = mysqli_query($conn, $sql);
        if (!$query){
            echo json_encode(array("error" => 5, "msg" => "数据库插入失败"));
        }
        else{
            echo json_encode(array("error" => 0, "nickName" => $nickName, "time" => $time, "content" => $content));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}

function applyOne(){
    global $conn;
	if (empty($_POST['token']) || empty($_POST['activityId'])){
        paramsError();
    }
    $token=$_POST['token'];
    $activityId=$_POST['activityId'];
    $sql = "SELECT * from account where token='$token' and status=1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_array($query);
        $userId=$row['userId'];
        $userName=$row['userName'];
        $applyTime=date("Y-m-d H:i:s", time());
        $temp=mysqli_query($conn, "select applyId from apply");
        $num=(string)(mysqli_num_rows($temp)+1);
        $sql="SELECT userId,status from apply where userId='$userId' and activityId='$activityId'";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            //重新申请或取消申请
            $row = mysqli_fetch_array($query);
            $status=$row['status'];
            if($status==1){
                $temp=mysqli_query($conn, "select actualNum from activity where activityId='$activityId'");
                $num=(string)(mysqli_num_rows($temp)-1);
                $sql = "update apply,activity set apply.status=0,activity.actualNum='$num' where apply.userId='$userId' and apply.activityId='$activityId' and activity.activityId='$activityId'";
                $query=mysqli_query($conn,$sql);
                if (mysqli_affected_rows($conn) < 1){
                    echo json_encode(array("error" => 5, "msg" => "数据库更新失败"));
                }
                else{
                    echo json_encode(array("error" => 0, "msg" => "申请已取消"));
                }
            }
            else{
                $temp=mysqli_query($conn, "select actualNum from activity where activityId='$activityId'");
                $num=(string)(mysqli_num_rows($temp)+1);
                $sql = "update apply,activity set apply.status=1,activity.actualNum='$num' where apply.userId='$userId' and apply.activityId='$activityId' and activity.activityId='$activityId'";
                $query=mysqli_query($conn,$sql);
                if (mysqli_affected_rows($conn) < 1){
                    echo json_encode(array("error" => 5, "msg" => "数据库更新失败"));
                }
                else{
                    echo json_encode(array("error" => 0, "msg" => "申请成功"));
                }
            }
        }
        else{
            //提交申请
            $sql = "insert into apply(applyId,activityId,applyTime,userId,userName,status)values ('$num', '$activityId', '$applyTime', '$userId', '$userName', 1)";
            $query1 = mysqli_query($conn, $sql);
            //更新参与人数
            $temp=mysqli_query($conn, "select actualNum from activity where activityId='$activityId'");
            $num=(string)(mysqli_num_rows($temp)+1);
            $sql = "update activity set actualNum='$num' where activityId='$activityId'";
            $query2=mysqli_query($conn,$sql);
            if (!$query1 && !query2){
                echo json_encode(array("error" => 5, "msg" => "数据库插入失败"));
            }
            else{
                echo json_encode(array("error" => 0, "msg" => "申请成功"));
            }
        }   
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}

function getNotifyList(){
    global $conn;
	if (empty($_POST['token'])){
        paramsError();
    }
    $token=$_POST['token'];
    $sql = "SELECT userId from account where token='$token' and status=1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_array($query);
        $userId=$row['userId'];
        $sql = "SELECT activity.* from apply,activity where apply.userId='$userId' and apply.status=1 and apply.activityId=activity.activityId";
        $query = mysqli_query($conn, $sql);
        if (mysqli_num_rows($query) > 0){
            $list = mysqli_fetch_all($query, MYSQLI_ASSOC);
            echo json_encode(array("error" => 0, "data" => $list));
        }
        else{
            echo json_encode(array("error" => 11, "msg" => "用户没有通知"));
        }
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询用户失败"));
    }
}
?>