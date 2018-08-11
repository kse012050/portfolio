<?
include("dbconfig.php");

$seq = $_POST["seq"];
if($seq == null || $seq == "") {
	$seq = $_GET["seq"];
}
$conn = mysql_connect($mysql_host,$mysql_user,$mysql_password,$mysql_db);
mysql_select_db($mysql_user, $conn);
$sql = "DELETE FROM collection WHERE seq = ".$seq;
mysql_query($sql, $conn);
mysql_close($conn);

$retVal = array("result" => true, "code" => "001", "sql" => $sql);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($retVal);
?>