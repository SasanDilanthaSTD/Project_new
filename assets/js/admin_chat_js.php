
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
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [
            {
                label: 'Data Set 1',
                borderColor: 'rgba(75, 192, 192, 0.7)',
                backgroundColor: gradiatFill_2,
                data: [10, 30, 20, 25, 35, 30],
                tension: 0.3,
                fill:true
            },
            // Add more datasets if needed
            {
                label: 'Data Set 2',
                borderColor: 'rgba(26,72,153,0.7)',
                backgroundColor: gradiatFill_1,
                data: [45, 12, 15, 52, 25, 26],
                tension: 0.3,
                fill: true
            },
        ],
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
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [
            {
                label: 'Data Set 1',
                borderColor: 'rgba(75, 192, 192, 0.7)',
                backgroundColor: gradiatFill_2,
                data: [10, 30, 20, 25, 35, 30],
                tension: 0.3,
                fill:true
            },
            // Add more datasets if needed
            {
                label: 'Data Set 2',
                borderColor: 'rgba(26,72,153,0.7)',
                backgroundColor: gradiatFill_1,
                data: [45, 12, 15, 52, 25, 26],
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