<?php

	include "dbcon.php";


	
	$stamp = mktime();
	$get_date = date('Y-m-d H:i:s', $stamp);

	$get_user_id = $_POST['id'];



	if( $get_user_id )
	{


		$query = "INSERT INTO tag_value(card_num, date_) VALUES ('$get_user_id', '$get_date')"; // SQL 쿼리문
		$result = mysqli_query($conn, $query);


		if ( $result )
		{
			echo 1;
		}else{
			echo 2;
		}
		

	}else{ //get으로 들어온 값이 없을때

		echo 0;

	}
	

?>

		