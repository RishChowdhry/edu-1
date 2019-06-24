
(function ($) {
    // All your code here
    $(document).ready(function() {
        $('#pagepiling').pagepiling({

            direction: 'vertical',

            onLeave: function(index, nextIndex, direction){
			//after leaving section 2
			if(index == 1 && direction =='down'){
                //alert("Going to section 2!");
                $('header').css({'display':'block'});
                $('footer').css({'color':'black'});

			}

			else if(index == 2 && direction == 'up'){
                //alert("Going to section 1!");
                $('header').css({'display':'none'});
                $('footer').css({'color':'white'});
			}
		}
            });

    });


  }(jQuery));
