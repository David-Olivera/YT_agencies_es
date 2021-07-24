$(document).ready(function(){
	
	var direction = $('#sltraslado option:selected').val();
	$('#sltraslado').on('change', function(){
		direction = $('#sltraslado option:selected').val();
		$('#fieldHomeArrive, #fieldHomeDeparture').removeClass('fieldDatas');

		if(direction == 'RED') {
			$('#fieldHomeArrive, #fieldHomeDeparture').addClass('fieldDatas');
			$('#fieldHomeArrive,#fieldHomeDeparture').show();
		}

		if(direction == 'SEN/AH') {
			$('#fieldHomeDeparture').hide();
			$('#fieldHomeArrive').show();
		}

		if(direction == 'SEN/HA') {
			$('#fieldHomeArrive').hide();
			$('#fieldHomeDeparture').show();
		}
	
	});


	//CLICK.BTN CONTINUE BOOK HOME
	$('#btn-field').click(function(event) {
        event.preventDefault();

        //OBJECT WITH FIELDS BOOK HOME PAGE
        var ctrlHome = {
        	hotel : $('#hotel').val(),
        	paxes : $('#pax option:selected').val(),
        	transfer : $('#sltraslado option:selected').val(),
        	arrival : $('#dateArriv').val(),
        	departure : $('#dateDepart').val()
        };

        //VALIDATIONS OF FIELDS
        if (ctrlHome.hotel == null || ctrlHome.hotel.length == 0 || /^\s+$/.test(ctrlHome.hotel)) {
            alert('Choose a hotel origin or destination is required');
            $('#hotel').focus();
            return false;
        }
      
        if(ctrlHome.transfer == 'RED') {

        	if(ctrlHome.arrival == null || ctrlHome.arrival.length == 0 || /^\s+$/.test(ctrlHome.arrival)) {
        		alert('Select the date your arrival');
        		$('#dateArriv').focus();
        		return false;
        	}

        	if(ctrlHome.departure == null || ctrlHome.departure.length == 0 || /^\s+$/.test(ctrlHome.departure)) {
        		alert('Select the date your departure');
        		$('#dateDepart').focus();
        		return false;
        	}
        }

        if(ctrlHome.transfer == 'SEN/AH' && (ctrlHome.arrival == null || ctrlHome.arrival.length == 0 || /^\s+$/.test(ctrlHome.arrival))) {

        	alert('Select the date your arrival');
        	$('#dateArriv').focus();
        	return false;
        }


        if(ctrlHome.transfer == 'SEN/HA' && (ctrlHome.departure == null || ctrlHome.departure.length == 0 || /^\s+$/.test(ctrlHome.departure))) {

        	alert('Select the date your departure');
        	$('#dateDepart').focus();
        	return false;
        }

        $('#engine-home').submit();
       

    });


     

});