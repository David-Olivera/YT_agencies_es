$(function(){
    loadElectronicPurse();
    loadExchangerate();
    $(document).ready(function(){
        function load(){
            loadExchangerate();
            loadElectronicPurse();
        }
        setInterval(load, 5000);
    });

    function loadElectronicPurse(){
        let id_agency = $('#inp_id_agency').val();
        const postData = {
            'id_agency': id_agency,
            'action': 'get_electronic_purse'
        }
        $.ajax({
            data: postData,
            url: '../helpers/menu.php',
            type: 'POST',
            success: function(res){
                if (res != 0) {

                    $('#value_electronic_purse').html('$'+res);
                    $('#inp_electronic').val(res);
                    $("#check_electronic_purse").prop("disabled", false);
                }else{
                    $('#value_electronic_purse').html('$0.00');
                    $('#inp_electronic').val('0.00');
                    $("#check_electronic_purse").prop("disabled", true);
                }
            }
        });
    }

    $(document).on('click', '#btn_electronic_purse', function(){
        let value_electronic  = $('#inp_electronic').val();
        if (value_electronic != 0) {
            $('#val_electronic_purse').html('<h3 class="text-success"> $ ' + value_electronic + '</h3>');
        }else{
            
            $('#val_electronic_purse').html('<h3> $0.00 </h3>');
        }
    });

    function loadExchangerate(){
        let action = 'get_exchange_rate';
        const postData = {
            'action': action
        };
        $.ajax({
            data: postData,
            url: '../helpers/menu.php',
            type: 'post',
            success: function(data){
                $('#inp_change_type').val(data);
            }
        });
    }
});