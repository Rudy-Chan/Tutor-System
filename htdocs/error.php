<?php
include 'connect.php';

function paramsError(){
    echo json_encode(array("error" => 1, "msg" => "参数缺失"));;
    die();
}

function jsonError(){
    echo json_encode(array("error" => 4, "msg" => "数据格式错误"));;
    die();
}
?>