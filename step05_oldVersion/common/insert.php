<?php
include('dbconfig.php');
$result = false;
$code = "000";
$referer = $_SERVER["HTTP_REFERER"];

$referer = "http://kse012050.cafe24.com/step05/";
$refer = str_replace("http://","",$referer);
$refer = str_replace("www.", "", $refer);

$title			= iconv("UTF-8", "EUC-KR", $_POST["addTitle"]);
$link		= iconv("UTF-8", "EUC-KR", $_POST["addURL"]);
$thumb_original	= "";
$thumb_saved	= "";

if($_FILES['addImg'] != null && $_FILES['addImg']['name'] != null && trim($_FILES['addImg']['name']) != '') {
    @mkdir("../thum/", 0707);
    @chmod("../thum/", 0707);

    $_FILES['addImg']['name'] = iconv("UTF-8", "EUC-KR", $_FILES['addImg']['name']);

    // $_FILES['upfile']['tmp_name'] = 웹서버에 임시로 저장된 파일의 위치
    // $_FILES['upfile']['name'] = 사용자 시스템에 있을 때의 파일 이름
    // $_FILES['upfile']['size'] = 파일의 바이트 크기
    // $_FILES['upfile']['type'] = 파일의 MIME 타입 예)text/plain | image/png
    // $_FILES['upfile']['error'] = 파일 업로드시 발생한 오류 코드


    $tempfile		= $_FILES['addImg']['tmp_name'];
    $thumb_original	= $_FILES['addImg']['name'];
    $thumb_saved	= uniqid().'_'.$thumb_original;
    // uniqid() 유니크한 값을 부여합니다

	if (preg_match("/.(gif|jpe?g|png)$/i", $thumb_saved)) {
        $savefile = "../thum/".$thumb_saved;
        move_uploaded_file($tempfile, $savefile);
        // move_uploaded_file() 이 함수는에 의해 지정된 파일 filename이 유효한 업로드 파일을 확인합니다. 파일이 유효하면 주어진 파일 이름으로 이동합니다 destination

        $result = true;
        $code = "001";
        $conn = mysql_connect($mysql_host,$mysql_user,$mysql_password,$mysql_db);

        if($conn){
            $code = "010";
            $list = array();

            mysql_select_db($mysql_user, $conn);

            $sql = "INSERT INTO collection (password, title, link ,img ,test ) VALUES ('".$password."','".$title."','".$link."','".$thumb_original."','".$thumb_saved."');";
            mysql_query($sql, $conn);
            mysql_close($conn);
        }else{
            $result = false;
            $code	= "004"; // DB 연결안됨
        }
    } else{
        $result = false;
        $code	= "003"; // 썸네일이 이미지 파일이 아님
    }
} else{
    $result = false;
    $code	= "002"; // 썸네일 전달 안됨
}
$retVal = array("result" => $result, "code" => $code, "referer" => $referer, "refer" => $refer);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($retVal);
?>
