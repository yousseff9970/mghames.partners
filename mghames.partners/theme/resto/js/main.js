(function() {
	"use strict";
	
	/*=====================================
	  Preloader
	======================================= */
	window.onload = function() {
		window.setTimeout(fadeout, 500);
	};

	function fadeout() {
		document.querySelector('.preloader').style.opacity = '0';
		document.querySelector('.preloader').style.display = 'none';
	}

	/*=====================================
	  Sticky
	======================================= */
	window.onscroll = function() {
		var header_navbar = document.querySelector(".navbar-area");
		var sticky = header_navbar.offsetTop;

		if (window.pageYOffset > sticky) {
			header_navbar.classList.add("sticky");
		} else {
			header_navbar.classList.remove("sticky");
		}

		// show or hide the back-top-top button
		var backToTo = document.querySelector(".scroll-top");
		if (
			document.body.scrollTop > 50 ||
			document.documentElement.scrollTop > 50
		) {
			backToTo.style.display = "flex";
		} else {
			backToTo.style.display = "none";
		}
	};

	/*=====================================
	  Wow Animation
	======================================= */
	new WOW().init();

	/*=====================================
	  Mobile Menu Button
	======================================= */
	let navbarToggler = document.querySelector(".mobile-menu-btn");
	navbarToggler.addEventListener("click", function() {
		navbarToggler.classList.toggle("active");
	});

	$('.shopping-list').perfectScrollbar();          
	
	$('.order-popup-inner').perfectScrollbar();          
	
	$('.cart-sidebar,.close-button').on("click", function() {
		$('.shopping-item').toggleClass('active');
	});

	
		

		$('.accounts-top-btn a').on( "click", function(){
			$('.accounts-signin-top-form').toggleClass('active');
		});		
	
			
		
		$('select').niceSelect();
		
		
		$(document).on("click",".plus",function() {
		  var $button = $(this);
		  var $input = $button.closest('.sp-quantity').find("input.quntity-input");
		  if ($input.val() < $input.data('max')) {
		  	$input.val((i, v) => Math.max(0, +v + 1 * $button.data('multi')));
		  }
		 
		  
		});

		$(document).on("click",".minus",function() {
		  var $button = $(this);
		  var $input = $button.closest('.sp-quantity').find("input.quntity-input");
		 
		  	$input.val((i, v) => Math.max(0, +v + 1 * $button.data('multi')));
		  
		 
		  
		});
		

		$('.pricesvariations').on('change', function () {
			var id=$(this).val();
			if ($(this).is(':checked')){
				$('.variation'+id).addClass('active');
			}
			else{
				$('.variation'+id).removeClass('active');
			}
			
		});

		$('.color_single').on('change', function () {
			var id=$(this).val();
			var idName=$(this).attr('id');

			if ($(this).is(':checked')){
				$('.'+idName).html('<i class="icofont-verification-check"></i>');
			}
			else{
				$('.'+idName).html('');
			}
			
		});
		


		
	

})();

