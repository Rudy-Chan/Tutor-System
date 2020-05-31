<?php
header("content-type:text/json;charset=utf-8");

include 'error.php';
if (empty($_POST["action"])) {
    paramsError();
}

include 'connect.php';

switch ($_POST["action"]) {
    case 'unitRegister':
		unitRegister();
        break;
    case 'adminRegister':
        adminRegister();
        break;
    case 'getFileList':
        getFileList();
        break;
	default:
		jsonError();
		break;
}

mysqli_close($conn);

function unitRegister(){
    global $conn;
    
    if(empty($_POST["unitName"]) || empty($_POST["manager"]) || empty($_POST["category"]) 
    || empty($_POST["introduction"]) || empty($_POST["address"]) || empty($_POST["phone"]) 
    || empty($_POST["email"]) ){
       paramsError();
    }

    $email=trim($_POST["email"]);
    $temp=mysqli_query($conn, "select unitId,status from unit where email='$email'");
    if(mysqli_num_rows($temp) > 0){
        $row = mysqli_fetch_array($temp);
        if($row['status']==0){
            echo json_encode(array("error" => 6, "msg" => "注册信息已提交"));
        }
        else{
            echo json_encode(array("error" => 7, "msg" => "用户已存在"));
        }
    }
    else{
        $num=(string)(mysqli_num_rows($temp)+1);
        $temp=mysqli_query($conn, "select unitId from unit");
        $num=(string)(mysqli_num_rows($temp)+1);
        $unitName=trim($_POST["unitName"]);
        $manager=trim($_POST["manager"]);
        $category=trim($_POST["category"]);
        $introduction=trim($_POST["introduction"]);
        $buildDate=date("Y-m-d H:i:s", time());
        $address=trim($_POST["address"]);
        $phone=trim($_POST["phone"]);
    
        $sql = "insert into unit values ('$num', '$unitName', '$manager', '$category', '$introduction', '$buildDate', '$address', '$phone', '$email', 0, NULL)";
        $query1=mysqli_query($conn, $sql);

        $temp=mysqli_query($conn, "select userId from account");
        $num=(string)(mysqli_num_rows($temp)+1);
        $token= md5($email.$buildDate);  //创建激活码
        $sql="insert into account(userId,nickName,email,password,token,phone,registerDate,status,privilege)values ('$num','设置昵称','$email','123456', '$token','$phone','$buildDate', 0, 2)";
        $query2=mysqli_query($conn, $sql);

        if (!$query1 && !query2){
            echo json_encode(array("error" => 5, "msg" => "数据库插入失败"));
        }
        else{
            if ($_FILES["file"]["error"] > 0)
            {
                echo json_encode(array("error" => $_FILES["file"]["error"], "msg" => "文件上传出错"));
            }
            else
            {
                $temp = explode(".", $_FILES["file"]["name"]);
                $extension = end($temp);     // 获取文件后缀名
                $temp=mysqli_query($conn, "select fileId from file");
                $fileId=(string)(mysqli_num_rows($temp)+1);
                $fileNewName=$fileId.$_FILES["file"]["name"];
                $filePath="D:/xampp/htdocs/upload/".$fileNewName;
                $fileName=$_FILES["file"]["name"];
                $fileSize=$_FILES["file"]["size"];
                $uploadTime=date("Y-m-d H:i:s", time());

                // 判断当前目录下的 upload 目录是否存在该文件
                if (file_exists("D:/xampp/htdocs/upload/".$fileNewName)){
                    echo json_encode(array("error" => $_FILES["file"]["error"], "msg" => "文件已存在"));;
                }
                else{
                    // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                    move_uploaded_file($_FILES["file"]["tmp_name"], "D:/xampp/htdocs/upload/".$fileNewName);
                    $sql = "insert into file values ('$fileId', '$fileName', '$fileNewName', '$filePath', '$fileSize', '$uploadTime', '$num', '$extension',0, 1, NULL)";
                    $query=mysqli_query($conn, $sql);
                    if (!$query){
                        echo json_encode(array("error" => 5, "msg" => "数据库插入失败"));
                    }
                    else{
                        echo json_encode(array("error" => 0, "msg" => "注册信息已提交，待审核"));
                    }
                }    
            }
        }
    } 
}

function adminRegister(){
    global $conn;
    
    if(empty($_POST["userName"]) || empty($_POST["password"]) || empty($_POST["phone"]) || empty($_POST["email"]) ){
       paramsError();
    }

    $email=trim($_POST["email"]);
    $temp=mysqli_query($conn, "select userId,status from account where email='$email' and status=0");
    if(mysqli_num_rows($temp) > 0){
        $row = mysqli_fetch_array($temp);
        if($row['status']==0){
            echo json_encode(array("error" => 6, "msg" => "注册信息已提交"));
        }
        else{
            echo json_encode(array("error" => 7, "msg" => "用户已存在"));
        }
    }
    else{
        $temp=mysqli_query($conn, "select userId from account");
        $num=(string)(mysqli_num_rows($temp)+1);
        $userName=trim($_POST["userName"]);
        $password=trim($_POST["password"]);
        $phone=trim($_POST["phone"]);
        $registerDate= date("Y-m-d H:i:s", time());
        $verifyCode= rand(pow(10,(6-1)), pow(10,6)-1);
        $token= md5($email.$registerDate);  //创建激活码
        $sql="insert into account(userId,userName,nickName,email,password,phone,token,registerDate,status,privilege)values ('$num','$userName','设置昵称','$email','$password', '$phone', '$token','$registerDate', 0, 1)";
        $query=mysqli_query($conn, $sql);
        if (!$query){
            echo json_encode(array("error" => 5, "msg" => "数据库插入失败"));
        }
        else{
            if ($_FILES["file"]["error"] > 0)
            {
                echo json_encode(array("error" => $_FILES["file"]["error"], "msg" => "文件上传出错"));
            }
            else
            {
                $temp = explode(".", $_FILES["file"]["name"]);
                $extension = end($temp);     // 获取文件后缀名
                $temp=mysqli_query($conn, "select fileId from file");
                $fileId=(string)(mysqli_num_rows($temp)+1);
                $fileNewName=$fileId.$_FILES["file"]["name"];
                $filePath="D:/xampp/htdocs/upload/".$fileNewName;
                $fileName=$_FILES["file"]["name"];
                $fileSize=$_FILES["file"]["size"];
                $uploadTime=date("Y-m-d H:i:s", time());

                // 判断当前目录下的 upload 目录是否存在该文件
                if (file_exists("D:/xampp/htdocs/upload/".$fileNewName)){
                    echo json_encode(array("error" => $_FILES["file"]["error"], "msg" => "文件已存在"));;
                }
                else{
                    // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                    move_uploaded_file($_FILES["file"]["tmp_name"], "D:/xampp/htdocs/upload/".$fileNewName);
                    $sql = "insert into file values ('$fileId', '$fileName', '$fileNewName', '$filePath', '$fileSize', '$uploadTime', '$num', '$extension', 1, 1, NULL)";
                    $query=mysqli_query($conn, $sql);
                    if (!$query){
                        echo json_encode(array("error" => 5, "msg" => "数据库插入失败"));
                    }
                    else{
                        echo json_encode(array("error" => 0, "msg" => "注册信息已提交，待审核"));
                    }
                }    
            }
        }
    } 
}

?>
