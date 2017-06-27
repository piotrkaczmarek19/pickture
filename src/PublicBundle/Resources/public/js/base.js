$(document).ready(function(){
	$('.content').fadeOut(0).fadeIn('slow');
	// Setting variables
	var screen_height = $(window).height(),
		screen_width = $(window).width();

	// Setting elements
	var $navbar_vertical = $('.navbar-vertical'),
		$content = $('.content'),
		$body = $('body'),
		$flash_msg = $(".flash-msg-wrapper.navigation"),
		$menu_small_button = $('.menu_small_button');

	// Responsivity Block
		// adjusting elements
		$navbar_vertical.height(screen_height);
		$content.css({"min-height":screen_height});


		if(screen_width<1000){
			var navbar_width = $navbar_vertical.width();

			$body.addClass('small');
			$menu_small_button.show('fast');
			// Clearing navbar
			$content.css({'margin-left':'0'});
			$navbar_vertical.translate({
				offsetX 	: -navbar_width - 150,
				offsetY		: 0,
				speed 		: 0,
			});

		}else{
			$body.removeClass('small');
		}

		// readjusting settings when resize window
		$(window).on('resize', function(){
			var screen_width = $(window).width(),
				screen_height = $(window).height(),
				navbar_width = $navbar_vertical.width();
			$content.css({"min-height":screen_height});
			if(screen_width<1100){
				if(!$body.hasClass('small')){
				// Moving navbar out of the way if we start from a big screen
					$content.css({'margin-left':'0'});
					$navbar_vertical.translate({
						offsetX 	: -navbar_width - 150,
						offsetY		: 0,
						speed 		: 0.5,
						animation	: 'ease-in'
					});
					$body.addClass('small');
					$menu_small_button.show('fast');
				}

			}else{
				// Putting the navbar back into view
				$content.removeAttr('style');
				$navbar_vertical.translate({
					offsetX 	: 0,
					offsetY		: 0,
					speed 		: 0.5,
					animation	: 'ease-in'
				}).height(screen_height);

				$body.removeClass('small');
				$menu_small_button.hide('fast');
			}
		});
	// Small screen menu module
	$menu_small_button.on('click touchstart', function()
	{
		$(".menu_small_wrapper").toggleClass('visible');
	});
	$(".menu_small li a").on("click touchstart", function()
	{
		setTimeout(function()
		{
			$(".menu_small_wrapper").removeClass('visible');
		}, 1000);
	});

	// User triggered animations (hover, etc.)
		// scale logos attached to links on hover
		$(document).on('mouseenter', 'a.link', function(event){
			$(this).children('img').scale({
				scale	: 1.3,
				speed	: 0.2
			});
			var top = $(this).offset().top - $(window).scrollTop() + 60;
			var left = $(this).offset().left + 120;
			var val = $(this).attr('href');
			var Reg = new RegExp();
			var pattern = /\/(\w+)/;
			val = pattern.exec(val);

			$flash_msg[0].style.opacity = 1;
			$flash_msg[0].style.top = top + "px";
			$flash_msg[0].style.left = left + "px";
			if (val == null)
			{
				val = ["", "Home"];

			}
			val = val[1].charAt(0).toUpperCase() + val[1].slice(1);
			$flash_msg.text(val);

		});
		$(document).on('mouseleave','a.link', function(){
			$(this).children('img').scale({
				scale	: 1,
				speed	: 0.2
			});
			$flash_msg[0].style.opacity = 0;
		});
		$(document).on('mouseenter', 'div.face-detect-box', function()
		{
			$('.flash-msg-face-detect')[0].style.opacity = 1;
		});
		$(document).on('mouseleave', 'div.face-detect-box', function()
		{
			$('.flash-msg-face-detect')[0].style.opacity = 0;
		});
	// Ajax and PHP-JS dialogue Block
		// Get the current Route
		var current_route = $('#route_tag').attr('data-route'),
			current_button = '.category_button[data-route="'+current_route+'"]',
			$current_button = $(current_button);
		$current_button.addClass('current');

	$("#comment_content").val("");

	var $ban_button = $(".logo_admin_action");
	$ban_button.on("click", function ()
	{
		var url = "/admin/delete";
		var curr_type = this.getAttribute('data-type');
		var curr_id = this.getAttribute('data-id');
		var action = this.classList[1];
		var _self = this;
		$.ajax({
            type    : 'POST',
            url     : url,
            data    : {type: curr_type, id: curr_id, action: action},
            success : function(response){
                // fade out the element if successfull
                if (response == "deleted")
                {
                	_self.parentNode.style.display = "none";
                }
                // Toggle user status if action == ban
                else if (response == "banned")
                {
                	var status_cell = _self.parentNode.parentNode.querySelector(".user_status")
                	$(status_cell).toggleClass("banned");
                	if (status_cell.classList[1] == "banned")
                	{
                		status_cell.innerHTML = "banned";
                	}
                	else
                	{
						status_cell.innerHTML = "active";
                	}
                }
            }
        });
	})
});