$(function(){
    $('#alert_msg_account').hide();
    loadDetailAccount();
    // Btn cancelar
    $('#cancelButtonModal').on("click", function(e){
        e.preventDefault();
        $('#exampleModal').modal('hide');
    });
    
    function loadDetailAccount(){
        $('#alert_msg').hide();
        let id = $('#inp_agency').val();
        const postDatas = {
            'id': id,
            'get_data_account': true
        }
        $.ajax({
           data: postDatas,
           url: '../helpers/cuenta.php',
           type: "POST",
           success: function(data){
                console.log(data);
                const res = JSON.parse(data);
                $('#id_agencie_img').val(res.id_agency)
                $('#inp_name_agencie').val(res.name_agency);
                $('#name_agenci_img').val(res.name_agency);
                $('#inp_name_contac').val(res.name_contact);
                $('#inp_lastname_contac').val(res.last_name_contact);
                $('#inp_email_contact').val(res.email_agency);
                $('#inp_email_pay').val(res.email_pay_agency);
                $('#inp_phone_agencie').val(res.phone_agency);
                $('#inp_name_user').val(res.username);
                if(res.icon_agency == 'not_found.png' || res.icon_agency == '' ){
                    $('.elimined').hide();
                    let img = new Image();
                    img.src = "../assets/img/agencias/not_found.png";
                    $('#img_agency').attr('src',img.src);
                }else{
                    let img = new Image();
                    img.src = "../assets/img/agencias/"+res.icon_agency;
                    $('.elimined').show();
                    $('#name_img').val(res.icon_agency);
                    $('#img_ame').attr('src',img.src);
                    $('#img_agency').attr('src',img.src);

                }                

           } 
        });
    }

    // Abrir modal de agregar img
    $(document).on('click', '#add_img', function(){
        loadIdImg();
    });
    function loadIdImg(){
        let amenity = $('#name_agenci_img').val();
        let newagencie = amenity.replace(/ /g, "");
        let key = generateUUID();
        $('#name_age_img').val(key  + '_' +newagencie+'.png');
    }
    // Actualizar imagen
    $('#agencieFormModal').on('submit', (function(e){
        e.preventDefault();
        var formData = new FormData(this);
        let name_age_img = $('#name_age_img').val();
        formData.append("name_age_img", name_age_img);
        $.ajax({
            url:"../model/agencie_img.php",
            type:"POST",
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            success: function(data)
            {
                console.log(data);
                if(data == 1){
                    $('#alert_msg').show();
                    loadDetailAccount();
                    loadIdImg();
                    $('#file_agency').val('');
                    $('#alert_msg').addClass(' alert-success');
                    $('#text_alert_msg').html('<strong>Excelente!</strong> La imagen de la agencia a sido actualizada.');
                    $('#alert_msg').show();
                }else{
                    $('#alert_msg').addClass(' alert-danger');
                    $('#alert_msg').show();
                    $('#text_alert_msg').html('<strong>Ops!</strong> Error al actualizar la imagen.');

                }
            }
        });
    }));

    // Actualizar data account
    $('#agencyDataForm').on('submit', function(e){
        e.preventDefault();
        const postDatas = {
            id: $('#inp_agency').val(),
            name_agency: $('#inp_name_agencie').val(),
            name_contect: $('#inp_name_contac').val(),
            last_name: $('#inp_lastname_contac').val(),
            email_contact: $('#inp_email_contact').val(),
            email_pay: $('#inp_email_pay').val(),
            phone_agency: $('#inp_phone_agencie').val(),
            action: 'update_data'
        };
        if (postDatas.name_agency == null || postDatas.name_agency.length == 0 || /^\s+$/.test(postDatas.name_agency) || /'/.test(postDatas.name_agency)) {
            $('#inp_name_agencie').addClass(" is-invalid");
            $('#inp_name_agencie').focus();
            return false;
        }
        if (postDatas.name_contect == null || postDatas.name_contect.length == 0 || /^\s+$/.test(postDatas.name_contect)  || /'/.test(postDatas.name_contect)) {
            $('#inp_name_contac').addClass(" is-invalid");
            $('#inp_name_contac').focus();
            return false;
        }
        if (postDatas.last_name == null || postDatas.last_name.length == 0 || /^\s+$/.test(postDatas.last_name)  || /'/.test(postDatas.last_name)) {
            $('#inp_lastname_contac').addClass(" is-invalid");
            $('#inp_lastname_contac').focus();
            return false;
        }
        $.post('../helpers/cuenta.php', postDatas, function(res){
            console.log(res);
            if(res == 1){
                $('#alert_msg_account').show('slow');
                loadDetailAccount();
                loadIdImg();
                $('#alert_msg_account').addClass(' alert-success');
                $('#text_alert_msg_account').html('<strong>Excelente!</strong> La datos han sido actualizados correctamente.');
            }else{
                $('#alert_msg_account').addClass(' alert-danger');
                $('#alert_msg_account').show('slow');
                $('#text_alert_msg_account').html('<strong>Ops!</strong> Error al intentar editar la información, intentelo más tarde.');

            }
        });
    });

    // Actualizar credentials
    $('#agencyCredentialsForm').on('submit', function(e){
        e.preventDefault();
        let checked = 0;
        var seleccion = $("#checked_pass_agency")[0].checked;

        const postDatas = {
            id: $('#inp_agency').val(),
            username: $('#inp_name_user').val(),
            password: $('#inp_password_agencie').val(),
            status: checked,
            action: 'update_credentials'
        };
        if ($('#inp_name_user').val() == null || $('#inp_name_user').val().length == 0 || /^\s+$/.test($('#inp_name_user').val())) {
            $('#inp_name_user').addClass(" is-invalid");
            $('#inp_name_user').focus();
            return false;
        }
        if(seleccion){
            checked = 1;
            if ((postDatas.password == null || postDatas.password.length == 0 || postDatas.password.length < 6 || /^\s+$/.test(postDatas.password))) {
                $('#inp_password_agencie').addClass(" is-invalid");
                $('#inp_password_agencie').focus();
                return false;
            }
        }
        $.post('../helpers/cuenta.php', postDatas, function(res){
            console.log(res);
            if(res == 1){
                $('#alert_msg_account').show('slow');
                loadDetailAccount();
                loadIdImg();
                $('#alert_msg_account').addClass(' alert-success');
                $('#text_alert_msg_account').html('<strong>Excelente!</strong> Las credenciales han sido actualizados correctamente.');
            }else{
                $('#alert_msg_account').addClass(' alert-danger');
                $('#alert_msg_account').show('slow');
                $('#text_alert_msg_account').html('<strong>Ops!</strong> Error al intentar editar las credenciales, intentelo más tarde.');

            }
        });
    });
    
    // Delete agency img
    $(document).on('click', '#deleteImg', function() {
        if (confirm('¿Esta seguro de querer eliminar la img de la agencia?')) {
         let id = $('#inp_agency').val();
         let delet = 'delete_img';
         console.log(id);
         const postData = {
             'id': id,
             'delete': delet,
         }
         $.post('../helpers/cuenta.php', postData, function(response){
            if(response == 1){
                $('#alert_msg').show('slow');
                loadDetailAccount();
                loadIdImg();
                $('#alert_msg').addClass(' alert-success');
                $('#text_alert_msg').html('<strong>De acuerdo!</strong> La imagen a sido eliminada.');
            }else{
                $('#alert_msg').addClass(' alert-danger');
                $('#alert_msg').show('slow');
                $('#text_alert_msg').html('<strong>Ops!</strong> Error al eliminar la imagen.');

            }
         });
            
        }
     });   

    $('#inp_password_agencie').keyup(function(){
        if($('#inp_password_agencie').val()){
            if ($('#inp_password_agencie').val().length > 6) {
                $(this).removeClass(' is-invalid');
                $("#checked_pass_agency").prop('checked', true);      
            }else{            
                $(this).addClass(' is-invalid');
            }
        }else{

            $("#checked_pass_agency").prop('checked', false);
        }
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
    //Removemos class al cambiar de Paso 2
    $(document).on('change', '#agencyDataForm :input', function(){
        if ($.trim($(this).val()).length) {
            $(this).removeClass(' is-invalid');
        } else {
            $(this).addClass(' is-invalid');
        }
    });
    //Removemos class al cambiar de Paso 2
    $(document).on('change', '#agencyCredentialsForm :input', function(){
        if ($.trim($(this).val()).length) {
            $(this).removeClass(' is-invalid');
        } else {
            $(this).addClass(' is-invalid');
        }
    });
});