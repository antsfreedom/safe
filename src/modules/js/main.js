//index
var index = {
	//banner轮播
	init: function (num) {
		require(['jquery'],function($){
			$(document).ready(function(){
				var i=0;
				var length = $(".bannerBox li").length;

				$(".banner").hover(function(){
					clearInterval(time)
				},function(){
					time = setInterval(move,1500)
				})

				var time = setInterval(move,1500)

				function move(){
					i++;
					if(i==length){
						i=0;
					}
					$(".bannerBox li").eq(i).stop().fadeIn(500).siblings().stop().fadeOut(500);				
				}


			function moveL(){
				i--;
				if(i==-1){
					i=length-1;
				}
				$(".bannerBox li").eq(i).stop().fadeIn(500).siblings().stop().fadeOut(500);				
			}

				$(".Larrow").click(function(){
					moveL()
				})

				$(".Rarrow").click(function(){
					move()
				})
			})
		})
	}
}

exports.index = index;
