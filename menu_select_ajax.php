<?php

include "dbcon.php";


$get_ip = $_SERVER['REMOTE_ADDR'];

$stamp = mktime();
$get_date = date('Y-m-d H:i:s', $stamp);

$get_seq = $_POST['seq'];



//특수문자 제거함수
function content($text){
 $text = strip_tags($text);
 $text = htmlspecialchars($text);
 $text = preg_replace ("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $text);
 return $text;
}




$query = "SELECT * FROM menu WHERE seq=".$get_seq; // SQL 쿼리문

$result = mysqli_query($conn, $query);


mysqli_close($conn);


if( !$result ) {
	echo "Failed to list query menu_select_ajax";
	$isSuccess = FALSE;
}

$boardList = array();

while( $row = mysqli_fetch_array($result) ) {
	$board['seq'] = $row['seq'];
	$board['name'] = $row['name'];
	$board['price'] = $row['price'];
	$board['category'] = $row['category'];
	$board['count'] = $row['count'];
	array_push($boardList, $board);
}



if($result) {
	echo json_encode($boardList);
} else {
	echo "처리하지 못했습니다.";
}

?>