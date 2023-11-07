<!-- import jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- js AJAX code -->
<script>
    function  checkUsername(){
        $.ajax({
            url : "process/AJAX_request/signup.php",
            data : "check_username=" + $("#userName").val(),
            method : "POST",
            success : function (data){
                $("#check_username").html(data)
            },
            error : function (){}
        });
    }

    function  checkMail(){
        $.ajax({
            url : "process/AJAX_request/signup.php",
            data : "check_mail=" + $("#email").val(),
            method : "POST",
            success : function (data){
                $("#check_mail").html(data)
            },
            error : function (){}
        });
    }
    let mailStatus = $("#mailStatus").val();
    let nameStatus = $("#nameStatus").val();

    if (mailStatus == "Uavailable" || nameStatus == "Uavailable"){
        $("#submitBtn").prop("disabled", true);
    }
</script>
