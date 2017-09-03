define('modules/js/main', function(require, exports, module) {

  //index
  "use strict";
  
  var index = {
  	//banner轮播
  	init: function init(num) {
  		require(['modules/js/jquery'], function ($) {
  			$(document).ready(function () {
  				var i = 0;
  				var length = $(".bannerBox li").length;
  
  				$(".banner").hover(function () {
  					clearInterval(time);
  				}, function () {
  					time = setInterval(move, 1500);
  				});
  
  				var time = setInterval(move, 1500);
  
  				function move() {
  					i++;
  					if (i == length) {
  						i = 0;
  					}
  					$(".bannerBox li").eq(i).stop().fadeIn(1000).siblings().stop().fadeOut(1000);
  				}
  
  				function moveL() {
  					i--;
  					if (i == -1) {
  						i = length - 1;
  					}
  					$(".bannerBox li").eq(i).stop().fadeIn(1000).siblings().stop().fadeOut(1000);
  				}
  
  				$(".Larrow").click(function () {
  					moveL();
  				});
  
  				$(".Rarrow").click(function () {
  					move();
  				});
  			});
  		});
  	},
  
  	tabShow: function tabShow(num) {
  		require(['modules/js/jquery'], function ($) {
  			$(document).ready(function () {
  				$(".examTab ul li").first().addClass("on");
  				$(".examTab ul li").click(function () {
  					var index = $(this).index();
  					$(this).addClass("on").siblings().removeClass("on");
  					$(".examList ul li").eq(index).show().siblings().hide();
  				});
  			});
  		});
  	}
  
  };
  
  var user_center = {
  	init: function init(num) {
  		require(['modules/js/jquery'], function ($) {
  			$(document).ready(function () {});
  		});
  	}
  };
  
  //tool
  var tool = {
  	init: function init() {
  		require(['modules/js/jquery','modules/js/swiper'], function ($, swiper) {
  			$(document).ready(function () {
  				var mySwiper = new Swiper('.swiper-container', {
  					autoplay: 2000, //可选选项，自动滑动
  					nextButton: '.swiper-button-next',
  					prevButton: '.swiper-button-prev'
  				});
  			});
  		});
  	}
  };
  
  exports.index = index;
  
  exports.tool = tool;
  
  exports.user_center = user_center;

});
