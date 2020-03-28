<?php

include "dbcon.php";


header("Content-Type: application/json");



$get_ip = $_SERVER['REMOTE_ADDR'];

$stamp = mktime();
$get_date = date('Y-m-d H:i:s', $stamp);

// $get_seq = $_POST['order_array'];


$get_user_card_num = $_POST['user_card_num'];
$get_today_temp = $_POST['today_temp'];



$get_category = "null";

$success = true;


$today_temp_min = $get_today_temp - 2;
$today_temp_max = $get_today_temp + 2;




//빈도수가 많은 주문 데이터 한개 가져와서 카테고리 조사하기
$query = "SELECT sale.*, count(sale.menu_seq) as cnt, menu.category FROM sale LEFT JOIN menu ON sale.menu_seq = menu.seq WHERE (sale.card_num = '$get_user_card_num' AND sale.today_temp != -99) AND (sale.today_temp <= '$today_temp_max' AND sale.today_temp >= '$today_temp_min') GROUP BY sale.menu_seq ORDER BY cnt DESC LIMIT 0, 1"; // SQL 쿼리문


$result = mysqli_query($conn, $query);
if( !$result ) {
	echo "Failed to list query menu_gogo_ajax.php";
	$isSuccess = FALSE;
	$success = false;
}

while( $row = mysqli_fetch_array($result) ) {
	$get_seq = $row['seq'];
	$get_menu_seq = $row['menu_seq'];
	$get_user_seq = $row['user_seq'];
	$get_card_num = $row['card_num'];
	$get_store_seq = $row['store_seq'];
	$get_today_temp = $row['today_temp'];
	$get_category = $row['category'];
}







$boardList = array();

$board['result'] = true;
$board['category'] = $get_category;
array_push($boardList, $board);

if($success) {
	echo json_encode($boardList);
} else {
	echo "처리하지 못했습니다.";
}




?>