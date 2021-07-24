$(document).ready(function(){
	
	console.log('DOM Listo para trabajar');
	//NEWSLETTER - FOOTER
	$('#btn-newsletter').on('click', function(event){
		event.preventDefault();

		var newsletter = $('#int-newsletter').val();
		if (!(/\w+([-+.']\w+)*@\w+([-.]\w+)/.test(newsletter))) {
			$('#int-newsletter').addClass('required');
			$('#int-newsletter').focus();
		} else {
			
			$.ajax({
				data:  { "news" : newsletter },
				url:   'helpers/hMail.php',
				type:  'post',
												
				beforeSend: function(){	},

				success:  function (data) {
					var response = $.parseJSON(data);
					alert(response.message);

					$('#int-newsletter').val('');
				}
			});

		}

	});


	$('#contactNotification').hide();
	//CONTACTO - CONTACT US
	$('#btnReserve').on('click', function(event){
		event.preventDefault();

		var fullname = $('#in-name').val();
		var phone = $('#in-phone').val();
		var email = $('#in-mail').val();
		var message = $('#in-comment').val();

		if (fullname == null || fullname.length == 0 || /^\s+$/.test(fullname)) {
			$('#in-name').addClass('requiredV2');
			$('#in-name').focus();
		} else {
			if (!(/\w+([-+.']\w+)*@\w+([-.]\w+)/.test(email))) {
				$('#in-mail').addClass('requiredV2');
				$('#in-mail').focus();
			} else {
				if (message == null || message.length == 0 || /^\s+$/.test(message)) {
					$('#in-comment').addClass('requiredV2');
					$('#in-comment').focus();
				} else {

					var send = { "name" : fullname, "mail" : email, "phone" : phone, "message" : message };					

					$.ajax({
						data:  send,
						url:   'helpers/hMail.php',
						type:  'post',
														
						beforeSend: function(){	},

						success:  function (data) {
							var response = $.parseJSON(data);
							if(response.state = "SEND") {
								$('#contactNotification').text(response.message);
								$('#contactNotification').fadeIn('last');
							}

							$('#in-name, #in-phone, #in-mail, #in-comment').val('');							
						}
					});

				}
			}
		}


	});
	
	//GROUPS - GROUPS
	$('#groupNotification').hide();
	$('#btnGroups').on('click', function(event){
		event.preventDefault();
		
		var name = $('#in-name').val();
		var email = $('#in-mail').val();
		var phone = $('#in-phone').val();
		var company = $('#in-company').val();
		var people = $('#in-peoples').val();
		var information = $('#in-information').val();
		
		if (name == null || name.length == 0 || /^\s+$/.test(name)) {
			$('#in-name').addClass('requiredV2');
			$('#in-name').focus();
		} else {
			if (!(/\w+([-+.']\w+)*@\w+([-.]\w+)/.test(email))) {
				$('#in-mail').addClass('requiredV2');
				$('#in-mail').focus();
			} else {
				if (phone == null || phone.length == 0 || /^\s+$/.test(phone)) {
					$('#in-phone').addClass('requiredV2');
					$('#in-phone').focus();
				} else {
					if (company == null || company.length == 0 || /^\s+$/.test(company)) {
						$('#in-company').addClass('requiredV2');
						$('#in-company').focus();
					} else {
						if (people == null || people.length == 0 || /^\s+$/.test(people)) {
							$('#in-peoples').addClass('requiredV2');
							$('#in-peoples').focus();
						} else {
							if (information == null || information.length == 0 || /^\s+$/.test(information)) {
								$('#in-information').addClass('requiredV2');
								$('#in-information').focus();
							} else {
								
								var group = $('#frm-groups').serialize();
								$.ajax({
									data:  { "serialize" : group },
									url:   'helpers/hMail.php',
									type:  'post',

									beforeSend: function(){	},

									success:  function (data) {
										var response = $.parseJSON(data);
										if(response.state == "SEND") {
											$('#groupNotification').text(response.message);
											$('#groupNotification').fadeIn('last');
											
											$('#in-name, #in-phone, #in-mail, #in-company, #in-peoples, #in-information').val('');
										}
																	
									}
								});
								
							}
						}
					}
				}
			}
		}
		
	});
	
	
	//TOURS - PAGE TOUR
	$('#tourNotification').hide();
	$('#btnTour').on('click', function(event){
		event.preventDefault();
		
		var name = $('#client').val();
		var email = $('#client-email').val();
		var pickup = $('#client-pickup').val();
		var tourdate = $('#tour-date').val();
		var people = $('#tour-peoples').val();
		var request = $('#tour-request').val();
		
		if (name == null || name.length == 0 || /^\s+$/.test(name)) {
			$('#client').addClass('requiredV2');
			$('#client').focus();
		} else{
			if (!(/\w+([-+.']\w+)*@\w+([-.]\w+)/.test(email))) {
				$('#client-email').addClass('requiredV2');
				$('#client-email').focus();
			} else {
				if (pickup == null || pickup.length == 0 || /^\s+$/.test(pickup)) {
					$('#client-pickup').addClass('requiredV2');
					$('#client-pickup').focus();
				} else {
					if (tourdate == null || tourdate.length == 0 || /^\s+$/.test(tourdate)) {
						$('#tour-date').addClass('requiredV2');
						$('#tour-date').focus();
					} else {
						if (request == null || request.length == 0 || /^\s+$/.test(request)) {
							$('#tour-request').addClass('requiredV2');
							$('#tour-request').focus();
						} else {
							
							var tour = $('#booktour').serialize();
							$.ajax({
								data:  { "serietour" : tour },
								url:   'helpers/hMail.php',
								type:  'post',

								beforeSend: function(){	},

								success:  function (data) {
									var response = $.parseJSON(data);
									if(response.state = "SEND") {
										$('#tourNotification').text(response.message);
										$('#tourNotification').fadeIn('last');
											
										$('#client, #client-email, #client-pickup, #tour-date, #tour-peoples, #tour-request').val('');
									}
																	
								}
							});
							
						}
					}
				}
			}
		}
		
	});

	//REMOVE CLASS REQUIRED FORMS
	$('form input, form textarea').on('keyup', function(){
		if($(this).hasClass('required')) { $(this).removeClass('required'); }
		if($(this).hasClass('requiredV2')) { $(this).removeClass('requiredV2'); }
	});

	///////////////////
	///LANDING CAMPAIGN
	///////////////////
	$('.overlay-widget-campaign, .features-in-overlay ul').hide();

	$('.button-reserve-campaign').on('click', function(event){
		event.preventDefault();

		$('.overlay-widget-campaign').fadeIn('last');

		if($(window).width() > 767) {
			var feature = $(this).data('features') + '-features';
			$('#'+feature).fadeIn('last');
		}

		$('#service-campaign').val($(this).data('features'));

	});

});