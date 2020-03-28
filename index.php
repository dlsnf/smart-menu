<?php



// echo $_SERVER['REMOTE_ADDR'];
	// include "common.php";

	// include "admin/dbcon.php";

	// $query="SELECT * FROM portfolio ORDER BY seq DESC"; // SQL 쿼리문
	
	// $result=mysql_query($query, $conn);  // 쿼리문을 실행 결과

	// if( !$result ) {
	// 	echo "Failed to list query index";
	// 	$isSuccess = FALSE;
	// }

	// $boardList = array();

	// while( $row = mysql_fetch_array($result) ) {
	// 	$board['seq'] = $row['seq'];
	// 	$board['photo'] = $row['photo'];	
	// 	$board['title'] = strip_tags($row['title']);
	// 	$board['body'] = nl2br(strip_tags($row['body']));
	// 	$board['date_'] = $row['date_'];

	// 	array_push($boardList, $board);
	// }



?>
<!DOCTYPE html>
	<head>
		<title>스마트 메뉴판</title>

		<?php
			include "head_common.php";

			include "jquery.php";
		?>



	</head>
	<body class="bd">
	
		<div class="all_wrap">

			<div class="black_bg"></div>

			<?php
				//include "menu2.php";
			?>


			<div class="menu_controller">
				<ul>
					<li onclick="scroll_move(0);"><span class="font_oswald_bold text_middle_low">Top</span></li>
					<li onclick="scroll_move(menu[1]);"><span class="font_oswald_bold text_middle_low">전체</span></li>
					<li onclick="scroll_move(menu[2]);"><span class="font_oswald_bold text_middle_low">아메</span></li>
					<li onclick="scroll_move(menu[3]);"><span class="font_oswald_bold text_middle_low">라떼</span></li>
					<li onclick="scroll_move(menu[4]);"><span class="font_oswald_bold text_middle_low">TEA</span></li>
					<li onclick="scroll_move(menu[5]);"><span class="font_oswald_bold text_middle_low">디저트</span></li>
					<li onclick="scroll_move(menu[6]);"><span class="font_oswald_bold text_middle_low">딸기</span></li>
				</ul>
			</div>


			<div class="main_video">

				<div class="video_div">
					<div class="black_back"></div>

					<video autoplay="" playsinline="" muted="" loop="" id="video-background">
					  <source src="videos/all_fit_size.mp4" type="video/mp4">
					  <track src="videos/all_fit_size.vtt" kind="captions" srclang="en" label="captions">
					  <track src="videos/all_fit_size.vtt" kind="descriptions" srclang="en" label="captions">
					</video>
				</div>

			</div><!-- main_video -->




			<div class="content">

				<div class="step step_1 detect">

					<div class="content_center">
						<div class="today_temp">
							<span class="user_info_span text_big font_oswald_regular text_white text_shadow2"></span>
						</div>
						<span class="font_oswald_bold text_big2 text_white text_shadow2">스마트 메뉴판</span>

						<div class="user_info" style="margin-top:160px">
							<span class="user_info_span text_top font_oswald_regular text_white user_info_display text_shadow2"></span><br>
							<span class="user_info_span text_big22 font_oswald_regular text_white user_menu_gogo text_shadow2"></span><br><br><br><br><br>
							<span class="user_info_span text_middle font_oswald_regular text_white user_card_num_display text_shadow2"></span><br>
							<span class="user_info_span text_middle font_oswald_regular text_white user_card_num_check_date"></span>
						</div><!-- user_info -->

					</div>

				</div><!-- step_1 -->



				<div class="step step_2 detect">

					<div class="content_center">

						<div class="step_menu_div">
							<span class="font_oswald_bold text_top_low2 step_menu_title text_white text_shadow2">1. 전체 메뉴판</span>
							<div class="all_menu_div">
								<ul class="all_menu_div_ul">
									<li class="all_menu_div_ul_li">
										<div class="all_menu_div_ul_li_div">
											<img src="images/menu_origin/americano_hot.png" height="30%"><br><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">아메리카노(핫)</span><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">4,000원</span>
										</div>
									</li>
									<li class="all_menu_div_ul_li">
										<div class="all_menu_div_ul_li_div">
											<img src="images/menu_origin/americano_ice.png" height="22%"><br><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">아메리카노(아이스)</span><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">4,500원</span>
										</div>
									</li>
									<li class="all_menu_div_ul_li">
										<div class="all_menu_div_ul_li_div">
											<img src="images/menu_origin/cafelatte.png" height="22%"><br><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">카페라떼</span><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">5,000원</span>
										</div>
									</li>
									<li class="all_menu_div_ul_li">
										<div class="all_menu_div_ul_li_div">
											<img src="images/menu_origin/cafemoca.png" height="22%"><br><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">카페모카</span><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">5,500원</span>
										</div>
									</li>
									<li class="all_menu_div_ul_li">
										<div class="all_menu_div_ul_li_div">
											<img src="images/menu_origin/greentea.png" height="33%"><br><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">녹차</span><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">4,500원</span>
										</div>
									</li>
									<li class="all_menu_div_ul_li">
										<div class="all_menu_div_ul_li_div">
											<img src="images/menu_origin/redtea.png" height="60%"><br><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">홍차</span><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">4,500원</span>
										</div>
									</li>
									<li class="all_menu_div_ul_li">
										<div class="all_menu_div_ul_li_div">
											<img src="images/menu_origin/cheesecake.png" height="23%"><br><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">치즈케이크</span><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">6,000원</span>
										</div>
									</li>
									<li class="all_menu_div_ul_li">
										<div class="all_menu_div_ul_li_div">
											<img src="images/menu_origin/honeybread.png" height="30%"><br><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">허니브레드</span><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">6,000원</span>
										</div>
									</li>
									<li class="all_menu_div_ul_li">
										<div class="all_menu_div_ul_li_div">
											<img src="images/menu_origin/waffle.png" height="30%"><br><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">와플</span><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">6,000원</span>
										</div>
									</li>
									<li class="all_menu_div_ul_li">
										<div class="all_menu_div_ul_li_div">
											<img src="images/menu_origin/st_yo.png" height="45%"><br><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">딸기요거트</span><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">6,000원</span>
										</div>
									</li>
									<li class="all_menu_div_ul_li">
										<div class="all_menu_div_ul_li_div">
											<img src="images/menu_origin/st_smoo.png" height="30%"><br><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">딸기스무디</span><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">6,000원</span>
										</div>
									</li>
									<li class="all_menu_div_ul_li">
										<div class="all_menu_div_ul_li_div">
											<img src="images/menu_origin/st_cake.png" height="35%"><br><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">딸기케이크</span><br>
											<span class="text_middle_low font_oswald_regular text_white text_shadow2">6,000원</span>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>


				</div> <!-- step_2 -->

				<div class="step step_3">

					<div class="content_center">
						
						

						<div class="step_menu_div">
							<span class="font_oswald_bold text_top_low2 step_menu_title text_white text_shadow2">2. 메뉴추천 - 아메리카노</span>

							<ul class="step_menu_ul">
								<li class="step_menu_ul_li">

									<span class="font_oswald_regular text_top_low_low_low underline_white step_menu_subtitle text_white text_shadow2">- 메뉴추천</span>
									<ul class="step_menu_two_ul">
										<li class="step_menu_two_ul_li">
											<div class="step_menu_two_ul_li_menu_div">
												<img src="images/menu_origin/americano_hot.png" width="70%"><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_title text_shadow2">아메리카노(핫)</span><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_price text_shadow2">4,000원</span>
											</div>
										</li>
										<li class="step_menu_two_ul_li">
											<div class="step_menu_two_ul_li_menu_div">
												<img src="images/menu_origin/americano_ice.png" width="66%"><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_title text_shadow2">아메리카노(아이스)</span><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_price text_shadow2">4,500원</span>
											</div>
										</li>
									</ul>

								</li>

								<li class="step_menu_ul_li">
									<span class="font_oswald_regular text_top_low_low_low underline_white step_menu_subtitle text_white text_shadow2">- SET 메뉴추천</span>
									<ul class="step_menu_two_ul">
										<li class="step_menu_two_ul_li" style="width:100%">
											<div class="step_menu_two_ul_li_menu_div set_menu_right_div">
												<img class="set_dessert_img" src="images/menu_origin/cheesecake.png" width="80%"><br>
												<span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_title text_white dessert_menu_title text_shadow2 set_menu_right_div_title">치즈케이크</span><br><br><span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_title text_white dessert_menu_title text_shadow2">음료랑 같이 주문시 할인!</span><br>
												<span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_price text_white dessert_menu_price_origin text_shadow2">6,000원</span><span class="font_oswald_regular text_top step_menu_two_ul_li_menu_div_price text_white dessert_menu_price_discount text_shadow2 text_red2">&nbsp;&nbsp;->&nbsp;&nbsp;5,000원</span>
											</div>
										</li>
									</ul>
								</li>
							</ul>

						</div><!-- step_menu_div -->
					</div>


				</div> <!-- step_3 -->

				<div class="step step_4">

	

					<div class="content_center">

						<div class="step_menu_div">
							<span class="font_oswald_bold text_top_low2 step_menu_title text_white text_shadow2">3. 메뉴추천 - 라떼</span>

							<ul class="step_menu_ul">
								<li class="step_menu_ul_li">

									<span class="font_oswald_regular text_top_low_low_low underline_white step_menu_subtitle text_white text_shadow2">- 메뉴추천</span>
									<ul class="step_menu_two_ul">
										<li class="step_menu_two_ul_li">
											<div class="step_menu_two_ul_li_menu_div">
												<img src="images/menu_origin/cafelatte.png" width="70%"><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_title text_shadow2">카페라떼</span><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_price text_shadow2">5,000원</span>
											</div>
										</li>
										<li class="step_menu_two_ul_li">
											<div class="step_menu_two_ul_li_menu_div">
												<img src="images/menu_origin/cafemoca.png" width="66%"><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_title text_shadow2">카페모카</span><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_price text_shadow2">5,500원</span>
											</div>
										</li>
									</ul>

								</li>

								<li class="step_menu_ul_li">
									<span class="font_oswald_regular text_top_low_low_low underline_white step_menu_subtitle text_white text_shadow2">- SET 메뉴추천</span>
									<ul class="step_menu_two_ul">
										<li class="step_menu_two_ul_li" style="width:100%">
											<div class="step_menu_two_ul_li_menu_div set_menu_right_div">
												<img class="set_dessert_img" src="images/menu_origin/cheesecake.png" width="80%"><br>
												<span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_title text_white dessert_menu_title text_shadow2 set_menu_right_div_title">치즈케이크</span><br><br><span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_title text_white dessert_menu_title text_shadow2">음료랑 같이 주문시 할인!</span><br>
												<span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_price text_white dessert_menu_price_origin text_shadow2">6,000원</span><span class="font_oswald_regular text_top step_menu_two_ul_li_menu_div_price text_white dessert_menu_price_discount text_shadow2 text_red2">&nbsp;&nbsp;->&nbsp;&nbsp;5,000원</span>
											</div>
										</li>
									</ul>
								</li>
							</ul>

						</div><!-- step_menu_div -->


					</div>


				</div> <!-- step_4 -->

				<div class="step step_5">

					<div class="content_center">

						<div class="step_menu_div">
							<span class="font_oswald_bold text_top_low2 step_menu_title text_white text_shadow2">4. 메뉴추천 - TEA</span>

							<ul class="step_menu_ul">
								<li class="step_menu_ul_li">

									<span class="font_oswald_regular text_top_low_low_low underline_white step_menu_subtitle text_white text_shadow2">- 메뉴추천</span>
									<ul class="step_menu_two_ul">
										<li class="step_menu_two_ul_li">
											<div class="step_menu_two_ul_li_menu_div">
												<img src="images/menu_origin/greentea.png" width="70%"><br><br><br><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_title text_shadow2">녹차</span><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_price text_shadow2">4,500원</span>
											</div>
										</li>
										<li class="step_menu_two_ul_li">
											<div class="step_menu_two_ul_li_menu_div">
												<img src="images/menu_origin/redtea.png" width="80%"><br><br><br><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_title text_shadow2">홍차</span><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_price text_shadow2">4,500원</span>
											</div>
										</li>
									</ul>

								</li>

								<li class="step_menu_ul_li">
									<span class="font_oswald_regular text_top_low_low_low underline_white step_menu_subtitle text_white text_shadow2">- SET 메뉴추천</span>
									<ul class="step_menu_two_ul">
										<li class="step_menu_two_ul_li" style="width:100%">
											<div class="step_menu_two_ul_li_menu_div set_menu_right_div">
												<img class="set_dessert_img" src="images/menu_origin/cheesecake.png" width="80%"><br>
												<span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_title text_white dessert_menu_title text_shadow2 set_menu_right_div_title">치즈케이크</span><br><br><span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_title text_white dessert_menu_title text_shadow2">음료랑 같이 주문시 할인!</span><br>
												<span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_price text_white dessert_menu_price_origin text_shadow2">6,000원</span><span class="font_oswald_regular text_top step_menu_two_ul_li_menu_div_price text_white dessert_menu_price_discount text_shadow2 text_red2">&nbsp;&nbsp;->&nbsp;&nbsp;5,000원</span>
											</div>
										</li>
									</ul>
								</li>
							</ul>

						</div><!-- step_menu_div -->


					</div>
					
				</div>

				<div class="step step_6">

					<div class="content_center">
						
						<div class="step_menu_div">
							<span class="font_oswald_bold text_top_low2 step_menu_title text_white text_shadow2">5. 메뉴추천 - 디저트</span>

							<ul class="step_menu_ul">
								<li class="step_menu_ul_li">

									<span class="font_oswald_regular text_top_low_low_low underline_white step_menu_subtitle text_white text_shadow2">- 메뉴추천</span>
									<ul class="step_menu_two_ul">
										<li class="step_menu_two_ul_li">
											<div class="step_menu_two_ul_li_menu_div" style="vertical-align: middle;padding-bottom: 0px;">
												<img src="images/menu_origin/cheesecake.png" width="80%"><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_title text_shadow2">치즈케이크</span><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_price text_shadow2">6,000원</span>
											</div>
										</li>
										<li class="step_menu_two_ul_li">
											<ul class="step_menu_two_ul_li_ul">
												<li class="step_menu_two_ul_li_ul_li">
													<div class="step_menu_two_ul_li_ul_li_menu_div" style="margin-top:50px;">
														<img src="images/menu_origin/honeybread.png" width="45%"><br>
														<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_title text_shadow2">허니브레드</span><br>
														<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_price text_shadow2">6,000원</span>
													</div>
												</li>
												<li class="step_menu_two_ul_li_ul_li">
													<div class="step_menu_two_ul_li_ul_li_menu_div" style="margin-top:50px;">
														<img src="images/menu_origin/waffle.png" width="40%"><br>
														<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_title text_shadow2">와플</span><br>
														<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_price text_shadow2">6,000원</span>
													</div>
												</li>
											</ul>
										</li>
									</ul>

								</li>

								<li class="step_menu_ul_li">
									<span class="font_oswald_regular text_top_low_low_low underline_white step_menu_subtitle text_white text_shadow2">- SET 메뉴추천</span>
									<ul class="step_menu_two_ul">
										<li class="step_menu_two_ul_li" style="width:100%">
											<div class="step_menu_two_ul_li_menu_div set_menu_right_div">
												<img class="set_coffee_img" src="images/menu_origin/americano_ice.png" width="40%"><br>
												<span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_title text_white dessert_menu_title text_shadow2 set_menu_right_div_title">아메리카노(아이스)</span><br><br><span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_title text_white dessert_menu_title text_shadow2">디저트랑 같이 주문시 할인!</span><br>
												<span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_price text_white dessert_menu_price_origin text_shadow2">4,500원</span><span class="font_oswald_regular text_top step_menu_two_ul_li_menu_div_price text_white dessert_menu_price_discount text_shadow2 text_red2">&nbsp;&nbsp;->&nbsp;&nbsp;3,500원</span>
											</div>
										</li>
									</ul>
								</li>
							</ul>

						</div><!-- step_menu_div -->


					</div>
					
				</div>

				<div class="step step_7">

					<div class="content_center">

						<div class="step_menu_div">
							<span class="font_oswald_bold text_top_low2 step_menu_title text_white text_shadow2">6. 메뉴추천 - 딸기</span>

							<ul class="step_menu_ul">
								<li class="step_menu_ul_li">

									<span class="font_oswald_regular text_top_low_low_low underline_white step_menu_subtitle text_white text_shadow2">- 메뉴추천</span>
									<ul class="step_menu_two_ul">
										<li class="step_menu_two_ul_li">
											<div class="step_menu_two_ul_li_menu_div">
												<img src="images/menu_origin/st_yo.png" width="60%"><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_title text_shadow2">딸기요거트</span><br>
												<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_price text_shadow2">6,000원</span>
											</div>
										</li>
										<li class="step_menu_two_ul_li">
											<ul class="step_menu_two_ul_li_ul">
												<li class="step_menu_two_ul_li_ul_li">
													<div class="step_menu_two_ul_li_ul_li_menu_div">
														<img src="images/menu_origin/st_smoo.png" width="45%"><br>
														<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_title text_shadow2">딸기스무디</span><br>
														<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_price text_shadow2">6,000원</span>
													</div>
												</li>
												<li class="step_menu_two_ul_li_ul_li">
													<div class="step_menu_two_ul_li_ul_li_menu_div">
														<img src="images/menu_origin/st_cake.png" width="40%"><br>
														<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_title text_shadow2">딸기케이크</span><br>
														<span class="font_oswald_regular text_top_low_low text_white step_menu_two_ul_li_menu_div_price text_shadow2">6,000원</span>
													</div>
												</li>
											</ul>
										</li>
									</ul>

								</li>

								<li class="step_menu_ul_li">
									<span class="font_oswald_regular text_top_low_low_low underline_white step_menu_subtitle text_white text_shadow2">- SET 메뉴추천</span>
									<ul class="step_menu_two_ul">
										<li class="step_menu_two_ul_li" style="width:100%">
											<div class="step_menu_two_ul_li_menu_div set_menu_right_div">
												<img class="set_dessert_img" src="images/menu_origin/cheesecake.png" width="80%"><br>
												<span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_title text_white dessert_menu_title text_shadow2 set_menu_right_div_title">치즈케이크</span><br><br><span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_title text_white dessert_menu_title text_shadow2">음료랑 같이 주문시 할인!</span><br>
												<span class="font_oswald_regular text_top_low_low step_menu_two_ul_li_menu_div_price text_white dessert_menu_price_origin text_shadow2">6,000원</span><span class="font_oswald_regular text_top step_menu_two_ul_li_menu_div_price text_white dessert_menu_price_discount text_shadow2 text_red2">&nbsp;&nbsp;->&nbsp;&nbsp;5,000원</span>
											</div>
										</li>
									</ul>
								</li>
							</ul>

						</div><!-- step_menu_div -->


					</div>
					
				</div>






		</div><!-- all_wrap -->







	</body>
</html>
		