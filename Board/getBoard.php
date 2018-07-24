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

$sql="select * from board";
$result=mysqli_query($link,$sql);

$data = array();
if($result){

    while($row=mysqli_fetch_array($result)){
        $board = array(
            'id' => $row[0],
            'user_id' => $row[1],
            'image_url' => $row[2],
            'location' => $row[3],
            'description' => $row[4],
            'camera' => $row[5],
            'angle' => $row[6],
            'tightening' => $row[7],
            'shutter_speed' => $row[8],
            'iso' => $row[9]
        );


        // 해시태그
        $sub_sql = "select * from board_tag where board_id ='".$row[0]."'";

        $sub_result = mysqli_query($link, $sub_sql);
        $tags = array();

        while($sub_row = mysqli_fetch_array($sub_result)){
            array_push($tags, $sub_row[2]);
        }

        $board['tag'] = $tags;

        array_push($data, $board);
    }

    header('Content-Type: application/json; charset=utf8');
    $json = json_encode(array("board"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $json;
}else{
    echo "SQL문 처리중 에러 발생 : ";
    echo mysqli_error($link);
}


mysqli_close($link);
?>


