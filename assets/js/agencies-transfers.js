$(function(){
    $('.btn_load').hide();
    $('#details_reservation').hide();
    $('#content_results').hide();    
    $('.content_interhotel').hide();
    $('.content_interhotel_2').hide();
    $('#content_search').hide();
    $('#content_bloquee').hide();
    $('#option_paypal').hide();
    $('#option_cash').hide();
    $('#option_card').hide();
    $('#inps_entrada').hide();
    $('#inps_salida').hide();
    $('#inp_pickup_enter').hide();
    $('#inp_pickup_exit').hide(); 
    $("#alert-msg").hide();
    $('#btn-anuncio').hide();
    loadTimeReservation();


        $(document).on('click', '#close-anuncio', function(){
            $('#anuncio').hide('slow');
            $('#btn-anuncio').show('slow');

        });
        $(document).on('click', '#btn-anuncio', function(){
            $('#anuncio').show('slow');
            $('#btn-anuncio').hide('slow');

        });

       //Btn x de alert mensaje
        $("#alert-close").click(function(){
            $("#alert-msg").hide('slow');

        });
        // datepicker
        $(function() {        
            var $datepicker2 = $( "#datepicker_end" );
            let inp_todaysale = $('#inp_todaysale').val();
            let todaysale = 0;
            if (inp_todaysale == 1 || inp_todaysale == 0) {
                todaysale = $('#inp_todaysale').val();
            }else{
                todaysale = 0;
            }
            var minDateArg = todaysale == 1 ? 0 : '+1d';
            $('#datepicker_star').datepicker( {
                language: 'es',
                minDate: minDateArg,
                onSelect: function(fecha) {
                    $datepicker2.datepicker({
                        language: 'es',       
                        minDate: new Date(),
    
                    });
                    $datepicker2.datepicker("option", "disabled", false);
                    $datepicker2.datepicker('setDate', null);
                    $datepicker2.datepicker("option", "minDate", fecha); 
                }
            });
            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '<Ant',
                nextText: 'Sig>',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                weekHeader: 'Sm',
                dateFormat: 'yy-mm-dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
              };
              $.datepicker.setDefaults($.datepicker.regional['es']);
        });
        // datepicker edit
        $("#datepicker_star_edit").datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: "+1w",
            dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
            monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
            changeMonth: true,
            changeYear: true,
            onClose: function( selectedDate ) {
                $("#datepicker_end_edit").datepicker( "option", "minDate", selectedDate );
            }
        });
        $("#datepicker_end_edit").datepicker({
            defaultDate: "+1w",
            dateFormat: "yy-mm-dd",
            dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
            monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
            changeMonth: true,
            changeYear: true,
            onClose: function( selectedDate ) {
                $("#datepicker_star_edit" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
        
        function loadTimeReservation(){
            var dt = new Date();
            var time = dt.getHours();
            if (time < 8 || time >= 20){
                $('#content_search').show();
                var $datepicker2 = $( "#datepicker_end" );
                let inp_todaysale = $('#inp_todaysale').val();
                let todaysale = 0;
                if (inp_todaysale == 1 || inp_todaysale == 0) {
                    todaysale = $('#inp_todaysale').val();
                }else{
                    todaysale = 0;
                }
                var minDateArg = todaysale == 1 ? 0 : '+2d';
                $('#datepicker_star').datepicker( {
                    language: 'es',
                    minDate: minDateArg,
                    onSelect: function(fecha) {
                        $datepicker2.datepicker({
                            language: 'es',       
                            minDate: new Date(),
        
                        });
                        $datepicker2.datepicker("option", "disabled", false);
                        $datepicker2.datepicker('setDate', null);
                        $datepicker2.datepicker("option", "minDate", fecha); 
                    }
                });   
            }else{
                $('#content_search').show();

            }
        }
        $( "#datepicker_end"  ).focus(function() {
            let date = $('#datepicker_star').val();
            if (date == '') {
                $('#datepicker_star').addClass(' is-invalid');
                $('#datepicker_star').focus();
            }
        });
        //Tipo de traslado
        $(document).on('change', '#inp_traslado', function(){
            $('#datepicker_star').val('');
            $('#datepicker_end').val('');
            let value = "";
            value = $(this).val();
            if (value == '') {
                $('#label_date_star').text('Entrada');
                $('#content_date_star').show('slow');
                $('#content_date_end').show('slow');
            }
            if (value == 'SEN/AH') {
                $('#label_date_star').text('Entrada');
                $('#content_date_star').show('slow');
                $('#content_date_end').hide('slow');
                $('.content_interhotel').hide('slow');
            }
            if (value == 'SEN/HH') {
                $('#label_date_star').text('Entrada');
                $('#content_date_star').show('slow');
                $('#content_date_end').hide('slow');
                $('.content_interhotel').show('slow');
            }
            if (value == 'SEN/HA') {
                $('#label_date_star').text('Salida');
                $('#content_date_star').show('slow');
                $('.content_interhotel').hide('slow');
                $('#content_date_end').hide('slow');
            }
            if (value == 'RED') {
                $('#label_date_star').text('Entrada');
                $('#content_date_star').show('slow');
                $('#content_date_end').show('slow');
                $('.content_interhotel').hide('slow');
            }
            if (value == 'REDHH') {
                $('#label_date_star').text('Entrada');
                $('#content_date_star').show('slow');
                $('#content_date_end').show('slow');
                $('.content_interhotel').show('slow');
            }
        });

        //Tipo de traslado edit
        $(document).on('change', '#inp_traslado_edit', function(){
            let value = "";
            value = $(this).val();
            if (value == '') {
                $('#content_date_star_edit').show('slow');
                $('#content_date_end_edit').show('slow');
                $('.content_interhotel_2').hide();
            }
            if (value == 'SEN/AH') {
                $('#content_date_star_edit').show('slow');
                $('#content_date_end_edit').hide('slow');
                $('.content_interhotel_2').hide();
                $('.content_pasajeros').removeClass('col-md-1');
                $('.content_pasajeros').addClass('col-md-2');
                $('#content_btn_search').removeClass();
                $('#content_btn_search').addClass('form-inline col-md-3 pl-3 pr-3');
            }
            if (value == 'SEN/HH') {
                $('#content_date_star_edit').show('slow');
                $('#content_date_end_edit').hide('slow');
                $('.content_interhotel').show('slow');
                $('.content_hotel_1').removeClass('col-md-3');
                $('.content_hotel_1').addClass('col-md-2');
                $('.content_interhotel_2').show('slow');
                $('.content_pasajeros').removeClass('col-md-1');
                $('.content_pasajeros').addClass('col-md-2');
                $('#content_btn_search').removeClass();
                $('#content_btn_search').addClass(' form-inline col-md-1 pl-3 pr-3');
            }
            if (value == 'SEN/HA') {
                $('#content_date_star_edit').show('slow');
                $('#content_date_end_edit').hide('slow');
                $('.content_interhotel_2').hide();
                $('.content_pasajeros').removeClass('col-md-1');
                $('.content_pasajeros').addClass('col-md-2');
                $('#content_btn_search').removeClass();
                $('#content_btn_search').addClass('form-inline col-md-3 pl-3 pr-3');
            }
            if (value == 'RED') {
                $('#content_btn_search').removeClass();
                $('#content_btn_search').addClass('form-inline col-md-1 pl-3 pr-3');
                $('#content_date_star_edit').show('slow');
                $('#content_date_end_edit').show('slow');
                $('.content_interhotel_2').hide();
                $('.content_pasajeros').removeClass('col-md-1');
                $('.content_pasajeros').addClass('col-md-2');
            }
            if (value == 'REDHH') {
                $('#content_btn_search').removeClass();
                $('#content_btn_search').addClass('form-inline col-md-1 pl-3 pr-3');
                $('#content_date_star_edit').show('slow');
                $('#content_date_end_edit').show('slow');
                $('.content_interhotel').show('slow');
                $('.content_hotel_1').removeClass('col-md-3');
                $('.content_hotel_1').addClass('col-md-2');
                $('.content_interhotel_2').show('slow');
                $('.content_pasajeros').removeClass('col-md-2');
                $('.content_pasajeros').addClass('col-md-1');
            }
        });

        //Search Reservacion
        $(document).on('click', '#btn_search_reserva', function(e){
            e.preventDefault();
            let hotel = $('#inp_hotel').val();
            let interhotel = "";
            let pasajeros = $('#inp_pasajeros').val();
            let traslado = $('#inp_traslado').val();
            let f_llegada = $('#datepicker_star').val();
            let f_salida = $('#datepicker_end').val();
            let operadora = $('#inp_operadora').val();
            if (hotel == null || hotel.length == 0 || /^\s+$/.test(hotel)) {
                $('#inp_hotel').addClass(" is-invalid");
                $('#inp_hotel').focus();
                return false;
            }
            if (traslado == 'REDHH' ||traslado == 'SEN/HH') {
                interhotel = $('#inp_hotel_2').val();
                if (interhotel == null || interhotel.length == 0 || /^\s+$/.test(interhotel)) {
                    $('#inp_hotel_2').addClass(" is-invalid");
                    $('#inp_hotel_2').focus();
                    return false;
                }
            }
            if (traslado == null || traslado.length == 0 || /^\s+$/.test(traslado)) {
                $('#inp_traslado').addClass(" is-invalid");
                $('#inp_traslado').focus();
                return false;
            }
            if (pasajeros == null || pasajeros.length == 0 || /^\s+$/.test(pasajeros)) {
                $('#inp_pasajeros').addClass(" is-invalid");
                $('#inp_pasajeros').focus();
                return false;
            }
            if (f_llegada == null || f_llegada.length == 0 || /^\s+$/.test(f_llegada)) {
                $('#datepicker_star').addClass(" is-invalid");
                $('#datepicker_star').focus();
                return false;
            }
            if (traslado == 'RED') {
                if (f_salida == null || f_salida.length == 0 || /^\s+$/.test(f_salida)) {
                    $('#datepicker_end').addClass(" is-invalid");
                    $('#datepicker_end').focus();
                    return false;
                }    
            }
            const postDatas = {
                'hotel': hotel,
                'interhotel': interhotel,
                'pasajeros': pasajeros,
                'traslado': traslado,
                'date_star': f_llegada,
                'date_end': f_salida,
                'operadora':operadora,
                'search_traslado': true
            };
            $.ajax({
                data: postDatas,
                url: '../helpers/traslados.php',
                type: 'post',
                beforeSend: function(){
                    let template = '';
                    template += `    
                        <div class="loader"></div>
                    `;
                    $('#loading').html(template);
                },
                success: function(data){
                    let inp_todaysale = $('#inp_todaysale').val();
                    let todaysale = 0;
                    $('#inp_type_traslate').val(traslado);
                    if (inp_todaysale == 1 || inp_todaysale == 0) {
                        todaysale = $('#inp_todaysale').val();
                    }else{
                        todaysale = 0;
                    }
                    var minDateArg = todaysale == 1 ? 0 : '+1d';
                    $('#inp_hotel_edit').val(hotel);
                    if (traslado == 'REDHH' || traslado == 'SEN/HH') {
                        $('.content_interhotel_2').show();
                        $('#inp_hotel_edit_2').val(interhotel);
                        $('.content_hotel_1').removeClass('col-md-3');
                        $('.content_hotel_1').addClass('col-md-2');
                        $('.content_pasajeros').removeClass('col-md-2');
                        $('.content_pasajeros').addClass('col-md-1');
                    }
                    $('#inp_pasajeros_edit').val(pasajeros);
                    $('#inp_traslado_edit').val(traslado);
                    $("#datepicker_star_edit").datepicker({
                        language: 'es',
                        minDate: f_llegada,
                    });
                    $("#datepicker_star_edit").datepicker('setDate', new Date(f_llegada));
                    $("#datepicker_star_edit").datepicker( "option", "minDate", f_llegada );
                    if (f_salida) {
                        $("#datepicker_end_edit").datepicker( "option", "minDate", f_salida );
                        $("#datepicker_end_edit").datepicker('setDate', new Date(f_salida));
                    }
                    if (traslado == 'RED' || traslado == 'REDHH') {
                        $('#content_btn_search').addClass('col-md-1 pl-3 pr-3');
                    }
                    if (traslado == 'SEN/HH') {
                        $('#content_date_end_edit').hide();
                        $('.content_pasajeros').removeClass('col-md-1');
                        $('.content_pasajeros').addClass('col-md-2');
                        $('#content_btn_search').addClass('col-md-2 pl-3 pr-3');
                    }
                    if (traslado == 'SEN/HA' || traslado == 'SEN/AH') {
                        $('#content_btn_search').addClass('col-md-3 pl-3 pr-3');
                        $('#content_date_end_edit').hide();
                    }
                    $('.content_card_results').html(data);
                    $(".loader").fadeOut("slow");
                    $("div#content_search").hide( "drop", { direction: "left"}, "slow" );
                    $("#content_results").show( "drop", { direction: "right" }, "slow" );
                    $("html, body").animate({scrollTop: 0}, 1000);
                }
            });

        });
        //Search Reservaion Edit
        $(document).on('click', '#btn_search_reserva_edit', function(e){
            e.preventDefault();
            let hotel = $('#inp_hotel_edit').val();
            let interhotel = '';
            let pasajeros = $('#inp_pasajeros_edit').val();
            let traslado = $('#inp_traslado_edit').val();
            let f_llegada = $('#datepicker_star_edit').val();
            let f_salida = $('#datepicker_end_edit').val();
            let operadora = $('#inp_operadora').val();
            if (hotel == null || hotel.length == 0 || /^\s+$/.test(hotel)) {
                $('#inp_hotel_edit').addClass(" is-invalid");
                $('#inp_hotel_edit').focus();
                return false;
            }
            if (traslado == 'REDHH' ||traslado == 'SEN/HH') {
                interhotel = $('#inp_hotel_edit_2').val();
                if (interhotel == null || interhotel.length == 0 || /^\s+$/.test(interhotel)) {
                    $('#inp_hotel_edit_2').addClass(" is-invalid");
                    $('#inp_hotel_edit_2').focus();
                    return false;
                }
            }
            if (pasajeros == null || pasajeros.length == 0 || /^\s+$/.test(pasajeros)) {
                $('#inp_pasajeros_edit').addClass(" is-invalid");
                $('#inp_pasajeros_edit').focus();
                return false;
            }
            if (traslado == null || traslado.length == 0 || /^\s+$/.test(traslado)) {
                $('#inp_traslado_edit').addClass(" is-invalid");
                $('#inp_traslado_edit').focus();
                return false;
            }
            if (f_llegada == null || f_llegada.length == 0 || /^\s+$/.test(f_llegada)) {
                $('#datepicker_star_edit').addClass(" is-invalid");
                $('#datepicker_star_edit').focus();
                return false;
            }
            if (traslado == 'REDHH' || traslado == 'RED') {
                if (f_salida == null || f_salida.length == 0 || /^\s+$/.test(f_salida)) {
                    $('#datepicker_end_edit').addClass(" is-invalid");
                    $('#datepicker_end_edit').focus();
                    return false;
                }    
            }
            const postDatas = {
                'hotel': hotel,
                'interhotel': interhotel,
                'pasajeros': pasajeros,
                'traslado': traslado,
                'date_star': f_llegada,
                'date_end': f_salida,
                'operadora':operadora,
                'search_traslado': true
            };
            $.ajax({
                data: postDatas,
                url: '../helpers/traslados.php',
                type: 'post',
                beforeSend: function(){
                    let template = '';
                    template += `    
                        <div class="loader"></div>
                    `;
                    $('#loading').html(template);
                },
                success: function(data){
                    let inp_todaysale = $('#inp_todaysale').val();
                    let todaysale = 0;
                    $('#inp_type_traslate').val(traslado);
                    if (inp_todaysale == 1 || inp_todaysale == 0) {
                        todaysale = $('#inp_todaysale').val();
                    }else{
                        todaysale = 0;
                    }
                    var minDateArg = todaysale == 1 ? 0 : '+1d';
                    $('#inp_hotel_edit').val(hotel);
                    if (traslado == 'REDHH' ||traslado == 'SEN/HH') {
                        $('.content_interhotel_2').show();
                        $('#inp_hotel_edit_2').val(interhotel);
                        $('.content_hotel_1').removeClass('col-md-3');
                        $('.content_hotel_1').addClass('col-md-2');
                    }
                    $('#inp_pasajeros_edit').val(pasajeros);
                    $('#inp_traslado_edit').val(traslado);
                    $("#datepicker_star_edit").datepicker('setDate', new Date(f_llegada));
                    $("#datepicker_star_edit").datepicker( "option", "minDate", f_llegada );
                    if (f_salida) {
                        $("#datepicker_end_edit").datepicker( "option", "minDate", f_salida );
                        $("#datepicker_end_edit").datepicker('setDate', new Date(f_salida));
                    }else{
                        $('#content_date_end_edit').hide();
                        $('#content_btn_search').addClass('col-md-1 pl-3 pr-3');
                    }
                    $('.content_card_results').html(data);
                    $(".loader").fadeOut("slow");
                    $("div#content_search").hide( "drop", { direction: "left"}, "slow" );
                    $("#content_results").show( "drop", { direction: "right" }, "slow" );
                }
            });

        });
        
        //Form details reservation
        $(document).on('click', '#init_reserva', function(e){
            $("#content_results").hide( "drop", { direction: "left"}, "slow" );
            $("#details_reservation").show( "drop", { direction: "right" }, "slow" );
            $('.content_h_destino').hide();
            $('.content_descuento').hide();
            $('#content_time_service').hide();
            $('.content_descuento_operadora').hide();
            $('#content_descuento_electronic').hide();
            $('.btn_load').hide();
            $('.content_mprecio').hide();
            $('#finish_reserv').show();
            e.preventDefault();
            let hotel = $('#name_hotel').text();
            let a_traslado = $('#inp_type_traslate').val();
            let traslado = $('#name_traslado').text();
            let pasajeros =$(this).data('pasajeros');
            let precio_mxn_ow = $(this).data('rate-ow');
            let precio_us_ow = $(this).data('rateus-ow');
            let precio_mxn_rt = $(this).data('rate-rt');
            let precio_us_rt = $(this).data('rateus-rt');
            let type_traslado = $(this).data('type');
            let operadora = $(this).data('operadora');
            let id_operadora = $('#inp_operadora').val();
            let new_type_traslado = "";
            let paypal = $('#inp_paypal').val();
            let cash = $('#inp_cash').val();
            let card = $('#inp_card').val();
            let interhotel = "";
            let type_change = $(this).data('tchange');
            let f_llegada = $(this).data('fllegada');
            let f_salida = 0;
            if ($(this).data('fsalida')) {
                f_salida = $(this).data('fsalida');
            }
            switch (type_traslado) {
                case 'compartido':
                    new_type_traslado ="Compartido";
                    break;
                case 'privado':
                    new_type_traslado = "Privado";
                    break;
                case 'lujo':
                    new_type_traslado = "Lujo";
                    break;
            }
            if (type_traslado == 'compartido' && (a_traslado == "RED" || a_traslado == 'SEN/AH')) {
                $('#content_time_service').show();
                
            }
            if (a_traslado == 'REDHH' || a_traslado == 'SEN/HH') {
                 interhotel = $('#name_interhotel').text();
            }
            $('#traslado_resumen').text(new_type_traslado);
            $('#_TYPE_TRANSFER').val(type_traslado);
            $('#servicio_resumen').text(traslado);
            $('#_TYPE_SERVICE').val(a_traslado);
            $('#h_origen_resumen').text(hotel);
            $('#_ORIGIN_HOTEL').val(hotel);
            $('#_DATE_ENTRY').val(f_llegada);
            $('#_DATE_EXIT').val(f_salida);
            $('#_TYPE_CHANGE').val(type_change);
            $('#_PAYMENT').val('card');
            $('#_TYPE_CURRENCY').val('MXN');
            if (a_traslado == 'REDHH' || a_traslado == 'SEN/HH') {
                $('#h_destino_resumen').text(interhotel);
                $('#_DESTINY_HOTEL').val(interhotel);
                $('.content_h_destino').show();
            }
            $('#pasajeros_resumen').text(pasajeros);
            $('#_NUMBER_PAS').val(pasajeros);
            let descuento = 0.05;
            let cargo = 0.95;
            let valor_descuento_mx = 0;
            let valor_descuento_us = 0;
            var valor_descuento_mx_ope = 0;
            var valor_descuento_us_ope = 0;
            var valor_descuento_mx_ope_tp = 0;
            var valor_descuento_us_ope_tp = 0;
            var finally_valor_descuento_mx_ope_tp = 0;
            var finally_valor_descuento_us_ope_tp = 0;
            let porcentaje = 5;
            $('#porcentaje').text(porcentaje + '%');
            $('#porcentaje_operadora').text(parseFloat(operadora) + '%');
            let nuevo_valor_mx = 0; 
            let nuevo_valor_us = 0;
            let nuevo_valor_mx_ope = 0; 
            let nuevo_valor_us_ope = 0;
            var new_porcen = 0;
            let descuento_operador = 0.05;
          
            if (id_operadora == 1) {
                descuento_operador = 0.85;
                new_porcen = operadora /= 100;
                $('.content_descuento_operadora').show('slow');
            }
            console.log(descuento_operador);
            if (a_traslado == 'RED' || a_traslado == 'REDHH') {
                nuevo_valor_mx = (precio_mxn_rt / cargo).toFixed(0);
                nuevo_valor_us = (precio_us_rt / cargo).toFixed(0);
                valor_descuento_mx = (nuevo_valor_mx * descuento).toFixed(0);
                valor_descuento_us = (nuevo_valor_us * descuento).toFixed(0);

                //Operator
                // nuevo_valor_mx_ope = (precio_mxn_ow / descuento_operador).toFixed(0);
                // nuevo_valor_us_ope = (precio_us_ow / descuento_operador).toFixed(0);
                // console.log(precio_mxn_ow + '/'+descuento_operador + '='+ nuevo_valor_mx_ope);
                // console.log(precio_us_ow + '/'+descuento_operador + '='+nuevo_valor_us_ope);
                console.log('VALOR DE DESCUENTO DEL 10% A TRANSFERENCIA Y PAGO AL ABORDAR');
                valor_descuento_mx_ope = (precio_mxn_rt * new_porcen).toFixed(0);
                valor_descuento_us_ope = (precio_us_rt  * new_porcen).toFixed(0);
                console.log(precio_mxn_rt + '*'+new_porcen + '='+ valor_descuento_mx_ope);
                console.log(precio_us_rt  + '*'+new_porcen + '='+valor_descuento_us_ope); 

                finally_valor_descuento_mx_ope = (precio_mxn_rt - valor_descuento_mx_ope).toFixed(0);
                finally_valor_descuento_us_ope = (precio_us_rt  - valor_descuento_us_ope).toFixed(0); 
                console.log('EL NUEVO VALOR DE DESCUENTO DEL 10% A TRANSFERENCIA Y PAGO AL ABORDAR');
                console.log(precio_mxn_rt + '-'+valor_descuento_mx_ope + '='+ finally_valor_descuento_mx_ope);
                console.log(precio_us_rt  + '-'+valor_descuento_us_ope + '='+finally_valor_descuento_us_ope);
                
                console.log('VALOR DE DESCUENTO DEL 10% AL TARJETA Y PAYPAL');
                valor_descuento_mx_ope_tp = (nuevo_valor_mx * new_porcen).toFixed(0);
                valor_descuento_us_ope_tp = (nuevo_valor_us * new_porcen).toFixed(0); 
                console.log(nuevo_valor_mx + '*'+new_porcen + '='+ valor_descuento_mx_ope_tp);
                console.log(nuevo_valor_us + '*'+new_porcen + '='+valor_descuento_us_ope_tp);

                finally_valor_descuento_mx_ope_tp = (nuevo_valor_mx - valor_descuento_mx_ope_tp).toFixed(0);
                finally_valor_descuento_us_ope_tp = (nuevo_valor_us - valor_descuento_us_ope_tp).toFixed(0); 
                console.log('EL NUEVO VALOR DE DESCUENTO DEL 10% AL TARJETA Y PAYPAL');
                console.log(nuevo_valor_mx + '-'+valor_descuento_mx_ope_tp + '='+ finally_valor_descuento_mx_ope_tp);
                console.log(nuevo_valor_us + '-'+valor_descuento_us_ope_tp + '='+ finally_valor_descuento_us_ope_tp);

                $('#info_import').text(nuevo_valor_mx);
                $('#inp_amount_total_mxn').val(precio_mxn_rt);
                $('#inp_amount_total_usd').val(precio_us_rt);
                $('#_TOTAL_MXN').val(nuevo_valor_mx);
                $('#_TOTAL_USD').val(nuevo_valor_us);
                $('#_AMOUNT_TOTAL').val(nuevo_valor_mx);
                if (id_operadora == 1) {
                    $('#_AMOUNT_TOTAL').val(finally_valor_descuento_mx_ope_tp);              
                    $('#info_import').text(finally_valor_descuento_mx_ope_tp);
                    $('#descuento_resumen_operadora').val(valor_descuento_mx_ope_tp);
                }
                $('#info_import').attr('data-ratemx', precio_mxn_rt);
                $('#info_import').attr('data-rateus', precio_us_rt);
                $('#info_import').attr('data-ratemx_c', nuevo_valor_mx);
                $('#info_import').attr('data-rateus_c', nuevo_valor_us);
                $('#info_import').attr('data-discountmx', valor_descuento_mx);
                $('#info_import').attr('data-discountus', valor_descuento_us);
                $('#info_import').attr('data-operator', id_operadora);
                $('#info_import').attr('data-ratemx_ope', finally_valor_descuento_mx_ope);
                $('#info_import').attr('data-rateus_ope', finally_valor_descuento_us_ope);
                $('#info_import').attr('data-discountmxope', valor_descuento_mx_ope);
                $('#info_import').attr('data-discountusope', valor_descuento_us_ope);

                $('#info_import').attr('data-ratemx_ope_tp', finally_valor_descuento_mx_ope_tp);
                $('#info_import').attr('data-rateus_ope_tp', finally_valor_descuento_us_ope_tp);
                $('#info_import').attr('data-discountmxope_tp', valor_descuento_mx_ope_tp);
                $('#info_import').attr('data-discountusope_tp', valor_descuento_us_ope_tp);
                
            }
            if (a_traslado == 'SEN/AH' || a_traslado == 'SEN/HA' || a_traslado == 'SEN/HH') {
                nuevo_valor_mx = (precio_mxn_ow / cargo).toFixed(0);
                nuevo_valor_us = (precio_us_ow / cargo).toFixed(0); 
                valor_descuento_mx = (nuevo_valor_mx * descuento).toFixed(0);
                valor_descuento_us = (nuevo_valor_us * descuento).toFixed(0); 

                //Operator
                // nuevo_valor_mx_ope = (precio_mxn_ow / descuento_operador).toFixed(0);
                // nuevo_valor_us_ope = (precio_us_ow / descuento_operador).toFixed(0);
                // console.log(precio_mxn_ow + '/'+descuento_operador + '='+ nuevo_valor_mx_ope);
                // console.log(precio_us_ow + '/'+descuento_operador + '='+nuevo_valor_us_ope);
                console.log('VALOR DE DESCUENTO DEL 10% A TRANSFERENCIA Y PAGO AL ABORDAR');
                valor_descuento_mx_ope = (precio_mxn_ow * new_porcen).toFixed(0);
                valor_descuento_us_ope = (precio_us_ow  * new_porcen).toFixed(0);
                console.log(precio_mxn_ow + '*'+new_porcen + '='+ valor_descuento_mx_ope);
                console.log(precio_us_ow  + '*'+new_porcen + '='+valor_descuento_us_ope); 

                finally_valor_descuento_mx_ope = (precio_mxn_ow - valor_descuento_mx_ope).toFixed(0);
                finally_valor_descuento_us_ope = (precio_us_ow  - valor_descuento_us_ope).toFixed(0); 
                console.log('EL NUEVO VALOR DE DESCUENTO DEL 10% A TRANSFERENCIA Y PAGO AL ABORDAR');
                console.log(precio_mxn_ow + '-'+valor_descuento_mx_ope + '='+ finally_valor_descuento_mx_ope);
                console.log(precio_us_ow  + '-'+valor_descuento_us_ope + '='+finally_valor_descuento_us_ope);
                
                console.log('VALOR DE DESCUENTO DEL 10% AL TARJETA Y PAYPAL');
                valor_descuento_mx_ope_tp = (nuevo_valor_mx * new_porcen).toFixed(0);
                valor_descuento_us_ope_tp = (nuevo_valor_us * new_porcen).toFixed(0); 
                console.log(nuevo_valor_mx + '*'+new_porcen + '='+ valor_descuento_mx_ope_tp);
                console.log(nuevo_valor_us + '*'+new_porcen + '='+valor_descuento_us_ope_tp);

                finally_valor_descuento_mx_ope_tp = (nuevo_valor_mx - valor_descuento_mx_ope_tp).toFixed(0);
                finally_valor_descuento_us_ope_tp = (nuevo_valor_us - valor_descuento_us_ope_tp).toFixed(0); 
                console.log('EL NUEVO VALOR DE DESCUENTO DEL 10% AL TARJETA Y PAYPAL');
                console.log(nuevo_valor_mx + '-'+valor_descuento_mx_ope_tp + '='+ finally_valor_descuento_mx_ope_tp);
                console.log(nuevo_valor_us + '-'+valor_descuento_us_ope_tp + '='+ finally_valor_descuento_us_ope_tp);

                $('#inp_amount_total_mxn').val(precio_mxn_ow);
                $('#inp_amount_total_usd').val(precio_us_ow);
                $('#_TOTAL_MXN').val(nuevo_valor_mx);
                $('#_TOTAL_USD').val(nuevo_valor_us);
                $('#_AMOUNT_TOTAL').val(nuevo_valor_mx);              
                $('#info_import').text(nuevo_valor_mx);
                if (id_operadora == 1) {
                    $('#_AMOUNT_TOTAL').val(finally_valor_descuento_mx_ope_tp);              
                    $('#info_import').text(finally_valor_descuento_mx_ope_tp);
                    $('#descuento_resumen_operadora').val(valor_descuento_mx_ope_tp);
                }
                $('#info_import').attr('data-ratemx', precio_mxn_ow);
                $('#info_import').attr('data-rateus', precio_us_ow);
                $('#info_import').attr('data-ratemx_c', nuevo_valor_mx);
                $('#info_import').attr('data-rateus_c', nuevo_valor_us);
                $('#info_import').attr('data-discountmx', valor_descuento_mx);
                $('#info_import').attr('data-discountus', valor_descuento_us);
                $('#info_import').attr('data-operator', id_operadora);
                $('#info_import').attr('data-ratemx_ope', finally_valor_descuento_mx_ope);
                $('#info_import').attr('data-rateus_ope', finally_valor_descuento_us_ope);
                $('#info_import').attr('data-discountmxope', valor_descuento_mx_ope);
                $('#info_import').attr('data-discountusope', valor_descuento_us_ope);

                $('#info_import').attr('data-ratemx_ope_tp', finally_valor_descuento_mx_ope_tp);
                $('#info_import').attr('data-rateus_ope_tp', finally_valor_descuento_us_ope_tp);
                $('#info_import').attr('data-discountmxope_tp', valor_descuento_mx_ope_tp);
                $('#info_import').attr('data-discountusope_tp', valor_descuento_us_ope_tp);
                
                
            }

            switch (a_traslado) {
                case 'SEN/HA':
                    $('#inps_salida').show();
                    break;
                case 'SEN/AH':
                    $('#inps_entrada').show();
                    break;
                case 'RED':
                    $('#inps_entrada').show();
                    $('#inps_salida').show();
                    break;
                case 'REDHH':
                    $('#inp_pickup_enter').show();
                    $('#inp_pickup_exit').show();
                    break;
                case 'SEN/HH':
                    $('#inp_pickup_enter').show();
                    break;
                    
            }
            if (paypal == 1) {
                $('#option_paypal').show();
            }
            if (card == 1) {
                $('#option_card').show();
            }
            if (cash == 1 && (a_traslado == 'RED' || a_traslado == "SEN/AH")) {
                $('#option_cash').show();
            }
            $("html, body").animate({scrollTop: 0}, 1000);
        });

        //Select payment
        $(document).on('change', '#mpago_resumen', function(){
            $("#check_electronic_purse").prop('checked', false);
            $('#content_descuento_electronic').hide('slow');
            $('#cservicio_resumen').val('0.00');
            let a_traslado = $('#inp_type_traslate').val();
            let paypal = $('#inp_paypal').val();
            let cash = $('#inp_cash').val();
            let card = $('#inp_card').val();
            let id_operadora = $('#inp_operadora').val();
            let value = "";
            let type_change = "";
            let descuento = "";
            let descuento_ope = "";
            var mx = 0;
            var us = 0;
            var mx_ope = 0;
            var us_ope = 0;
            var operator = $('#info_import').data('operator'); //getter
            
            if (paypal == 1) {
                $('#option_paypal').show();
            }
            if (card == 1) {
                $('#option_card').show();
            }
            if (cash == 1 && (a_traslado == 'RED' || a_traslado == "SEN/AH")) {
                $('#option_cash').show();
            }
            value = $(this).val();
            type_change = $('#select_type_change').val();                
            if (id_operadora == 1) {
                $('.content_descuento_operadora').show();
            }
            if (value == 'transfer' || value == 'airport' ) {
                $('#_PAYMENT').val('transfer');
                mx = $('#info_import').data('ratemx'); //getter
                us = $('#info_import').data('rateus'); //getter
                $('#_TOTAL_MXN').val(mx);
                $('#_TOTAL_USD').val(us);
                if (operator == 1) {
                    mx_ope = $('#info_import').data('ratemx_ope'); //getter
                    us_ope = $('#info_import').data('rateus_ope'); //getter    
                    $('#_TOTAL_MXN').val(mx_ope);
                    $('#_TOTAL_USD').val(us_ope);
                }
                $('#_CHARGE_SERVICE').val('0.00');
                $('#_AMOUNT_TOTAL').val('0.00');
                if (type_change == 'mxn') {
                    descuento = $('#info_import').data('discountmx');
                    $('#info_import').text(mx);
                    $('#_AMOUNT_TOTAL').val(mx);
                    if (operator == 1) {
                        descuento_ope = $('#info_import').data('discountmxope');
                        $('#info_import').text(mx_ope);
                        $('#_AMOUNT_TOTAL').val(mx_ope);
                    }
                }
                if (type_change == 'usd') {
                    descuento = $('#info_import').data('discountus');
                    $('#info_import').text(us);
                    $('#_AMOUNT_TOTAL').val(us);
                    if (operator == 1) {
                        descuento_ope = $('#info_import').data('discountusope');
                        $('#info_import').text(us_ope);
                        $('#_AMOUNT_TOTAL').val(us_ope);
                    }
                }
                $('.content_cservicio').hide('slow');
                $('.content_descuento').show('slow');

                $('#descuento_resumen').val('$ '+descuento);
                if (operator == 1) {
                    $('#descuento_resumen_operadora').val('$ '+descuento_ope);
                }
            }
            if (value == 'a_pa' || value == 'a_transfer') {
                $('.content_mprecio').show('slow');
                $('#_PAYMENT').val('transfer');
                mx = $('#info_import').data('ratemx'); //getter
                us = $('#info_import').data('rateus'); //getter
                $('#_TOTAL_MXN').val(mx);
                $('#_TOTAL_USD').val(us);
                if (operator == 1) {
                    mx_ope = $('#info_import').data('ratemx_ope'); //getter
                    us_ope = $('#info_import').data('rateus_ope'); //getter    
                    $('#_TOTAL_MXN').val(mx_ope);
                    $('#_TOTAL_USD').val(us_ope);
                }
                $('#_CHARGE_SERVICE').val('0.00');
                $('#_AMOUNT_TOTAL').val('0.00');
                if (type_change == 'mxn') {
                    descuento = $('#info_import').data('discountmx');
                    $('#info_import').text(mx);
                    $('#_AMOUNT_TOTAL').val(mx);
                    if (operator == 1) {
                        descuento_ope = $('#info_import').data('discountmxope');
                        $('#info_import').text(mx_ope);
                        $('#_AMOUNT_TOTAL').val(mx_ope);
                    }
                }
                if (type_change == 'usd') {
                    descuento = $('#info_import').data('discountus');
                    $('#info_import').text(us);
                    $('#_AMOUNT_TOTAL').val(us);
                    if (operator == 1) {
                        descuento_ope = $('#info_import').data('discountusope');
                        $('#info_import').text(us_ope);
                        $('#_AMOUNT_TOTAL').val(us_ope);
                    }
                }
                $('.content_cservicio').hide('slow');
                $('.content_descuento').show('slow');

                $('#descuento_resumen').val('$ '+descuento);
                if (operator == 1) {
                    $('#descuento_resumen_operadora').val('$ '+descuento_ope);
                }
            }
            
            if (value == 'card' || value == "paypal") {
                $('#_PAYMENT').val('card');
                mx = $('#info_import').data('ratemx_c'); //getter
                us = $('#info_import').data('rateus_c'); //getter
                $('#_TOTAL_MXN').val(mx);
                $('#_TOTAL_USD').val(us);
                if (operator == 1) {
                    mx_ope = $('#info_import').data('ratemx_ope_tp'); //getter
                    us_ope = $('#info_import').data('rateus_ope_tp'); //getter    
                    $('#_TOTAL_MXN').val(mx_ope);
                    $('#_TOTAL_USD').val(us_ope);
                }
                if (type_change == 'mxn') {
                    $('#info_import').text(mx);
                    $('#_AMOUNT_TOTAL').val(mx);
                    if (operator == 1) {
                        descuento_ope = $('#info_import').data('discountmxope_tp');
                        $('#info_import').text(mx_ope);
                        $('#_AMOUNT_TOTAL').val(mx_ope);
                    }
                }
                if (type_change == 'usd') {
                    $('#info_import').text(us);
                    $('#_AMOUNT_TOTAL').val(us);
                    if (operator == 1) {
                        descuento_ope = $('#info_import').data('discountusope_tp');
                        $('#info_import').text(us_ope);
                        $('#_AMOUNT_TOTAL').val(us_ope);
                    }
                }
                $('#descuento_resumen').val('');
                $('.content_cservicio').show('slow');
                $('.content_descuento').hide('slow');
                if (operator == 1) {
                    $('#descuento_resumen_operadora').val('$ '+descuento_ope);
                }
            }
            if (value == 'a_card' || value == "a_paypal") {
                $('.content_mprecio').show('slow');
                $('#_PAYMENT').val('card');
                mx = $('#info_import').data('ratemx_c'); //getter
                us = $('#info_import').data('rateus_c'); //getter
                $('#_TOTAL_MXN').val(mx);
                $('#_TOTAL_USD').val(us);
                if (operator == 1) {
                    mx_ope = $('#info_import').data('ratemx_ope_tp'); //getter
                    us_ope = $('#info_import').data('rateus_ope_tp'); //getter    
                    $('#_TOTAL_MXN').val(mx_ope);
                    $('#_TOTAL_USD').val(us_ope);
                }
                if (type_change == 'mxn') {
                    $('#info_import').text(mx);
                    $('#_AMOUNT_TOTAL').val(mx);
                    if (operator == 1) {
                        descuento_ope = $('#info_import').data('discountmxope_tp');
                        $('#info_import').text(mx_ope);
                        $('#_AMOUNT_TOTAL').val(mx_ope);
                    }
                }
                if (type_change == 'usd') {
                    $('#info_import').text(us);
                    $('#_AMOUNT_TOTAL').val(us);
                    if (operator == 1) {
                        descuento_ope = $('#info_import').data('discountusope_tp');
                        $('#info_import').text(us_ope);
                        $('#_AMOUNT_TOTAL').val(us_ope);
                    }
                }
                $('#descuento_resumen').val('');
                $('.content_cservicio').hide('slow');
                $('.content_descuento').hide('slow');
                if (operator == 1) {
                    $('#descuento_resumen_operadora').val('$ '+descuento_ope);
                }
            }
            $('#_PAYMENT').val(value);
        });

        //Select change type
        $(document).on('change', '#select_type_change', function(){
            $("#check_electronic_purse").prop('checked', false);
            $('#content_descuento_electronic').hide('slow');
            $('#cservicio_resumen').val('0.00');
            $('#_CHARGE_SERVICE').val('');
            let value = "";
            let mpago = "";
            let descuento = "";
            let descuento_ope = "";
            var mx = 0;
            var us = 0;
            var mx_ope = 0;
            var us_ope = 0;
            var operator = $('#info_import').data('operator'); //getter
            value = $(this).val();
            mpago = $('#mpago_resumen').val();

            if (value == 'mxn') {
                $('#_TYPE_CURRENCY').val('MXN');
                if (mpago == 'transfer' || mpago == 'airport') {
                    mx = $('#info_import').data('ratemx'); //getter
                    descuento = $('#info_import').data('discountmx');
                    $('#info_import').text(mx); 
                    $('#_AMOUNT_TOTAL').val(mx);
                    if (operator == 1) {
                        mx_ope = $('#info_import').data('ratemx_ope'); //getter
                        descuento_ope = $('#info_import').data('discountmxope');
                        $('#info_import').text(mx_ope); 
                        $('#_AMOUNT_TOTAL').val(mx_ope);
                    }
                }
                if (mpago == 'card' || mpago == 'paypal') {
                    mx = $('#info_import').data('ratemx_c'); //getter
                    $('#info_import').text(mx); 
                    $('#_AMOUNT_TOTAL').val(mx);
                    if (operator == 1) {
                        mx_ope = $('#info_import').data('ratemx_ope_tp'); //getter
                        descuento_ope = $('#info_import').data('discountmxope_tp');
                        $('#info_import').text(mx_ope); 
                        $('#_AMOUNT_TOTAL').val(mx_ope);
                    }
                }
            }
            if (value == 'usd') {
                $('#_TYPE_CURRENCY').val('USD');
                if (mpago == 'transfer' || mpago == 'airport') {
                    us = $('#info_import').data('rateus'); //getter
                    descuento = $('#info_import').data('discountus');
                    $('#info_import').text(us);
                    $('#_AMOUNT_TOTAL').val(us);
                    if (operator == 1) {
                        us_ope = $('#info_import').data('rateus_ope'); //getter
                        descuento_ope = $('#info_import').data('discountusope');
                        $('#info_import').text(us_ope);
                        $('#_AMOUNT_TOTAL').val(us_ope);
                    }
                }
                if (mpago == 'card' || mpago == 'paypal') {
                    us = $('#info_import').data('rateus_c'); //getter
                    $('#info_import').text(us);
                    $('#_AMOUNT_TOTAL').val(us);
                    if (operator == 1) {
                        us_ope = $('#info_import').data('rateus_ope_tp'); //getter
                        descuento_ope = $('#info_import').data('discountusope_tp');
                        $('#info_import').text(us_ope);
                        $('#_AMOUNT_TOTAL').val(us_ope);
                    }
                }
            }
            $('#descuento_resumen').val('$ '+descuento);
            if (operator == 1) {
                $('#descuento_resumen_operadora').val('$ '+descuento_ope);
            }
        });
        
        //Checkbox de Monedero Electrónico
        $(document).on('click', '#check_electronic_purse', function(){
            var seleccion_ep = $("#check_electronic_purse")[0].checked;
            var comision = 0;
            if (comision != 0) {
                comision = $('#cservicio_resumen').val();
            }
            if (seleccion_ep == true) {
                let total = $('#info_import').text();
                let currency = $('#select_type_change').val();
                let before_electronic_purse = $('#inp_electronic').val();
                let change_type = $('#inp_change_type').val();
                var discount_electronic_purse = 0;
                let resta = total;
                if (currency == 'usd') {
                    discount_electronic_purse = Math.round(parseFloat(before_electronic_purse) / parseFloat(change_type));
                }else{
                    discount_electronic_purse = before_electronic_purse;
                }
                if (discount_electronic_purse != 0) {
                    var electronic_pur_com = Math.round(discount_electronic_purse);
                    resta = 0;
                    if ( electronic_pur_com < total) {
                        resta = Math.round(parseFloat(total) - parseFloat(discount_electronic_purse));
                    }   
                }
                $('#content_descuento_electronic').show('slow');
                let curr = "MXN";
                if (currency == 'usd') {
                    curr = "USD";
                }
                $('#inp_discount_electronic').val(discount_electronic_purse + ' ' + curr);
                $('#info_import').text(resta);
            }else{
                $('#cservicio_resumen').val('');
                $('#content_descuento_electronic').hide('slow');
                let id_operadora = $('#inp_operadora').val();
                let type_payment = $('#_PAYMENT').val();
                var newtotal = 0;
                let rate_mx =$('#info_import').data('ratemx');
                let rate_us =$('#info_import').data('rateus');
                if(type_payment == 'card' || type_payment == 'paypal'){
                    rate_mx =$('#info_import').data('ratemx_c');
                    rate_us =$('#info_import').data('rateus_c');
                }
                if (id_operadora == 1) {
                    rate_mx =$('#info_import').data('ratemx_ope_tp');
                    rate_us =$('#info_import').data('rateus_ope_tp');
                }
                let currency = $('#select_type_change').val();
                var subtotal = currency == 'usd' ? rate_us : rate_mx;
                
                $('#_CHARGE_SERVICE').val(comision);  
                let subtotal_card_paypal = "";
                newtotal = parseFloat(subtotal) + parseFloat(comision);
                if(type_payment == 'card' || type_payment == 'paypal'){
                    subtotal_card_paypal = Math.round(parseFloat(subtotal) * 0.05);
                    newtotal = Math.round(((parseFloat(subtotal) - subtotal_card_paypal)+ parseFloat(comision)) / .95);
                }   
                $('#info_import').text(newtotal);
                $('#_AMOUNT_TOTAL').val(newtotal);
                if( isNaN(parseFloat(comision)) == true ) {
                    $('#info_import').text(parseFloat(subtotal));
                }

            }

        });
        $(document).on('click', '#check_ceros', function(){
            var seleccion_ceros = $("#check_ceros")[0].checked;
            if (seleccion_ceros == true) {
                $('#_VIEW_PRICE_TOTAL').val('1');
            }else{
                $('#_VIEW_PRICE_TOTAL').val('0');
            }
        });

        $('#cservicio_resumen').on('keyup', function(e){
            if ($(this).val() == null || $(this).val() == "") {
                $(this).val('0.00');
                $('#_CHARGE_SERVICE').val('0.00');
            }
            let id_operadora = $('#inp_operadora').val();
            let change_type = $('#inp_change_type').val();
            let rate_mx =$('#info_import').data('ratemx_c');
            let rate_us =$('#info_import').data('rateus_c');
            if (id_operadora == 1) {
                rate_mx =$('#info_import').data('ratemx_ope_tp');
                rate_us =$('#info_import').data('rateus_ope_tp');
            }
            var sale = {
                'subtotalmx' : rate_mx,
                'subtotalus' : rate_us,
                'commission' : $(this).val(),
                'currency' : $('#select_type_change').val()
            };
            if (!(/^([0-9]+\.?[0-9]{0,2})$/.test(sale.commission))) {
                $('#cservicio_resumen').val('');
                $('#cservicio_resumen').focus();
                return false;
            } 
            var seleccion_ep = $("#check_electronic_purse")[0].checked;
            let discount_electronic_purse = 0;
            if (seleccion_ep) {
                if (sale.currency == 'usd') {
                    val_elect = $('#inp_electronic').val();
                    discount_electronic_purse = Math.round(parseFloat(val_elect) / parseFloat(change_type));
                }else{
                    discount_electronic_purse = $('#inp_electronic').val();
                }
            }
            var subtotal = sale.currency == 'usd' ? sale.subtotalus : sale.subtotalmx; 
            $('#_CHARGE_SERVICE').val(sale.commission);  
            let type_payment = $('#_PAYMENT').val();
            let subtotal_card_paypal = "";
            let price_temporal = 0;
            // Metodos de pago con transferencia, pago al abordar, etc. asignando precios
            if (discount_electronic_purse != 0 && seleccion_ep) {
                price_temporal = Math.round((parseFloat(subtotal) + parseFloat(sale.commission)) - parseFloat(discount_electronic_purse));
                sale.total = Math.round(parseFloat(subtotal) + parseFloat(sale.commission));
                $('#info_import').text(price_temporal);
            }else{
                sale.total = Math.round(parseFloat(subtotal) + parseFloat(sale.commission));
                $('#info_import').text(sale.total);
            }
            // Metodos de pago con tarjeta y paypal asignando precios
            if(type_payment == 'card' || type_payment == 'paypal'){
                if (discount_electronic_purse != 0 && seleccion_ep) {
                    subtotal_card_paypal = Math.round(parseFloat(subtotal) * 0.05);
                    price_temporal = Math.round((((parseFloat(subtotal) - subtotal_card_paypal)+ parseFloat(sale.commission)) / .95) - parseFloat(discount_electronic_purse));
                    sale.total = Math.round(((parseFloat(subtotal) - subtotal_card_paypal)+ parseFloat(sale.commission)) / .95);
                    $('#info_import').text(price_temporal);
                }else{
                    subtotal_card_paypal = Math.round(parseFloat(subtotal) * 0.05);
                    sale.total = Math.round(((parseFloat(subtotal) - subtotal_card_paypal)+ parseFloat(sale.commission)) / .95);
                    $('#info_import').text(sale.total);
                }
            }   
            $('#_AMOUNT_TOTAL').val(sale.total);
            if( isNaN(parseFloat(sale.commission)) == true ) {
                $('#info_import').text(parseFloat(subtotal));
            }
        });
        $('#mprecio_resumen').on('keyup', function(e){
            if ($(this).val() == null || $(this).val() == "") {
                $(this).val('0.00');
                $('#_CHARGE_SERVICE').val('0.00');
            }
            let method_payment = $('#mpago_resumen').val();
            let id_operadora = $('#inp_operadora').val();
            let change_type = $('#inp_change_type').val();
            let rate_mx = "";
            let rate_us = "";
            if (method_payment == 'card' || method_payment == 'paypal' || method_payment == 'a_card' || method_payment == 'a_paypal') {
                rate_mx =$('#info_import').data('ratemx_c');
                rate_us =$('#info_import').data('rateus_c');
            }else{
                rate_mx =$('#info_import').data('ratemx');
                rate_us =$('#info_import').data('rateus');
            }
            if (id_operadora == 1) {
                rate_mx =$('#info_import').data('ratemx_ope_tp');
                rate_us =$('#info_import').data('rateus_ope_tp');
            }
            var sale = {
                'subtotalmx' : rate_mx,
                'subtotalus' : rate_us,
                'commission' : $(this).val(),
                'currency' : $('#select_type_change').val()
            };
            var seleccion_ep = $("#check_electronic_purse")[0].checked;
            let discount_electronic_purse = 0;
            if (seleccion_ep) {
                if (sale.currency == 'usd') {
                    val_elect = $('#inp_electronic').val();
                    discount_electronic_purse = Math.round(parseFloat(val_elect) / parseFloat(change_type));
                }else{
                    discount_electronic_purse = $('#inp_electronic').val();
                }
            }
            var subtotal = sale.currency == 'usd' ? sale.subtotalus : sale.subtotalmx; 
            $('#_CHARGE_SERVICE').val(sale.commission);  
            let type_payment = $('#_PAYMENT').val();
            let subtotal_card_paypal = "";
            let price_temporal = 0;
            // Metodos de pago con transferencia, pago al abordar, etc. asignando precios
            if (discount_electronic_purse != 0 && seleccion_ep) {
                price_temporal = Math.round((parseFloat(subtotal) + parseFloat(sale.commission)) - parseFloat(discount_electronic_purse));
                sale.total = Math.round(parseFloat(subtotal) + parseFloat(sale.commission));
                $('#info_import').text(price_temporal);
            }else{
                sale.total = Math.round(parseFloat(subtotal) + parseFloat(sale.commission));
                $('#info_import').text(sale.total);
            }
            // Metodos de pago con tarjeta y paypal asignando precios
            if(type_payment == 'card' || type_payment == 'paypal' || type_payment == 'a_card' || type_payment == 'a_paypal'){
                if (discount_electronic_purse != 0 && seleccion_ep) {
                    subtotal_card_paypal = Math.round(parseFloat(subtotal) * 0.05);
                    price_temporal = Math.round((((parseFloat(subtotal) - subtotal_card_paypal)+ parseFloat(sale.commission)) / .95) - parseFloat(discount_electronic_purse));
                    sale.total = Math.round(((parseFloat(subtotal) - subtotal_card_paypal)+ parseFloat(sale.commission)) / .95);
                    $('#info_import').text(price_temporal);
                }else{
                    subtotal_card_paypal = Math.round(parseFloat(subtotal) * 0.05);
                    sale.total = Math.round(((parseFloat(subtotal) - subtotal_card_paypal)+ parseFloat(sale.commission)) / .95);
                    $('#info_import').text(sale.total);
                }
            }   
            $('#_AMOUNT_TOTAL').val(sale.total);
            if( isNaN(parseFloat(sale.commission)) == true ) {
                $('#info_import').text(parseFloat(subtotal));
            }
        });
        //Select payment
        $(document).on('change', '#idioma_resumen', function(){

            value = $(this).val();
            $('#_LETTER_LANGUAGE').val(value);
        });
        // $(document).on('click', '.options', function(){
        //     let val = $(this).val();
        //     alert(val);
        // });
        //Finalizar reservacion
        $(document).on('click','#finish_reserv', function(){
            let status_reserv= 0;
            let type_service = "";
            let name_client = $('#inp_name_client').val();
            let lastname_client = $('#inp_lastname_client').val();
            let mother_lastname = $('#inp_mother_lastname').val();
            let phone_client = $('#inp_phone_client').val();
            let email_client = $('#inp_email_client').val();
            let country_client = $('#inp_country_client').val();
            let special_request = $('#inp_special_requests').val();
            let method_payment = $('#mpago_resumen').val();
            let letter_lang = $('#idioma_resumen').val();
            let co_yt = $('#inp_internal_yt').val();
            let name_asesor = "";
            let time = "";
            let time_exit = "";
            let time_pickup = "";
            let time_pickup_inter = "";
            let airline_entry="";
            let nofly_entry ="";
            let airline_exit="";
            let of_the_agency = "";
            let nofly_exit ="";
            var code_reser = "";
            var traslado = $('#_TYPE_TRANSFER').val();
            let time_service = "";
            if (traslado == 'compartido') {
                if(!$("#content_check_btns input[name='options']").is(':checked')){
                    $("#alert-msg").show('slow');
                    $("#alert-msg").addClass('alert-danger');
                    $('#text_time_service').addClass(' text-danger');
                    $msg = "Favor de seleccionar un horario de abordaje";
                    $('#text-msg').val($msg);
                    $("html, body").animate({scrollTop: 0}, 1000);
                    setTimeout(function(){ $("#alert-msg").hide('slow'); }, 3000);
                    return false;
                }else{
                    time_service = $("#content_check_btns input[name='options']:checked").val();
                    $('#text_time_service').removeClass(' text-danger');
                }
            }

            if ($('#_TYPE_SERVICE').val()) {
                type_service = $('#_TYPE_SERVICE').val();
            }
            if (co_yt == 1) {   
                //Reservaciones hechas para agencias por parte de Yamevi         
                code_reser = $('#inp_reserv_ex').val();
                if ($('#inp_asesor').val()) {
                    name_asesor = $('#inp_asesor').val();
                }
            }
            if (type_service == 'SEN/AH' || type_service == "RED") {
                airline_entry = $('#inp_airline_entry').val();
                nofly_entry = $('#inp_nofly_entry').val();
                time = validateTimeEntry();
                if (airline_entry == null || airline_entry.length == 0 || /^\s+$/.test(airline_entry)) {
                    $('#inp_airline_entry').addClass(" is-invalid");
                    $('#inp_airline_entry').focus();
                    return false;
                }
                if (nofly_entry == null || nofly_entry.length == 0 || /^\s+$/.test(nofly_entry)) {
                    $('#inp_nofly_entry').addClass(" is-invalid");
                    $('#inp_nofly_entry').focus();
                    return false;
                }
                if (time == null || time == 0) {
                    $('#inp_hour_entry').addClass(" is-invalid");
                    $('#inp_hour_entry').focus();
                    return false;
                }
            }
            if (type_service == "RED" || type_service == 'SEN/HA') {
                airline_exit = $('#inp_airline_exit').val();
                nofly_exit = $('#inp_nofly_exit').val();
                time_exit = validateTimeExit();
                if (airline_exit == null || airline_exit.length == 0 || /^\s+$/.test(airline_exit)) {
                    $('#inp_airline_exit').addClass(" is-invalid");
                    $('#inp_airline_exit').focus();
                    return false;
                }
                if (nofly_exit == null || nofly_exit.length == 0 || /^\s+$/.test(nofly_exit)) {
                    $('#inp_nofly_exit').addClass(" is-invalid");
                    $('#inp_nofly_exit').focus();
                    return false;
                }
                if (time_exit == null || time_exit == "") {
                    $('#inp_hour_exit').addClass(" is-invalid");
                    $('#inp_hour_exit').focus();
                    return false;
                }
            }
            if (type_service == 'SEN/HH' || type_service == 'REDHH') {
                time_pickup = validateTimePickEntry();
                if (time_pickup == null || time_pickup == 0) {
                    $('#inp_hour_pick').addClass(" is-invalid");
                    $('#inp_hour_pick').focus();
                    return false;
                }
            }
            if (type_service == 'REDHH') {
                time_pickup_inter = validateTimePickExit();
                if (time_pickup_inter == null || time_pickup_inter == "") {
                    $('#inp_hour_pick_inter').addClass(" is-invalid");
                    $('#inp_hour_pick_inter').focus();
                    return false;
                }
            }
            if (name_client == null || name_client.length == 0 || /^\s+$/.test(name_client)) {
                $('#inp_name_client').addClass(" is-invalid");
                $('#inp_name_client').focus();
                return false;
                
            }
            if (lastname_client == null || lastname_client.length == 0 || /^\s+$/.test(lastname_client)) {
                $('#inp_lastname_client').addClass(" is-invalid");
                $('#inp_lastname_client').focus();
                return false;
                
            }
            if (phone_client == null || phone_client.length == 0 || /^\s+$/.test(phone_client)) {
                $('#inp_phone_client').addClass(" is-invalid");
                $('#inp_phone_client').focus();
                return false;
                
            }
            if (!(/\w+([-+.']\w+)*@\w+([-.]\w+)/.test(email_client))) {
                $('#inp_email_client').addClass(" is-invalid");
                $('#inp_email_client').focus();
                return false;
            }
            if (country_client == null || country_client.length == 0 || /^\s+$/.test(country_client)) {
                $('#inp_country_client').addClass(" is-invalid");
                $('#inp_country_client').focus();
                return false;
            }
            if (letter_lang == null || letter_lang.length == 0 || /^\s+$/.test(letter_lang)) {
                $('#idioma_resumen').addClass(" is-invalid");
                $('#idioma_resumen').focus();
                return false;
            }
            var seleccion = $("#check_terminos")[0].checked;
            if(!seleccion){
                $('#content_terms_conditions').addClass(' was-validated');
                $('#check_terminos').focus();
                $('.invalid-feedback').removeClass('d-none');
                return false;
            }
            //CHECHBOX DE MONEDERO ELECTRONICO
            var change_type = $('#inp_change_type').val();
            var seleccion_ep = $("#check_electronic_purse")[0].checked;
            var discount_electronic_purse = 0;
            if (seleccion_ep) {
                discount_electronic_purse = parseFloat($('#inp_electronic').val());
            }
            var seleccion_ceros = $("#check_ceros")[0].checked;
            let ceros = 0;
            if(seleccion_ceros){
                ceros = 1;
            }
            var agencie = $('#_AGENCIE').val();
            if ($('#inp_of_agency').val()) {
                of_the_agency = $('#inp_of_agency').val();
            }else{
                of_the_agency = agencie;
            }
            //Form 1
            var hotel = $('#_ORIGIN_HOTEL').val();
            var hotel_destino = $('#_DESTINY_HOTEL').val();
            var pasajeros = $('#_NUMBER_PAS').val();

            var tipo_servicio = $('#_TYPE_SERVICE').val();
            
            var date_entry = $('#_DATE_ENTRY').val();
            var date_exit = $('#_DATE_EXIT').val();
            var t_cambio = $('#_TYPE_CHANGE').val();
            var t_currency = $('#_TYPE_CURRENCY').val();
            let letter_language = $('#_LETTER_LANGUAGE').val();
            var sub_total = 0;
            var sub_total_us = 0;
            var amount_total = 0;
            var new_sub_total_mx= 0;
            var new_sub_total_us = 0;
            
            sub_total = $('#_TOTAL_MXN').val();
            new_sub_total_mx = parseFloat(sub_total).toFixed(2);
            sub_total_us = $('#_TOTAL_USD').val();
            new_sub_total_us = parseFloat(sub_total_us).toFixed(2);
            if (method_payment == 'card' || method_payment == 'paypal') {
                sub_total = $('#inp_amount_total_mxn').val();
                new_sub_total_mx = parseFloat(sub_total).toFixed(2);
                sub_total_us = $('#inp_amount_total_usd').val();
                new_sub_total_us = parseFloat(sub_total_us).toFixed(2);
                
            }
            var charge_service = 0;
            if ($('#_CHARGE_SERVICE').val()) {                
                charge_service = $('#_CHARGE_SERVICE').val();
            }
            if ($('#_AMOUNT_TOTAL').val()) {
                amount_total = $('#_AMOUNT_TOTAL').val();
            }
            if (new_sub_total_mx) {
                status_reserv = 1; 
            }
            var postDatas = {
                'id_agencie': agencie,
                'code_reserv': code_reser,
                'name_advisor': name_asesor,
                'of_the_agency': of_the_agency,
                'name_client': name_client,
                'lastname_client':lastname_client,
                'mother_lastname':mother_lastname,
                "email_client": email_client,
                'phone_client': phone_client,
                'country': country_client,
                'special_requests': special_request,
                'hotel_origin': hotel,
                'hotel_destiny': hotel_destino,
                'type_transfer': traslado,
                'type_service': tipo_servicio,
                'pasajeros': pasajeros,
                "date_entry": date_entry,
                'time_entry': time,
                'airline_entry': airline_entry,
                'nofly_entry': nofly_entry,
                "date_exit":date_exit,
                'time_exit': time_exit,
                'pick_up': time_pickup,
                'pick_up_inter': time_pickup_inter,
                'airline_exit': airline_exit,
                'nofly_exit':nofly_exit,
                'time_service': time_service,
                'currency': t_currency,
                'type_change': t_cambio,
                'method_peyment':method_payment,
                'total_mxn': new_sub_total_mx,
                'total_usd': new_sub_total_us,
                'service_charge': charge_service,
                "amount_total":amount_total,
                'discount_electronic_purse': discount_electronic_purse,
                'change_type': change_type,
                "letter_lang": letter_language,
                'ceros': ceros,
                "status": status_reserv
            };
            
            $.ajax({
                data: postDatas,
                url: '../helpers/traslados.php',
                type: 'post',
                beforeSend: function(){
                    console.log(postDatas);
                    $("html, body").animate({scrollTop: 0}, 1000);
                    let template = '';
                    template += `    
                        <div class="loader"></div>
                    `;
                    $('#loading').html(template);
                    $('#finish_reserv').hide();
                    $('.btn_load').show(); 

                },
                success: function(data){
                    $(".loader").fadeOut("slow");
                    console.log(data);
                    const res = JSON.parse(data);
                    if (res.status != 0) {
                        if (method_payment == 'transfer' || method_payment == 'airport' || method_payment == 'a_pa' || method_payment == 'a_transfer') {
                            $('#myModal').modal('show');
                            $('#msj_success').text('Su reservación ha sido creada satisfactoriamente, en breve recibirá su carta de confirmación.');  
                        }
                    }else{
                        $('#myModalerror').modal('show');
                    }  

                    switch(type_service) {
                        case 'SEN/AH':
                        var iptName = 'Sencillo - Aeropuerto a Hotel';
                        break;
                        
                        case 'SEN/HA':
                        var iptName = 'Sencillo - Hotel a Aeropuerto';
                        break;
                        
                        case 'RED':
                        var iptName = 'Redondo';
                        break;

                        case 'REDHH':
                        var iptName = 'Redondo - Hotel a Hotel';
                        break;

                        case 'SEN/HH':
                        var iptName = 'Sencillo - Hotel a Hotel';
                        break;
                    }

                    if (method_payment == 'paypal' || method_payment == 'a_paypal') {

                        $('#p_itemname').val(iptName + ' | ' + hotel);
                        $('#p_amount').val(amount_total);
                        $('#p_invoice').val(res.invoice);
                        if (res.status == 1) {
                                $('#myModal').modal('show');
                                $('#btn_succes_r').hide();
                                $('#msj_success').text('Su reservación ha sido creada satisfactoriamente, en breve sera redireccionado.');  
                                setTimeout(function(){ $('#paypalPayment').submit(); }, 1000);
                                
                        }else{
                            $('#myModalerror').modal('show');
                        }

                    }
                    if (method_payment == 'card' || method_payment == 'a_card') {
                        $('#myModal').modal('show');
                        $('#_INVOICE').val(res.invoice);
                        $('#_NAME_CLIENT').val(postDatas.name_client);
                        $('#_LAST_NAME').val(postDatas.lastname_client);
                        $('#_CLIENT_EMAIL').val(postDatas.email_client);
                        $('#_CLIENT_PHONE').val(postDatas.phone_client);
                        $('#_LETTER_LANGUAGE').val(postDatas.letter_lang);
                        $('#_AMOUNT_TOTAL').val(postDatas.amount_total);
                        $('#_VIEW_PRICE_TOTAL').val(postDatas.ceros);

                        $('#inps_store').attr('action','/es/secciones/checkout.php');
                            $('#myModal').modal('show');
                            $('#btn_succes_r').hide();
                            $('#msj_success').text('Su reservación ha sido creada satisfactoriamente, en breve sera redireccionado, por favor espere.');  
                            setTimeout(function(){ $('#inps_store').submit(); }, 500);
                            
                    }
                }
            });
        });

        //Validar horarios de llegada
        function validateTimeEntry(){
            var time = {
                'hour': $('#inp_hour_entry option:selected').val(),
                'minute': $('#inp_minute_entry option:selected').val(),
                'service': $('#_TYPE_TRANSFER').val()
            };
            if (parseInt(time.hour) < 0 || parseInt(time.hour) > 23) {
                $('#inp_hour_entry').focus();
                return false;
            }
            if (parseInt(time.minute) < 0 || parseInt(time.minute) > 59) {
                $('#inp_minute_entry').focus();
                return false;
            }
            var new_time = 0; 
            if (time.service == 'compartido') {
                if (parseInt(time.hour) == 0) {
                    $('#inp_hour_entry').addClass(" is-invalid");
                    $('#inp_hour_entry').focus();
                    $("#alert-msg").show('slow');
                    $("#alert-msg").addClass('alert-danger');
                    $msg = "El servicio COMPARTIDO sólo se encuentra disponible para llegadas de 08:00 HRS a 20:00 HRS";
                    setTimeout(function(){ $("#alert-msg").hide('slow'); }, 3000);
                    $('#text-msg').val($msg);
                    $("html, body").animate({scrollTop: 0}, 1000);
                    return new_time;
                }
                
                if (parseInt(time.hour) >= 8 && parseInt(time.hour) <= 19) {
                    new_time = time.hour + ':' + time.minute + ' '+ 'Hrs';
                    return new_time;
                }
            }
            new_time = time.hour + ':' + time.minute + ' '+ 'Hrs';
            return new_time;
        }

        //Validar horarios de salida
        function validateTimeExit(){
            var time = {
                'hour': $('#inp_hour_exit option:selected').val(),
                'minute': $('#inp_minute_exit option:selected').val(),
                'service': $('#_TYPE_TRANSFER').val()
            };
            if (parseInt(time.hour) < 0 || parseInt(time.hour) > 23) {
                $('#inp_hour_exit').focus();
                return false;
            }
            if (parseInt(time.minute) < 0 || parseInt(time.minute) > 59) {
                $('#inp_minute_exit').focus();
                return false;
            }
            var new_time = 0; 
            if (time.service == 'compartido') {
                if (parseInt(time.hour) == 0) {
                    $("html, body").animate({scrollTop: 0}, 1000);
                    $('#inp_hour_exit').focus();
                    $("#alert-msg").show('slow');
                    $("#alert-msg").addClass('alert-danger');
                    $msg = "El servicio COMPARTIDO sólo se encuentra disponible para salidas de 08:00 HRS a 20:00 HRS";
                    $('#text-msg').val($msg);
                    setTimeout(function(){ $("#alert-msg").hide('slow'); }, 3000);
                    return new_time;
                }
                if (parseInt(time.hour) >= 8 && parseInt(time.hour) <= 19) {
                    new_time = time.hour + ':' + time.minute + ' '+ 'Hrs';
                    return new_time;
                }
                
            }
            new_time = time.hour + ':' + time.minute + ' '+ 'Hrs';
            return new_time;

        }

        //Validar horarios pick up llegada
        function validateTimePickEntry(){
            var time = {
                'hour': $('#inp_hour_pick option:selected').val(),
                'minute': $('#inp_minute_pick option:selected').val(),
                'service': $('#_TYPE_TRANSFER').val()
            };
            
            var new_time = 0; 
            if (parseInt(time.hour) <= 0 || parseInt(time.hour) > 23) {
                $("#alert-msg").show('slow');
                $("#alert-msg").addClass('alert-danger');
                setTimeout(function(){ $("#alert-msg").hide('slow'); }, 3000);
                $msg = "Debes ingresar una hora entre 1 - 23";
                $('#text-msg').val($msg);
                $('#inp_hour_pick').focus();
                return new_time;
            }
            if (parseInt(time.minute) < 0 || parseInt(time.minute) > 59) {
                $("#alert-msg").show('slow');
                $("#alert-msg").addClass('alert-danger');
                setTimeout(function(){ $("#alert-msg").hide('slow'); }, 3000);
                $msg = "Debes ingresar un minute entre 1 - 59";
                $('#text-msg').val($msg);
                $('#inp_minute_pick').focus();
                return new_time;
            }
            new_time = time.hour + ':' + time.minute + ' '+ 'Hrs';
            return new_time;

        }

        //Validar horarios pick up salida
        function validateTimePickExit(){
            var time = {
                'hour': $('#inp_hour_pick_inter option:selected').val(),
                'minute': $('#inp_minute_pick_inter option:selected').val(),
                'service': $('#_TYPE_TRANSFER').val()
            };
            var new_time = 0; 
            if (parseInt(time.hour) < 0 || parseInt(time.hour) > 23) {
                $('#inp_hour_pick_inter').focus();
                return new_time;
            }
            if (parseInt(time.minute) < 0 || parseInt(time.minute) > 59) {
                $('#inp_minute_pick_inter').focus();
                return new_time;
            }
            new_time = time.hour + ':' + time.minute + ' '+ 'Hrs';
            return new_time;

        }
        //Removemos class de Date 1
        $(document).on('click', '#datepicker_star', function(){
                $(this).removeClass(' is-invalid');
        });
        //Removemos class de Date 2
        $(document).on('click', '#datepicker_end', function(){
            $(this).removeClass(' is-invalid');
        });
        //Removemos class de Date 1
        $(document).on('click', '#datepicker_star_edit', function(){
            $(this).removeClass(' is-invalid');
        });
        //Removemos class de Date 2
        $(document).on('click', '#datepicker_end_edit', function(){
            $(this).removeClass(' is-invalid');
        });
        //Removemos class al cambiar de Paso 2
        $(document).on('change', '#form_reserva :input', function(){
            if ($.trim($(this).val()).length) {
                $(this).removeClass(' is-invalid');
            } else {
                $(this).addClass(' is-invalid');
            }
        });
        //Removemos class al cambiar de Paso 2
        $(document).on('change', '#form_reserva_edit :input', function(){
            if ($.trim($(this).val()).length) {
                $(this).removeClass(' is-invalid');
            } else {
                $(this).addClass(' is-invalid');
            }
        });
        //Removemos class al cambiar de Paso 3
        $(document).on('change', '.form_details :input', function(){
            if ($.trim($(this).val()).length) {
                $(this).removeClass(' is-invalid');
            } else {
                $(this).addClass(' is-invalid');
            }
        });
}); 