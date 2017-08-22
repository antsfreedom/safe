//index
var index = {
	init: function (num) {
		require(['jquery'],function($){
			$(document).ready(function(){
				let index = 0;
				let index_time = null;
				let index_dywidth = $(".dynamic_list_box").width();
				function index_move(){	
					$('.dynamic_list').stop().animate({
						left: -(index_dywidth + 50)*index +"px"
					},500)
				}
				index_move()
				function index_showTime(){
					index_time = setInterval(function(){
						index ++;
						if(index>$('.dynamic_list li').length/2-1){
							index = 0
						}
						index_move();
					},2000)
				} 
				index_showTime()
				$('.cli_l').click(function(){				
					if(index<1){
						index = $('.dynamic_list li').length/2-1
					}else{
						index --
					}
					index_move()
				})
				$('.cli_r').click(function(){		
					index ++;		
					if(index>$('.dynamic_list li').length/2-1){
						index = 0
					}
					index_move()
				})
				$(".dynamic_list_box").mouseover(function(){
					clearInterval(index_time)
				}).mouseleave(function(){
					index_showTime()
				});

				let inde = 0
				$('.cli_le').click(function(){
					if(inde<1){
						return
					}else{					
						inde --;
						$('.company_list').animate({
							left: -($('.company_list li').width() + 43)*inde + "px"
						})
					}
				})
				$('.cli_ri').click(function(){
					if(inde+3<$('.company_list li').length-1){
						inde ++;
						$('.company_list').animate({
							left: -($('.company_list li').width() + 43)*inde + "px"
						})
					}				
				})
			})
		})
	}
}
//about
var about = {
	init: function(num) {
		require(['jquery'],function($){
			$(document).ready(function(){
					$(".list-coo li").mouseover(function(){
						var index = $(this).index();
						$(".list-pic li").eq(index).show().siblings().hide()
					})				
			})
		})
	}
}


//guide
var guide = {
	init: function(num) {
		require(['jquery'],function($){
			$(document).ready(function(){
				var index = 0,
				len = $('.btn').length;
				$('.pics').css({width: 619*len + 'px'});
				function show(){
					$('.pics').stop().animate({left: -619*index +'px'});
					$('.btn').eq(index).find('.btn_pic01').hide();
					$('.btn').eq(index).find('.btn_pic02').show();
					$('.btn').eq(index).siblings().find('.btn_pic01').show();
					$('.btn').eq(index).siblings().find('.btn_pic02').hide();
				}
				show();
				$('.btn').click(function(){
					index = $(this).index();
					show();
				})

			})
		})
	}
}

//helpBulletin
var helpBulletin = {
	init: function(){
		require(['jquery'],function($){
			$(document).ready(function(){
			  //上下拉菜单
				var sta = false;
				$('.list_tilte1').click(function(){
					if (!sta) {
						$('.list_sonone li').stop().slideUp(500);
						$('.list_sontwo li').stop().slideDown(500);
						 sta =true;
					}else{
						$('.list_sonone li').stop().slideDown(500);
						$('.list_sontwo li').stop().slideUp(500);
						sta = false;
					}
				})
				$('.list_tilte2').click(function(){
					if (!sta) {
						$('.list_sonone li').stop().slideUp(500);
						$('.list_sontwo li').stop().slideDown(500);
						 sta =true;
					}else{
						$('.list_sonone li').stop().slideDown(500);
						$('.list_sontwo li').stop().slideUp(500);
						sta = false;
					}
				})
				$('.bulletin_detail .listp li').click(function(){
					$(this).children('span').css('color','blue');
					$(this).children('.detail').css('display','block');
					$(this).siblings().children('span').css('color','black');
					$(this).siblings().children('.detail').css('display','none');
				})
			})
		})	
	}
}



exports.index = index;
exports.about = about;
exports.helpBulletin = helpBulletin;
exports.guide = guide;