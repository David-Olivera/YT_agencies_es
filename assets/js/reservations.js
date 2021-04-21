$(function(){
    let date_en = "";
    let date_ex = "";
    loadReservations(date_en, date_ex);
    // datepicker
    $( function() {        
        var $datepicker2 = $( "#datepicker_end_ser" );
        $('#datepicker_star_ser').datepicker( {
            language: 'es',
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
    
    $(document).on('click', '#get_pdf', function(){
        id = $(this).data('letter'); //getter
        letter_lang = 'mx';
        con = "";
        action = "get_pdf"
        $.ajax({
          data: {id, letter_lang, con, action},
          url: '../helpers/reservaciones.php',
          type: 'post',
          beforeSend: function(){
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
          }
        });
    });
    

    //PRINT LETTER
    $('#printLetter').on('click', function(event){
      event.preventDefault();

      var ventimp = window.open(' ', 'popimpr');

      ventimp.document.write($('.PDFLetter').html());

      ventimp.document.close();

      ventimp.print( );

      ventimp.close();
    });
    $(document).on('click', '#btn_search_reservations', function(){
      let f_llegada = $('#datepicker_star_ser').val();
      let f_salida = $('#datepicker_end_ser').val();
      if (f_llegada == null || f_llegada.length == 0 || /^\s+$/.test(f_llegada)) {
        $('#datepicker_star_ser').addClass(" is-invalid");
        $('#datepicker_star_ser').focus();
        return false;
      }
      if (f_salida == null || f_salida.length == 0 || /^\s+$/.test(f_salida)) {
          $('#datepicker_end_ser').addClass(" is-invalid");
          $('#datepicker_end_ser').focus();
          return false;
      }   
      loadReservations(f_llegada, f_salida);
      $('#datepicker_star_ser').val('');
      $('#datepicker_end_ser').val('');
    });

    $(document).on('click', '#view_all_reservations', function(){
      let date_en = "";
      let date_ex = "";
      loadReservations(date_en, date_ex);
    });

    //Removemos class de Date 1
	  $('#datepicker_star_ser').on('focusout', function(){
      $(this).removeClass(' is-invalid');
    });
    //Removemos class de Date 2
    $('#datepicker_end_ser').on('focusout', function(){
        $(this).removeClass(' is-invalid');
    });

    function loadReservations(date_en, date_ex){
        function loadData(page,value){
            value = $('#inp_agency').val();
            $.ajax({
                url  : "../model/reservaciones_paginacion.php",
                type : "POST",
                cache: false,
                data : {page_no:page, value:value, date_en, date_ex},
                beforeSend: function(){
                  $("html, body").animate({scrollTop: 0}, 1000);
                  let template = '';
                  template += `    
                      <div class="loader"></div>
                  `;
                  $('#loading').html(template);
                  $('#finish_reserv').hide();
                  $('.btn_load').show(); 

                },
                success:function(response){
                $(".loader").fadeOut("slow");
                $("#content_reservations").html(response);
                }
            });
        }
        loadData();
        // Pagination code
        $(document).on("click", ".pagination li a", function(e){
            e.preventDefault();
            var pageId = $(this).attr("id");
            loadData(pageId);
        });
        // New Ordenamiento de tabla
        $(document).on("click", "th", function(){
            var table = $(this).parents('table').eq(0)
            var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
            this.asc = !this.asc
            if (!this.asc) {
              rows = rows.reverse()
            }
            for (var i = 0; i < rows.length; i++) {
              table.append(rows[i])
            }
            setIcon($(this), this.asc);
          })
        
          function comparer(index) {
            return function(a, b) {
              var valA = getCellValue(a, index),
                valB = getCellValue(b, index)
              return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
            }
          }
        
          function getCellValue(row, index) {
            return $(row).children('td').eq(index).html()
          }
        
          function setIcon(element, asc) {
            $("th").each(function(index) {
              $(this).removeClass("sorting");
              $(this).removeClass("asc");
              $(this).removeClass("desc");
            });
            element.addClass("sorting");
            if (asc) element.addClass("asc");
            else element.addClass("desc");
          }
    }

    $('#inp_agency_commision_edit').on('keyup', function(e){
        if ($(this).val() == null || $(this).val() == "") {
            $(this).val('0.00');
        }
        var sale = {
            'subtotalmx' : $('#inp_total_cost_edit').val(),
            'commission' : $(this).val()
        };
        if (!(/^([0-9]+\.?[0-9]{0,2})$/.test(sale.commission))) {
            $('#inp_agency_commision_edit').val('');
            $('#inp_agency_commision_edit').focus();
            return false;
        }
            
        sale.total = parseFloat(sale.subtotalmx) + parseFloat(sale.commission);
        $('#inp_total_cost_commesion_edit').val(sale.total);
        if( isNaN(parseFloat(sale.commission)) == true ) {
            $('#inp_total_cost_commesion_edit').val(parseFloat(subtotal));
        }
    });
  
    $(document).on('click', '#get_pdf_req', function(){
      let element = $(this)[0].parentElement.parentElement;
      let id = $(element).attr('res-id');
      $('#id_res_pdf').val(id);

    });

    $(document).on('change', '#select_price_pdf', function(){

      let id = $('#id_res_pdf').val();
      value = $(this).val();
      let template = '';
      if(value == 3){
        template = '<p>Debes elegir una respuesta para continuar.</p>';
        $('#content_btn_pdf').html(template);
      }
      if (value == 1) {
        template = `    
          <a class="btn btn-success" id="btn_load_pdf"  href='generate-letter.php?letter=${id}&total=${value}' target='_blank' ><span>Mis Reservaciones</span> <i class="material-icons">&#xE5C8;</i></a>
        `;
        $('#content_btn_pdf').html(template);
      }
      if(value == 0){
        template = `    
        <a class="btn btn-success" id="btn_load_pdf" href='generate-letter.php?letter=${id}&total=${value}' target='_blank'><span>Mis Reservaciones</span> <i class="material-icons">&#xE5C8;</i></a>
        `;
        $('#content_btn_pdf').html(template);
      }
    });

    $(document).on('click', '#btn_load_pdf', function(){
        $('#myModal').modal('hide');
        $("#select_price_pdf").val(3);
        $('#content_btn_pdf').html('');
        ;
    });

    $(document).on('click', '#update_details_reservation', function(){
      let code_invoice = $('#inp_code_invoice_edit').val();
      let co_yt = $('#inp_internal_yt').val();
      let code_client = "";
      let name_asesor = "";
      let of_the_agency = "";

      let name_hotel = $('#inp_hotel_edit').val();
      let name_hotel_interhotel= "";
      let type_traslado = $('#inp_traslado_edit').val();
      let type_service = $('#inp_servicio_edit').val();
      let num_pasajeros =$('#inp_pasajeros_edit').val();

      let date_arrival = ""; 
      let airline_arrival = "";
      let no_fly_arrival = "";
      let time = "";
      let time_exit = "";
      let time_hour_arrival ="";
      let time_minute_arrival = "";
      let date_exit = "";
      let airline_exit = "";
      let no_fly_exit = "";
      let time_hour_exit ="";
      let time_minute_exit = "";
      let time_pickup = "";
      let time_pickup_inter = "";


      let method_payment = $('#inp_method_payment_edit').val();
      let sub_total= "";
      let commission = "";
      let total_cost_comision ="";
      
      let name_client = $('#inp_name_client_edit').val();
      let last_name = $('#inp_lastname_client_edit').val();
      let email_client = $('#inp_email_client_edit').val();
      let phone_client =$('#inp_phone_client_edit').val();
      let special_request = $('#inp_special_requests_edit').val();

      console.log('CODE INVOICE');
      console.log(code_invoice);
      //RESERVA EXTERNA
      if (co_yt == 1) {
        if ($('#inp_reserv_edit').val()) {
          code_client = $('#inp_reserv_edit').val();
        }
        if ($('#inp_asesor_edit').val()) {
          name_asesor = $('#inp_asesor_edit').val();
        }
        if ($('#inp_agency_edit').val()) {
          of_the_agency = $('#inp_agency_edit').val();
        }
        console.log('RESERVA EXTERNA');
        console.log(code_client+' - '+name_asesor+' - '+of_the_agency);
      }
      //DATOS DE TRASLADO
      if (name_hotel == null || name_hotel.length == 0 || /^\s+$/.test(name_hotel)) {
        $('#inp_hotel_edit').addClass(" is-invalid");
        $('#inp_hotel_edit').focus();
        return false;
      }
      if (type_traslado == null || type_traslado.length == 0 || /^\s+$/.test(type_traslado)) {
        $('#inp_traslado_edit').addClass(" is-invalid");
        $('#inp_traslado_edit').focus();
        return false;
      }
      if (type_traslado == 'SEN/HH' || type_traslado == 'REDHH') {
        if ($('#inp_hotel_interhotel_edit').val()) {
          name_hotel_interhotel = $('#inp_hotel_interhotel_edit').val();
          if (name_hotel_interhotel == null || name_hotel_interhotel.length == 0 || /^\s+$/.test(name_hotel_interhotel)) {
            $('#inp_hotel_interhotel_edit').addClass(" is-invalid");
            $('#inp_hotel_interhotel_edit').focus();
            return false;
          }
        }
      }
      if (type_service == null || type_service.length == 0 || /^\s+$/.test(type_service)) {
        $('#inp_servicio_edit').addClass(" is-invalid");
        $('#inp_servicio_edit').focus();
        return false;
      }
      if (num_pasajeros == null || num_pasajeros.length == 0 || /^\s+$/.test(num_pasajeros)) {
        $('#inp_pasajeros_edit').addClass(" is-invalid");
        $('#inp_pasajeros_edit').focus();
        return false;
      }
      
      console.log('RESERVA TRASLADO');
      console.log(name_hotel+' - '+type_traslado+' - '+type_service+' - '+num_pasajeros);
      console.log(name_hotel_interhotel);

      console.log('DATOS DE VUELO Y/O PICKUP');
      //DATOS DE VUELO Y/O PICKUP
      if (type_traslado == 'SEN/AH' || type_traslado == 'RED') {
          date_arrival = $('#datepicker_star_edit').val();
          airline_arrival = $('#inp_airline_entry_edit').val();
          no_fly_arrival = $('#inp_nofly_entry_edit').val();
          time = validateTimeEntry();
          if (date_arrival == null || date_arrival.length == 0 || /^\s+$/.test(date_arrival)) {
            $('#datepicker_star_edit').addClass(" is-invalid");
            $('#datepicker_star_edit').focus();
            return false;
          }
          if (airline_arrival == null || airline_arrival.length == 0 || /^\s+$/.test(airline_arrival)) {
              $('#inp_airline_entry_edit').addClass(" is-invalid");
              $('#inp_airline_entry_edit').focus();
              return false;
          }
          if (no_fly_arrival == null || no_fly_arrival.length == 0 || /^\s+$/.test(no_fly_arrival)) {
              $('#inp_nofly_entry_edit').addClass(" is-invalid");
              $('#inp_nofly_entry_edit').focus();
              return false;
          }
          if (time == null || time == 0) {
              $('#inp_hour_entry_edit').addClass(" is-invalid");
              $('#inp_hour_entry_edit').focus();
              return false;
          }
          
          console.log(date_arrival+' - '+airline_arrival+' - '+no_fly_arrival+' - '+time);
      }

      if (type_traslado == 'SEN/HA' || type_traslado == 'RED') {
          date_exit = $('#datepicker_end_edit').val();
          airline_exit = $('#inp_airline_exit_edit').val();
          no_fly_exit = $('#inp_nofly_exit_edit').val();
          time_exit = validateTimeExit();
          if (date_exit == null || date_exit.length == 0 || /^\s+$/.test(date_exit)) {
            $('#datepicker_end_edit').addClass(" is-invalid");
            $('#datepicker_end_edit').focus();
            return false;
          }
          if (airline_exit == null || airline_exit.length == 0 || /^\s+$/.test(airline_exit)) {
              $('#inp_airline_exit_edit').addClass(" is-invalid");
              $('#inp_airline_exit_edit').focus();
              return false;
          }
          if (no_fly_exit == null || no_fly_exit.length == 0 || /^\s+$/.test(no_fly_exit)) {
              $('#inp_nofly_exit_edit').addClass(" is-invalid");
              $('#inp_nofly_exit_edit').focus();
              return false;
          }
          if (time_exit == null || time_exit == 0) {
              $('#inp_hour_exit_edit').addClass(" is-invalid");
              $('#inp_hour_exit_edit').focus();
              return false;
          }
        
          
          console.log(date_exit+' - '+airline_exit+' - '+no_fly_exit+' - '+time_exit);
      }

      if (type_traslado == 'SEN/HH' || type_traslado == 'REDHH') {
          date_arrival = $('#datepicker_star_edit').val();
          time_pickup = validateTimePickEntry();
          if (date_arrival == null || date_arrival.length == 0 || /^\s+$/.test(date_arrival)) {
            $('#datepicker_star_edit').addClass(" is-invalid");
            $('#datepicker_star_edit').focus();
            return false;
          }
          if (time_pickup == null || time_pickup == 0) {
              $('#inp_hour_pick_edit').addClass(" is-invalid");
              $('#inp_hour_pick_edit').focus();
              return false;
          }
          console.log(date_arrival+' - '+time_pickup);
      }
      if (type_traslado == 'REDHH') {
          date_exit = $('#datepicker_end_edit').val();
          time_pickup_inter = validateTimePickExit();
          if (date_exit == null || date_exit.length == 0 || /^\s+$/.test(date_exit)) {
            $('#datepicker_end_edit').addClass(" is-invalid");
            $('#datepicker_end_edit').focus();
            return false;
          }
          if (time_pickup_inter == null || time_pickup_inter == "") {
              $('#inp_hour_pick_inter_edit').addClass(" is-invalid");
              $('#inp_hour_pick_inter_edit').focus();
              return false;
          }
          console.log(date_exit+' - '+time_pickup_inter);
      }
      //DATOS DE PAGO Y ESTADO
      if (method_payment == 'TARJETA' || method_payment == 'PAYPAL') {
        sub_total= $('#inp_total_cost_edit').val();
        commission = $('#inp_agency_commision_edit').val();
      }
      total_cost_comision =$('#inp_total_cost_commesion_edit').val();
      console.log('DATOS DE PAGO Y ESTADO');
      console.log(method_payment+' - '+total_cost_comision);
      console.log(method_payment+' - '+sub_total+' - '+commission+ ' - '+total_cost_comision);

      if (name_client == null || name_client.length == 0 || /^\s+$/.test(name_client)) {
          $('#inp_name_client').addClass(" is-invalid");
          $('#inp_name_client').focus();
          return false;
          
      }
      if (last_name == null || last_name.length == 0 || /^\s+$/.test(last_name)) {
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
      console.log('DATOS DE CLIENTE');
      console.log(name_client+' - '+last_name+' - '+email_client+' - '+phone_client+' - '+special_request);
      const postDatas = {
        'code_invoice':code_invoice,
        'co_yt':co_yt, 
        'code_client':code_client, 
        'name_asesor':name_asesor,  
        'of_the_agency':of_the_agency,
        'name_hotel':name_hotel,
        'name_hotel_interhotel':name_hotel_interhotel,
        'type_traslado':type_traslado,
        'type_service':type_service ,
        'num_pasajeros':num_pasajeros,
        'date_arrival': date_arrival,
        'airline_arrival': airline_arrival,
        'no_fly_arrival': no_fly_arrival,
        'time': time,
        'time_exit': time_exit,
        'time_hour_arrival': time_hour_arrival,
        'time_minute_arrival': time_minute_arrival,
        'date_exit': date_exit,
        'airline_exit': airline_exit,
        'no_fly_exit': no_fly_exit,
        'time_hour_exit': time_hour_exit,
        'time_minute_exit': time_minute_exit, 
        'time_pickup': time_pickup,
        'time_pickup_inter': time_pickup_inter,
        'method_payment' :method_payment, 
        'sub_total' :sub_total,
        'commission' :commission,
        'total_cost_comision' :total_cost_comision,
        'name_client' :name_client,
        'last_name':last_name,
        'email_client' :email_client, 
        'phone_client' :phone_client,
        'special_request' :special_request,
        'update_traslado': true
      };
      $.ajax({
          data: postDatas,
          url: '../helpers/reservaciones.php',
          type: 'post',
          beforeSend: function(){
            $("html, body").animate({scrollTop: 0}, 1000);
            let template = '';
            template += `    
                <div class="loader"></div>
            `;
            $('#loading').html(template);
            $('.btn_load').show();
          },
          success: function(data){
            $(".loader").fadeOut("slow");
            console.log('EL CODIGO DE RESERVACIÓN');
            console.log(data);
             
          }
      });

    });
    //Validar horarios de llegada
    function validateTimeEntry(){
        var time = {
            'hour': $('#inp_hour_entry_edit option:selected').val(),
            'minute': $('#inp_minute_entry_edit option:selected').val(),
            'service': $('#inp_servicio_edit').val()
        };
        if (parseInt(time.hour) < 0 || parseInt(time.hour) > 23) {
            $('#inp_hour_entry_edit').focus();
            return false;
        }
        if (parseInt(time.minute) < 0 || parseInt(time.minute) > 59) {
            $('#inp_minute_entry_edit').focus();
            return false;
        }
        var new_time = 0; 
        if (time.service == 'compartido') {
            if (parseInt(time.hour) <= 7 || parseInt(time.hour) >= 20) {
                $('#inp_hour_entry_edit').addClass(" is-invalid");
                $('#inp_hour_entry_edit').focus();
                $("#alert-msg").show('slow');
                $("#alert-msg").addClass('alert-danger');
                $msg = "El servicio COMPARTIDO sólo se encuentra disponible para llegadas de 08:00 HRS a 20:00 HRS";
                $('#text-msg').val($msg);
                $("html, body").animate({scrollTop: 0}, 1000);
                console.log('se queda aqui 1');
                return new_time;
            }
            
            if (parseInt(time.hour) >= 8 && parseInt(time.hour) <= 19) {
                $("#alert-msg").hide('slow');
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
          'hour': $('#inp_hour_exit_edit option:selected').val(),
          'minute': $('#inp_minute_exit_edit option:selected').val(),
          'service': $('#inp_servicio_edit').val()
      };
      if (parseInt(time.hour) < 0 || parseInt(time.hour) > 23) {
          $('#inp_hour_exit_edit').focus();
          return false;
      }
      if (parseInt(time.minute) < 0 || parseInt(time.minute) > 59) {
          $('#inp_hour_exit_edit').focus();
          return false;
      }
      var new_time = 0; 
      if (time.service == 'compartido') {
          if (parseInt(time.hour) <= 7 || parseInt(time.hour) >= 20) {
              $("html, body").animate({scrollTop: 0}, 1000);
              $('#inp_hour_exit_edit').focus();
              $("#alert-msg").show('slow');
              $("#alert-msg").addClass('alert-danger');
              $msg = "El servicio COMPARTIDO sólo se encuentra disponible para salidas de 08:00 HRS a 20:00 HRS";
              $('#text-msg').val($msg);
              return new_time;
          }
          if (parseInt(time.hour) >= 8 && parseInt(time.hour) <= 19) {
              $("#alert-msg").hide('slow');
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
            'hour': $('#inp_hour_pick_edit option:selected').val(),
            'minute': $('#inp_minute_pick_edit option:selected').val(),
            'service': $('#inp_servicio_edit').val()
        };
        
        var new_time = 0; 
        if (parseInt(time.hour) <= 0 || parseInt(time.hour) > 23) {
            $("#alert-msg").show('slow');
            $("#alert-msg").addClass('alert-danger');
            $msg = "Debes ingresar una hora entre 1 - 23";
            $('#text-msg').val($msg);
            $('#inp_hour_pick_edit').focus();
            return new_time;
        }
        if (parseInt(time.minute) < 0 || parseInt(time.minute) > 59) {
            $("#alert-msg").show('slow');
            $("#alert-msg").addClass('alert-danger');
            $msg = "Debes ingresar un minute entre 1 - 59";
            $('#text-msg').val($msg);
            $('#inp_minute_pick_edit').focus();
            return new_time;
        }
        new_time = time.hour + ':' + time.minute + ' '+ 'Hrs';
        return new_time;

    }
    //Validar horarios pick up salida
    function validateTimePickExit(){
        var time = {
            'hour': $('#inp_hour_pick_inter_edit option:selected').val(),
            'minute': $('#inp_minute_pick_inter_edit option:selected').val(),
            'service': $('#_TYPE_TRANSFER').val()
        };
        var new_time = 0; 
        if (parseInt(time.hour) < 0 || parseInt(time.hour) > 23) {
            $('#inp_hour_pick_inter_edit').focus();
            return new_time;
        }
        if (parseInt(time.minute) < 0 || parseInt(time.minute) > 59) {
            $('#inp_minute_pick_inter_edit').focus();
            return new_time;
        }
        new_time = time.hour + ':' + time.minute + ' '+ 'Hrs';
        return new_time;

    }
});