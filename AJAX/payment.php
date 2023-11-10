<!-- import jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- js AJAX code -->
<script>
    function paymentGateway() {
        $.ajax({
            uri: "process/AJAX_request/payment.php",
            data: {pay : "", payment_id:"<?=$pay_id ?>",description : "<?=$description ?>" , user_id : "<?=$c_id ?>", contact_therapist_id : "<?=$c_id ?>", treat_therapist_id : "<?=$d_id ?>"},
            method: 'POST',
            success: function (data) {
                alert(data);
            },
            error: function () {
                console.log("Payment gateway AJAX fail !!");
            }
        });
    }
</script>