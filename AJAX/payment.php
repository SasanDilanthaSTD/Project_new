<!-- import jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- js AJAX code -->
<script>
    $(document).ready(function () {
        $("#pay").click(function () {
            $.ajax({
                url: "process/AJAX_request/payment.php",
                data: {
                    pay: "",
                    payment_id: "<?=$pay_id ?>",
                    description: "<?=$description ?>",
                    user_id: "<?=$c_id ?>",
                    contact_therapist_id: "<?=$c_id ?>",
                    treat_therapist_id: "<?=$d_id ?>"
                },
                method: 'POST',
                success: function (data) {
                    console.log(data);
                    let obj = $.parseJSON(data);
                    // Payment completed. It can be a successful failure.
                    payhere.onCompleted = function onCompleted(orderId) {
                        console.log("Payment completed. OrderID:" + orderId);
                        // Note: validate the payment and show success or failure page to the customer
                    };

                    // Payment window closed
                    payhere.onDismissed = function onDismissed() {
                        // Note: Prompt user to pay again or show an error page
                        console.log("Payment dismissed");
                    };

                    // Error occurred
                    payhere.onError = function onError(error) {
                        // Note: show an error page
                        console.log("Error:" + error);
                    };

                    // Put the payment variables here
                    var payment = {
                        "sandbox": true,
                        "merchant_id": "1224607",
                        "return_url": "http://localhost/Project_new/payment.php",     // Important
                        "cancel_url": "http://localhost/Project_new/payment.php",     // Important
                        "notify_url": "http://localhost/Project_new/userprofile.php",
                        "order_id": obj['order_id'],
                        "items": obj['item'],
                        "amount": obj['amount'],
                        "currency": "LKR",
                        "hash": obj['hash'], // *Replace with generated hash retrieved from backend
                        "first_name": "<?=$patient->firstname ?>",
                        "last_name": "<?=$patient->lastname ?>",
                        "email": "<?=$patient->email ?>",
                        "phone": "",
                        "address": "",
                        "city": "",
                        "country": "Sri Lanka",
                        "delivery_address": "",
                        "delivery_city": "",
                        "delivery_country": "Sri Lanka",
                        "custom_1": "",
                        "custom_2": ""
                    };

                    payhere.startPayment(payment);
                },
                error: function () {
                }
            });
        });
    });

    function asd() {
        $.ajax({});
    }
</script>