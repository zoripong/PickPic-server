
<?php
#TODO Test
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

$user_id = $_POST['user_id'];
$password = $_POST['password'];
$nick_name = $_POST['nick_name'];


$sql = "update user SET user_id = '".$user_id."', password = '".$password."', nick_name = '".$nick_name."' where user_id='".$user_id."'";
$result=mysqli_query($link,$sql);

if(!$result){
        echo "SQL문 처리중 에러 발생 : ";
	echo "sql:".$sql;
        echo mysqli_error($link);
}else{
    // 지우고 재삽입
    $sql = "delete from user_camera where user_id='".$user_id."'";
    $user_cameras = json_decode(stripslashes($_POST['camera']));
    foreach ($user_cameras as $camera) {
        $sql = "INSERT INTO user_camera VALUES(null, '".$user_id."', '".$camera."')";
        $result = mysqli_query($link, $sql);

        if(!$result){
            echo "SQL문 처리중 에러 발생 : ";
            echo mysqli_error($link);
            break;
        }
    }
}



mysqli_close($link);
?>


