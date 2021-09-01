$(function(){
    let date_en = "";
    let date_ex = "";
    $("#alert-msg").hide();
    $('#content_edit_reserva').hide();
    loadReservations(date_en, date_ex, code="");


    //Btn x de alert mensaje
    $("#alert-close").click(function(){
     $("#alert-msg").hide('slow');
    });
    function loadReservations(date_en, date_ex, code){
      function loadData(page,value){
          value = $('#inp_agency').val();
          $.ajax({
              url  : "../model/reservaciones_paginacion.php",
              type : "POST",
              cache: false,
              data : {page_no:page, value:value, date_en, date_ex, code},
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
    // datepicker search
    $(function() {        
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
    // datepicker entrada y salida edit
    $(function() {        
          var $datepicker2 = $( "#datepicker_exit_edit" );
          let inp_todaysale = $('#inp_todaysale_edit').val();
          let daypicket = $('#datepicker_arrival_edit').val();
          let todaysale = 0;
          if (inp_todaysale == 1 || inp_todaysale == 0) {
              todaysale = $('#inp_todaysale_edit').val();
          }else{
              todaysale = 0;
          }
          var minDateArg = "";
          if(todaysale == 1){
            minDateArg = daypicket;
           }else{
            minDateArg = '+1d';
           }
          $('#datepicker_arrival_edit').datepicker( {
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
    // datepicker pick up edit
    $(function() {        
      var $datepicker_3 = $("#datepicker_pickup_exit_edit");
      $('#datepicker_pickup_arrival_edit').datepicker( {
          language: 'es',
          onSelect: function(fecha) {
              $datepicker_3.datepicker({
                  language: 'es',       
                  minDate: new Date(),

              });
              $datepicker_3.datepicker("option", "disabled", false);
              $datepicker_3.datepicker('setDate', null);
              $datepicker_3.datepicker("option", "minDate", fecha); 
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
      loadReservations(f_llegada, f_salida, code="");
      $('#datepicker_star_ser').val('');
      $('#datepicker_end_ser').val('');
    });
    $(document).on('click', '#btn_search_code_invoice_res', function(){
      let code = $('#inp_code_invoice_res').val();
      if (code == null || code.length == 0 || /^\s+$/.test(code)) {
        $('#inp_code_invoice_res').addClass(" is-invalid");
        $('#inp_code_invoice_res').focus();
        return false;
      }
      loadReservations(f_llegada ="", f_salida="", code);
      $('#inp_code_invoice_res').val('');


    });
    $(document).on('click', '#view_all_reservations', function(){
      let date_en = "";
      let date_ex = "";
      loadReservations(date_en, date_ex, code="");
    });
    $(document).on('click','.reservation-action',function(){
        let id = $(this).data('id');
        let edit = $(this).data('edit');
        loadEditReservation(id,edit);
    });
    $(document).on('click',  '#close_alert_edit', function(){
      $('#form-content-edit-agencie').trigger('reset');
      id = $('#code_invoice_edit_alert').val();
      loadEditReservation(id,edit = 1);
      let date_en = "";
      let date_ex = "";
      loadReservations(date_en, date_ex, code="");
      
    });
    function loadEditReservation(id, edit){
        if (edit == 1) {
          $('#content_btns').show();
          $('#form-content-edit-agencie :input').prop('disabled', false);
        }else{
          $('#content_btns').hide();
          $('#form-content-edit-agencie :input').prop('disabled', false);
          $('#form-content-edit-agencie :input').prop('disabled', true);

        }
        $('#content_inp_code_client').hide(); 
        $('#content_inp_asesor').hide(); 
        $('#content_inp_ofagencie').hide(); 
        $('#content_inp_interhotel').hide();
        $('#inps_entrada_edit').hide();
        $('#inps_salida_edit').hide();
        $('#inp_pickup_edit').hide();
        $('#content_comission_agency').hide();
        $('#content_subtotal').hide();
        $('#pick_up_exit').hide();
        $('#compartido_ts').show();
        $('#card').hide();
        $('#transfer').hide();
        $('#paypal').hide();
        $('#airport').hide();
        $('#inp_time_service_edit').hide();
        let code = $(this).data('code');
        let yt = $('#inp_internal_yt').val();
        $('#code_invoice_edit_alert').val(id);
        $('#inp_id_reservation').val(id);
        $('#title_edit_res').text('Editar Reservación '+code);
        const postDatas = {
          'id': id,
          'get_data_reserva': true
        }
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
            },
            success: function(data){
              const res = JSON.parse(data);
              if (res.type_service == 'compartido' && (res.type_transfer == 'RED' || res.type_transfer == 'SEN/AH')) {
                $('#inp_time_service_edit').show();
                $('#inp_time_service').val(res.time_service);
                
              }
              $('#transfer').show();
              switch (res.method_payment) {
                case 'card':
                  $('#card').show();
                  break;
                case 'paypal':
                  $('#paypal').show();
                  break;
              
                case 'airport':
                  $('#airport').show();
                  break;
              }
              let methodpayment ="";
              switch (res.method_payment) {
                case 'card':
                    methodpayment = 'TARJETA';
                    break;
                case 'transfer':
                    methodpayment = 'TRANSFERENCIA';
                    break;
                case 'paypal':
                    methodpayment = 'PAYPAL';
                    break;
                case 'airport':
                    methodpayment = 'PAGO AL ABORDAR';
                    break;
              }
              $('#title_reservation').text('Reservación - '+res.code_invoice);
              new_of_the_agency ="";
              if (yt == 1) {
                  $('#content_inp_code_client').show(); 
                  $('#content_inp_asesor').show(); 
                  $('#content_inp_ofagencie').show();
                  if (res.code_client) { 
                    $('#inp_code_client_edit').val(res.code_client);
                  }
                  if (res.name_advisor) {
                    $('#inp_asesor_edit').val(res.name_advisor);
                  }
                  if (res.of_the_agency) { 
                    $('#inp_ofagency_edit').val("");
                    if (res.of_the_agency != res.id_agency) {
                      $('#inp_ofagency_edit').val(res.of_the_agency);
                    }
                  }
              }
              $('#inp_hotel_edit').val(res.transfer_destiny);
              if (res.type_transfer == 'REDHH' || res.type_transfer == 'SEN/HH') {
                $('#content_inp_interhotel').show();
                $('#inp_hotel_interhotel_edit').val(res.destiny_interhotel);
              }
              $('#inp_traslado_up').val(res.type_transfer);
              $('#inp_servicio_edit').val(res.type_service);
              if (res.type_service == 'lujo') {
                $('.num_px_pri').hide();
              }else{
                $('.num_px_pri').show();

              }
              $('#inp_pasajeros_edit').val(res.number_adults);
              if (res.type_transfer == 'SEN/AH' || res.type_transfer == 'RED') {
                $('#label_date_star').text('Llegada');
                $('#inps_entrada_edit').show();
                $('#datepicker_arrival_edit').val(res.date_arrival);
                $('#inp_airline_entry_edit').val(res.airline_in);
                $('#inp_nofly_entry_edit').val(res.no_fly);
                $('#inp_hour_entry_edit').val(res.time_hour_arrival);
                $('#inp_minute_entry_edit').val(res.time_min_arrival);
              }
              if (res.type_transfer == 'SEN/HA' ) {
                $('#label_date_star').text('Salida');
                $('#inps_entrada_edit').show();
                $('#datepicker_arrival_edit').val(res.date_exit);
                $('#inp_airline_entry_edit').val(res.airline_out);
                $('#inp_nofly_entry_edit').val(res.no_flyout);
                $('#inp_hour_entry_edit').val(res.time_hour_exit);
                $('#inp_minute_entry_edit').val(res.time_min_exit);
              }
              if (res.type_transfer == 'RED') {
                $('#label_date_star').text('Llegada');
                $('#inps_salida_edit').show();
                $('#datepicker_exit_edit').val(res.date_exit);
                $('#inp_airline_exit_edit').val(res.airline_out);
                $('#inp_nofly_exit_edit').val(res.no_flyout);
                $('#inp_hour_exit_edit').val(res.time_hour_exit);
                $('#inp_minute_exit_edit').val(res.time_min_exit);
              }
              if (res.type_transfer == 'SEN/HH' || res.type_transfer == 'REDHH') {
                $('#inp_pickup_edit').show();
                $('#datepicker_pickup_arrival_edit').val(res.date_arrival);
                $('#inp_hour_pick_edit').val(res.time_hour_arrival);
                $('#inp_minute_pick_edit').val(res.time_min_arrival);
                $('#compartido_ts').hide();

              }
              if ( res.type_transfer == 'REDHH') {
                $('#inp_pickup_edit').show();
                $('#pick_up_exit').show();
                $('#datepicker_pickup_exit_edit').val(res.date_exit);
                $('#inp_hour_pick_inter_edit').val(res.time_hour_exit);
                $('#inp_minute_pick_inter_edit').val(res.time_min_exit);
                $('#compartido_ts').hide();
              }

              $('#inp_date_register_res_edit').val(res.date_register_reservation);
              $('#inp_status_reserva_edit').val(res.status_reservation);
              $('#inp_method_payment_edit').val(res.method_payment);
              $('#inp_total_cost_edit').val(res.total_cost);
              $('.currency').text(res.type_currency);
              if (res.method_payment == 'card' || res.method_payment == 'paypal') {
                $('#content_comission_agency').show();
                $('#content_subtotal').show();
                $('#inp_agency_commision_edit').val(res.agency_commision);
                $('#inp_total_cost_commesion_edit').val(res.total_cost_commision);
                $('#inp_total_cost_before').val(res.total_cost_commision);
              }else{
                $('#inp_total_cost_commesion_edit').val(res.total_cost);
                $('#inp_total_cost_before').val(res.total_cost);

              }
              $('#inp_name_client_edit').val(res.name_client);
              $('#inp_lastname_client_edit').val(res.last_name);
              $('#inp_mother_lastname_edit').val(res.mother_lastname);
              $('#inp_email_client_edit').val(res.email_client);
              $('#inp_phone_client_edit').val(res.phone_client);
              $('#inp_country_client_edit').val(res.country_client);
              $('#inp_special_requests_edit').val(res.comments_client);
              $('#inp_code_invoice').val(res.code_invoice);
              $("#content_reservs_search").hide( "drop", { direction: "left"}, "slow" );
              $("#content_edit_reserva").show( "drop", { direction: "right" }, "slow" );
              setTimeout(function(){  $(".loader").fadeOut("slow"); }, 300);
             
              
            }
        });
    }
    // Editar el tipo de traslado
    $(document).on('change', '#inp_traslado_up', function(){
      $('#content_inp_interhotel').hide();
      $('#inps_entrada_edit').hide();
      $('#inps_salida_edit').hide();
      $('#inp_pickup_edit').hide();
      $('#content_comission_agency').hide();
      $('#pick_up_exit').hide();
        let value ="";
        value = $(this).val();
        if (value == 'RED') {
          $('#label_date_star').text('Llegada');
          $('#compartido_ts').show();
          $('#inps_entrada_edit').show("drop", { direction: "left"}, "slow");
          $('#inps_salida_edit').show("drop", { direction: "left"}, "slow");
        }
        if (value == 'SEN/AH') {
          $('#compartido_ts').show();
          $('#label_date_star').text('Llegada');
          $('#inps_entrada_edit').show("drop", { direction: "left"}, "slow");
        }
        if (value == 'SEN/HA') {
          $('#compartido_ts').show();
          $('#label_date_star').text('Salida');
          $('#inps_entrada_edit').show("drop", { direction: "left"}, "slow");
        }
        if (value == 'SEN/HH') {
          $('#inp_servicio_edit').val('privado');
          $('#content_inp_interhotel').show();
          $('#compartido_ts').hide();
          $('#inp_pickup_edit').show("drop", { direction: "left"}, "slow");
        }
        if (value == 'REDHH') {
          $('#inp_servicio_edit').val('privado');
          $('#content_inp_interhotel').show();
          $('#compartido_ts').hide();
          $('#pick_up_exit').show();
          $('#inp_pickup_edit').show("drop", { direction: "left"}, "slow");
          $('#pick_up_exit').show("drop", { direction: "left"}, "slow");
        }
        
    });
    // Editar el tipo de traslado
    $(document).on('change', '#inp_servicio_edit', function(){
        let value ="";
        value = $(this).val();
        if (value == 'compartido') {
          $('.num_px_pri').show();
          
        }
        if (value == 'privado') {
          $('.num_px_pri').show();
        }
        if (value == 'lujo') {
          $('.num_px_pri').hide();
        }
        
    });
    // Editar el metodo de pago
    $(document).on('change', '#inp_method_payment_edit', function(){
        let value = $(this).val();
        $('#content_subtotal').hide();
        $('#content_comission_agency').hide();
        total_cost = $('#inp_total_cost_edit').val();
        amount_commision = $('#inp_agency_commision_edit').val();
        value_before = $('#inp_total_cost_commesion_edit').val();
        var suma = 0;
        var commision = 0.05;
        var cost_comision= 0;
        var cost_finally = 0;
        var cost_total_commision = 0;
        cost_comision = total_cost * commision;
        cost_finally = (total_cost - cost_comision).toFixed(0);
        cost_total_commision =   Math.round((parseFloat(total_cost) / 0.95) + parseFloat(amount_commision));
        if (value == 'card') {
          $('#content_subtotal').show( "drop", { direction: "right" }, "slow" );
          $('#content_comission_agency').show( "drop", { direction: "right" }, "slow" );
          $('#inp_total_cost_commesion_edit').val('');
          $('#inp_total_cost_commesion_edit').val(cost_total_commision);
        }else{
          $('#inp_total_cost_commesion_edit').val(total_cost);
        }
        $('#inp_total_cost_before').val(value_before);
    });
    $('.close_content_edit_reserva').click(function(){
      $('#form-content-edit-agencie').trigger('reset');
      $("#content_edit_reserva").hide( "drop", { direction: "right" }, "slow" );
      $.ajax({
        beforeSend: function(){
          let template = '';
          template += `    
              <div class="loader"></div>
          `;
          $('#loading').html(template);
        },
        complete: function(){
          $("#content_reservs_search").show( "drop", { direction: "left"}, "slow" );
          setTimeout(function(){  $(".loader").fadeOut("slow"); }, 200);
        }
      });

    });
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
    $(document).on('click', '#update_details_reservation', function(){
      let id_reservation = $('#inp_id_reservation').val();
      let code_invoice = $('#inp_code_invoice').val();
      let co_yt = $('#inp_internal_yt').val();
      let code_client = "";
      let name_asesor = "";
      let of_the_agency = "";

      let name_hotel = $('#inp_hotel_edit').val();
      let name_hotel_interhotel= "";
      let type_traslado = $('#inp_traslado_up').val();
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
      let sub_total= 0.00;
      let commission = "";
      let total_cost_comision =0.00;
      let currency ="";
      let time_service = "";
      let name_client = $('#inp_name_client_edit').val();
      let last_name = $('#inp_lastname_client_edit').val();
      let mother_lastname = $('#inp_mother_lastname_edit').val();
      let email_client = $('#inp_email_client_edit').val();
      let phone_client =$('#inp_phone_client_edit').val();
      let special_request = $('#inp_special_requests_edit').val();

      console.log('ID RESERVATION');
      console.log(id_reservation);

      console.log('CODE INVOICE');
      console.log(code_invoice);
      //RESERVA EXTERNA
      if (co_yt == 1) {
        if ($('#inp_code_client_edit').val()) {
          code_client = $('#inp_code_client_edit').val();
        }
        if ($('#inp_asesor_edit').val()) {
          name_asesor = $('#inp_asesor_edit').val();
        }
        var agencie = $('#inp_id_agencie').val();
        if ($('#inp_ofagency_edit').val()) {
            of_the_agency = $('#inp_ofagency_edit').val();
        }else{
            of_the_agency = agencie;
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
      if (type_service == 'compartido' && (type_traslado == 'RED' || type_traslado == 'SEN/AH')) {
        time_service = $('#inp_time_service').val();
        if (time_service == null || time_service.length == 0 || /^\s+$/.test(time_service)) {
          $('#inp_time_service').addClass(" is-invalid");
          $('#inp_time_service').focus();
          return false;
        }
      }
      console.log('RESERVA TRASLADO');
      console.log(name_hotel+' - '+type_traslado+' - '+type_service+' - '+num_pasajeros);
      console.log(name_hotel_interhotel);

      console.log('DATOS DE VUELO Y/O PICKUP');
      //DATOS DE VUELO Y/O PICKUP
      if (type_traslado == 'SEN/AH' || type_traslado == 'RED') {
          date_arrival = $('#datepicker_arrival_edit').val();
          airline_arrival = $('#inp_airline_entry_edit').val();
          no_fly_arrival = $('#inp_nofly_entry_edit').val();
          time = validateTimeEntry();
          if (date_arrival == null || date_arrival.length == 0 || /^\s+$/.test(date_arrival)) {
            $('#datepicker_arrival_edit').addClass(" is-invalid");
            $('#datepicker_arrival_edit').focus();
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

      if (type_traslado == 'SEN/HA') {
          date_exit = $('#datepicker_arrival_edit').val();
          airline_exit = $('#inp_airline_entry_edit').val();
          no_fly_exit = $('#inp_nofly_entry_edit').val();
          time_exit = validateTimeEntry();
          if (date_exit == null || date_exit.length == 0 || /^\s+$/.test(date_exit)) {
            $('#datepicker_arrival_edit').addClass(" is-invalid");
            $('#datepicker_arrival_edit').focus();
            return false;
          }
          if (airline_exit == null || airline_exit.length == 0 || /^\s+$/.test(airline_exit)) {
              $('#inp_airline_entry_edit').addClass(" is-invalid");
              $('#inp_airline_entry_edit').focus();
              return false;
          }
          if (no_fly_exit == null || no_fly_exit.length == 0 || /^\s+$/.test(no_fly_exit)) {
              $('#inp_nofly_entry_edit').addClass(" is-invalid");
              $('#inp_nofly_entry_edit').focus();
              return false;
          }
          if (time_exit == null || time_exit == 0) {
              $('#inp_hour_entry_edit').addClass(" is-invalid");
              $('#inp_hour_entry_edit').focus();
              return false;
          }
          console.log(date_exit+' - '+airline_exit+' - '+no_fly_exit+' - '+time_exit);
      }
      if (type_traslado == 'RED') {
        date_exit = $('#datepicker_exit_edit').val();
        airline_exit = $('#inp_airline_exit_edit').val();
        no_fly_exit = $('#inp_nofly_exit_edit').val();
        time_exit = validateTimeExit();
        if (date_exit == null || date_exit.length == 0 || /^\s+$/.test(date_exit)) {
          $('#datepicker_exit_edit').addClass(" is-invalid");
          $('#datepicker_exit_edit').focus();
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
          date_arrival = $('#datepicker_pickup_arrival_edit').val();
          time_pickup = validateTimePickEntry();
          if (date_arrival == null || date_arrival.length == 0 || /^\s+$/.test(date_arrival)) {
            $('#datepicker_pickup_arrival_edit').addClass(" is-invalid");
            $('#datepicker_pickup_arrival_edit').focus();
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
          date_exit = $('#datepicker_pickup_exit_edit').val();
          time_pickup_inter = validateTimePickExit();
          if (date_exit == null || date_exit.length == 0 || /^\s+$/.test(date_exit)) {
            $('#datepicker_pickup_exit_edit').addClass(" is-invalid");
            $('#datepicker_pickup_exit_edit').focus();
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
        total_cost_comision = $('#inp_total_cost_commesion_edit').val();
        inp_total_cost_before = $('#inp_total_cost_before').val();
      if (method_payment == 'card' || method_payment == 'paypal') {
        sub_total= $('#inp_total_cost_edit').val();
        commission = $('#inp_agency_commision_edit').val();
      }
      currency = $('#currency').text();
      console.log('DATOS DE PAGO Y ESTADO');
      console.log(method_payment+' - '+total_cost_comision);
      console.log(method_payment+' - '+sub_total+' - '+commission+ ' - '+total_cost_comision);
      console.log(currency);

      if (name_client == null || name_client.length == 0 || /^\s+$/.test(name_client)) {
          $('#inp_name_client_edit').addClass(" is-invalid");
          $('#inp_name_client_edit').focus();
          return false;
          
      }
      if (last_name == null || last_name.length == 0 || /^\s+$/.test(last_name)) {
          $('#inp_lastname_client_edit').addClass(" is-invalid");
          $('#inp_lastname_client_edit').focus();
          return false;
          
      }
      if (mother_lastname == null || mother_lastname.length == 0 || /^\s+$/.test(mother_lastname)) {
          $('#inp_mother_lastname_edit').addClass(" is-invalid");
          $('#inp_mother_lastname_edit').focus();
          return false;
          
      }
      if (phone_client == null || phone_client.length == 0 || /^\s+$/.test(phone_client)) {
          $('#inp_phone_client_edit').addClass(" is-invalid");
          $('#inp_phone_client_edit').focus();
          return false;
          
      }
      if (!(/\w+([-+.']\w+)*@\w+([-.]\w+)/.test(email_client))) {
          $('#inp_email_client_edit').addClass(" is-invalid");
          $('#inp_email_client_edit').focus();
          return false;
      }
      console.log('DATOS DE CLIENTE');
      console.log(name_client+' - '+last_name+' - '+email_client+' - '+phone_client+' - '+special_request);
      const postDatas = {
        'id_reservation':id_reservation,
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
        'time_service': time_service,
        'method_payment' :method_payment, 
        'sub_total' :sub_total,
        'commission' :commission,
        'total_cost_comision' :total_cost_comision,
        'currency': currency,
        'name_client' :name_client,
        'last_name':last_name,
        'mother_lastname': mother_lastname,
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
            const res = JSON.parse(data);
            $(".loader").fadeOut("slow");
            console.log('EL NUEVO PRECIO ES');
            console.log(data);
            let new_currency ="";
            let newdata ="";
            if (currency == 'mx') {
              new_currency = 'MXN';
            }else{
              new_currency = 'USD';
            }
            console.log(res.sql);
            if (res.error == 1) {
              if (res.total_cost == total_cost_comision || res.total_cost_commision == total_cost_comision) {
                newdata = '<p>Los datos han sido actualizados correctamente, sin cambios en la tarfia <p/>';
              }else {
                newdata = '<p>La reservación a sido actualizada, el nuevo balance es <p/>'+ '<h4 style="color:#47c9a2;">$'+res.total_cost+ ' '+ new_currency +'</h4> <p> balance anterior</p> <h5 style="color:#E1423B; text-decoration: line-through;">$ '+inp_total_cost_before+ ' '+ new_currency +'</h5>';
                if (method_payment == 'card' || method_payment == 'paypal') {
                  newdata = '<p>La reservación a sido actualizada, el nuevo balance es <p/>'+ '<h4 style="color:#47c9a2;">$'+res.total_cost_commision+ ' '+ new_currency +'</h4>'+' <p> ya incluida la comisión</p> <h5 style="color:#47c9a2;">$ '+commission+ ' '+ new_currency +'</h5>' +'<p> balance anterior</p> <h5 style="color:#E1423B; text-decoration: line-through;">$ '+total_cost_comision+ ' '+ new_currency +'</h5>';
                }
              }
              $('#update').modal('show');
              $('#msj_success').html(newdata);  
            }else{
                $('#myModalerror').modal('show'); 
            }
          }      
      });

    });
    $(document).on('change', '.agencyCancelSale', function(){
      var data = {
        'id' : $(this).data('sale'),
        'state' : $(this).val()
      };
      $('#reservation_state').val(data.id);
      $('#myUpdateState').modal('show');
    });
    $(document).on('click', '.confirm_reservation_state', function(){
      var id_reservation = $('#reservation_state').val();
      var state = $('.agencyCancelSale').val();
      const postData = {
        'id_reservation': id_reservation,
        'state': state,
        'action': 'update_reservation_state'
      };
      
      $.ajax({
        data: postData,
        url: '../helpers/reservaciones.php',
        type: 'post',
        beforeSend: function(){
          $('.confirm_reservation_state').prop('disabled', true);    
          $('.confirm_reservation_state').html('<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>');

        },
        success: function(res){
          console.log(res);
          $('.confirm_reservation_state').prop('disabled', false);    
          $('.confirm_reservation_state').html('<span>Aceptar</span>');
          $('#myUpdateState').modal('hide');
          if (res == 1) {
            $('#alert-msg').show();
            $("#alert-msg").addClass('alert-info');
            $('#text-msg').val('El estado de la reservacion a sido actualizado a '+ postData.state);
          }else{
            $('#alert-msg').show();
            $("#alert-msg").addClass('alert-danger');
            $('#text-msg').val('Error al intentar actualizar el Estado de la Reservación ');
          }
          loadReservations(date_en, date_ex, code="");
        }
      });
    });

    $(document).on('click', '#cancel_reservation_state', function(){
      loadReservations(date_en, date_ex, code="");
    });
    //PRINT LETTER
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
    $(document).on('click', '#get_pdf_req', function(){
      let element = $(this)[0].parentElement.parentElement;
      let id = $(element).attr('res-id');
      $('#id_res_pdf').val(id);

    });
    
    $(document).on('click','#printLetter', function(event){
      event.preventDefault();
    
      var ventimp = window.open(' ', 'popimpr');
    
      ventimp.document.write($('.PDFLetter').html());
    
      ventimp.document.close();
    
      ventimp.print( );
    
      ventimp.close();
    });
    $(document).on('click', '#btn_load_pdf', function(){
        $('#myModal').modal('hide');
        $("#select_price_pdf").val(3);
        $('#content_btn_pdf').html('');
        ;
    });

    //Removemos class de Date 1
	  $('#datepicker_star_ser').on('focusout', function(){
      $(this).removeClass(' is-invalid');
    });
    //Removemos class de Date 2
    $('#datepicker_end_ser').on('focusout', function(){
        $(this).removeClass(' is-invalid');
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
              $('#inp_hour_exit_edit').addClass(" is-invalid");
              $('#inp_hour_exit_edit').focus();
              $("#alert-msg").show('slow');
              $("#alert-msg").addClass('alert-danger');
              $msg = "El servicio COMPARTIDO sólo se encuentra disponible para salidas de 08:00 HRS a 20:00 HRS";
              $('#text-msg').val($msg);
              $("html, body").animate({scrollTop: 0}, 1000);
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
    //Removemos class de Date 1
    $(document).on('click', '#datepicker_arrival_edit', function(){
      $(this).removeClass(' is-invalid');
    });
    //Removemos class de Date 2
    $(document).on('click', '#datepicker_exit_edit', function(){
      $(this).removeClass(' is-invalid');
    });
    //Removemos class de Date 1
    $(document).on('click', '#datepicker_pickup_arrival_edit', function(){
      $(this).removeClass(' is-invalid');
    });
    //Removemos class de Date 2
    $(document).on('click', '#datepicker_pickup_exit_edit', function(){
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