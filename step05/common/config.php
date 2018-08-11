<?php

include('dbconfig.php');
$result = false;
$code = "000";
$referer = $_SERVER["HTTP_REFERER"];
// $_SERVER 서버쪽 언어
// $_SERVER["*"] * 은 다양한게 들어가는데 정확히 어떤게 어떤역활을 하는지 아직 몰라 아직 공부안했어
// 일단 HTTP_REFERER 은 사용자 에이전트를 현재 페이지로 참조한 페이지 주소(있을 경우). 이것은 사용자 에이전트에 의해 설정됩니다. 모든 사용자 에이전트가 이를 설정하는 것은 아니며 일부는 HTTP_REFERER를 기능으로 수정할 수 있는 기능을 제공 이라는데 무슨 말인지 모르겠어
// 일단 완벽히 신뢰할 수 없다는데

$referer = "http://kse012050.cafe24.com/step05/";
$refer = str_replace("http://","",$referer);
$refer = str_replace("www.", "", $refer);
// $refer = str_replace("/", "", $refer);
// str_replace() 함수는 일부 문자를 문자열의 다른 문자로 바꾸는거래
// 그렇니까 str_replace(찾기,바꾸기,문자열,개수) 여기서 개수는 생략한 것같아
// 음 그렇니까 http:// 랑 www. 이랑 / 를 ""공백? 없는걸로 만들어 어떠한 경로로 들어오든 같은 url로 만드는 것 같아 그것을 $refer 이곳에 넣는거지

$retVal = array("result" => $result, "code" => $code, "referer" => $referer, "refer" => $refer);

if(trim($refer) == "kse012050.cafe24.com/step05/"){
    // trim() 함수는 문자열의 얄쪽에서 공백과 다른 미리 정의 된 문자를 제거 합니다.

    $retVal["result"] = true;
    $retVal["code"] = "001";

    $conn = mysql_connect($mysql_host,$mysql_user,$mysql_password,$mysql_db);
    // mysql_connect db연결 정보? 함수 ?
    if($conn){
        mysql_select_db($mysql_user, $conn);
        // mysql_select_db 접속 지시자와 연관된 서버에서 현재 활성화할 데이터베이스를 선택합니다.

        $list = array();
        // $sql = "SELECT * FROM kse012050 ORDER BY seq DESC";
        // $dbResult = mysql_query($sql,$conn);

        //$dbResult = mysql_query("SELECT * FROM test");
        $sql = "SELECT * FROM collection";
        $dbResult = mysql_query($sql, $conn);

        // mysql_query()는 다른 형식의 SQL 구문, INSERT, UPDATE, DELETE, DROP 등에서 성공하면 TRUE를 , 실패하면 FALSE를 반환합니다.
        // mysql_query()는 link_identifier로 지정한 데이터베이스 서버에 하나의 질의를 전송합니다.(다중 질의는 지원하지 않습니다)

        $retVal["code"] = "002";
        $i = 0;

        while($row = mysql_fetch_row($dbResult) ){
            $retVal["code"] = "005";
            // mysql_fetch_array() db에서 정보를 꺼내오는 함수
            // 중요함으로 사이트 참조
            // http://sbumseo.tistory.com/84
            $i = $i + 1;

            $seq = $row["seq"];
            $password = iconv("EUC-KR","UTF-8", $row[1]);
            $title = iconv("EUC-KR","UTF-8", $row[2]);
            $link = iconv("EUC-KR","UTF-8", $row[3]);
            $img = iconv("EUC-KR","UTF-8", $row[4]);
            $regist_datetime	= $row["regist_datetime"];
            // 문자열 iconv ( 문자열 $in_charset , 문자열 $out_charset , 문자열 $str )
            // in_charset 입력 캐릭터 셋  // out_charset 출력 캐릭터 셋 // str 변환 할 문자열입니다.
            // iconv()  문자열을 요청 된 문자 인코딩으로 변환합니다.


            $item = array("password" => $password, "title" => $title, "link" => $link , "img" => $img);
            array_push($list,$item);
        }
        $retVal["count"] = $i;
        $retVal["list"] = $list;
        mysql_close($conn);
        // mysql_close db 연결에 대한 비 지속 연결 닫기라는데 무슨말인지..
    }else{
        $result = false;
        $code	= "004"; // DB 연결안됨

    }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($retVal);
// json_encode() value 의 JSON 표현을 가지는 문자열을 반환합니다.
?>
