<?php
include('dbconfig.php');

$result = false;
$code = "000";

$referer = $_SERVER["HTTP_REFERER"];
$referer ="http://kse012050.cafe24.com/step05/";
$refer = str_replace("http://","",$referer);
$refer = str_replace("www.","",$refer);
$refer = str_replace("/", "", $refer);

$retVal = array("result" => $result, "code" => $code, "referer" => $referer, "refer" => $refer);

$retVal["result"] = true;
$retVal["code"] = "001";

$conn = mysql_connect($mysql_host,$mysql_user,$mysql_password,$mysql_db);

if($conn){
    $retVal["code"] = "002";
    mysql_select_db($mysql_user,$conn);

    $list = array();
    $sql = "SELECT * FROM collection";
    $dbResult = mysql_query($sql, $conn);
    $i = 0;
    while($row = mysql_fetch_array($dbResult)) {
        $retVal["code"] = "003";
        $i = $i + 1;

        $seq = $row["seq"];
        $password = iconv("EUC-KR","UTF-8", $row["password"]);
        $title = iconv("EUC-KR","UTF-8", $row["title"]);
        $link = iconv("EUC-KR","UTF-8", $row["link"]);
        $thumb_original = iconv("EUC-KR","UTF-8", $row["img"]);
        $thumb_saved = iconv("EUC-KR","UTF-8", $row["test"]);
        $regist_datetime = $row["regist_datetime"];

        $item = array("seq" => $seq, "title" => $title, "link" => $link, "thumb_original" => $thumb_original, "thumb_saved" => $thumb_saved, "regist_datetime" => $regist_datetime );
        array_push($list, $item);
    }
    $retVal["count"] = $i;
    $retVal["list"] = $list;
    mysql_close($conn);
}else{
    $result = false;
    $code = "004";
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($retVal);
?>