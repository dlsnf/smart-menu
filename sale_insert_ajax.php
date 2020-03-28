<?php

include "dbcon.php";


header("Content-Type: application/json");



$get_ip = $_SERVER['REMOTE_ADDR'];

$stamp = mktime();
$get_date = date('Y-m-d H:i:s', $stamp);

// $get_seq = $_POST['order_array'];



//ajax 배열 받기 json
$sale_list_seq = json_decode(stripslashes($_POST['array_seq']));
// $get_user_seq = $_POST['user_seq']; //주문한 사용자 seq 받아오기
$get_user_card_num = $_POST['user_card_num'];
$get_user_seq = $_POST['user_seq'];
$get_today_temp = $_POST['today_temp'];
$get_user_name = "비회원";


if( $get_user_seq != -1 )//비회원이 아닐때
{
	//유저 card_num번호로 seq, 이름 찾아오기
	$query = "SELECT seq, name FROM user WHERE card_num = '$get_user_card_num'"; // SQL 쿼리문
	$result = mysqli_query($conn, $query);
	if( !$result ) {
		echo "Failed to list query sale_insert_ajax.php";
		$isSuccess = FALSE;
	}

	while( $row = mysqli_fetch_array($result) ) {
		$get_user_seq = $row['seq'];
		$get_user_name = $row['name'];
	}

}



$success = true;



//JSON 데이터 반복해주기
foreach($sale_list_seq as $get_menu_seq){

	//장바구니 리스트 sale db에 insert 해주기

	$query = "INSERT INTO sale(menu_seq, user_seq, card_num, store_seq, today_temp, sale_date) VALUES ('$get_menu_seq', '$get_user_seq', '$get_user_card_num', 1, '$get_today_temp', '$get_date')"; // SQL 쿼리문
	$result = mysqli_query($conn, $query);


	if ( $result )
	{
		
	}else{ //디비 등록이 하나라도 실패하면 실패 메시지 전송
		$success = false;
	}

}






/////////////JSON 데이터 반복해주기 (셋트메뉴 구성 카운트) 시작 //////////////

if( count($sale_list_seq) >= 2 )//주문내역이 2개 이상일 때
{

	$dessert_check = false;

	$query = "SELECT seq FROM menu WHERE (";
	$numItems = count($sale_list_seq);
	$i = 0;

	foreach($sale_list_seq as $get_menu_seq){
		if(++$i === $numItems) { //마지막 요소 찾기
			//echo "last index!";
			$query = $query."seq='$get_menu_seq'";
		  }else{
			$query = $query."seq='$get_menu_seq' OR ";
		  }	
	}

	$query = $query.") AND category = 'dessert'";
	$result1 = mysqli_query($conn, $query);


	$boardList_set_menu = array();

	if ( $result1 )//구매 내역중에 디저트가 있는 경우 배열에 정리
	{

		while( $row = mysqli_fetch_array($result1) ) {
			$board_set['seq'] = $row['seq'];
			array_push($boardList_set_menu, $board_set);
			$dessert_check = true;
		}
		
	}



	//주문내역중에 디저트가 있을때//
	if( $dessert_check ) 
	{
		//echo "디저트 갯수 : ".count($boardList_set_menu);
		//echo "print".print_r($boardList_set_menu);

		foreach($boardList_set_menu as $board_set) { //디저트가 어떤것이 있는지 반복
			//echo "dessert seq: ".$board_set['seq'];

			$dessert_seq = $board_set['seq'];

			

			foreach($sale_list_seq as $get_menu_seq){ //주문 내역 반복
				//SELECT sale_set.* FROM sale_set LEFT JOIN menu ON menu.category = sale_set.menu_category WHERE menu.seq = 4 AND sale_set.dessert_seq = 8 AND menu.category != 'dessert'

					$set_seq = -1;
					$set_count = 0;

					//주문내역중에 셋트메뉴 테이블과 조인 (주문내역중에 디저트가 아닌것)
					$query_set = "SELECT sale_set.* FROM sale_set LEFT JOIN menu ON menu.category = sale_set.menu_category WHERE menu.seq = '$get_menu_seq' AND sale_set.dessert_seq = '$dessert_seq' AND menu.category != 'dessert'";
					$result_set = mysqli_query($conn, $query_set);


					if ( $result_set )
					{
						

						while( $row = mysqli_fetch_array($result_set) ) {
							$set_seq = $row['seq'];
							$set_count = $row['count'];
						}

						if ( $set_seq != -1 )
						{

							//echo "셋 값이 존재함!".$set_seq;

							//셋트메뉴 count 올려주기
							$query_update = "UPDATE sale_set SET count = count + 1 WHERE seq = '$set_seq'";
							$result_set_update = mysqli_query($conn, $query_update);
							if( !$result_set_update )
							{
								echo "db 업데이트 에러 sale_insert_ajax.php";
								exit;
							}

						}else{
							//echo "셋값이 존재하지 않음!";
						}
					}
			}
			
		}


	}else{
		//echo "주문 내역 중에 디저트가 없습니다.";
	}

}


/////////////JSON 데이터 반복해주기 (셋트메뉴 구성 카운트) 끝 //////////////





$boardList = array();

$board['result'] = true;
$board['user_name'] = $get_user_name;
array_push($boardList, $board);

if($success) {
	echo json_encode($boardList);
} else {
	echo "처리하지 못했습니다.";
}




?>