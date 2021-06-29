$(function(){
    $('#btn_load').hide();
    $('#alert_msg').hide();
    $('#check_edit_pass').hide();
    $('#btn_edit_user_d').hide();
    loadUsers();

    $('#close_modal_user').click(function(){
        $('#formNewUser').trigger('reset');
        $('#modal_add_user').modal('hide');
        $('#formNewUser :input').removeClass(' is-invalid');
        $('#formNewUser :input').removeClass(' is-valid');
        $('#check_edit_pass').hide();
        $('#btn_edit_user_d').hide();
        $('#btn_new_user').show();
    });
    
    function loadUsers(){
        function loadData(page,value){
            value = $('#inp_agency').val();
            $.ajax({
                url  : "../model/users_paginacion.php",
                type : "POST",
                cache: false,
                data : {page_no:page, value:value},
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
                $("#content_user_agency").html(response);
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
    //Agregar usuario
    $('#btn_new_user').on('click', function(e){
        value = $('#inp_agency').val();
        const postDatas = {
            'id_agency': value,
            'name_user': $('#inp_user_name').val(),
            'last_name': $('#inp_user_lastname').val(),
            'email_user': $('#inp_user_email').val(),
            'phone_user': $('#inp_user_phone').val(),
            'username': $('#inp_user_username').val(),
            'password': $('#inp_user_password').val(),
            'password_confirm': $('#inp_user_password_confirm').val(),
            'action': 'add_user'
        };
        if (postDatas.name_user == null || postDatas.name_user.length == 0 || /^\s+$/.test(postDatas.name_user)) {
            $('#inp_user_name').addClass(" is-invalid");
            $('#inp_user_name').focus();
            return false;
        }
        if (postDatas.last_name == null || postDatas.last_name.length == 0 || /^\s+$/.test(postDatas.last_name)) {
            $('#inp_user_lastname').addClass(" is-invalid");
            $('#inp_user_lastname').focus();
            return false;
        }
        if (postDatas.email_user == null || postDatas.email_user.length == 0 || /^\s+$/.test(postDatas.email_user)) {
            $('#inp_user_email').addClass(" is-invalid");
            $('#inp_user_email').focus();
            return false;
        }
        if (postDatas.username == null || postDatas.username.length == 0 || /^\s+$/.test(postDatas.username)) {
            $('#inp_user_username').addClass(" is-invalid");
            $('#inp_user_username').focus();
            return false;
        }
        if (postDatas.password == null || postDatas.password.length == 0 || /^\s+$/.test(postDatas.password)) {
            $('#inp_user_password').addClass(" is-invalid");
            $('#inp_user_password').focus();
            return false;
        }
        if (postDatas.password_confirm == null || postDatas.password_confirm.length == 0 || /^\s+$/.test(postDatas.password_confirm)) {
            $('#inp_user_password_confirm').addClass(" is-invalid");
            $('#inp_user_password_confirm').focus();
            return false;
        }
        if(postDatas.password != postDatas.password_confirm){
            $('#inp_user_password_confirm').addClass(" is-invalid");
            $('#inp_user_password_confirm').focus();
            return false;
        }
        $.ajax({
            data: postDatas,
            url: '../helpers/usuarios.php',
            type: 'post',
            beforeSend: function(){
                $('#btn_load').show();
                $('#btn_new_user').hide();
            },
            success: function(data){
                console.log(data);
                if(data == 1){
                    $('#formNewUser').trigger('reset');
                    $('#modal_add_user').modal('hide');
                    $('#formNewUser :input').removeClass(' is-invalid');
                    $('#formNewUser :input').removeClass(' is-valid');
                    $('#btn_load').hide();
                    $('#btn_new_user').show();
                    $('#alert_msg').show();
                    $('#alert_msg').addClass(' alert-success');
                    $('#text_alert_msg').html('<strong>Excelente!</strong> Usuario a sido agregado correctamente.');
                    $('#alert_msg').show();
                    loadUsers();
                }else{
                    $('#alert_msg').addClass(' alert-danger');
                    $('#alert_msg').show();
                    $('#text_alert_msg').html('<strong>Ops!</strong> Error al agregar el usuario, intentelo más tarde.');
                }
            }
        });
    });
    $('#btn_close_msg').on('click', function(){
        $('#alert_msg').hide('slow');

    });

    //Editra usuario
    $(document).on('click', '#btn_edit_user',function(){
        $('#check_edit_pass').show();
        $('#btn_edit_user_d').show();
        $('#btn_new_user').hide(); 
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('user-us');
        const postData = {
            'id_user': id,
            'action': 'get_user'
        };
        $.ajax({
            data: postData,
            url: '../helpers/usuarios.php',
            type: 'POST',
            success: function(data){
                console.log(data);
                const res = JSON.parse(data);
                $('#inp_id_user').val(res.id_user);
                $('#inp_user_name').val(res.first_name);
                $('#inp_user_lastname').val(res.last_name);
                $('#inp_user_email').val(res.email_user);
                $('#inp_user_phone').val(res.phone_user);
                $('#inp_user_username').val(res.username);
            }
        });
    });

    $(document).on('click', '#btn_delete_user', function(){
        let name = $(this).attr('user-name');
        $('#name_user_delete').text(name);
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('user-us');
        $('#inp_id_user_delete').val(id);

    });

    $(document).on('click', '#delete_user', function(){
        let id = $('#inp_id_user_delete').val();
        const postData = {
            'id': id,
            'action': 'delete_user'
        };
        $.ajax({
            data: postData,
            url: '../helpers/usuarios.php',
            type: 'POST',
            success: function(data){
                if(data == 1){
                    $('#myModaldelete').modal('hide');
                    $('#alert_msg').show();
                    $('#alert_msg').addClass(' alert-success');
                    $('#text_alert_msg').html('<strong>De acuerdo!</strong> Usuario a sido eliminado correctamente.');
                    $('#alert_msg').show();
                    loadUsers();
                }else{
                    $('#myModaldelete').modal('hide');
                    $('#alert_msg').addClass(' alert-danger');
                    $('#alert_msg').show();
                    $('#text_alert_msg').html('<strong>Ops!</strong> Error al eliminar el usuario, intentelo más tarde.');
                }
            }
        });
    });

    $('#btn_edit_user_d').on('click', function(){
        let id = $('#inp_id_user').val();
        value = $('#inp_agency').val();
        const postDatas = {
            'id_agency': value,
            'id_user': id,
            'name_user': $('#inp_user_name').val(),
            'last_name': $('#inp_user_lastname').val(),
            'email_user': $('#inp_user_email').val(),
            'phone_user': $('#inp_user_phone').val(),
            'username': $('#inp_user_username').val(),
            'password': $('#inp_user_password').val(),
            'password_confirm': $('#inp_user_password_confirm').val(),
            'action': 'edit_user'
        };
        if (postDatas.name_user == null || postDatas.name_user.length == 0 || /^\s+$/.test(postDatas.name_user)) {
            $('#inp_user_name').addClass(" is-invalid");
            $('#inp_user_name').focus();
            return false;
        }
        if (postDatas.last_name == null || postDatas.last_name.length == 0 || /^\s+$/.test(postDatas.last_name)) {
            $('#inp_user_lastname').addClass(" is-invalid");
            $('#inp_user_lastname').focus();
            return false;
        }
        if (postDatas.email_user == null || postDatas.email_user.length == 0 || /^\s+$/.test(postDatas.email_user)) {
            $('#inp_user_email').addClass(" is-invalid");
            $('#inp_user_email').focus();
            return false;
        }
        if (postDatas.username == null || postDatas.username.length == 0 || /^\s+$/.test(postDatas.username)) {
            $('#inp_user_username').addClass(" is-invalid");
            $('#inp_user_username').focus();
            return false;
        }
        if($('#inp_user_password').val() != ''){
            if (postDatas.password == null || postDatas.password.length == 0 || /^\s+$/.test(postDatas.password)) {
                $('#inp_user_password').addClass(" is-invalid");
                $('#inp_user_password').focus();
                return false;
            }
            if (postDatas.password_confirm == null || postDatas.password_confirm.length == 0 || /^\s+$/.test(postDatas.password_confirm)) {
                $('#inp_user_password_confirm').addClass(" is-invalid");
                $('#inp_user_password_confirm').focus();
                return false;
            }
            if(postDatas.password != postDatas.password_confirm){
                $('#inp_user_password_confirm').addClass(" is-invalid");
                $('#inp_user_password_confirm').focus();
                return false;
            }
        }
        $.ajax({
            data: postDatas,
            url: '../helpers/usuarios.php',
            type: 'post',
            beforeSend: function(){
                $('#btn_load').show();
                $('#btn_edit_user_d').hide();
            },
            success: function(data){
                console.log(data);
                if(data == 1){
                    $('#formNewUser').trigger('reset');
                    $('#modal_add_user').modal('hide');
                    $('#formNewUser :input').removeClass(' is-invalid');
                    $('#formNewUser :input').removeClass(' is-valid');
                    $('#btn_load').hide();
                    $('#btn_new_user').show();
                    $('#alert_msg').show();
                    $('#alert_msg').addClass(' alert-success');
                    $('#text_alert_msg').html('<strong>Excelente!</strong> Usuario a sido editado correctamente.');
                    $('#alert_msg').show();
                    loadUsers();
                }else{
                    $('#modal_add_user').modal('hide');
                    $('#alert_msg').addClass(' alert-danger');
                    $('#alert_msg').show();
                    $('#text_alert_msg').html('<strong>Ops!</strong> Error al editar el usuario, intentelo más tarde.');
                }
            }
        });
    });


    //Removemos class al cambiar de Paso 3
    $(document).on('keyup', '#formNewUser :input', function(){
      if ($.trim($(this).val()).length) {
          $(this).removeClass(' is-invalid');
          $(this).addClass(' is-valid');
      } else {
          $(this).addClass(' is-invalid');
      }
    });
    $(document).on('keyup', '#inp_user_password_confirm', function(){
        let pass = $('#inp_user_password').val();
        if($(this).val() == pass){
            $(this).removeClass(' is-invalid');
            $(this).addClass(' is-valid');
        }else{
            $(this).addClass(' is-invalid');
            return false;
        }
    });
});