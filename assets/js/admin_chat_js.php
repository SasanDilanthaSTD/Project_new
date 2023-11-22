
<script>
    // JavaScript code for the Line Chart
    // Get the canvas element
    const ctx = document.getElementById('myChart').getContext('2d');
    //create gradiant
    const gradiatFill_1 = ctx.createLinearGradient(0,0,0,290);
    const gradiatFill_2 = ctx.createLinearGradient(0,0,0,800);
    gradiatFill_1.addColorStop(0,'hsla(218,71%,35%,1)');
    gradiatFill_1.addColorStop(1,'hsla(218,71%,35%,0.2)');
    gradiatFill_2.addColorStop(1,'hsla(180,48%,52%,0.2)');
    gradiatFill_2.addColorStop(1,'hsla(180,48%,52%, 1)');

    // +++++++++ Step of create chart +++++++++++++
    //** Setup Blok - set data variable
    const data = {
        <?php
        if ($chart == "month" ){?>
        labels: ['Jan', 'Feb', 'March', 'Apr', 'May', 'Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [
            {
                label: 'Mothly Visit',
                borderColor: 'rgba(75, 192, 192, 0.7)',
                backgroundColor: gradiatFill_2,
                data: [<?=$viw_data[0]?>,<?=$viw_data[1]?>,<?=$viw_data[2]?>,<?=$viw_data[3]?>,<?=$viw_data[4]?>,<?=$viw_data[5]?>,<?=$viw_data[6]?>,<?=$viw_data[7]?>,<?=$viw_data[8]?>,<?=$viw_data[9]?>,<?=$viw_data[10]?>,<?=$viw_data[11]?>],
                tension: 0.3,
                fill:true
            }
        ],
        <?php }else {?>
        labels: ['<?=$viw_data_m[0]['day']?>', '<?=$viw_data_m[1]['day']?>', '<?=$viw_data_m[2]['day']?>', '<?=$viw_data_m[3]['day']?>', '<?=$viw_data_m[4]['day']?>'],
        datasets: [
            {
                label: 'Nearest 5 days',
                borderColor: 'rgba(26,72,153,0.7)',
                backgroundColor: gradiatFill_1,
                data: [<?=$viw_data_m[0]['count']?>, <?=$viw_data_m[1]['count']?>, <?=$viw_data_m[2]['count']?>, <?=$viw_data_m[3]['count']?>, <?=$viw_data_m[4]['count']?>],
                tension: 0.3,
                fill: true
            }
        ],
        <?php }?>
    };

    //** Render Bock
    const myChart = new Chart(ctx,{
        type: 'line',
        data: data,
        options: {
            maintainAspectRatio: false,
            legend:{
                display: false,
            },
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Month',
                        color: 'rgb(0,196,255)',
                    },
                    ticks:{
                        color:'rgb(0,196,255)',
                    },
                    grid: {
                        color: 'rgba(255,255,255,0.43)', // Change this color to your desired grid color for the x-axis
                    },
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Value',
                        color: 'rgb(0,196,255)',
                    },
                    ticks:{
                        color:'rgb(0,196,255)',
                    },
                    grid: {
                        color: 'rgba(255,255,255,0.43)', // Change this color to your desired grid color for the x-axis
                    },
                },
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Custom Bar Chart', // Custom option: Set the chart title
                    font: {
                        size: 24 ,// Custom option: Set the font size for the chart title
                        color: 'rgba(255,255,255,0.9)'
                    }
                },
            }
        },
    });
    // JavaScript code for the Bar Chart
    // Get the canvas element
    const ctx_2 = document.getElementById('barChart').getContext('2d');
    //create gradiant
    const B_gradiatFill_1 = ctx_2.createLinearGradient(0,0,0,290);
    const B_gradiatFill_2 = ctx_2.createLinearGradient(0,0,0,800);
    B_gradiatFill_1.addColorStop(0,'hsla(218,71%,35%,1)');
    B_gradiatFill_1.addColorStop(1,'hsla(218,71%,35%,0.2)');
    B_gradiatFill_2.addColorStop(1,'hsla(180,48%,52%,0.2)');
    B_gradiatFill_2.addColorStop(1,'hsla(180,48%,52%, 1)');

    // +++++++++ Step of create chart +++++++++++++
    //** Setup Blok - set data variable
    const B_data = {
        labels: ['Jan', 'Feb', 'March', 'Apr', 'May', 'Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [
            {
                label: 'Doctors',
                borderColor: 'rgba(75, 192, 192, 0.7)',
                backgroundColor: gradiatFill_2,
                data: [<?=$doc_data[0]?>, <?=$doc_data[1]?>, <?=$doc_data[2]?>, <?=$doc_data[3]?>, <?=$doc_data[4]?>, <?=$doc_data[5]?>,<?=$doc_data[6]?>,<?=$doc_data[7]?>,<?=$doc_data[8]?>,<?=$doc_data[9]?>,<?=$doc_data[10]?>,<?=$doc_data[11]?>],
                tension: 0.3,
                fill:true
            },
            // Add more datasets if needed
            {
                label: 'Couselor',
                borderColor: 'rgba(26,72,153,0.7)',
                backgroundColor: gradiatFill_1,
                data: [<?=$cou_data[0]?>,<?=$cou_data[1]?>,<?=$cou_data[2]?>,<?=$cou_data[3]?>,<?=$cou_data[4]?>,<?=$cou_data[5]?>,<?=$cou_data[6]?>,<?=$cou_data[7]?>,<?=$cou_data[8]?>,<?=$cou_data[9]?>,<?=$cou_data[10]?>,<?=$cou_data[11]?>],
                tension: 0.3,
                fill: true
            },
        ],
    };

    //** Render Bock
    const barChart = new Chart(ctx_2,{
        type: 'bar',
        data: B_data,
        options: {
            maintainAspectRatio: false,
            legend:{
                display: false,
            },
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Month',
                        color: 'rgb(0,196,255)',
                    },
                    ticks:{
                        color:'rgb(0,196,255)',
                    },
                    grid: {
                        color: 'rgba(255,255,255,0.43)', // Change this color to your desired grid color for the x-axis
                    },
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Value',
                        color: 'rgb(0,196,255)',
                    },
                    ticks:{
                        color:'rgb(0,196,255)',
                    },
                    grid: {
                        color: 'rgba(255,255,255,0.43)', // Change this color to your desired grid color for the x-axis
                    },
                },
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Custom Bar Chart', // Custom option: Set the chart title
                    font: {
                        size: 24 ,// Custom option: Set the font size for the chart title
                        color: 'rgba(255,255,255,0.9)'
                    }
                },
            }
        },
    });
</script>