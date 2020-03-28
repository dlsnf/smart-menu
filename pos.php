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


	// foreach($boardList as $board) {

	// 	echo $board['seq']; 

	// }
	

?>


<!DOCTYPE html>
	<head>
		<title>스마트 메뉴판 - 포스기</title>

		<?php
			include "head_common.php";

			include "jquery_pos.php";
		?>


		<link rel="stylesheet" href="css/style_pos.css?<?=filemtime('css/style_pos.css')?>">



	</head>
	<body class="bd">
	
		<div class="all_wrap">

			<div class="content">

				<div class="step step_11 detect">

					<div class="content_center">

						<span class="text_top_low_low font_oswald_regular">스마트 메뉴판 - 포스기</span><br>



						<div class="pos">

							<ul class="pos_ul">

								<li class="pos_ul_li pos_ul_li_left">
									<span class="text_middle_low font_oswald_regular">메뉴</span><br>
									<ul class="menu_ul">

										<?php
										foreach($boardList as $board) {

											$menu_image_num = $board['seq'];
											switch($menu_image_num){
												case 1 : $menu_image = "americano_hot"; break;
												case 2 : $menu_image = "americano_ice"; break;
												case 3 : $menu_image = "cafelatte"; break;
												case 4 : $menu_image = "cafemoca"; break;
												case 5 : $menu_image = "greentea"; break;
												case 6 : $menu_image = "redtea"; break;
												case 7 : $menu_image = "cheesecake"; break;
												case 8 : $menu_image = "honeybread"; break;
												case 9 : $menu_image = "waffle"; break;
												case 10 : $menu_image = "st_yo"; break;
												case 11 : $menu_image = "st_smoo"; break;
												case 12 : $menu_image = "st_cake"; break;
												default : $menu_image = "americano_hot"; break;
											}

										?>

										<li value="<?=$board['seq']?>" onclick="menu_click(this);">
											<div class="menu_div">
												<img src="images/<?=$menu_image?>.png" width="100%">
												<span class="text_middle_low font_oswald_regular"><?=$board['name']?></span><br>
												<span class="text_middle_low font_oswald_regular"><?=number_format($board['price'])?>원</span>
											</div>
										</li>

										<?php
										}
										?>

										<!-- <li value="1" onclick="menu_click(this);">
											<div class="menu_div">
												<img src="images/americano_hot.png" width="100%">
												<span class="text_middle_low font_oswald_regular">아메리카노(핫)</span><br>
												<span class="text_middle_low font_oswald_regular">4,000원</span>
											</div>
										</li>

										<li value="2" onclick="menu_click(this);">
											<div class="menu_div">
												<img src="images/americano_ice.png" width="100%">
												<span class="text_middle_low font_oswald_regular">아메리카노(아이스)</span><br>
												<span class="text_middle_low font_oswald_regular">4,500원</span>
											</div>
										</li>
										<li value="3" onclick="menu_click(this);">
											<div class="menu_div">
												<img src="images/cafelatte.png" width="100%">
												<span class="text_middle_low font_oswald_regular">카페라떼</span><br>
												<span class="text_middle_low font_oswald_regular">5,000원</span>
											</div>
										</li>
										<li value="4" onclick="menu_click(this);">
											<div class="menu_div">
												<img src="images/cafemoca.png" width="100%">
												<span class="text_middle_low font_oswald_regular">카페모카</span><br>
												<span class="text_middle_low font_oswald_regular">5,500원</span>
											</div>
										</li>
										<li value="5" onclick="menu_click(this);">
											<div class="menu_div">
												<img src="images/greentea.png" width="100%">
												<span class="text_middle_low font_oswald_regular">녹차</span><br>
												<span class="text_middle_low font_oswald_regular">4,500원</span>
											</div>
										</li>
										<li value="6" onclick="menu_click(this);">
											<div class="menu_div">
												<img src="images/redtea.png" width="100%">
												<span class="text_middle_low font_oswald_regular">홍차</span><br>
												<span class="text_middle_low font_oswald_regular">4,500원</span>
											</div>
										</li>
										<li value="7" onclick="menu_click(this);">
											<div class="menu_div">
												<img src="images/cheesecake.png" width="100%">
												<span class="text_middle_low font_oswald_regular">치즈케이크</span><br>
												<span class="text_middle_low font_oswald_regular">6,000원</span>
											</div>
										</li>
										<li value="8" onclick="menu_click(this);">
											<div class="menu_div">
												<img src="images/honeybread.png" width="100%">
												<span class="text_middle_low font_oswald_regular">허니브레드</span><br>
												<span class="text_middle_low font_oswald_regular">6,000원</span>
											</div>
										</li>
										<li value="9" onclick="menu_click(this);">
											<div class="menu_div">
												<img src="images/waffle.png" width="100%">
												<span class="text_middle_low font_oswald_regular">와플</span><br>
												<span class="text_middle_low font_oswald_regular">6,000원</span>
											</div>
										</li>
										<li value="10" onclick="menu_click(this);">
											<div class="menu_div">
												<img src="images/st_yo.png" width="100%">
												<span class="text_middle_low font_oswald_regular">딸기요거트</span><br>
												<span class="text_middle_low font_oswald_regular">6,000원</span>
											</div>
										</li>
										<li value="11" onclick="menu_click(this);">
											<div class="menu_div">
												<img src="images/st_smoo.png" width="100%">
												<span class="text_middle_low font_oswald_regular">딸기스무디</span><br>
												<span class="text_middle_low font_oswald_regular">6,000원</span>
											</div>
										</li>
										<li value="12" onclick="menu_click(this);">
											<div class="menu_div">
												<img src="images/st_cake.png" width="100%">
												<span class="text_middle_low font_oswald_regular">딸기케이크</span><br>
												<span class="text_middle_low font_oswald_regular">6,000원</span>
											</div>
										</li> -->

									</ul>
								</li>


								<li class="pos_ul_li pos_ul_li_right">
									
									<div class="order_sale">
										<span class="text_middle_low font_oswald_regular">장바구니</span><br>

										<div class="order_sale_table">
											<ul>
												<li>Num.</li>
												<li>메뉴명</li>
												<li>가격</li>
											</ul>
											
										</div>

										<div class="sale_list">
											<div class="sale_list_div">

												<div class="sale_list_table">
													<!-- <ul class='item' value="1">
														<li>1</li>
														<li>아메리카노(핫)</li>
														<li>4,000원</li>
													</ul> -->
												</div>

<!-- 
												<div class='item' value="1">01. 아메리카노(핫) 4,000원</div>
												<div class='item' value="2">02. 아메리카노(아이스) 4,000원</div> -->
											</div>
										</div>
									</div><!-- order_sale -->

									<div class="order_sale_confirm">

										<div class="final_price">

											<span class="text_top_low_low font_oswald_regular final_price_span">최종 가격 : 0원</span>
											
										</div>

									</div><!-- order_sale_confirm -->

									

									<div class="button">
										<button class="btn_reset btn_div" onclick="order_clear();"><span class="text_top_low_low font_oswald_regular">장바구니 초기화</span></button>

										<button class="btn_sale btn_div" onclick="sale_insert();"><span class="text_top_low_low font_oswald_regular">주문완료</span></button>

										<button class="btn_sale btn_div" onclick="user_info_init();"><span class="text_top_low_low font_oswald_regular">회원 초기화</span></button>

										<button onclick="array_check();" style="display:none;">check</button>
									</div>

									<div class="user_info">
										<span class="user_info_span text_top_low_low_low font_oswald_regular user_info_display">회원 정보 : </span><br>
										<span class="user_info_span text_top_low_low_low font_oswald_regular user_card_num_display">카드 번호 : </span><br>
										<span class="user_info_span text_middle font_oswald_regular user_card_num_check_date"></span>
									</div><!-- user_info -->

								</li>



							</ul>

						</div><!-- pos -->






					</div>


				</div><!-- step_1 -->


			</div>


		</div><!-- all_wrap -->







	</body>
</html>
		