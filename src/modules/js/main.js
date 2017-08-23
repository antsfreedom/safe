//index
var index = {
	//banner轮播
	init: function (num) {
		require(['jquery'],function($){
			$(document).ready(function(){
				var picWidth = $(".banner").width();
				var length = $(".bannerBox li").length;
				// alert(length)
				// console.log(picWidth)
				var i=0;
				//函数
				function moveL(){
					i++;
					if(i==length){
						i=0;
					}
					$(".bannerBox").stop().animate({left:-i * picWidth + "px"},500)
				}
				//左按钮
				$(".Larrow").click(function(){
					moveL()
				})
				//右按钮
				$(".Rarrow").click(function(){
					i--;
					if(i==-1){
						i=length-1
					}
					$(".bannerBox").stop().animate({left:-i * picWidth + "px"},500)
				})
				//定时器
				var timer = setInterval(moveL,1500)

				$(".bannerBox").hover(function(){
					clearInterval(timer)
				},function(){
					timer = setInterval(moveL,1500)
				})

			})
		})
	}
}

exports.index = index;
