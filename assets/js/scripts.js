<!-- BEGIN JIVOSITE CODE -->
(function(){ var widget_id = 'Vsz4zh5sua';var d=document;var w=window;function l(){ var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
<!-- END JIVOSITE CODE -->

$(window).load(function() {
    $('#slider').nivoSlider({
        effect: 'fade',
        animSpeed: 300,                 // Slide transition speed
        pauseTime: 5000
    });

    $('.flexslider').flexslider({
        animation: "slide"
    });

});

$(document).ready(function(){var n=!1;$(".sandwich").on("click",function(){0==n?($("#nav-mobile ul.menu").animate({height:"325px"}),n=!0):($("#nav-mobile ul.menu").animate({height:"35px"}),n=!1)})});

$(document).ready(function(){

    $('.tripcomment').readmore({
      moreLink: '<a href="#" class="readmorejs">Read more</a>',
      collapsedHeight: 86,
      afterToggle: function(trigger, element, expanded) {
        if(! expanded) { // The "Close" link was clicked
          $('html, body').animate({scrollTop: element.offset().top}, {duration: 100});
        }
      }
    });


    
    $( "#dateArriv" ).datepicker({
        minDate: "+1d",
        /*defaultDate: "+1w",*/
        onClose: function( selectedDate ) {
            $( "#dateDepart" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    
    $( "#dateDepart" ).datepicker({
        minDate: "+1d",
        /*defaultDate: "+1w",*/
        onClose: function( selectedDate ) {
            $( "#dateArriv" ).datepicker( "option", "maxDate", selectedDate );
        }
    });


    var pleca = false;
    $('.persistentContact .pleca').on('click', function(){

        if(pleca == false) {
            $('.persistentContact #perContact').css('display','block');
            pleca = true;
        } else {
            $('.persistentContact #perContact').css('display','none');
             pleca = false;
        }

    });

    $('#btn-prcontact').on('click', function(event){
        event.preventDefault();

        var ourChat = {
            'name' : $('#pr-fullName').val(),
            'email' : $('#pr-email').val(),
            'message' : $('#pr-message').val()
        };


        if (ourChat.name == null || ourChat.name.length == 0 || /^\s+$/.test(ourChat.name)) {
            $('#pr-fullName').focus();
            alert('His name is required');
            return false;
        }

        if(!(/\w+([-+.']\w+)*@\w+([-.]\w+)/.test(ourChat.email))) {
            $('#pr-email').focus();
            alert('His email is required');
            return false;
        }

        if (ourChat.message == null || ourChat.message.length == 0 || /^\s+$/.test(ourChat.message)) {
            $('#pr-message').focus();
            alert('Enter your comments');
            return false;
        }

        $.ajax({
            data:  { 'name' : ourChat.name, 'email' : ourChat.email, 'message' : ourChat.message },
            url:   'https://www.bekaretransfers.com/helpers/sendOurChat.php',
            type:  'post',
                                    
            beforeSend: function(){

            },

            success:  function (data) {
                var rs = $.parseJSON(data);
                alert(rs.message);

                $('#pr-fullName, #pr-email, #pr-message').val(' ');                  
            }


        });


    });


});