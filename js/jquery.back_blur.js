/* 
 * jQuery back_blur 1.0
 * Copyright (c) 2017, Nu-Ri Lee
 * Lisensed under the MIT
 * 
 * Dependencies:
 *  jQuery >= 1.6
 * 
 * Contacts
 *  Email : dlsnf@naver.com
 *
 * 
 */

 //React to window size
 
var isIE = /*@cc_on!@*/false || !!document.documentMode;

$(window).resize(function(){

	if (isIE) {
		//alert("인터넷익스플로러 브라우저입니다.");
		back_blur_init( ".full_size", ".card" , "");
		setTimeout(function(){
			if(bg_top !=  ( - card_el.position().top )  )
			{
				back_blur_init( ".full_size", ".card" , "");
			}
		},1000);
	}else{
			back_blur_init( ".full_size", ".card" , "fixed");

			setTimeout(function(){
				if(bg_top !=  ( - card_el.position().top )  )
				{
					back_blur_init( ".full_size", ".card" , "fixed");
				}
			},1000);
		
		
	}




});



$(window).load(function(){

	if (isIE) {
		//alert("인터넷익스플로러 브라우저입니다.");
		back_blur_init( ".full_size", ".card" , "");
	}else{
		back_blur_init( ".full_size", ".card" , "fixed");		
	}

});
$(window).ready(function(){

	if (isIE) {
		//alert("인터넷익스플로러 브라우저입니다.");
		back_blur_init( ".full_size", ".card" , "");
	}else{
		back_blur_init( ".full_size", ".card" , "fixed");		
	}

});

$(window).scroll(function(){

	
});



var full_size_el;
var card_el;
var fixed_bool = true;

var bg_width;
var bg_height;
var bg_left;
var bg_top;

	function back_blur_init(full_size, card, fixed){
		full_size_el = $(full_size);
		card_el = $(card);

		

		if(fixed == "fixed")
		{
			fixed_bool = true;
		}else{
			fixed_bool = false;
		}


		//custom - 가로가 780px보다 낮을때
		if( $(window).width() <= 780 )
		{
			full_size_el.css({'height':$(".card_text").height() + 220});

			bg_width = full_size_el.width();
			bg_height = full_size_el.height();
			bg_left = - card_el.position().left;
			bg_top = - card_el.position().top;

		}else{
			full_size_el.css({'height':'900px'});

			bg_width = full_size_el.width();
			bg_height = full_size_el.height();
			bg_left = - card_el.position().left;
			bg_top = - card_el.position().top;

		}


		//fixed 가 이상할때
		if(fixed == "fixed")
		{
			if( full_size_el.height()> $(window).height() )
			{
				fixed_bool = false;
				full_size_el.css({'position':'relative', 'bottom':'inherit'});
			}else{
				fixed_bool = true;
			}

			//fixed_bool = true;
		}
		
		if( fixed_bool == true )
		{
			var toppx = $(this).scrollTop();			
			back_blur_fixed(toppx);
		}else{
			back_blur_size();
		}
	}



function back_blur_fixed(toppx){




		//parent_bottom
		var full_parent_el = full_size_el.parent();
		var step_bottom = $("body").height() - ( full_parent_el.offset().top + full_parent_el.height() );

		//full_size_el.css({'position':'fixed','bottom':step_bottom, 'z-index':'1'});
		full_size_el.css({'position':'fixed','bottom':step_bottom, 'z-index':'1'});
		full_size_el.parent().css( "height", full_size_el.height()  );


	back_blur_size();


}


	function back_blur_size(){


		card_el.children(".bg_back").css({'width':bg_width, 'height':bg_height, 'left':bg_left, 'top':bg_top});	


		//custom
		$(".card").css({'top':( full_size_el.height() - $(".footer").height() ) / 2});
	

		

	}

