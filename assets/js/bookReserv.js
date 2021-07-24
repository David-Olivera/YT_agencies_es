$(document).ready(function() {

    var path = 'https://www.bekaretransfers.com/';
    $('.thingsDepart, .box-finallyStep').hide();

    $('#hotel').bind("cut copy paste",function(event) {
          event.preventDefault();
      });

    //TRIGGER HOME -> RESERVE
    var transfHome = $('#trasHome').val();
    if (transfHome == null || transfHome.length == 0 || /^\s+$/.test(transfHome)) {
        console.log('Link directo a Reserve');
    } else {

        var hotel = $('#hotel').val();
        var pax = $('#pax option:selected').val();
        if (hotel == null || hotel.length == 0 || /^\s+$/.test(hotel)) {

            if(pax <= 2) { $('.lbl-paxs').text('1-2 Paxs'); }
            if(pax >= 3 && pax <= 5) { $('.lbl-paxs').text('3-5 Paxs'); }
            if(pax >= 6 && pax <= 10) { $('.lbl-paxs').text('6-10 Paxs'); }
            if(pax > 10) { $('.lbl-paxs').text(pax+' Paxs'); }

        } else {

            if(pax <= 2) { $('.lbl-paxs').text('1-2 Paxs'); }
            if(pax >= 3 && pax <= 5) { $('.lbl-paxs').text('3-5 Paxs'); }
            if(pax >= 6 && pax <= 10) { $('.lbl-paxs').text('6-10 Paxs'); }
            if(pax > 10) { $('.lbl-paxs').text(pax+' Paxs'); }

            $.ajax({
                data: { 'hotel' : hotel, 'rpax' : pax },
                url: path + 'helpers/helperAutocomplete.php',
                type: 'post',
                beforeSend: function() {
                    //$('#lblhotel').text('Looking...');
                },
                success: function(data) {
                    var response = $.parseJSON(data);
                    $('#price-ow').text('$'+response.pow+' USD');
                    $('#price-rt').text('$'+response.prt+' USD');
                }
            });
        }
        
        if(transfHome == 'SEN') { $('#trs-ow').trigger('click'); }
        if(transfHome == 'RED') { 
            $('#trs-rt').trigger('click'); 
            $('.thingsDepart').show('last');
            $('.sub-label input[name="direction"]').stop(true).fadeOut('last');
        }
    }

    //TYPE TRANSFER - ROUND TRIP
    $('#trs-rt').on('click', function(){

        if( $('#trs-rt').is(':checked') ) {

            $('.thingsDepart, .thingsArrival').stop(true).slideDown('last');
            $('.sub-label input[name="direction"]').stop(true).fadeOut('last');

        }

    });

    //TYPE TRANSFER - ONE WAY
    $('#trs-ow').on('click', function(){

        if( $('#trs-ow').is(':checked') ) {

            $('.thingsDepart').stop(true).slideUp('last');
            $('.thingsArrival').stop(true).slideDown('last');
            $('.sub-label input[name="direction"]').stop(true).fadeIn('last');
            //Reset radio checked
            $('#checkha').removeAttr('checked');
            $('#checkah').attr('checked','checked');

        }

    });


    //ONE WAY - AIRPORT TO HOTEL
    $("#checkah").on('click', function() {
        if ($("#checkah").is(':checked')) {
            
            $('.thingsDepart').stop(true).slideUp('last');
            $('.thingsArrival').stop(true).slideDown('last');

        }
    });

    //ONE WAY - HOTEL TO AIRPORT
    $("#checkha").click(function() {
        if ($("#checkha").is(':checked')) {
           
           $('.thingsArrival').stop(true).slideUp('last');
           $('.thingsDepart').stop(true).slideDown('last');

        }
    });


    //MAKE PICKUP SUGERIDO
    function pickupss(hora, minuto, formato, anticipo)
    {
        var suggest = parseInt(hora) - parseInt(anticipo);
        if(suggest < 0)
        {
            var suggestreal = parseInt(suggest) + parseInt(12);
            var pickformat = ( formato == "AM" ) ? 'PM' : 'AM';

            $('#hours-pick').val(suggestreal);
            $('#minets-pick').val(minuto);
            $('#turno-pick option[value='+ pickformat +']').attr('selected', true);
        }
        else if(suggest == 0)
        {
            $('#hours-pick').val('12');
            $('#minets-pick').val(minuto);
            $('#turno-pick option[value='+ formato +']').attr('selected', true);
        }
        else
        {
            $('#hours-pick').val(suggest);
            $('#minets-pick').val(minuto);
            $('#turno-pick option[value='+ formato +']').attr('selected', true);
            //$("#provincia option[value="+ valor +"]").attr("selected",true);
        }
    }


    //VALIDATE ARRIVAL TIME
    function arrivalTime() {

        valid = false;
        if ($('#hours-arriv').val() <= 0 || $('#hours-arriv').val() > 12)
        {
            alert('Enter a hour between 1 - 12');
            $('#hours-arriv').addClass('requiredV2');
            $('#hours-arriv').focus();
        } else {
            
            if ($('#minets-arriv').val() < 0 || $('#minets-arriv').val() > 59) {
                alert('Enter one minute between 0 - 59')
                $('#minets-arriv').addClass('requiredV2');
                $('#minets-arriv').focus();
            } 
            else {
                
                if ($('#minets-arriv').val() == null || $('#minets-arriv').val().length == 0 || /^\s+$/.test($('#minets-arriv').val())) {
                    $('#arrival').val($('#hours-arriv').val() + ':00 ' + $('#turno-arriv option:selected').text());
                    valid = true;
                }
                else {
                    $('#arrival').val($('#hours-arriv').val() + ':' + $('#minets-arriv').val() + ' ' + $('#turno-arriv option:selected').text());
                    valid = true;
                }
            }
        }

        return valid;

    }


    //VALIDATE DEPARTURE TIME
    function departureTime() {

        valid = false;
            
            if ($('#hours-dep').val() <= 0 || $('#hours-dep').val() > 12) {
                alert('Enter a hour between 1 - 12');
                $('#hours-dep').addClass('requiredV2');
                $('#hours-dep').focus();
            }
            else {
                if ($('#minets-dep').val() < 0 || $('#minets-dep').val() > 59) {
                    alert('Enter one minute between 0 - 59')
                    $('#minets-dep').addClass('requiredV2');
                    $('#minets-dep').focus();
                }
                else {
                    if ($('#minets-dep').val() == null || $('#minets-dep').val().length == 0 || /^\s+$/.test($('#minets-dep').val())) {
                        $('#departure').val($('#hours-dep').val() + ':00 ' + $('#turno-dep option:selected').text());
                        valid = true;
                    }
                    else {
                        $('#departure').val($('#hours-dep').val() + ':' + $('#minets-dep').val() + ' ' + $('#turno-dep option:selected').text());
                        valid = true;
                    }
                }
            }
        

        return valid;

    }


    //ACTIVATE STEP 2
    $('#priceService, .summary, .arrivalBox, .departBox').hide();
    function stepTwoActive() {

        if($('#trs-ow').is(':checked')) { 
            var price = $('#price-ow').text();
            if($('#checkah').is(':checked')) {
                var transfer = 'One Way - Airport to Hotel';
                $('.arrivalBox').show();
            } else {
                var transfer = 'One Way - Hotel to Airport';
                $('.departBox').show();
            }
            
        } else {
            var price = $('#price-rt').text();
            var transfer = 'Round Trip';
            $('.arrivalBox, .departBox').show();
        }

        if(price != '$null USD') {

            $('.box-firsTep').stop(true).slideUp('last');
            $('.box-finallyStep').stop(true).slideDown('last');


            $('#priceService, .summary').fadeIn('last');
            $('#priceService').text(price);
            $('#lblHotel').text($('#hotel').val());
            $('#lblTransfer').text(transfer);
            $('#lblPassengers').text($('#pax option:selected').val() + ' Passengers');

            $('#lblArrival').text($('#dateArriv').val());
            $('#lblAirline').text($('#airline').val());
            $('#lblArrivalTime').text($('#arrival').val());
            $('#lblFlight').text($('#numberfly').val());

            $('#lblDeparture').text($('#dateDepart').val());
            $('#lblAirlineOut').text($('#airlineout').val());
            $('#lblDepartureTime').text($('#departure').val());
            $('#lblFlightOut').text($('#flightout').val());

        } else {
            alert('Sorry we do not have the '+$('#hotel').val()+' on our list of hotels, please provide the area with the word "Area"');
        }

    }

    
    $('.infodep').hide();
    //Validacion Primer Paso
    $('#next-one, #btn-field').click(function(event) {
        event.preventDefault();

        var hotel = $('#hotel').val();

        if (hotel == null || hotel.length == 0 || /^\s+$/.test(hotel)) {
            $('#hotel').addClass('requiredV2');
            $('#hotel').focus();
        }
        else
        {
            var type_transfer = $('input[name="traslado"]:checked').val();
            //Traslado Sencillo
            if (type_transfer == 'SEN')
            {
                //SUBMIT FORM BOOK ENGINE HOME
                var referer = $('#btn-field').data('referer');
                if(referer == 'home') { $('#engine-home').submit(); }

                //Traslado Sencillo + Airport to Hotel
                if ($('#checkah').is(':checked'))
                {

                    var date_arrive = $('#dateArriv').val();
                    if (date_arrive == null || date_arrive.length == 0 || /^\s+$/.test(date_arrive)) {
                        alert('Choose a date please Arrivals');
                        $('#dateArriv').addClass('requiredV2');
                    }
                    else
                    {
                								
                        var valid = arrivalTime();
                        if (valid == true) {

                            var originair = $('#originAirp').val();
                            var airline = $('#airline').val();
                            var numberfly = $('#numberfly').val();
                             
                            if(originair == null || originair.length == 0 || /^\s+$/.test(airline)) {
                                $('#originAirp').addClass('requiredV2');
                                $('#originAirp').focus();
                            }
                            else
                            {

                                if (airline == null || airline.length == 0 || /^\s+$/.test(airline)) {
                                    $('#airline').addClass('requiredV2');
                                    $('#airline').focus();
                                }
                                else
                                {

                                    if (numberfly == null || numberfly.length == 0 || /^\s+$/.test(numberfly)) {
                                        $('#numberfly').addClass('requiredV2');
                                        $('#numberfly').focus();
                                    } 
                                    else {

                                        //Activate Step 2
                                        stepTwoActive();

                                    }
        
                                }
                            }        
                        }

                    }
                
                }

                //Traslado Sencillo + Hotel to Airport
                if ($('#checkha').is(':checked'))
                {
                    var date_depart = $('#dateDepart').val();
                    var time_depart = $('#timeDepart').val();
                    if (date_depart == null || date_depart.length == 0 || /^\s+$/.test(date_depart)) {
                        alert('Choose a date please Departure');
                        $('#dateDepart').addClass('requiredV2');
                    }
                    else
                    {

                        //VALIDACION HORARIOS							
                        var valid = departureTime();
                        if (valid == true) {

                            var destinair = $('#destinAirp').val();
                            var airlineout = $('#airlineout').val();
                            var flyout = $('#flightout').val();

                            if (destinair == null || destinair.length == 0 || /^\s+$/.test(destinair)) {
                                $('#destinAirp').addClass('requiredV2');
                                $('#destinAirp').focus();
                            }
                            else
                            {

                                if (airlineout == null || airlineout.length == 0 || /^\s+$/.test(airlineout)) {
                                    $('#airlineout').addClass('requiredV2');
                                    $('#airlineout').focus();
                                }
                                else
                                {        

                                    if (flyout == null || flyout.length == 0 || /^\s+$/.test(flyout)) {
                                        $('#flightout').addClass('requiredV2');
                                        $('#flightout').focus();
                                    }
                                    else
                                    {
                                        
                                        //PICKUP TIME
                                        /*if($('#minets-pick').val() == '')
                                        {
                                            var pickup = $('#hours-pick').val() + ':00 ' + $('#turno-pick option:selected').text();
                                        }
                                        else
                                        {
                                            var pickup = $('#hours-pick').val() + ':' + $('#minets-pick').val() + ' ' + $('#turno-pick option:selected').text(); 
                                        }

                                        $('#pickup').val(pickup);*/

                                        //Activate Step 2
                                        stepTwoActive();
                                        
                                    }
                                }
                            }
                        }
                    }
                }


            }
        
            //Traslado redondo
            if (type_transfer == 'RED')
            {

                //SUBMIT FORM BOOK ENGINE HOME
                var referer = $('#btn-field').data('referer');
                if(referer == 'home') { $('#engine-home').submit(); return false; }

                var date_arrive = $('#dateArriv').val();
                var date_depart = $('#dateDepart').val();


                if (date_arrive == null || date_arrive.length == 0 || /^\s+$/.test(date_arrive)) {
                    alert('Choose a date please Arrivals');
                    $('#dateArriv').addClass('requiredV2');
                }
                else
                {
                           
                    var validarriv = arrivalTime();
                    if (validarriv == true) {

                        var originair = $('#originAirp').val();
                        var airline = $('#airline').val();
                        var numberfly = $('#numberfly').val();

                        if (originair == null || originair.length == 0 || /^\s+$/.test(originair)) {
                            $('#originAirp').addClass('requiredV2');
                            $('#originAirp').focus();
                        }
                        else
                        {
                            if (airline == null || airline.length == 0 || /^\s+$/.test(airline)) {
                                $('#airline').addClass('requiredV2');
                                $('#airline').focus();
                            }
                            else
                            {
                                if (numberfly == null || numberfly.length == 0 || /^\s+$/.test(numberfly)) {
                                    $('#numberfly').addClass('requiredV2');
                                    $('#numberfly').focus();
                                }
                                else
                                {
                                    if (date_depart == null || date_depart.length == 0 || /^\s+$/.test(date_depart)) {
                                        alert('Choose a date please Departure');
                                        $('#dateDepart').addClass('requiredV2');
                                    }
                                    else
                                    {

                                        //VALIDACION HORARIOS
                                        var valid = departureTime();
                                        if (valid == true) {

                                            var destinair = $('#destinAirp').val();
                                            var airlineout = $('#airlineout').val();
                                            var flyout = $('#flightout').val();

                                            if (destinair == null || destinair.length == 0 || /^\s+$/.test(destinair)) {
                                                $('#destinAirp').addClass('requiredV2');
                                                $('#destinAirp').focus();
                                            }
                                            else
                                            {    
                                                if (airlineout == null || airlineout.length == 0 || /^\s+$/.test(airlineout)) {
                                                    $('#airlineout').addClass('requiredV2');
                                                    $('#airlineout').focus();
                                                }
                                                else
                                                {
                                                    if (flyout == null || flyout.length == 0 || /^\s+$/.test(flyout)) {
                                                        $('#flightout').addClass('requiredV2');
                                                        $('#flightout').focus();
                                                    }
                                                    else
                                                    {
                                                        //PICKUP TIME
                                                        /*if($('#minets-pick').val() == '')
                                                        {
                                                            var pickup = $('#hours-pick').val() + ':00 ' + $('#turno-pick option:selected').text();
                                                        }
                                                        else
                                                        {
                                                            var pickup = $('#hours-pick').val() + ':' + $('#minets-pick').val() + ' ' + $('#turno-pick option:selected').text(); 
                                                        }    

                                                        $('#pickup').val(pickup);*/

                                                        //Activate Step 2
                                                        stepTwoActive();
                                                    
                                                    }
                                                }
                                            }

                                        }
                                    }
                                }
                            }
                        }

                    }
                }

            }


        }

        

    });



    //Validacion Segundo Paso
    $('#btnBookNow').on('click', function(event) {
        event.preventDefault();

        var name = $('#nameuser').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var country = $('#pais').val();
        var comment = $('#comentario').val();

        if (name == null || name.length == 0 || /^\s+$/.test(name)) {
            $('#nameuser').addClass('requiredV2');
            $('#nameuser').focus();
        }
        else
        {
            if (!(/\w+([-+.']\w+)*@\w+([-.]\w+)/.test(email))) {
                $('#email').addClass('requiredV2');
                $('#email').focus();
            }
            else {
                if (phone == null || phone.length == 0 || /^\s+$/.test(phone)) {
                    $('#phone').addClass('requiredV2');
                    $('#phone').focus(); 
                }
                else {
                    if (country == 0) {
                        alert('Please select your origin');
                    }
                    else {

                        $('#btnBookNow').attr('disabled','disabled');
            
                        //VARS GROUP 1
                        var hotel = $('#hotel').val();
                        var paxs = $('#pax option:selected').val();
                        var transfer = $('input[name="traslado"]:checked').val();
                        if(transfer == 'SEN' && $('#checkah').is(':checked')) { transfer = transfer+'/AH'; }
                        if(transfer == 'SEN' && $('#checkha').is(':checked')) { transfer = transfer+'/HA'; }
                        var price = ($('input[name="traslado"]:checked').val() == 'SEN') ? $('#price-ow').text() : $('#price-rt').text();
                        price = price.replace('$', '');
                        price = price.replace(' USD', '');
                        price = parseFloat(price).toFixed(2);

                        //VARS GROUP 2
                        var arrival = $('#dateArriv').val();
                        var timeArriv = $('#arrival').val();
                        var origin = $('#originAirp').val();
                        var airline = $('#airline').val();
                        var nofly = $('#numberfly').val();
                        var departure = $('#dateDepart').val();
                        var timeDepart = $('#departure').val();
                        var destination = $('#destinAirp').val();
                        var airlineto = $('#airlineout').val();
                        var noflyto = $('#flightout').val();

                        //VARS GROUP 3
                        var methodPayment = $('#methodPay option:selected').val();
                        var cambio = 1;
                        var moneda = $('#moneda').val();

                        //AJAX INSERT VENTA
                        var addsale = {
                            "name": name,
                            "mail": email,
                            "phone": phone,
                            "country": country,
                            "comment": comment,
                            "serviceto": hotel,
                            "transfer": transfer,
                            "paxs" : paxs,
                            "amount" : price,
                            "arrival" : arrival,
                            "arrivalTime" : timeArriv,
                            "origin" : origin,
                            "airlinein" : airline,
                            "flyin" : nofly,
                            "departure" : departure,
                            "departureTime" : timeDepart,
                            "destination" : destination,
                            "airlineout" : airlineto,
                            "flyout" : noflyto,
                            "moneda": moneda,
                            "cambio": cambio,
                            "payment": methodPayment
                        };


                        $.ajax({
                            data: addsale,
                            url: path + 'helpers/helpersetVenta.php',
                            type: 'post',
                            
                            beforeSend: function() {
                                $('.boxSummary').addClass('opcsummary');
                                $('.reservating').fadeIn('last');
                            },
                            
                            success: function(data) {
                                var res = $.parseJSON(data);
                                
                                if(methodPayment == 'airport') {
                                    alert('Your reservation has been successfully made, thank you for choosing');
                                    location.href = "/completed";
                                }

                                if(methodPayment == 'paypal') {
                                    switch(transfer) {
                                        case 'SEN/AH':
                                        var iptName = 'One Way - Airport to Hotel';
                                        break;
                                        case 'SEN/HA':
                                        var iptName = 'One Way - Hotel to Airport';
                                        break;
                                        case 'RED':
                                        var iptName = 'Round Trip';
                                        break;
                                    }

                                    $('#item_name').val(iptName+' <> '+hotel);
                                    $('#amount').val(price);
                                    $('#invoice').val(res.invoice);
                                    $('#paypalPayment').submit();
                                }
                            

                                

                            }
                            
                        });
                        //END AJAX


                    }
                }
            }
            
        }

    });


    //GUARDAR DATOS DE LA RESERVA
    /*$('.btnBooks').on('click', function(event) {
        event.preventDefault();

        var methodPayment = $(this).data('payment');

        var translate = $('#traslado').val();
        if (translate == 'SEN'){
            if ($('#checkah').is(':checked')){
                translate = 'SEN/AH';
            }
            else
            {
                translate = 'SEN/HA';
            }
        }
        var nom = $('#nameuser').val();
        var ape = $('#lastname').val();
        var mail = $('#email').val();
        var phone = $('#phone').val();
        var pais = $('#pais').val();
        var comment = $('#comentario').val();
        var noAdult = $('#adults').val();
        var noLittle = $('#children').val();
        
        var moneda = $('#moneda').val();
        var servicio = $('#etservice').text();
        var airline = $('#etairline').text();
        var fly = $('#etfly').text();
        var origin = $('#etoriginair').text();
        var airlineout = $('#etairlineout').text();
        var flyout = $('#etflyout').text();
        var destin = $('#etdestinair').text();
        var pickup = $('#etpickup').text();
        var arrival = $('#etarrival').text();
        var depart = $('#etdepart').text();
        var time_arrive = $('#ettimearrival').text();
        var time_depart = $('#ettimedepart').text();



        var addventa = {
            "name": nom,
            "lastname": ape,
            "mail": mail,
            "phone": phone,
            "comment": comment,
            "country": pais,
            "transfer": translate,
            "airline": airline,
            "fly": fly,
            "origin" : origin,
            "airlineout" : airlineout,
            "flyout" : flyout,
            "destin" : destin,
            "mode": mode,
            "arrive": arrival,
            "depart": depart,
            "tarrive": time_arrive,
            "tdepart": time_depart,
            "pickup" : pickup,
            "adult": noAdult,
            "children": noLittle,
            "total": total,
            "moneda": moneda,
            "cambio": cambio,
            "servicio": servicio,
            "payment": methodPayment
        };


        $.ajax({
            data: addventa,
            url: path + 'helpers/helpersetVenta.php',
            type: 'post',
            
            beforeSend: function() {
                $('.boxSummary').addClass('opcsummary');
                $('.reservating').fadeIn('last');
            },
            
            success: function(data) {
                var response = $.parseJSON(data);
                $("#custom").val(response.id);
                $("#business").val('ediaz@disotravel.com');

                //alert(data);

                if (response.message == 'exito')
                {

                    if(methodPayment != 'airport') {

                        document.forms["frmPayPal1"].submit();
                        $('#custom').val(response.id);
                        return false;
                        document.frmPayPal1.submit();
                        return false;

                    }

                    $('.loaders').fadeOut('last', function() {
                            $('.exites').fadeIn('last');
                        });

                    $('.exito-reserv').hover(
                        function() {
                            if (moneda == 'us')
                            {
                                $(this).stop(true).text('BACK TO TOP');
                            }
                            if (moneda == 'mx')
                            {
                                $(this).stop(true).text('REGRESAR AL SITIO');
                            }
                        }, function() {
                            if (moneda == 'us')
                            {
                                $(this).stop(true).text('successful reservation process');
                            }
                            if (moneda == 'mx')
                            {
                                $(this).stop(true).text('RESERVACION EXITOSA');
                            }
                        });

                    $('.exito-reserv').on('click', function() {
                       if (moneda == 'us')
                        {
                            window.location.href = 'http://www.cuncierge.com';
                        }
                        if (moneda == 'mx')
                        {
                            window.location.href = 'http://www.cuncierge.com/es/';
                        }
                   });
                }

                

            }
            
        });
        //END AJAX
    
    });*/

    //Solo numeros
    //$('#phone').numeric();


    //Limpiando inputs con clase requiredV2
    $('input, textarea').on('click', function() {
        if ($(this).hasClass('requiredV2'))
        {
            $(this).removeClass('requiredV2');
            $(this).val('');
        }
    });

    //Auto complete hoteles
    $('.boxauto').hide();
    $('#hotel').on('keyup', function() {
        var hotel = $(this).val();
        var pax = $('#pax option:selected').val();

        var json = { "hotel" : hotel, "pax" : pax };

        $.ajax({
            data: json,
            url: path + 'helpers/helperAutocomplete.php',
            type: 'post',
            beforeSend: function() {
                //$('#lblhotel').text('Looking...');
            },
            success: function(data) {
                
                var response = $.parseJSON(data);
                $('.boxauto').fadeIn('last', function() {
                    $('.boxauto').html(response.autocomp);
                });
                
            }
        });

    });

    //Llenar campo hotel click autocomplete
    $('.itemautocomp').live('click', function(event) {
        event.preventDefault();

        var hotel = $(this).text();
        $('#hotel').val(hotel);
        var price_ow = $(this).data('priceow');
        var price_rt = $(this).data('pricert');

        $('#price-ow').text('$'+price_ow+' USD');
        $('#price-rt').text('$'+price_rt+' USD');

    });

    //Reset price on change paxes
    $('#pax').on('change', function(){
        
        var hotel = $('#hotel').val();
        var pax = $('#pax option:selected').val();
        if (hotel == null || hotel.length == 0 || /^\s+$/.test(hotel)) {

            if(pax <= 2) { $('.lbl-paxs').text('1-2 Paxs'); }
            if(pax >= 3 && pax <= 5) { $('.lbl-paxs').text('3-5 Paxs'); }
            if(pax >= 6 && pax <= 10) { $('.lbl-paxs').text('6-10 Paxs'); }
            if(pax > 10) { $('.lbl-paxs').text(pax+' Paxs'); }

        } else {

            if(pax <= 2) { $('.lbl-paxs').text('1-2 Paxs'); }
            if(pax >= 3 && pax <= 5) { $('.lbl-paxs').text('3-5 Paxs'); }
            if(pax >= 6 && pax <= 10) { $('.lbl-paxs').text('6-10 Paxs'); }
            if(pax > 10) { $('.lbl-paxs').text(pax+' Paxs'); }

            $.ajax({
                data: { 'hotel' : hotel, 'rpax' : pax },
                url: path + 'helpers/helperAutocomplete.php',
                type: 'post',
                beforeSend: function() {
                    //$('#lblhotel').text('Looking...');
                },
                success: function(data) {
                    var response = $.parseJSON(data);
                    $('#price-ow').text('$'+response.pow+' USD');
                    $('#price-rt').text('$'+response.prt+' USD');
                }
            });
        }

    });

    //Desaparecer autocomplete
    $('#hotel').on('focusout', function() {
        $('.boxauto').fadeOut('last');
    });

    //Listado de Zonas por hotel no encontrado
    /*$('#noHotel a').on('click', function(event) {
        event.preventDefault();

        $('#hotel').val();
        $('#hotel').addClass('disabledForm');
        $('#hotel').fadeOut('last', function() {

            //Agregar al DOM la lista de Zonas
            $('#noHotel').fadeOut('last', function() {
                $('#lblhotel').text('Zona');
                $('#zonas').fadeIn('last');
            });

        });

    });*/

    //Back del segundo paso al primero
    /*$('#back-one').on('click', function(event) {
        event.preventDefault();

        $('#rulltwo').removeClass('currentrull');
        $('#rullone').addClass('currentrull');

        $('#pinf').fadeOut('last', function() {
            $('#tinf').fadeIn('last');
        });

        $('.boxFormTwo').slideUp('last', function() {
            $('.boxFormOne').slideDown('last');
        });

    });*/



});