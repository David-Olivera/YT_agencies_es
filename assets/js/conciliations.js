$(function(){
    var con = 0;
    let code = "";
    loadConciliations(con, code);
    $('#conciliacion_multi_select').hide();
    $('.column_mult').hide();

    /* CARGA DE DATOS */
    $('#conciliation-tab').click(function(){
        var con = 1;
        let code = "";
        loadConciliations(con, code);
    });
    $('#noconciliation-tab').click(function(){
        var con = 0;
        let code = "";
        loadConciliations(con, code);
    });
    function generateUUID() {
      var d = new Date().getTime();
      var uuid = 'xxxxxxxxxx4xxxyxxxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
          var r = (d + Math.random() * 16) % 16 | 0;
          d = Math.floor(d / 16);
          return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
      });
      return uuid;
    }
    function loadDocs(id_agency){
      $('#storaged_documents').html('');
      var id_conciliation = $('#inp_id_conciliation').val();
      const postDatas = {
        'id_agency': id_agency,
        'id_conciliation': id_conciliation,
        'action': 'load_docs'
      }
      $.ajax({
        url: '../helpers/conciliaciones.php',
        type: 'POST',
        data: postDatas,
        success: function(response){
          const docs = JSON.parse(response);
          let template = '';
          if (docs != '') {
            let template = '';
            template += `
                  <table class="table w-100" >
                      <thead>
                          <tr>
                          <th style="width:10%"  scope="col">#</th>
                          <th style="width:45%" scope="col">Nombre</th>
                          <th style="width:15%" scope="col">Factura</th>
                          <th style="width:20%" scope="col">Fecha</th>
                          <th style="width:10%" scope="col">Opción</th>
                          </tr>
                      </thead>
                      <tbody>
            `;
            docs.forEach(docs => {
              let factura = 'No Factura';
              let file = docs.file_document_completed;
              let ext = file.substring(file.lastIndexOf("."));
              if (docs.facture == 1) {
                factura = 'Factura';
              }
              
              if (ext == ".pdf") {
                template += `
                            
                            <tr dataia= ${id_agency} datado="${docs.id_concidocs}" datana="${docs.file_document_completed}">
                            <td><a href='../assets/docs/conciliaciones/${docs.file_document_completed}'  target="_blank" title='${docs.file_document_completed}' data='' class='edit_img' id='add_img'><img src='../assets/img/icon/icon_pdf.png' class='img-thumbnail w-100'></a></td>
                            <td><a href="../assets/docs/conciliaciones/${docs.file_document_completed}"  target="_blank" title='${docs.file_document_completed}'><small>${docs.file_document}...</small></a></td>
                            <td><small>${factura}</small></td>
                            <td><small>${docs.register_date}</small></td>
                            <td><a href="#" id="btn-delete-doc" class="btn btn-danger btn-sm btn-block">Eliminar</a></td>
                            </tr>
                            <tr>
                `;
              }
              if (ext == ".png" || ext == ".jpg" || ext == '.jpeg') {
                template += `
                            
                            <tr dataia= ${id_agency} datado="${docs.id_concidocs}" datana="${docs.file_document_completed}">
                            <td><a href='../assets/docs/conciliaciones/${docs.file_document_completed}'  target="_blank" title='${docs.file_document_completed}' data='' class='edit_img' id='add_img'><img src='../assets/img/icon/icon_imge.png' class='img-thumbnail w-100'></a></td>
                            <td><a href="../assets/docs/conciliaciones/${docs.file_document_completed}"  target="_blank" title='${docs.file_document_completed}'><small>${docs.file_document}...</small></a></td>
                            <td><small>${factura}</small></td>
                            <td><small>${docs.register_date}</small></td>
                            <td><a href="#" id="btn-delete-doc" class="btn btn-danger btn-sm btn-block">Eliminar</a></td>
                            </tr>
                            <tr>
                `;  
              }

            });
            template += `
                      </tbody>
                    </table>
            `;
            $('#storaged_documents').html(template);
          }else{
            $('#storaged_documents').html(template);

          }
        }

      });
    }
    function loadConciliations(type, code){
        function loadData(page){
            value = $('#inp_agency').val();
            $.ajax({
                url  : "../model/conciliaciones_paginacion.php",
                type : "POST",
                cache: false,
                data : {page_no:page, value: value, type: type, code: code},
                beforeSend:function(){
                  let template = '';
                      template += `
                      <div class="row">
                          <div class="col-lg-4 col-md-3">
                          </div>
                          <div class="col-lg-4 col-md-6">
                              <div class="spinner-grow text-dark" role="status">
                                  <span class="sr-only">Loading...</span>
                              </div>
                              <div class="spinner-grow text-secondary" role="status">
                                  <span class="sr-only">Loading...</span>
                              </div>
                              <div class="spinner-grow text-dark" role="status">
                                  <span class="sr-only">Loading...</span>
                              </div>
                          </div>
                          <div class="col-lg-4 col-md-3">
                          </div>
                      </div>
                          
                      `;
                      if (type == '') {
                          $("#si_conciliations").html(template);
                          
                      }
                      if (type == 0) {
                        $("#no_conciliations").html(template);
                      }   
                      if (type == 1) {
                        $("#si_conciliations").html(template);
                      } 
                },
                success:function(response){
                  if (type == '') {
                      $("#si_conciliations").html(response);
                      
                  }
                  if (type == 0) {
                    $("#no_conciliations").html(response);
                  }   
                  if (type == 1) {
                      $("#si_conciliations").html(response);
                  } 
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

    // SEARCH NO CONCI
    $(document).on('click', '#search_code_invoice_nco', function(){
        let code_invoice = $('#inp_code_invoice_nco').val();
        var con = 0;
        if (code_invoice == null || code_invoice.length == 0 || /^\s+$/.test(code_invoice)) {
          $('#inp_code_invoice_nco').addClass(" is-invalid");
          $('#inp_code_invoice_nco').focus();
          return false;
        }
        loadConciliations(con, code_invoice);
        $('#inp_code_invoice_nco').val('');
        
        $('#conciliacion_multi').show('slow');
        $('#conciliacion_multi_select').hide('slow');
        $(".mult_conci").prop('checked', false);
        $('.column_mult').hide();
        $('.column_only').show('slow');
        $("#IdsSeleccionados").prop("disabled", true);
    });
    
    // SEARCH CONCI
    $(document).on('click', '#search_code_invoice_co', function(){
      let code_invoice = $('#inp_code_invoice_co').val();
      var con = 1;
      if (code_invoice == null || code_invoice.length == 0 || /^\s+$/.test(code_invoice)) {
        $('#inp_code_invoice_co').addClass(" is-invalid");
        $('#inp_code_invoice_co').focus();
        return false;
      }
      loadConciliations(con, code_invoice);
      $('#inp_code_invoice_co').val('');
      
  });
    // BTN VIEW ALL GENERAL
    $(document).on('click', '#view_all_reservations_noc', function(){
      var con = 0;
      let code = "";
      loadConciliations(con, code);

    });

    // BTN VIEW ALL GENERAL
    $(document).on('click', '#view_all_reservations_con', function(){
      var con = 1;
      let code = "";
      loadConciliations(con, code);

    });

    //!! CU !!
    //BTN AGREGAR ARCHIVO A LA BD CU
    $(document).on('click', '#btn_add_file', function(e){
          e.preventDefault();
          var myfiles = document.getElementById("files_conciliation");
          var files = myfiles.files;
          var data = new FormData();
          var id_reservation = $('#inp_id_reservation').val();
          var id_conciliation = $('#inp_id_conciliation').val();
          var type_conciliation = $('#inp_type_conciliation').val();
          var id_agency = $('#inp_agency').val();
          var code = $('#inp_code_conciliation').val();
          let checked = 0;
          var seleccion = $("#check_facture")[0].checked;
          if(seleccion){
              checked = 1;
          }
          for (i = 0; i < files.length; i++) {
              data.append('file' + i, files[i]);
          }
          data.append('id_reservation', id_reservation);
          data.append('id_conciliation', id_conciliation);
          data.append('facture', checked);
          data.append('id_agency', id_agency);
          data.append('code_invoice', code);
          data.append('action', 'upload_docs');
          $.ajax({
            url: '../helpers/conciliaciones.php',
            type: 'POST',
            contentType: false,
                data: data,
                processData: false,
                cache: false,
                beforeSend: function(){
                  $('#btn_add_file').prop('disabled', true);    
                  $('#btn_add_file').html('<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>');
                },
                success: function(res) {
                  $('#files_conciliation').val('');
                  $("#check_facture").prop('checked', false);
                  $("#loadedfiles").append(res);
                  console.log(res);
                  var id_agency = $('#inp_agency').val();
                  if(type_conciliation == 0){
                    $('#noconciliation-tab').click();
                  }else{
                    $('#conciliation-tab').click();
                  }
                  loadDocs(id_agency);
                  $("#btn_add_file").prop("disabled", true);
                  setTimeout(function(){ $("#loadedfiles").html(''); }, 4000);
                  $('#btn_add_file').html('Agregar archivo');
                }
          });
    });
    //BTN CANCELAR CONCILIACION UNICA CU
    $(document).on('click', '.btn_close_conci', function(){
      $('#files_conciliation').val('');
      $('#inp_id_conciliation').val('');
      $('#inp_code_conciliation').val('');
      $('#upload_conliation').modal('hide');
      $("#check_facture").prop('checked', false);
      $("#loadedfiles").html('');
      $('#storaged_documents').html('');
      $("#btn_add_file").prop("disabled", true);

    });
    //BTN PARA ELEGIR ARCHIVO CONCI UNICA
    $(document).on('click', '#btn_upload_file', function(){
      $('#storaged_documents').html('');
      var id_agency = $('#inp_agency').val();
      let element = $(this)[0];
      let id = $(element).attr('reserva');
      let conciliation = $(element).attr('conciliation');
      let code = $(element).attr('code');
      let type_conciliation = $(element).attr('type_conci');
      $('#inp_id_reservation').val(id);
      $('#inp_id_conciliation').val(conciliation);
      $('#inp_code_conciliation').val(code);
      $('#inp_type_conciliation').val(type_conciliation);
      $('#label_conci_code').text('Reservacíon '+ code);
      loadDocs(id_agency);
    });
    
    //!! CM !!
    //BTN CM
    $(document).on('click', '#btn_select_reservs', function(){
        $('#conciliacion_multi').hide();
        $('#conciliacion_multi_select').show('slow');
        $('.column_mult').show();
        $('.column_only').hide();
    });
    //BTN CANCELAR CONCILIACION MULTI CM
    $(document).on('click', '#cancel_multi_concilia', function(){
        $('#conciliacion_multi').show('slow');
        $('#conciliacion_multi_select').hide('slow');
        $(".mult_conci").prop('checked', false);
        $('.column_mult').hide();
        $('.column_only').show('slow');
        $("#IdsSeleccionados").prop("disabled", true);
    });
    //BTN CANCELAR MODAL CONCILIACION MULTI CM
    $(document).on('click', '.btn_close_conci_multi', function(){
      $('#files_conciliation_multi').val('');
      $('#inp_id_conciliation').val('');
      $('#inp_code_conciliation').val('');
      $('#upload_conliation_multi').modal('hide');
      $("#check_facture_multi").prop('checked', false);
      $("#loadedfiles").html('');
      $('#label_id_resercavions').text('');
      $('#storaged_documents').html('');
      $("#btn_add_file_multi").prop("disabled", true);
      $("#loadedfiles_multi").html('');
    });
    //SELECCION MULTIPLE DE RESERVACIONES CM
    $(document).on('click','#IdsSeleccionados', function() {
      var id_seleccionados = new Array();
      $('input[type=checkbox]:checked').each(function() {
        id_seleccionados.push($(this).val());
      });
      $('#label_id_resercavions').text(id_seleccionados);
    });
    //AGREGAR FILE DE CM
    $(document).on('click', '#btn_add_file_multi', function(){
      var data = new FormData();
      let key = generateUUID();
      data.append('key_u', key);
      $('input[type=checkbox]:checked').each(function() {
        if ($(this).val() != 'on') {
          var myfiles = document.getElementById("files_conciliation_multi");
          var files = myfiles.files;
          let element = $(this)[0];
          let reservacion = $(element).attr('reserva-re');
          let conciliation = $(element).attr('reserva-con');
          var id_agency = $('#inp_agency').val();
          let checked = 0;
          var seleccion = $("#check_facture_multi")[0].checked;
          if(seleccion){
              checked = 1;
          }
          for (i = 0; i < files.length; i++) {
            data.append('file' + i, files[i]);
          }
          data.append('id_reservation', reservacion);
          data.append('id_conciliation', conciliation);
          data.append('facture', checked);
          data.append('id_agency', id_agency);
          data.append('code_invoice', $(this).val());
          data.append('action', 'upload_docs_multi');
          $.ajax({
            url: '../helpers/conciliaciones.php',
            type: 'POST',
            contentType: false,
                data: data,
                processData: false,
                cache: false,
                success: function(res) {
                  $('#files_conciliation_multi').val('');
                  $("#check_facture_multi").prop('checked', false);
                  $("#loadedfiles_multi").append(res);
                  console.log(res);
                  var id_agency = $('#inp_agency').val();
                  var con = 0;
                  let code = "";
                  loadConciliations(con,code);
                  loadDocs(id_agency);
                  $('#conciliacion_multi').show('slow');
                  $('#conciliacion_multi_select').hide('slow');
                  $(".mult_conci").prop('checked', false);
                  $('.column_mult').hide();
                  $('.column_only').show('slow');
                  $("#btn_add_file_multi").prop("disabled", true);
                  setTimeout(function(){ $("#loadedfiles_multi").html(''); }, 4000);
                }
          });
        }

      });
    });

    /* VALIDACION */
    // VALIDAR SI HA ESCOGIDO ALGUN ARCHIVO CU
    $("#files_conciliation").change(function(){
      $("#btn_add_file").prop("disabled", this.files.length == 0);
    });
    // VALIDAR SI HA ESCOGIDO ALGUN ARCHIVO CM
    $("#files_conciliation_multi").change(function(){
      $("#btn_add_file_multi").prop("disabled", this.files.length == 0);
    });

    $(document).on('change','.mult_conci',function(){
      let inp = $('.mult_conci').prop("checked");
      if (inp == true) {
        $("#IdsSeleccionados").prop("disabled", '.mult_conci' == true);
      }else{
        $("#IdsSeleccionados").prop("disabled", '.mult_conci' != true);

      }
    });
    //ELIMINAR ARCHIVO GENERAL
    $(document).on('click', '#btn-delete-doc', function(e){
      e.preventDefault();
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('datado');
        let id_a = $(element).attr('dataia');
        let name = $(element).attr('datana');
        var type_conciliation = $('#inp_type_conciliation').val();
        let delet = 'delete_doc';
        const postData = {
            'id': id,
            'id_agency': id_a,
            'name_doc': name,
            'action': delet,
        }
        console.log(postData);
        $.post('../helpers/conciliaciones.php', postData, function(response){
          if(type_conciliation == 0){
            $('#noconciliation-tab').click();
          }else{
            $('#conciliation-tab').click();
          }
          loadDocs(id_a);
          $("#loadedfiles").html('');
          $("#loadedfiles").append(response);

          setTimeout(function(){ $("#loadedfiles").html(''); }, 2000);

        });
    });
    //Removemos class al cambiar de Paso 2
    $(document).on('keyup', '#inp_code_invoice_nco', function(){
      if ($.trim($(this).val()).length) {
          $(this).removeClass(' is-invalid');
      } else {
          $(this).addClass(' is-invalid');
      }
    });
    //Removemos class al cambiar de Paso 2
    $(document).on('focusout', '#inp_code_invoice_nco', function(){
          $(this).removeClass(' is-invalid');
    });
    // $(document).on('click', '.mult_conci', function(){
    //   let element = $(this)[0].parentElement.parentElement.parentElement;
    //   let id = $(element).attr('code-invoice');
    // });


});