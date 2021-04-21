<?php 
require_once '../config/conexion.php';
session_start();?>
    <?php include('include/estilos_agencies.php')?>
<?php  include('include/navigation_agencies.php'); ?>   


<!--PAYMENT PROCCESS-->
<?php 
require_once('../model/fPaypal.php');

if(isset($_GET['token']) && isset($_GET['invoice'])) { 

	$access_token = $_GET['token'];
	$paypalMode = 'live'; //sandbox - live
	$payerId = $_GET['payerId'];
	$paymentID = $_GET['paymentID'];

	if ($paypalMode=="sandbox") {
    	$host = 'https://api.sandbox.paypal.com';
	}
	if ($paypalMode=="live") {
   		$host = 'https://api.paypal.com';
	}

	#GET ACCESS TOKEN
	$url = $host.'/v1/payments/payment/'.$paymentID.'/execute/'; 
	$execute = '{"payer_id" : "'.$payerId.'"}';
	$payment = make_post_call($url, $execute);
	
	$logpayment = stripslashes(json_format($payment)); //String use
	//print_r($payment['transactions'][0]['related_resources']);

	//0 -> invoice
	//1 -> transactionid
	//2 -> amount
	//3 -> comission
	//4 -> currency
	//5 -> status
	//6 -> emailbuyer
	//7 -> paymentdate
	$paymentDetails = array($payment['transactions'][0]['custom'], 
							$payment['transactions'][0]['related_resources'][0]['sale']['id'],
							$payment['transactions'][0]['related_resources'][0]['sale']['amount']['total'],
							$payment['transactions'][0]['related_resources'][0]['sale']['transaction_fee']['value'],
							$payment['transactions'][0]['related_resources'][0]['sale']['amount']['currency'],
							$payment['transactions'][0]['related_resources'][0]['sale']['state'], 
							date('Y-m-d H:i:s'),
							$_GET['emailbuyer']);

	require_once('../models/traslados.php');
	$booking = new Transfer();

	$setStatus = $booking->changeStateSale($paymentDetails[0], strtoupper($paymentDetails[5]));


	$messageExecute = array('title' => 'Lo sentimos!',
							'message' => 'Ocurrio un problema al procesar su información de pago, contacte a su entidad bancaria o intente nuevamente más tarde.',
							'link' => '/agencias/app/',
							'class' => 'errorPayment',
							'icon' => 'fa-times-circle');
	

	//Message for Pendings transactions
	if($payment['transactions'][0]['related_resources'][0]['sale']['state'] == 'pending') {
			
		$messageExecute['title'] = 'Gracias por elegir Yamevi Travel';
		$messageExecute['message'] = 'Su pago se encuentra en proceso, tan pronto como sea completado deberá recibir la información para tomar su servicio.';
		$messageExecute['link'] = '/';
	}

	//Message and letter for Completed Transactions
	if($payment['transactions'][0]['related_resources'][0]['sale']['state'] == 'completed') {          
	    
	    $sale = json_decode($booking->callToLetter($paymentDetails[0], $_GET['letterlang']));
	    //print_r($sale);

		//Redirect page
		header('Location:/es/secciones/reservations.php');
	}

	header('Refresh:2; url='.$messageExecute['link'].'');


} else { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>YameviTravel - Pago Tarjeta</title>
        <?php include('include/estilos_agencies.php')?>
    </head>
<section class="container payments">

	<aside class="columns seven boxPaymentForm">

		<?php 
			$amount = floatval($_REQUEST['_AMOUNT_TOTAL']);
			
			$itemName = 'Yamevi Travel Transportation Services - '.$_REQUEST['_ORIGIN_HOTEL'];
			$itemDescription = 'Cancun Transportation Service by Yamevi Travel';
			$itemSku = 'PP_'.$_REQUEST['_INVOICE'];
			$itemPrice = $amount;
			$itemQuantity = 1;
			$payerEmail = $_REQUEST['_CLIENT_EMAIL'];
			$payerPhone = $_REQUEST['_CLIENT_PHONE'];
			$letterlang = $_REQUEST['_LETTER_LANGUAGE'];

			$name_client = trim($_REQUEST['_NAME_CLIENT'], ' ');
            $last_name = trim($_REQUEST['_LAST_NAME'], ' ');

			$payerFirstName = $name_client;
			$payerLastName = $last_name;
			$custom = $_REQUEST['_INVOICE'];
			
			$languageSite = 'en';
			$ppplusJsLibraryLang = 'en';
			$currency = $_REQUEST['_TYPE_CURRENCY'];
			$iframeHeight = NULL;
			$merchantInstallmentSelection = NULL;
			$merchantInstallmentSelectionOptional = false;
			
			$disallowRememberedCards = true; //TRUE OR FALSE
			$rememberedCards = NULL;
			$paypalMode = 'live'; //sandbox - live

			//API KEYS
			//Live
			$clientId = 'AfsFswX4jdDHCZrHls-Ug_fCI6XvVEAGbmdbjpc-hSlqYXMJCzmCS4Z7igr5MHTw9qgaeL1o8-oTZeMw';
			$secret = 'EEvewPFCdc1Rx00NF_y9OeYrpfK_457orwVZjLjWCg5rKSiL7kLTRKqKQ4YAcSj-ocZyEP6OCtzV2ilV';
			//$experience_profile_id = 'XP-2UWL-YYMH-6TEW-4WFD';
			$returnUrl = 'http://www.yamevitravel.com/agencias/reservacion-completada';
			$cancelUrl = 'http://www.yamevitravel.com/agencias/';

			//Sandbox
			//$clientId = 'AU9GCM5swF8clNxIuhqv-UdEaRqFrvMOKuxWcImmHSTwXB165uYLsWEdWvQygl3qKEERGB_C2F064MGi';
			//$secret = 'ELVW9Fba1kIEBVVMnI5bDuXPt7VT0CkojbSm6z2-zdVQkCJs3Iz7KouESZ5BNLh0cxDsxEbEeri_tfFC';
			//$experience_profile_id = 'XP-X6G8-HAYU-ZG5K-TXTX';
			//$returnUrl = 'http://www.yamevitravel.com/agencias/reservacion-completada';
			//$cancelUrl = 'http://www.yamevitravel.com/agencias/';


			if ($paypalMode=="sandbox") {
			    $host = 'https://api.sandbox.paypal.com';
			}
			if ($paypalMode=="live") {
			    $host = 'https://api.paypal.com';
			}


			#GET ACCESS TOKEN
			$url = $host.'/v1/oauth2/token'; 
			$postArgs = 'grant_type=client_credentials';
			$access_token= get_access_token($url, $postArgs);
			

			#CREATE PAYMENT
			$url = $host.'/v1/payments/payment';
			$payment = '{
			  "intent": "sale",
			  "application_context": {
			  	"shipping_preference": "NO_SHIPPING"
			  },
			  "payer": {
			    "payment_method": "paypal"
			  },
			  "transactions": [
			    {
			      "amount": {
			        "currency": "'.$currency.'",
			        "total": "'.$amount.'",
			        "details": {}
			      },
			      "description": "'.$itemDescription.'",
			      "custom": "'.$custom.'",
			      "payment_options": {
			        "allowed_payment_method": "IMMEDIATE_PAY"
			      },
			      "item_list": {
			        "items": [
			          {
			            "name": "'.$itemName.'",
			            "description": "'.$itemDescription.'",
			            "quantity": "'.$itemQuantity.'",
			            "price": "'.$itemPrice.'",
			            "sku": "'.$itemSku.'",
			            "currency": "'.$currency.'"
			          }
			        ]			        
			      }
			    }
			  ],
			  "redirect_urls": {
			    "return_url": "'.$returnUrl.'",
			    "cancel_url": "'.$cancelUrl.'"
			  }
			}
			';

			//var_dump ($json);
			//die($payment);
			$payment = make_post_call($url, $payment);

			#Get the approval URL for later use
			$approval_url = $payment['links']['1']['href'];

			#Get the token out of the approval URL
			$token = substr($approval_url,-20);

			#Get the PaymentID for later use
			$paymentID = ($payment['id']);

			#Put JSON in a nice readable format
			$payment = stripslashes(json_format($payment));
		?>


		<div id="pppDiv"> <!-- the div which id the merchant reaches into the clientlib configuration -->
            <script type="text/javascript">
                document.write("iframe is loading...");
            </script>
            <noscript> <!-- in case the shop works without javascript and the user has really disabled it and gets to the merchant's checkout page -->
                <iframe src="https://www.paypalobjects.com/webstatic/ppplusbr/ppplusbr.min.js/public/pages/pt_BR/nojserror.html" style="border: none;"></iframe>
            </noscript>
        </div>

        <button type="submit" id="continueButton" class="btn btn-lg btn-primary btn-block infamous-continue-button" onclick="ppp.doContinue(); return false;">PAGAR AHORA</button>

        <div class="totalInIframe">
			<span>TOTAL A PAGAR</span> 
			<strong class="detailTotal">$<?php echo number_format($amount, 2); ?> <small><?php echo $_REQUEST['_TYPE_CURRENCY']; ?></small></strong>
		</div>
		
		<a id="payNowButton" style="display: none;" class="btn btn-lg btn-primary btn-block infamous-continue-button hidden" href="?action=commit">Pay now</a>


		<!---->
		<form method="post" class="horizontal-form" action="?action=inline" id="checkout-form" onSubmit="return false;" data-checkout="inline"></form>
		
	</aside>
	<div class="clr"></div>

</section>


	<script type="text/javascript" src="<?php echo $path.'js/jquery-1.8.3.min.js'; ?>"></script>
	<script src="https://www.paypalobjects.com/webstatic/ppplusdcc/ppplusdcc.min.js?123456"></script>
	<script>

	    var ppp = PAYPAL.apps.PPP({

	        approvalUrl: "<?php echo $approval_url;?>",

	        buttonLocation: "outside",
	        preselection: "none",
	        surcharging: false,
	        hideAmount: false,
	        placeholder: "pppDiv",

	        disableContinue: "continueButton",
	        enableContinue: "continueButton",

	        // merchant integration note:
	        // this is executed when the iframe posts the "checkout" action to the library
	        // the merchant can do an ajax call to his shop backend to save the remembered cards token
	        onContinue: function (rememberedCards, payerId, token, term) {

	            // TODO: remove payNowButton
	            var access_token = "<?php echo $access_token; ?>";
	            var paymentID = "<?php echo $paymentID; ?>";
	            var paypalMode = "<?php echo $paypalMode; ?>";
	            var payURL = "checkout?token=" + access_token + "&payerId=" + payerId + "&paymentID=" + paymentID + "&invoice=<?php echo $custom; ?>&emailbuyer=<?php echo $payerEmail; ?>&language=<?php echo $languageSite; ?>&letterlang=<?php echo $letterlang; ?>";
	            $('#payNowButton').prop('href', payURL);

	            $('#continueButton').attr('disabled','disabled');
				
				console.log('Mete un loader gif');	            
	            setTimeout(function(){ window.location.href = payURL; }, 100);
	            
	        },

	        onError: function (err) {
	            var msg = jQuery("#responseOnError").html()  + "<BR />" + JSON.stringify(err);
	            jQuery("#responseOnError").html(msg);
	        },

	        language: "<?php echo $ppplusJsLibraryLang; ?>",
	        disallowRememberedCards: "<?php echo $disallowRememberedCards; ?>",
	        rememberedCards: "<?php echo $rememberedCards; ?>",
	        mode: "<?php echo $paypalMode; ?>",
	        useraction: "continue",
	        payerEmail: "<?php echo $payerEmail; ?>",
	        payerPhone: "<?php echo $payerPhone; ?>",
	        payerFirstName: "<?php echo $payerFirstName; ?>",
	        payerLastName: "<?php echo $payerLastName; ?>",
	        payerTaxId: "",
	        payerTaxIdType: "",
	        merchantInstallmentSelection: "<?php echo $merchantInstallmentSelection; ?>",
	        merchantInstallmentSelectionOptional:"<?php echo $merchantInstallmentSelectionOptional; ?>",
	        hideMxDebitCards: false,
	        iframeHeight: "",
	        collectBillingAddress: true
	    });

	    var _width = $(window).width();
	    console.log(_width);

	    setTimeout(function() {

	    	var _height = '700px';
	    	if(parseInt(_width) < 960) {
	    		_height = '800px';
	    	}

	    	$('#pppDiv').attr('style', 'height: '+_height+' !important;');
	    	$('#pppDiv iframe').attr('style', 'height: '+ _height +'; width: 100%; border:0px;');

	    }, 2000);

	</script>

<?php } ?>
</body>
    <?php include('include/footer_agencies.php')?>
    <?php include('include/scrips_agencies.php')?>
</html>
<?php ob_end_flush(); ?>