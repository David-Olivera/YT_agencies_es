$(function(){
    var con = 1;
    loadConciliations(con);
    $('#conciliacion_multi_select').hide();
    $('.column_mult').hide();

    $('#conciliation-tab').click(function(){
        var con = 1;
        loadConciliations(con);
      });
  
    $('#noconciliation-tab').click(function(){
        var con = 0;
        loadConciliations(con);
    });
    function loadConciliations(type){
        function loadData(page){
            value = $('#inp_agency').val();
            $.ajax({
                url  : "../model/conciliaciones_paginacion.php",
                type : "POST",
                cache: false,
                data : {page_no:page, value: value, type: type},
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
                          $("#conciliation").html(template);
                          
                      }
                      if (type == 0) {
                        $("#no_conciliations").html(template);
                      }   
                      if (type == 1) {
                        $("#conciliation").html(template);
                      } 
                },
                success:function(response){
                  if (type == '') {
                      $("#conciliation").html(response);
                      
                  }
                  if (type == 0) {
                    $("#no_conciliations").html(response);
                  }   
                  if (type == 1) {
                      $("#conciliation").html(response);
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
    $(document).on('click', '#btn_select_reservs', function(){
        $('#conciliacion_multi').hide('slow');
        $('#conciliacion_multi_select').show('slow');
        $('.column_mult').show('slow');
        $('.column_only').hide('slow');
    });
    $(document).on('click', '#cancel_multi_concilia', function(){
        $('#conciliacion_multi').show('slow');
        $('#conciliacion_multi_select').hide('slow');
        $('.column_mult').hide('slow');
        $('.column_only').show('slow');
    });

    $(document).on('click', '.mult_conci', function(){
      let element = $(this)[0].parentElement.parentElement.parentElement;
      let id = $(element).attr('reserva-re');
      console.log(element);
      console.log(id);
    });

    $(document).on('click','#verDiasSeleccionados', function() {

        var diasSeleccionados = new Array();

        $('input[type=checkbox]:checked').each(function() {
        diasSeleccionados.push($(this).val());
        });

        alert("Dias seleccionados => " + diasSeleccionados);
    });
});