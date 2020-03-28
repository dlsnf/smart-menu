<?php
	include "dbcon.php";
	// echo date("Y-m-d h:i:sa");
	$query = "SELECT * FROM menu WHERE 1"; // SQL 쿼리문
	$result = mysqli_query($conn, $query);
	//mysqli_close($conn);
	if( !$result ) {
		echo "Failed to list query index";
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
    $n=-1;
    $query2="SELECT category FROM menu WHERE seq=(SELECT menu_seq FROM sale WHERE user_seq=$n GROUP BY menu_seq ORDER BY count(*) DESC LIMIT 1) GROUP BY category ";
    $result2=mysqli_query($conn, $query2);
    $c=array();
    while( $rcmd = mysqli_fetch_array($result2)){
        $c[0]=$rcmd['category'];
        array_push($c, $rcmd);
    }
    echo $c[0];
	// foreach($boardList as $board) {
	// 	echo $board['seq']; 
	// }
	$query3="SELECT dessert_seq FROM sale_set WHERE menu_category like concat('americano') ORDER BY count DESC LIMIT 1";
	$result3=mysqli_query($conn,$query3);
	$d=array();
	while( $rcmd2 = mysqli_fetch_array($result3)){
        $d[0]=$rcmd2['dessert_seq'];
        array_push($d, $rcmd2);
    }
	echo $d[0];
	$count = 0;
?>
<!DOCTYPE html>
	<head>
	    <meta charset="UTF-8">
		<title>weather</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</head>
	<script>
	        console.log("start");
	        function weather()
			{
				var apiURI = "http://api.openweathermap.org/data/2.5/weather?q=Seoul,kr&appid=25ba2ba81a21ec5127b785492c1b737c";
				$.ajax({
					url: apiURI,
					dataType: "json",
					type: "GET",
					async: "false",
					success: function(resp) {			
						var imgURL = "http://openweathermap.org/img/w/"+resp.weather[0].icon+".png";
						$('.bd img').attr("src",imgURL);
					}
				});
			}
			weather();
	</script>
	<body class="bd">
        <img src="http://openweathermap.org/img/w/10d.png"/>
	</body>
</html>
		