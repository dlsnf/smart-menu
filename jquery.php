<script>
			

			$(window).load(function(){


				//날씨 온도 초기화
				weather();


				//스텝 위치 초기화
				init_step_position();


				//NFC 태그 체크 함수 실행
				nfc_check();


				//SET 메뉴 초기화
				set_gogo("americano");
				set_gogo("latte");
				set_gogo("tea");
				set_gogo("dessert");
				set_gogo("berry");


				
				
			});



			var galleryTop;
			var galleryThumbs;

			//스텝 위치 초기화
			var el_step;
			var menu;
			$(window).ready(function(){

				//스텝 높이조절
				$(".step_1").css({'height':$(window).height()});
				$(".step_2").css({'height':$(window).height()});
				$(".step_3").css({'height':$(window).height()});
				$(".step_4").css({'height':$(window).height()});
				$(".step_5").css({'height':$(window).height()});
				$(".step_6").css({'height':$(window).height()});
				$(".step_7").css({'height':$(window).height()});





			});



			var today_temp = -99;

			//날씨 데이터 가져오기
			function weather()
			{
				var apiURI = "http://api.openweathermap.org/data/2.5/weather?q=Seoul,kr&appid=25ba2ba81a21ec5127b785492c1b737c";
				$.ajax({
					url: apiURI,
					dataType: "json",
					type: "GET",
					async: "false",
					success: function(resp) {
						console.log(resp);
						console.log("현재온도 : "+ (resp.main.temp- 273.15) );
						
						//현재 온도
						today_temp = Math.floor((resp.main.temp- 273.15));
						console.log(today_temp);


						console.log("현재습도 : "+ resp.main.humidity);
						console.log("날씨 : "+ resp.weather[0].main );
						console.log("상세날씨설명 : "+ resp.weather[0].description );
						console.log("날씨 이미지 : "+ resp.weather[0].icon );
						console.log("바람   : "+ resp.wind.speed );
						console.log("나라   : "+ resp.sys.country );
						console.log("도시이름  : "+ resp.name );
						console.log("구름  : "+ (resp.clouds.all) +"%" );



						var today_temp_text = today_temp + "˚C";

						$(".today_temp span").empty();
						$(".today_temp span").append(today_temp_text);

					
						setTimeout(function() {
							weather();
							console.log("날씨 값 reload");
						}, 30000);
						

					}
				});
	
			}





			//주문 내용에 대한 변수
			var sale_list_count = 0; //주문 수
			var order_array = new Array(); //장바구니 담아둔 값
			var sale_list_price = 0;


			//user 정보
			var user_card_num = "";
			var user_seq = -1;
			var user_name = "비회원";


			//NFC 읽어오기
			var nfc_read_interval;
			var nfc_read_bool = true;
			var nfc_date_ = "";

			function nfc_check(){

				if( nfc_read_bool )
				{

					//메뉴 seq를 가지고 정보 가져오기 ajax
					$.ajax({
					type:"POST",
					url:"nfc_check_ajax.php",
					dataType:"json",
					//traditional: true,
					//contentType: "application/x-www-form-urlencoded;charset=utf-8",
					success:function( data ){
						//alert(data[0].seq);

						
						if( data[0].seq != -1 ) //NFC조회가 되었을때
						{
							

							if( data[0].user_seq != -1 )//회원일때
							{
								console.log("회원 카드 번호 : " + data[0].card_num);
								console.log(data[0].user_name + "님 환영합니다!"); //회원 이름 노출
								console.log("user seq : " + data[0].user_seq);


								user_card_num = data[0].card_num;
								user_seq = data[0].user_seq;
								user_name = data[0].user_name;

							}else{//비회원일때
								console.log("비회원 카드 번호 : " + data[0].card_num);
								console.log("비회원님 환영합니다!"); //회원 이름 노출


								user_card_num = data[0].card_num;
								user_seq = -1;
								user_name = "비회원";
							}

							nfc_date_ = data[0].date_;


							menu_gogo();


							setTimeout(function() {
								nfc_check();
							}, 3000);


						}else{ //반환값이 -1이면 조회가 안된것!
							
							setTimeout(function() {
								nfc_check();
							  	console.log("NFC 태그 값 없음! 반복!");
							}, 300);

						}

						user_info_update();


					},
					error:function(e){
							//alert("ajax 에러");
							alert( "ajax 에러 : " + e.responseText );
						}
					});

				}

			}

			function nfc_check_stop(){
				setTimeout(function() {
			        clearTimeout(nfc_read_interval);
			    },5000);
			}

			function user_info_update(){

				if( user_name != "비회원")
				{
					var user_info_display_text = '<span class="text_big3">' + user_name + '</span> 님 안녕하세요.';
					var user_card_num_display_text = '<span class="text_middle">'+user_card_num+'</span>';
					
				}else{
					
					if( user_card_num ) 
					{
						var user_info_display_text = "비회원";
					}else{
						var user_info_display_text = "";
					}

					var user_card_num_display_text = '<span class="text_middle">'+user_card_num+'</span>';

				}



				$(".user_info_display").empty();
				$(".user_card_num_display").empty();
				$(".user_card_num_check_date").empty();
				
				$(".user_info_display").append(user_info_display_text);
				$(".user_card_num_display").append(user_card_num_display_text);
				$(".user_card_num_check_date").append(nfc_date_);
				
			}


			function user_info_init(){
				user_name = "비회원";
				user_card_num = "";
				user_seq = -1;
				nfc_date_ = "";

				user_info_update();

			}




			function menu_gogo(){

				scroll_move(menu[0],500);


				//메뉴 추천 알고리즘 ajax
				$.ajax({
				type:"POST",
				url:"menu_gogo_ajax.php",
				data: {'user_card_num' : user_card_num, 'today_temp' : today_temp},
				dataType:"json",
				//traditional: true,
				//contentType: "application/x-www-form-urlencoded;charset=utf-8",
				success:function( data ){
					//alert(data[0].category);

					console.log("메뉴추천 : "+data[0].category);

					menu_gogo_text(data[0].category);

					setTimeout(function() {
						menu_gogo_move(data[0].category);
					}, 2000);
				

				},
				error:function(e){
						//alert("ajax 에러");
						alert( "ajax 에러 : " + e.responseText );
					}
				});



			}


			function menu_gogo_text(category){
	

				switch(category){
					case "americano" : var user_menu_gogo_text = "\"아메리카노 어떠세요?\"";
						break;
					case "latte" : var user_menu_gogo_text = "\"라떼 어떠세요?\"";
						break;
					case "tea" : var user_menu_gogo_text = "\"Tea 어떠세요?\"";
						break;
					case "dessert" : var user_menu_gogo_text = "\"디저트 어떠세요?\"";
						break;
					case "berry" : var user_menu_gogo_text = "\"딸기메뉴 어떠세요?\"";
						break;

					default: var user_menu_gogo_text = "\"전체 메뉴판 보여드릴께요\"";
						break;
				}


				$(".user_menu_gogo").empty();
				$(".user_menu_gogo").append(user_menu_gogo_text);


			}


			function menu_gogo_move(category){

				//alert(category);


				switch(category){
					case "americano" : scroll_move(menu[2]);
						break;
					case "latte" : scroll_move(menu[3]);
						break;
					case "tea" : scroll_move(menu[4]);
						break;
					case "dessert" : scroll_move(menu[5]);
						break;
					case "berry" : scroll_move(menu[6]);
						break;

					default: scroll_move(menu[1]);
						break;
				}

			}









			//SET
			function set_gogo(category){

				var get_category = category;

				//메뉴 추천 알고리즘 ajax
				$.ajax({
				type:"POST",
				url:"set_gogo_ajax.php",
				data: {'category' : category},
				dataType:"json",
				//traditional: true,
				//contentType: "application/x-www-form-urlencoded;charset=utf-8",
				success:function( data ){
					//alert(data[0].category);

					

					if( data.length == 1) //셋트추천이 음료일때
					{
						set_gogo_update(category, data[0].dessert_seq);
					}else{//셋트 추천이 디저트 일	

						//0에서 3까지 랜덤
						var ran_val = Math.round( Math.random()*3 );
						//4가지 음료 중 랜덤 한가지 출력
						set_gogo_update(category, data[ran_val].seq);

					}


				},
				error:function(e){
						//alert("ajax 에러");
						alert( "ajax 에러 : " + e.responseText );
					}
				});

			}


			function set_gogo_update(category, dessert_seq){

				/*
					category
					americano : step_3
					latte : step_4
					tea : step_5
					dessert : step_6
					berry : step_7


					dessert_seq
					7 : 치즈케이크
					8 : 허니브레드
					9 : 와플
				*/


				if( category == "americano")
				{

					switch(dessert_seq){
						case "7" : 
							$.ajax({
								type:"POST",
								url:"menu_select_ajax.php",
								data:"seq="+7,
								dataType:"json",
								//traditional: true,
								//contentType: "application/x-www-form-urlencoded;charset=utf-8",
								success:function( data ){


									$(".step_3 .set_menu_right_div .set_dessert_img").attr("src", "images/menu_origin/cheesecake.png");
									

									$(".step_3 .set_menu_right_div .set_menu_right_div_title").empty();
									$(".step_3 .set_menu_right_div .set_menu_right_div_title").append(data[0].name);

									$(".step_3 .set_menu_right_div .dessert_menu_price_origin").empty();
									$(".step_3 .set_menu_right_div .dessert_menu_price_origin").append(Number(data[0].price) + "원");

									$(".step_3 .set_menu_right_div .dessert_menu_price_discount").empty();
									$(".step_3 .set_menu_right_div .dessert_menu_price_discount").append("&nbsp;&nbsp;->&nbsp;&nbsp;" + Number(data[0].price - 1000) + "원");

								},
								error:function(e){
										alert("ajax 에러");
										//alert( e.responseText );
									}
								});


							break;
						case "8" : 

							$.ajax({
							type:"POST",
							url:"menu_select_ajax.php",
							data:"seq="+8,
							dataType:"json",
							//traditional: true,
							//contentType: "application/x-www-form-urlencoded;charset=utf-8",
							success:function( data ){


								$(".step_3 .set_menu_right_div .set_dessert_img").attr("src", "images/menu_origin/honeybread.png");
								

								$(".step_3 .set_menu_right_div .set_menu_right_div_title").empty();
								$(".step_3 .set_menu_right_div .set_menu_right_div_title").append(data[0].name);

								$(".step_3 .set_menu_right_div .dessert_menu_price_origin").empty();
								$(".step_3 .set_menu_right_div .dessert_menu_price_origin").append(Number(data[0].price) + "원");

								$(".step_3 .set_menu_right_div .dessert_menu_price_discount").empty();
								$(".step_3 .set_menu_right_div .dessert_menu_price_discount").append("&nbsp;&nbsp;->&nbsp;&nbsp;" + Number(data[0].price - 1000) + "원");

							},
							error:function(e){
									alert("ajax 에러");
									//alert( e.responseText );
								}
							});

							break;
						case "9" : 

							$.ajax({
								type:"POST",
								url:"menu_select_ajax.php",
								data:"seq="+9,
								dataType:"json",
								//traditional: true,
								//contentType: "application/x-www-form-urlencoded;charset=utf-8",
								success:function( data ){


									$(".step_3 .set_menu_right_div .set_dessert_img").attr("src", "images/menu_origin/waffle.png");
									

									$(".step_3 .set_menu_right_div .set_menu_right_div_title").empty();
									$(".step_3 .set_menu_right_div .set_menu_right_div_title").append(data[0].name);

									$(".step_3 .set_menu_right_div .dessert_menu_price_origin").empty();
									$(".step_3 .set_menu_right_div .dessert_menu_price_origin").append(Number(data[0].price) + "원");

									$(".step_3 .set_menu_right_div .dessert_menu_price_discount").empty();
									$(".step_3 .set_menu_right_div .dessert_menu_price_discount").append("&nbsp;&nbsp;->&nbsp;&nbsp;" + Number(data[0].price - 1000) + "원");

								},
								error:function(e){
										alert("ajax 에러");
										//alert( e.responseText );
									}
								});

							break;
						default: 
							break;
					}


				}else if( category == "latte")
				{


					switch(dessert_seq){
						case "7" : 
							$.ajax({
								type:"POST",
								url:"menu_select_ajax.php",
								data:"seq="+7,
								dataType:"json",
								//traditional: true,
								//contentType: "application/x-www-form-urlencoded;charset=utf-8",
								success:function( data ){


									$(".step_4 .set_menu_right_div .set_dessert_img").attr("src", "images/menu_origin/cheesecake.png");
									

									$(".step_4 .set_menu_right_div .set_menu_right_div_title").empty();
									$(".step_4 .set_menu_right_div .set_menu_right_div_title").append(data[0].name);

									$(".step_4 .set_menu_right_div .dessert_menu_price_origin").empty();
									$(".step_4 .set_menu_right_div .dessert_menu_price_origin").append(Number(data[0].price) + "원");

									$(".step_4 .set_menu_right_div .dessert_menu_price_discount").empty();
									$(".step_4 .set_menu_right_div .dessert_menu_price_discount").append("&nbsp;&nbsp;->&nbsp;&nbsp;" + Number(data[0].price - 1000) + "원");

								},
								error:function(e){
										alert("ajax 에러");
										//alert( e.responseText );
									}
								});


							break;
						case "8" : 

							$.ajax({
							type:"POST",
							url:"menu_select_ajax.php",
							data:"seq="+8,
							dataType:"json",
							//traditional: true,
							//contentType: "application/x-www-form-urlencoded;charset=utf-8",
							success:function( data ){


								$(".step_4 .set_menu_right_div .set_dessert_img").attr("src", "images/menu_origin/honeybread.png");
								

								$(".step_4 .set_menu_right_div .set_menu_right_div_title").empty();
								$(".step_4 .set_menu_right_div .set_menu_right_div_title").append(data[0].name);

								$(".step_4 .set_menu_right_div .dessert_menu_price_origin").empty();
								$(".step_4 .set_menu_right_div .dessert_menu_price_origin").append(Number(data[0].price) + "원");

								$(".step_4 .set_menu_right_div .dessert_menu_price_discount").empty();
								$(".step_4 .set_menu_right_div .dessert_menu_price_discount").append("&nbsp;&nbsp;->&nbsp;&nbsp;" + Number(data[0].price - 1000) + "원");

							},
							error:function(e){
									alert("ajax 에러");
									//alert( e.responseText );
								}
							});

							break;
						case "9" : 


							$.ajax({
								type:"POST",
								url:"menu_select_ajax.php",
								data:"seq="+9,
								dataType:"json",
								//traditional: true,
								//contentType: "application/x-www-form-urlencoded;charset=utf-8",
								success:function( data ){


									$(".step_4 .set_menu_right_div .set_dessert_img").attr("src", "images/menu_origin/waffle.png");
									

									$(".step_4 .set_menu_right_div .set_menu_right_div_title").empty();
									$(".step_4 .set_menu_right_div .set_menu_right_div_title").append(data[0].name);

									$(".step_4 .set_menu_right_div .dessert_menu_price_origin").empty();
									$(".step_4 .set_menu_right_div .dessert_menu_price_origin").append(Number(data[0].price) + "원");

									$(".step_4 .set_menu_right_div .dessert_menu_price_discount").empty();
									$(".step_4 .set_menu_right_div .dessert_menu_price_discount").append("&nbsp;&nbsp;->&nbsp;&nbsp;" + Number(data[0].price - 1000) + "원");

								},
								error:function(e){
										alert("ajax 에러");
										//alert( e.responseText );
									}
								});

							break;
						default: 
							break;
					}

				}else if( category == "tea")
				{

					switch(dessert_seq){
						case "7" : 
							$.ajax({
								type:"POST",
								url:"menu_select_ajax.php",
								data:"seq="+7,
								dataType:"json",
								//traditional: true,
								//contentType: "application/x-www-form-urlencoded;charset=utf-8",
								success:function( data ){


									$(".step_5 .set_menu_right_div .set_dessert_img").attr("src", "images/menu_origin/cheesecake.png");
									

									$(".step_5 .set_menu_right_div .set_menu_right_div_title").empty();
									$(".step_5 .set_menu_right_div .set_menu_right_div_title").append(data[0].name);

									$(".step_5 .set_menu_right_div .dessert_menu_price_origin").empty();
									$(".step_5 .set_menu_right_div .dessert_menu_price_origin").append(Number(data[0].price) + "원");

									$(".step_5 .set_menu_right_div .dessert_menu_price_discount").empty();
									$(".step_5 .set_menu_right_div .dessert_menu_price_discount").append("&nbsp;&nbsp;->&nbsp;&nbsp;" + Number(data[0].price - 1000) + "원");

								},
								error:function(e){
										alert("ajax 에러");
										//alert( e.responseText );
									}
								});


							break;
						case "8" : 

							$.ajax({
							type:"POST",
							url:"menu_select_ajax.php",
							data:"seq="+8,
							dataType:"json",
							//traditional: true,
							//contentType: "application/x-www-form-urlencoded;charset=utf-8",
							success:function( data ){


								$(".step_5 .set_menu_right_div .set_dessert_img").attr("src", "images/menu_origin/honeybread.png");
								

								$(".step_5 .set_menu_right_div .set_menu_right_div_title").empty();
								$(".step_5 .set_menu_right_div .set_menu_right_div_title").append(data[0].name);

								$(".step_5 .set_menu_right_div .dessert_menu_price_origin").empty();
								$(".step_5 .set_menu_right_div .dessert_menu_price_origin").append(Number(data[0].price) + "원");

								$(".step_5 .set_menu_right_div .dessert_menu_price_discount").empty();
								$(".step_5 .set_menu_right_div .dessert_menu_price_discount").append("&nbsp;&nbsp;->&nbsp;&nbsp;" + Number(data[0].price - 1000) + "원");

							},
							error:function(e){
									alert("ajax 에러");
									//alert( e.responseText );
								}
							});

							break;
						case "9" : 


							$.ajax({
								type:"POST",
								url:"menu_select_ajax.php",
								data:"seq="+9,
								dataType:"json",
								//traditional: true,
								//contentType: "application/x-www-form-urlencoded;charset=utf-8",
								success:function( data ){


									$(".step_5 .set_menu_right_div .set_dessert_img").attr("src", "images/menu_origin/waffle.png");
									

									$(".step_5 .set_menu_right_div .set_menu_right_div_title").empty();
									$(".step_5 .set_menu_right_div .set_menu_right_div_title").append(data[0].name);

									$(".step_5 .set_menu_right_div .dessert_menu_price_origin").empty();
									$(".step_5 .set_menu_right_div .dessert_menu_price_origin").append(Number(data[0].price) + "원");

									$(".step_5 .set_menu_right_div .dessert_menu_price_discount").empty();
									$(".step_5 .set_menu_right_div .dessert_menu_price_discount").append("&nbsp;&nbsp;->&nbsp;&nbsp;" + Number(data[0].price - 1000) + "원");

								},
								error:function(e){
										alert("ajax 에러");
										//alert( e.responseText );
									}
								});

							break;
						default: 
							break;
					}
					
				}else if( category == "dessert")
				{

					$.ajax({
						type:"POST",
						url:"menu_select_ajax.php",
						data:"seq="+dessert_seq,
						dataType:"json",
						//traditional: true,
						//contentType: "application/x-www-form-urlencoded;charset=utf-8",
						success:function( data ){




							var coffee_file_name = "";

							if( data[0].seq == 1 )
							{
								coffee_file_name = "americano_hot";

							}else if( data[0].seq == 2 )
							{
								coffee_file_name = "americano_ice";
							}else if( data[0].seq == 3 )
							{
								coffee_file_name = "cafelatte";
							}else if( data[0].seq == 4 )
							{
								coffee_file_name = "cafemoca";
							}else if( data[0].seq == 5 )
							{
								coffee_file_name = "greentea";
							}else if( data[0].seq == 6 )
							{
								coffee_file_name = "redtea";
							}else if( data[0].seq == 10 )
							{
								coffee_file_name = "st_yo";
							}else if( data[0].seq == 11 )
							{
								coffee_file_name = "st_smoo";
							}else if( data[0].seq == 12 )
							{
								coffee_file_name = "st_cake";
							}else{
								coffee_file_name = "americano_hot";
							}

							var file_url ="images/menu_origin/"+ coffee_file_name +".png"

							$(".step_6 .set_menu_right_div .set_coffee_img").attr("src", file_url);
							

							$(".step_6 .set_menu_right_div .set_menu_right_div_title").empty();
							$(".step_6 .set_menu_right_div .set_menu_right_div_title").append(data[0].name);

							$(".step_6 .set_menu_right_div .dessert_menu_price_origin").empty();
							$(".step_6 .set_menu_right_div .dessert_menu_price_origin").append(Number(data[0].price) + "원");

							$(".step_6 .set_menu_right_div .dessert_menu_price_discount").empty();
							$(".step_6 .set_menu_right_div .dessert_menu_price_discount").append("&nbsp;&nbsp;->&nbsp;&nbsp;" + Number(data[0].price - 1000) + "원");

						},
						error:function(e){
								alert("ajax 에러");
								//alert( e.responseText );
							}
						});


					
				}else if( category == "berry")
				{
					switch(dessert_seq){
						case "7" : 
							$.ajax({
								type:"POST",
								url:"menu_select_ajax.php",
								data:"seq="+7,
								dataType:"json",
								//traditional: true,
								//contentType: "application/x-www-form-urlencoded;charset=utf-8",
								success:function( data ){


									$(".step_7 .set_menu_right_div .set_dessert_img").attr("src", "images/menu_origin/cheesecake.png");
									

									$(".step_7 .set_menu_right_div .set_menu_right_div_title").empty();
									$(".step_7 .set_menu_right_div .set_menu_right_div_title").append(data[0].name);

									$(".step_7 .set_menu_right_div .dessert_menu_price_origin").empty();
									$(".step_7 .set_menu_right_div .dessert_menu_price_origin").append(Number(data[0].price) + "원");

									$(".step_7 .set_menu_right_div .dessert_menu_price_discount").empty();
									$(".step_7 .set_menu_right_div .dessert_menu_price_discount").append("&nbsp;&nbsp;->&nbsp;&nbsp;" + Number(data[0].price - 1000) + "원");

								},
								error:function(e){
										alert("ajax 에러");
										//alert( e.responseText );
									}
								});


							break;
						case "8" : 

							$.ajax({
							type:"POST",
							url:"menu_select_ajax.php",
							data:"seq="+8,
							dataType:"json",
							//traditional: true,
							//contentType: "application/x-www-form-urlencoded;charset=utf-8",
							success:function( data ){


								$(".step_7 .set_menu_right_div .set_dessert_img").attr("src", "images/menu_origin/honeybread.png");
								

								$(".step_7 .set_menu_right_div .set_menu_right_div_title").empty();
								$(".step_7 .set_menu_right_div .set_menu_right_div_title").append(data[0].name);

								$(".step_7 .set_menu_right_div .dessert_menu_price_origin").empty();
								$(".step_7 .set_menu_right_div .dessert_menu_price_origin").append(Number(data[0].price) + "원");

								$(".step_7 .set_menu_right_div .dessert_menu_price_discount").empty();
								$(".step_7 .set_menu_right_div .dessert_menu_price_discount").append("&nbsp;&nbsp;->&nbsp;&nbsp;" + Number(data[0].price - 1000) + "원");

							},
							error:function(e){
									alert("ajax 에러");
									//alert( e.responseText );
								}
							});

							break;
						case "9" : 


							$.ajax({
								type:"POST",
								url:"menu_select_ajax.php",
								data:"seq="+9,
								dataType:"json",
								//traditional: true,
								//contentType: "application/x-www-form-urlencoded;charset=utf-8",
								success:function( data ){


									$(".step_7 .set_menu_right_div .set_dessert_img").attr("src", "images/menu_origin/waffle.png");
									

									$(".step_7 .set_menu_right_div .set_menu_right_div_title").empty();
									$(".step_7 .set_menu_right_div .set_menu_right_div_title").append(data[0].name);

									$(".step_7 .set_menu_right_div .dessert_menu_price_origin").empty();
									$(".step_7 .set_menu_right_div .dessert_menu_price_origin").append(Number(data[0].price) + "원");

									$(".step_7 .set_menu_right_div .dessert_menu_price_discount").empty();
									$(".step_7 .set_menu_right_div .dessert_menu_price_discount").append("&nbsp;&nbsp;->&nbsp;&nbsp;" + Number(data[0].price - 1000) + "원");

								},
								error:function(e){
										alert("ajax 에러");
										//alert( e.responseText );
									}
								});

							break;
						default: 
							break;
					}
				}else{
					alert("카테고리 에러");
				}



				

			}



			function menu_select(seq) {
				//메뉴 seq를 가지고 정보 가져오기 ajax
				$.ajax({
				type:"POST",
				url:"menu_select_ajax.php",
				data:"seq="+seq,
				dataType:"json",
				//traditional: true,
				//contentType: "application/x-www-form-urlencoded;charset=utf-8",
				success:function( data ){
					
					//주문 수 늘리고, 장바구니 배열에 seq넣어두고, 가격 카운트 높혀주기
					// order_array.push(menu_seq);
					// sale_list_count += 1;
					// sale_list_price = Number(sale_list_price) + Number(data[0].price);


					// var append = "<ul class='item' value='"+ data[0].seq +"'><li>"+sale_list_count+"</li><li>"+data[0].name+"</li><li>"+comma(data[0].price)+"원</li></ul>";					
					// $(".sale_list_table").append(append);
					// $(".sale_list").scrollTop($(".sale_list_div").height());



					// var final_price_text = "최종 가격 : " + comma(sale_list_price) + "원";
					// $(".final_price_span").empty();
					// $(".final_price_span").text(final_price_text);


				},
				error:function(e){
						alert("ajax 에러");
						//alert( e.responseText );
					}
				});


				
			}









			function slide_event(index){
				$(".slide_text_on").removeClass("slide_text_on");
				index = index+1;
				$(".silde_img_"+index).addClass("slide_text_on");
			}



			$(window).scroll(windowScroll);
			$(window).resize(winodwResize);



			function windowScroll()
			{				
				


				


				var toppx = $(this).scrollTop();
				// scrollVisible($("body").find('.detect-inview-opacity'),toppx,60);

				// console.log("Dd");


				// scrollImage($("body").find('.detect-inscroll'),toppx);

				// scrollImage_up_img($("body").find('.detect-inscroll-up-img'),toppx);

				// scrollVisibleBig($("body").find('.detect-inview_big2'),toppx,-500);


				//main_title
					if( win_width >= 768 )
					{
						scrollVisible($("body").find('.detect-inview-opacity'),toppx,300);
						// scrollVisible($("body").find('.detect-inview'),toppx,60);
						// scrollVisibleBig($("body").find('.detect-inview_big'),toppx,-180);
						
						// scrollVisible_right($("body").find('.detect-right'),toppx,60);
						// scrollVisible_left($("body").find('.detect-left'),toppx,60);
						// scrollImage_up($("body").find('.detect-inscroll-up'),toppx);

						// scrollVisible($("body").find('.detect-ani-box'),toppx,120);

					}else{
						scrollVisible($("body").find('.detect-inview-opacity'),toppx,50);
						// scrollVisible($("body").find('.detect-inview'),toppx,-60);
						// scrollVisibleBig($("body").find('.detect-inview_big'),toppx,-180);

						// scrollVisible_right($("body").find('.detect-right'),toppx,10);
						// scrollVisible_left($("body").find('.detect-left'),toppx,10);

						// scrollVisible($("body").find('.detect-ani-box'),toppx,70);
					}




				menu_windowScroll();

				//google map disable
				/*
				if( toppx >= ( $(".step_4").offset().top ) )
				{
					if($(".bug").css("display") == 'none')
					{
						$(".bug").css({'display':'inline-block'});
					}
				}else{
					if($(".bug").css("display") == 'inline-block')
					{
						$(".bug").css({'display':'none'});
					}
				}*/

				
			}




			var win_height = $(window).height();
			var win_width = $(window).width();
			function winodwResize()
			{
				win_height = $(window).height();
				win_width = $(window).width();

	

				// galleryTop.onResize();
				// galleryThumbs.onResize();

				//스텝 위치 초기화
				init_step_position();
				setTimeout(function(){
					init_step_position();
				},300);

				//스텝 높이조절
				$(".step_1").css({'height':$(window).height()});
				$(".step_2").css({'height':$(window).height()});
				$(".step_3").css({'height':$(window).height()});
				$(".step_4").css({'height':$(window).height()});
				$(".step_5").css({'height':$(window).height()});
				$(".step_6").css({'height':$(window).height()});
				$(".step_7").css({'height':$(window).height()});
			}

			//스텝 위치 초기화
			
			function init_step_position(){
				//메뉴 위치 초기값
				el_step = $(".step");
				menu = new Array();
				for(var i = 0; i < el_step.length ; i++)
				{
					menu[i] = el_step.eq(i).offset().top;
				}
				//alert(menu[2]);
			}



			

			function menu_windowScroll()
			{
				var toppx = $(this).scrollTop();
				//스텝 위치 초기화
				init_step_position();
				
				if (toppx >= 1)
				{
					if( !$("body").hasClass('scroll') )
					{
						$("body").addClass("scroll");
					}
				}else{
					if( $("body").hasClass('scroll') )
					{
						$("body").removeClass("scroll");
					}					
				}				

				scrollMenuColor(menu,toppx);

			}



			//스크롤할때 메뉴 글씨 바꾸기
			var scrollMenuColor = function (menu, toppx) {

				var wH = $(window).height()/2;
				var toppxWh = toppx + wH;
				var count = 0;

				
				if(menu[4] < toppxWh)
				{
					if($(".menu_btn").eq(4).hasClass("active"))
					{

					}else{
						$(".menu_btn").removeClass("active");
						$(".menu_btn").eq(4).addClass("active");
						$(".menu_btn2").removeClass("active");
						$(".menu_btn2").eq(4).addClass("active");
					}
					
				}else if(menu[3] < toppxWh)
				{
					if($(".menu_btn").eq(3).hasClass("active"))
					{

					}else{
						$(".menu_btn").removeClass("active");
						$(".menu_btn").eq(3).addClass("active");
						$(".menu_btn2").removeClass("active");
						$(".menu_btn2").eq(3).addClass("active");
					}
					
				}else if(menu[2] < toppxWh)
				{
					if($(".menu_btn").eq(2).hasClass("active"))
					{

					}else{
						$(".menu_btn").removeClass("active");
						$(".menu_btn").eq(2).addClass("active");
						$(".menu_btn2").removeClass("active");
						$(".menu_btn2").eq(2).addClass("active");
					}
					
				}else if(menu[1] < toppxWh)
				{
					if($(".menu_btn").eq(1).hasClass("active"))
					{

					}else{
						$(".menu_btn").removeClass("active");
						$(".menu_btn").eq(1).addClass("active");
						$(".menu_btn2").removeClass("active");
						$(".menu_btn2").eq(1).addClass("active");
					}
					
				}else if(menu[0] < toppxWh){
					if($(".menu_btn").eq(0).hasClass("active"))
					{

					}else{
						$(".menu_btn").removeClass("active");
						$(".menu_btn").eq(0).addClass("active");
						$(".menu_btn2").removeClass("active");
						$(".menu_btn2").eq(0).addClass("active");
					}
				}

				
			}


			


			//화면 이동
			function scroll_move(px, speed){

				var toppx = px;
				if(!speed){
					$('html, body').animate({scrollTop: toppx }, 1000, 'easeInOutExpo');
				}else{
					$('html, body').animate({scrollTop: toppx }, speed, 'easeInOutExpo');
				}
				
			}

			

			
			


			//스크롤할때 이미지 따라다니기
			var scrollImage = function (elements, toppx) {

					
				elements.each(function () {
					
					var win_scroll_top = $(window).scrollTop();
					
					var el = $(this);
					var el_height = el.height();

					var elOffset = el.offset().top + 0;
					var el_view = win_scroll_top - elOffset; //0부터 높이까지
					var el_view_2  = (el_view / el_height) * 50;		

					

					if(el_view >= 0 && el_view <= el_height)
					{
											
						//console.log(el_view);
						el.css({'transform': 'translate(0%, '+el_view_2+'%) translate3d(0px, 0px, 0px)','-webkit-transform': 'translate(0%, '+el_view_2+'%) translate3d(0px, 0px, 0px)'});
					}else if (el_view > el_height){
						el.css({'transform': 'translate(0%, '+50+'%) matrix(1, 0, 0, 1, 0, 0)','-webkit-transform': 'translate(0%, '+50+'%) matrix(1, 0, 0, 1, 0, 0)'});
					}else if (el_view <= 0){
						el.css({'transform': 'translate(0%, '+0+'%) matrix(1, 0, 0, 1, 0, 0)','-webkit-transform': 'translate(0%, '+0+'%) matrix(1, 0, 0, 1, 0, 0)'});
					}
					
					
				});
			}

			//스크롤할때 이미지 따라다니기 up
			var scrollImage_up_img = function (elements, toppx) {



				elements.each(function () {
					
					var el = $(this);
					var el_height = el.height();

					var elOffset = el.offset().top + 0;
					var el_view = $(window).scrollTop() - elOffset + win_height; //0 부터 높이까지
					var el_view_2  = -(el_view / (win_height + el_height)) * 60;	

					//console.log(el_view_2);

					
					
					var el_view_start = $(window).scrollTop() - elOffset + win_height;
					var el_view_finish = $(window).scrollTop()- el_height;


					if (el_view_start >= 0 && elOffset > el_view_finish)
					{
						//console.log("on");
						el.css({'transform': 'translate(0%, '+el_view_2+'%) translate3d(0px, 0px, 0px)'});
						el.css({'-webkit-transform': 'translate(0%, '+el_view_2+'%) translate3d(0px, 0px, 0px)'});
					}else if(elOffset < el_view_finish){
						//console.log("down");
						el.css({'transform': 'translate(0%, -'+60+'%) matrix(1, 0, 0, 1, 0, 0)'});
						el.css({'-webkit-transform': 'translate(0%, -'+60+'%) matrix(1, 0, 0, 1, 0, 0)'});
					}else if(el_view_start <= 0){
						//console.log("up");
						el.css({'transform': 'translate(0%, '+0+'%) matrix(1, 0, 0, 1, 0, 0)'});
						el.css({'-webkit-transform': 'translate(0%, '+0+'%) matrix(1, 0, 0, 1, 0, 0)'});
					}

					
				});
			}

			//스크롤할때 글짜 따라다니기 up
			var scrollImage_up = function (elements, toppx) {



				elements.each(function () {
					
					var el = $(this);
					var el_height = el.height();

					var elOffset = el.offset().top + 0;
					var el_view = $(window).scrollTop() - elOffset + win_height; //0 부터 높이까지
					var el_view_2  = -(el_view / (win_height + el_height)) * 50;	

					//console.log(el_view_2);

					
					
					var el_view_start = $(window).scrollTop() - elOffset + win_height;
					var el_view_finish = $(window).scrollTop()- el_height;


					if (el_view_start >= 0 && elOffset > el_view_finish)
					{
						//console.log("on");
						el.css({'transform': 'translate(0%, '+el_view_2+'%) translate3d(0px, 0px, 0px)'});
						el.css({'-webkit-transform': 'translate(0%, '+el_view_2+'%) translate3d(0px, 0px, 0px)'});
					}else if(elOffset < el_view_finish){
						//console.log("down");
						el.css({'transform': 'translate(0%, -'+50+'%) matrix(1, 0, 0, 1, 0, 0)'});
						el.css({'-webkit-transform': 'translate(0%, -'+50+'%) matrix(1, 0, 0, 1, 0, 0)'});
					}else if(el_view_start <= 0){
						//console.log("up");
						el.css({'transform': 'translate(0%, '+0+'%) matrix(1, 0, 0, 1, 0, 0)'});
						el.css({'-webkit-transform': 'translate(0%, '+0+'%) matrix(1, 0, 0, 1, 0, 0)'});
					}

					
				});
			}


			//스크롤할때 나오는방법
			var scrollVisible = function (elements, toppx, bottom) {



				var toppxWh = toppx + win_height - bottom;
				var count = 0;

				elements.each(function () {
					
					var el = $(this);

					
					//이미 활성화 된것들은 무시
					if( el.hasClass('visible') )
					{

					}else{

						count += 50;
						var elOffset = el.offset().top;				
						if (elOffset < toppxWh) {
							setTimeout(function () {
								el.addClass('visible');
							}, count);
						}						

					}
					
				});
			}

			//스크롤할때 나오는방법 big
			var scrollVisibleBig = function (elements, toppx, bottom) {

				var toppxWh = toppx + win_height - bottom;
				var count = 0;

				elements.each(function () {
					
					var el = $(this);
					
					//이미 활성화 된것들은 무시
					if( el.hasClass('visible') )
					{
						
					}else{
						count += 50;
						var elOffset = el.offset().top;				
						if (elOffset < toppxWh) {
							setTimeout(function () {
								el.addClass('visible');
							}, count);
						}						

					}
					
				});
			}

			//스크롤할때 오른쪽으로 나오는방법
			var scrollVisible_right = function (elements, toppx, bottom) {

				var toppxWh = toppx + win_height - bottom;
				var count = 0;

				

				elements.each(function () {
					
					var el = $(this);
					
					//이미 활성화 된것들은 무시
					if( el.hasClass('visible') )
					{
						
					}else{
						count += 50;
						var elOffset = el.offset().top;				
						if (elOffset < toppxWh) {
							setTimeout(function () {
								el.addClass('visible');
							}, count);
						}						

					}

					
				});
			}

			//스크롤할때 왼쪽으로 나오는방법
			var scrollVisible_left = function (elements, toppx, bottom) {

				var toppxWh = toppx + win_height - bottom;
				var count = 0;

				elements.each(function () {
					
					var el = $(this);
					
					//이미 활성화 된것들은 무시
					if( el.hasClass('visible') )
					{
						
					}else{
						count += 50;
						var elOffset = el.offset().top;				
						if (elOffset < toppxWh) {
							setTimeout(function () {
								el.addClass('visible');
							}, count);
						}						

					}
					
				});
			}




		</script>