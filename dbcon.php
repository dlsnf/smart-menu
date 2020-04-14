<?php

//header ("Content-Type : text/html; charset=utf-8");





$mysql_host = "localhost";
$mysql_user="root";
$mysql_password="";
$mysql_db = "smart_menu";


$isSuccess = TRUE;


$conn=mysqli_connect($mysql_host, $mysql_user, $mysql_password);


if( !$conn ) {
  echo "Failed to mysql_connect ";
 $isSuccess = FALSE;
}else{
  //echo "성공";
}


mysqli_select_db ( $conn , $mysql_db );


mysqli_set_charset($conn, 'utf8'); //한글깨짐 해결하기



// db 연결부분
// $mysql_host = "localhost";
// $mysql_user = "root";
// $mysql_password = "root";
// $mysql_db = "smart_menu";

// $isSuccess = TRUE;

// // $encrypted = encrypt("value", "dlsnf");

// // $mysql_password = decrypt($mysql_password, "dlsnf");

// $conn = @mysql_connect($mysql_host, $mysql_user, $mysql_password);

// if( !$conn ) {
// 	echo "Failed to mysql_connect ";
// 	$isSuccess = FALSE;
// }else{
// 	//echo "성공";
// }
// mysql_select_db( , );



// mysql_query("set session character_set_connection=utf8;");
// mysql_query("set session character_set_results=utf8;");
// mysql_query("set session character_set_client=utf8;");

/*

function encrypt($string, $key) {
  $result = '';
  for($i=0; $i<strlen($string); $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)+ord($keychar));
    $result.=$char;
  }
  return base64_encode($result);
}
function decrypt($string, $key) {
  $result = '';
  $string = base64_decode($string);
  for($i=0; $i<strlen($string); $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)-ord($keychar));
    $result.=$char;
  }
  return $result;
}
*/

// mysql_close();


?>
