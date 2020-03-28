<?php

include "dbcon.php";


$get_ip = $_SERVER['REMOTE_ADDR'];

$stamp = mktime();
$get_date = date('Y-m-d H:i:s', $stamp);








//LEFT 조인으로 가져온것
//SELECT * 유저번호 FROM tag_value LEFT JOIN user ON user.card_num = tag_value.card_num WHERE tag_value.date_ > DATE_ADD(now(), INTERVAL -1000 second) ORDER BY tag_value.seq DESC LIMIT 0 , 1




//최근 10초 이내 NFC태그한 값 불러오기
$query = "SELECT * FROM tag_value WHERE date_ > DATE_ADD(now(), INTERVAL -2 second) ORDER BY seq DESC LIMIT 0 , 1"; // SQL 쿼리문


$result = mysqli_query($conn, $query);


// mysqli_close($conn);



if( !$result ) {
	echo "Failed to list query nfc_check_ajax.php";
	$isSuccess = FALSE;
}

$boardList = array();

while( $row = mysqli_fetch_array($result) ) {
	$board['seq'] = $row['seq'];
	$board['card_num'] = $row['card_num'];
	$card_num = $board['card_num'];
	$board['date_'] = $row['date_'];
	array_push($boardList, $board);
}




//회원 번호가 있는지 체크하기
if ( $card_num )
{

	$query2 = "SELECT * FROM user WHERE card_num = '$card_num'"; // SQL 쿼리문

	$result2 = mysqli_query($conn, $query2);



	if( !$result2 ) {
		echo "Failed to list query nfc_check_ajax2.php";
		$isSuccess = FALSE;
	}


	// echo $result2->num_rows."DDD";
	// exit;

	$boardList = array();


	if ( $result2->num_rows == 0 ) //회원 정보가 없을때
	{
		//user seq가 -1이면 회원이 없음
		$board['user_seq'] = -1;
		array_push($boardList, $board);
	}else{ //회원정보가 존재할때 


		while( $row = mysqli_fetch_array($result2) ) {
			$board['user_seq'] = $row['seq'];
			$board['user_card_num'] = $row['card_num'];
			$board['user_name'] = $row['name'];
			$board['user_sex'] = $row['sex'];
			$board['user_age'] = $row['age'];
			$board['user_area'] = $row['area'];
			$board['user_point'] = $row['point'];
			$board['user_since'] = $row['since'];

			array_push($boardList, $board);

		}
	}


}



//반환값 보내주기
if($board['seq']) {

	echo json_encode($boardList);
} else {
	$boardList1 = array();
	$board1['seq'] = -1;
	array_push($boardList1, $board1);
	echo json_encode($boardList1);
}





?>