(function($){
	$.fn.translate = function(options){
		var defaults = {
			offsetX 	: 0,
			offsetY		: 0,
			speed 		: 1,
			animation	: 'ease-in'
		}

		var settings = $.extend(defaults, options)

		return this.each(function(e){
			var offsetX= settings.offsetX,
				offsetY= settings.offsetY,
				speed= settings.speed,
				animation= settings.animation;
			$(this).css({
			    "-webkit-transform"	: "translate("+offsetX+"px,"+offsetY+"px) rotate(0.01deg)",
			    "-webkit-transition": "all "+speed+"s "+animation+" ",
			    "-moz-transform" 	: "translate("+offsetX+"px,"+offsetY+"px) rotate(0.01deg) rotate(0.01deg)",
			    "-moz-transition"	: "all "+speed+"s "+animation+" ",
			    "-ms-transform"		: "translate("+offsetX+"px,"+offsetY+"px) rotate(0.01deg)",
			    "-ms-transition"	: "all "+speed+"s "+animation+" ",
			    "transform"		: "translate("+offsetX+"px,"+offsetY+"px) rotate(0.01deg)",
			    "transition"	: "all "+speed+"s "+animation+" "
			});	
		});
	}

	$.fn.scale = function(options){
		var defaults = {
			scale		: 1,
			speed 		: 0.5,
			animation	: 'ease-in'
		}

		var settings = $.extend(defaults, options)

		return this.each(function(e){
			var scale= settings.scale,
				speed= settings.speed,
				animation= settings.animation;
			$(this).css({
			    "-webkit-transform"	: "scale("+scale+") rotate(0.01deg)",
			    "-webkit-transition": "all "+speed+"s "+animation+" ",
			    "-moz-transform" 	: "scale("+scale+") rotate(0.01deg) rotate(0.01deg)",
			    "-moz-transition"	: "all "+speed+"s "+animation+" ",
			    "-ms-transform"		: "scale("+scale+") rotate(0.01deg)",
			    "-ms-transition"	: "all "+speed+"s "+animation+" ",
			    "transform"		: "scale("+scale+") rotate(0.01deg)",
			    "transition"	: "all "+speed+"s "+animation+" "
			});	
		});		
	}
})(jQuery);