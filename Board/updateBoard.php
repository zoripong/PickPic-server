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

$id = $_POST['id'];
$user_id = $_POST['user_id'];
$image_url = "localhost/PickPic/".$user_id."/".$_POST['image_url'].time();
$location = $_POST['location'];
$description = $_POST['description'];
$camera = $_POST['camera'];
$angle = $_POST['angle'];
$tightening = $_POST['tightening'];
$shutter_speed = $_POST['shutter_speed'];
$iso = $_POST['iso'];

$sql = "UPDATE board SET user_id = '".$user_id."', image_url = '".$image_url."', location = '".$location."', description = '".$description."', camera = '".$camera."', angle = '".$angle."', tightening = '".$tightening."', shutter_speed = '".$shutter_speed."', iso = ".$iso."WHERE id = ".$id;
$result=mysqli_query($link,$sql);

if(!$result){
        echo "SQL문 처리중 에러 발생 : ";
        echo mysqli_error($link);
}else{
    // 지우고 재삽입
    $sql = "delete from board_tag where board_id='".$id."'";
    $tags = json_decode(stripslashes($_POST['tag']));
    foreach ($tags as $tag) {
        $sql = "INSERT INTO user_camera VALUES(null, '".$id."', '".$tag."')";
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


