<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT');
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

$link=mysqli_connect("localhost","pickpic","pickpic@)!*", "PickPic" );

if (!$link)
{
    echo "MySQL 접속 에러 : ";
    echo mysqli_connect_error();
    exit();
}

mysqli_set_charset($link,"utf8");

$sql="select * from user";
$result=mysqli_query($link,$sql);
$data = array();
if($result){

    while($row=mysqli_fetch_array($result)){
        $user = array(
            'id' => $row[0],
            'user_id' => $row[1],
            'password' => $row[2],
            'nick_name' => $row[3]
        );


        // 카메라
        $sub_sql = "select * from user_camera where user_id ='".$row[1]."'";

        $sub_result = mysqli_query($link, $sub_sql);
        $camera = array();

        while($sub_row = mysqli_fetch_array($sub_result)){
            array_push($camera, $sub_row[0]);
        }

        $user['camera'] = $camera;

        array_push($data, $user);
    }

    header('Content-Type: application/json; charset=utf8');
    $json = json_encode(array("user"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $json;
}else{
    echo "SQL문 처리중 에러 발생 : ";
    echo mysqli_error($link);
}
mysqli_close($link);
?>


