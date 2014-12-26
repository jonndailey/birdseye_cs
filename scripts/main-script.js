$(document).ready(function(){
			$("#message").click(function(){
				$("#theContact").slideDown("fast");
			});

			$('#submit').click(function(){
				$("#theContact").slideUp("fast", function(){
					$('#thanks').css("visibility","visible");
				});
			});

})

