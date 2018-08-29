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

$user_id = $_POST['user_id'];
$image_url = $_POST['image_url'];
$location = $_POST['location'];
$description = $_POST['description'];
$camera = $_POST['camera'];
$angle = $_POST['angle'];
$tightening = $_POST['tightening'];
$shutter_speed = $_POST['shutter_speed'];
$iso = $_POST['iso'];

$sql = "INSERT INTO board VALUES(null, '".$user_id."', '".$image_url."', '".$location."', '".$description."', '".$camera."', '".$angle."', '".$tightening."', '".$shutter_speed."', ".$iso.");";
$result=mysqli_query($link,$sql);

if(!$result){
        echo "SQL문 처리중 에러 발생 : ";
	echo "??1".$sql;
        echo mysqli_error($link);
}else{

    $sub_sql = "SELECT id FROM board WHERE image_url='".$image_url."'";
    $sub_result = mysqli_query($link, $sub_sql);
    while($sub_row = mysqli_fetch_array($sub_result)){

        $tags = json_decode(stripslashes($_POST['tag']));
        foreach ($tags as $tag) {
            $sql = "INSERT INTO board_tag VALUES(null, ".$sub_row[0].", '".$tag."');";
            $result = mysqli_query($link, $sql);
    
            if(!$result){
                echo "SQL문 처리중 에러 발생 : ";
                echo "2";
		echo mysqli_error($link);
                break;
            }
        }

        // break;
    
    }
}

mysqli_close($link);
?>


