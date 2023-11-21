<!-- import jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- js AJAX code -->
<script>
    $(document).ready(function () {
        $.ajax({
            url : "process/AJAX_request/admin.php",
            data : {therapist_count : "",video_count : "", patient_count: ""},
            method: "POST",
            success : function (data){
                console.log(data);
                let obj = $.parseJSON(data);
                $("#countT").text(obj['doctor']['count_t']);
                $("#countD").text(obj['doctor']['count_d']);
                $("#countC").text(obj['doctor']['count_c']);
                $("#pat_T").text(obj['patient_count']['total_patient']);
                $("#pat_Tm").text(obj['patient_count']['total_patient_m']);

                $("#videoCount").text(obj['video_count']['count']);
                $("#newVideo").text(obj['video_count']['new_video_count']);
            },
            error : function (xhr, status, error){
                console.log("Error:", xhr.status, xhr.statusText);
                console.log("Error message:", xhr.responseText);
            }
        });
    });

    setInterval(function() {
        $.ajax({
            url: 'process/AJAX_request/admin.php',
            dataType: 'json',
            data : {page_view:""},
            method: "POST",
            success: function(viewData) {
                //let page =  JSON.parse(viewData);
                console.log(viewData.page.count)
                $('#visitCount').text(viewData.page.count);
                $('#visitCountMonth').text(viewData.page_m.count_m);
            },
            error : function (xhr, status, error){
                console.log("Error:", xhr.status, xhr.statusText);
                console.log("Error message:", xhr.responseText);
            }
        });
    }, 500);
</script>z