<?php

include "dbcon.php";


header("Content-Type: application/json");



$get_ip = $_SERVER['REMOTE_ADDR'];

$stamp = mktime();
$get_date = date('Y-m-d H:i:s', $stamp);









$get_category = $_POST['category'];




if( $get_category != "dessert") // set 메뉴 추천할때 카테고리가 디저트가 아닐때 디저트 추천
{



	//디저트 판매량중 카운트가 가장 높은 조합 불러오기
	$query = "SELECT * FROM sale_set WHERE menu_category = '$get_category' ORDER BY sale_set.count DESC LIMIT 0, 1"; // SQL 쿼리문


	$result = mysqli_query($conn, $query);
	if( !$result ) {
		echo "Failed to list query set_gogo_ajax.php";
		$isSuccess = FALSE;
		$success = false;
	}

	while( $row = mysqli_fetch_array($result) ) {
		$get_dessert_seq = $row['dessert_seq'];
	}




	$success = true;



	$boardList = array();

	$board['result'] = true;
	$board['dessert_seq'] = $get_dessert_seq;
	array_push($boardList, $board);

	if($success) {
		echo json_encode($boardList);
	} else {
		echo "처리하지 못했습니다.";
	}


}else{ // set 메뉴 추천할때 카테고리가 디저트일때 음료 추천

	//디저트 셋트 판매량 중 카운트가 높은 음료 4가지 불러오기
	$query = "SELECT menu.* FROM sale_set LEFT JOIN menu ON menu.category = sale_set.menu_category ORDER BY sale_set.count DESC LIMIT 0, 4"; // SQL 쿼리문


	$result = mysqli_query($conn, $query);
	if( !$result ) {
		echo "Failed to list query set_gogo_ajax2.php";
		$isSuccess = FALSE;
		$success = false;
	}

	$boardList = array();

	while( $row = mysqli_fetch_array($result) ) {
		$board['seq'] = $row['seq'];
		$board['name'] = $row['name'];
		$board['price'] = $row['price'];
		array_push($boardList, $board);
	}



	$success = true;


	if($success) {
		echo json_encode($boardList);
	} else {
		echo "처리하지 못했습니다.";
	}



}











?>