<script>
			

			$(window).load(function(){
				weather();

				nfc_check();

			});


			$(window).ready(function(){

			});


			$(window).scroll(windowScroll);
			$(window).resize(winodwResize);



			function windowScroll()
			{				
				
				
			}


			function winodwResize()
			{
				

			}


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


			

			//장바구니 구매완료시 DB업로드
			function sale_insert()
			{


				if( order_array.length == 0 )
				{
					alert("장바구니에 메뉴를 담아주세요.");
				}else{

					$.ajaxSettings.traditional = true; //ajax 배열 넘길때 필요

					//ajax배열 넘기기 전 json으로 변환
					var jsonString = JSON.stringify(order_array);
					// user_card_num = "0x0 0x47 0x31 0x99";
					// user_seq = 1;

					$.ajax({
				        url:'sale_insert_ajax.php',
				        type:'POST',
				        data: {'array_seq' : jsonString, 'user_seq' : user_seq, 'user_card_num' : user_card_num, 'today_temp' : today_temp},
				        dataType:"json",
				        success:function(data){
				            //alert(data[0].result);

							if( data[0].result )
							{
								alert(data[0].user_name + "님 주문 완료");
								order_clear();
								user_info_init();
							}

				        },
				        error:function(e){
							alert("ajax 에러");
							alert( e.responseText );
						}
					});
				}


			}

			//메뉴 클릭시 장바구니 추가하기
			function menu_click(menu_seq)
			{
				//alert($(menu_seq).val());

				var menu_seq = $(menu_seq).val();



				//메뉴 seq를 가지고 정보 가져오기 ajax
				$.ajax({
				type:"POST",
				url:"menu_select_ajax.php",
				data:"seq="+menu_seq,
				dataType:"json",
				//traditional: true,
				//contentType: "application/x-www-form-urlencoded;charset=utf-8",
				success:function( data ){
					//alert(data[0].seq);

					//주문 수 늘리고, 장바구니 배열에 seq넣어두고, 가격 카운트 높혀주기
					order_array.push(menu_seq);
					sale_list_count += 1;
					sale_list_price = Number(sale_list_price) + Number(data[0].price);


					var append = "<ul class='item' value='"+ data[0].seq +"'><li>"+sale_list_count+"</li><li>"+data[0].name+"</li><li>"+comma(data[0].price)+"원</li></ul>";					
					$(".sale_list_table").append(append);
					$(".sale_list").scrollTop($(".sale_list_div").height());



					var final_price_text = "최종 가격 : " + comma(sale_list_price) + "원";
					$(".final_price_span").empty();
					$(".final_price_span").text(final_price_text);


				},
				error:function(e){
						alert("ajax 에러");
						//alert( e.responseText );
					}
				});



			}


			//장바구니 초기화
			function order_clear()
			{
				sale_list_count = 0;
				order_array = new Array();
				sale_list_price = 0;

				$(".sale_list_table").empty();

				var final_price_text = "최종 가격 : " + 0 + "원";
				$(".final_price_span").empty();
				$(".final_price_span").text(final_price_text);
			}



			function array_check()
			{
				alert(order_array[0]);
				alert(order_array[1]);
				alert(order_array[2]);
			}


			//세자리 콤마 찍어주기
			function comma(num){
			    var len, point, str; 
			       
			    num = num + ""; 
			    point = num.length % 3 ;
			    len = num.length; 
			   
			    str = num.substring(0, point); 
			    while (point < len) { 
			        if (str != "") str += ","; 
			        str += num.substring(point, point + 3); 
			        point += 3; 
			    } 
			     
			    return str;
			 
			}






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

				



				// nfc_read_interval = setInterval(function() {

				// 	if( nfc_read_bool ) //NFC값 읽어와도 될때
				// 	{

				// 	}
			        
			 //    },1000);


			}

			function nfc_check_stop(){
				setTimeout(function() {
			        clearTimeout(nfc_read_interval);
			    },5000);
			}

			function user_info_update(){

				if( user_name != "비회원")
				{
					var user_info_display_text = "회원 정보 : "+user_name+"님 안녕하세요.";
					var user_card_num_display_text = "카드 번호 : "+user_card_num+"";
					
				}else{
					
					if( user_card_num ) 
					{
						var user_info_display_text = "회원 정보 : 비회원";
					}else{
						var user_info_display_text = "회원 정보 : ";
					}
					
					var user_card_num_display_text = "카드 번호 : "+user_card_num+"";

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










		</script>








