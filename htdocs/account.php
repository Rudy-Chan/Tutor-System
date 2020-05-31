<?php
header("content-type:text/json;charset=utf-8"); //设置网页编码

include 'error.php';
if (empty($_POST['action'])) {
    paramsError();
}

include 'connect.php';

switch ($_POST["action"]) {
	case 'login':
		login();
		break;
	case 'forgetPwd':
		forgetPwd();
        break;
    case 'verify':
        verify();
        break;
    case 'loginByPwd':
        loginByPwd();
        break;
    case 'setPwd':
        setPwd();
        break;
    case 'setPhone':
        setPhone();
        break;
	default:
		jsonError();
		break;
}

mysqli_close($conn);

function login(){
    global $conn;
    if(empty($_POST["email"])){
        paramsError();
    }
    $email=trim($_POST["email"]);
    $sql="select * from account where email='$email'";
    // 检测用户名是否存在
    $query=mysqli_query($conn, $sql);
    include 'smtp.class.php';
    if(mysqli_num_rows($query) < 1){
        //注册
        $registerDate= date("Y-m-d H:i:s", time());
        $verifyCode= rand(pow(10,(6-1)), pow(10,6)-1);
        $token= md5($email.$registerDate);  //创建激活码
        $timeSpan = date("Y-m-d H:i:s", strtotime("1 hour"));//过期时间为24小时后
        $temp=mysqli_query($conn, "select userId from account");
        $num=(string)(mysqli_num_rows($temp)+1);
        $sql="insert into account(userId,nickName,email,password,verifyCode,token,phone,registerDate,timeSpan,status,privilege)values ('$num','设置昵称','$email','123456', '$verifyCode', '$token','未绑定','$registerDate', '$timeSpan', 1,0)";
        $query=mysqli_query($conn, $sql);
        if (!$query){
            echo json_encode(array("error" => 5, "msg" => "数据库插入失败"));
        }
        else{
            //写入数据库成功，发邮件
            $MailServer = "smtp.qq.com"; //SMTP服务器
            $MailPort = 25; //SMTP服务器端口
            $smtpMail = "email_address""; 
            $smtpuser = "email_address"; //SMTP服务器的用户帐号
            $smtppass = "授权码的base64编码"; //base64加密
            //创建$smtp对象 这里面的一个true是表示使用身份验证,否则不使用身份验证.
            $smtp = new Smtp($MailServer, $MailPort, $smtpuser, $smtppass, true); 
            $smtp->debug = false; 
            $mailType = "HTML"; //信件类型，文本:text；网页：HTML；$email = $email;  //收件人邮箱
            $emailTitle = "支教App用户帐号激活"; //邮件主题
            $emailBody = "亲爱的用户：<br/>感谢您在我站注册了新帐号。<br/>请复制验证码<br/>".$verifyCode."<br/>激活您的账户。<br/>该验证码1小时内有效。<br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- 支教APP 敬上</p>";
            // sendmail方法
            // 参数1是收件人邮箱
            // 参数2是发件人邮箱
            // 参数3是主题（标题）
            // 参数4是邮件主题（标题）
            // 参数4是邮件内容  参数是内容类型文本:text 网页:HTML
            $rs = $smtp->sendmail($email, $smtpMail, $emailTitle, $emailBody, $mailType);
            if($rs){
                $sql="select * from account where email='$email'";
                $query=mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($query);
                echo json_encode(array("error" => 0, "msg" => "注册成功", "token"=> $token, "userId"=> $row['userId'], "nickName"=>$row['nickName'], "phone"=>$row['phone'], "privilege"=>$row['privilege']));
            }
            else{
                echo json_encode(array("error" => 5, "msg" => "注册失败"));
            }
        }  
    }
    else{ 
        //登陆
        $verifyCode= rand(pow(10,(6-1)), pow(10,6)-1);
        $timeSpan = date("Y-m-d H:i:s", strtotime("1 hour"));//过期时间为1小时后
        $token= md5($email.$timeSpan);  //创建激活码
        $sql = "update account set verifyCode='$verifyCode',timeSpan='$timeSpan',token='$token' where email='$email' and status=1";
        $query=mysqli_query($conn,$sql);
        if (mysqli_affected_rows($conn) < 1){
            echo json_encode(array("error" => 5, "msg" => "数据库更新失败"));
        }
        else{
            $MailServer = "smtp.qq.com"; //SMTP服务器
            $MailPort = 25; //SMTP服务器端口
            $smtpMail = "email_address"; //
            $smtpuser = "email_address"; //SMTP服务器的用户帐号
            $smtppass = "授权码的base64编码"; //
            //创建$smtp对象 这里面的一个true是表示使用身份验证,否则不使用身份验证.
            $smtp = new Smtp($MailServer, $MailPort, $smtpuser, $smtppass, true); 
            $smtp->debug = false; 
            $mailType = "HTML"; //信件类型，文本:text；网页：HTML；$email = $email;  //收件人邮箱
            $emailTitle = "支教App用户帐号登录"; //邮件主题
            $emailBody = "亲爱的用户：<br/>感谢您在我站使用帐号。<br/>请复制验证码<br/>".$verifyCode."<br/>登录您的账户。<br/>该验证码1小时内有效。<br/>如果此次登录请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- 支教APP 敬上</p>";
            
            $rs = $smtp->sendmail($email, $smtpMail, $emailTitle, $emailBody, $mailType);
            if($rs){
                $sql="select * from account where email='$email'";
                $query=mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($query);
                echo json_encode(array("error" => 0, "msg" => "登陆成功", "token"=> $token, "userId"=> $row['userId'], "nickName"=>$row['nickName'], "phone"=>$row['phone'], "privilege"=>$row['privilege']));
            }
            else{
                echo json_encode(array("error" => 6, "msg" => "登陆失败"));
            }
        }
    }
}

function forgetPwd(){
    global $conn;
    if(empty($_POST["email"])){
        paramsError();
    }
    $email=trim($_POST["email"]);
    $sql="select * from account where email='$email' and status=1";
    // 检测用户名是否存在
    $query=mysqli_query($conn, $sql);
    include 'smtp.class.php';
    if(mysqli_num_rows($query) < 1){
        echo json_encode(array("error" => 6, "msg" => "用户不存在"));
    }
    else{
        $verifyCode= rand(pow(10,(6-1)), pow(10,6)-1);
        $timeSpan = date("Y-m-d H:i:s", strtotime("1 hour"));//过期时间为1小时后
        $token= md5($email.$timeSpan);  //创建激活码
        $sql = "update account set verifyCode='$verifyCode',timeSpan='$timeSpan',token='$token' where email='$email' and status=1";
        $query=mysqli_query($conn,$sql);
        if (mysqli_affected_rows($conn) < 1){
            echo json_encode(array("error" => 5, "msg" => "数据库更新失败"));
        }
        else{
            $MailServer = "smtp.qq.com"; //SMTP服务器
            $MailPort = 25; //SMTP服务器端口
            $smtpMail = "email_address"; //SMTP服务器的用户邮箱
            $smtpuser = "email_address"; //SMTP服务器的用户帐号
            $smtppass = "授权码的base64编码"; 
            //创建$smtp对象 这里面的一个true是表示使用身份验证,否则不使用身份验证.
            $smtp = new Smtp($MailServer, $MailPort, $smtpuser, $smtppass, true); 
            $smtp->debug = false; 
            $mailType = "HTML"; //信件类型，文本:text；网页：HTML；$email = $email;  //收件人邮箱
            $emailTitle = "支教App用户帐号忘记密码验证"; //邮件主题
            $emailBody = "亲爱的用户：<br/>感谢您在我站使用帐号。<br/>请复制验证码<br/>".$verifyCode."<br/>修改您的账户密码。<br/>该验证码1小时内有效。<br/>如果此次登录请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- 支教APP 敬上</p>";
            
            $rs = $smtp->sendmail($email, $smtpMail, $emailTitle, $emailBody, $mailType);
            if($rs){
                echo json_encode(array("error" => 0, "msg" => "验证成功", "token"=> $token));
            }
            else{
                echo json_encode(array("error" => 6, "msg" => "验证失败"));
            }
        }
    }
}

function verify(){
    global $conn;
    if(empty($_POST["verifyCode"]) || empty($_POST["token"])){
        paramsError();
    }
    $verifyCode=trim($_POST["verifyCode"]);
    $token=trim($_POST["token"]);
    $now= date("Y-m-d H:i:s", time());
    $sql="select verifyCode,timeSpan from account where token='$token' and status=1";
    // 检测验证码是否存在
    $query=mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    if ($row){
        if ($now > $row['timeSpan']) {
            echo json_encode(array("error" => 7, "msg" => "您的验证码有效期已过，请重新发送验证码邮件"));
            return;
        }
        if(strcmp($verifyCode,$row['verifyCode']) != 0){
            echo json_encode(array("error" => 8, "msg" => "验证码错误，请重新输入"));
            return;
        }
        echo json_encode(array("error" => 0, "msg" => "验证通过"));
    }
}

function loginByPwd(){
    global $conn;
    if(empty($_POST["email"]) || empty($_POST["password"])){
        paramsError();
    }
    $email=trim($_POST["email"]);
    $password=trim($_POST["password"]);
    $timeSpan = date("Y-m-d H:i:s", time());
    $token= md5($email.$timeSpan);  //创建激活码
    $sql="select * from account where email='$email' and status=1";
    // 检验密码是否正确
    $query=mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    if ($row){
        if ($password != $row['password']) {
            echo json_encode(array("error" => 9, "msg" => "密码错误，请重新输入"));
            return;
        }
        $sql="update account set token='$token',timeSpan='$timeSpan' where email='$email' and status=1";
        $query=mysqli_query($conn,$sql);
        if (mysqli_affected_rows($conn) < 1){
            echo json_encode(array("error" => 5, "msg" => "数据库更新失败"));
        }
        else{
            echo json_encode(array("error" => 0, "msg" => "登陆成功", "token"=> $token, "userId"=> $row['userId'], "nickName"=>$row['nickName'], "phone"=>$row['phone'], "privilege"=>$row['privilege']));
        }
    }
}

function setPwd(){
    global $conn;
	if (empty($_POST['token']) || empty($_POST['newPwd'])){
        paramsError();
    }
    $token=$_POST['token'];
    $newPwd=$_POST['newPwd'];
    $sql = "SELECT * from account where token='$token' and status=1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $sql = "update account set password='$newPwd' where token='$token'";
        $query=mysqli_query($conn,$sql);
        if (mysqli_affected_rows($conn) < 1){
            echo json_encode(array("error" => 5, "msg" => "数据库更新失败"));
        }
        else{
            echo json_encode(array("error" => 0, "msg" => "修改成功"));
        }
        
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}

function setPhone(){
    global $conn;
	if (empty($_POST['token']) || empty($_POST['phone'])){
        paramsError();
    }
    $token=$_POST['token'];
    $phone=$_POST['phone'];
    $sql = "SELECT * from account where token='$token' and status=1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0){
        $sql = "update account set phone='$phone' where token='$token'";
        $query=mysqli_query($conn,$sql);
        if (mysqli_affected_rows($conn) < 1){
            echo json_encode(array("error" => 5, "msg" => "数据库更新失败"));
        }
        else{
            echo json_encode(array("error" => 0, "msg" => "修改成功"));
        }
        
    }
    else{
        echo json_encode(array("error" => 5, "msg" => "数据库查询失败"));
    }
}
?>