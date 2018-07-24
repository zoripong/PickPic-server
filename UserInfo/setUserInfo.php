
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


$sql = "INSERT INTO user VALUES(null, '".$user_id."', '".$password."', '".$nick_name."')";
$result=mysqli_query($link,$sql);

if(!$result){
        echo "SQL문 처리중 에러 발생 : ";
        echo mysqli_error($link);
}else{
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


