<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Font Awesome -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
        rel="stylesheet"
    />
    <!-- MDB -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css"
        rel="stylesheet"
    />

    <style>

        .bg-glass{
            background: hsla(0, 11%, 61%, 0.07);
            backdrop-filter: blur(30px);
        }
        .bg-glass_sub{
            background: hsla(0, 0%, 94%, 0.07);
            backdrop-filter: blur(2px);
        }

        .txt-gradient{
            background: linear-gradient(-70deg, #00ff81 0%, #006eff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-theme{
            background-color: hsl(218,41%,25%);
        }

        .text-muted{
            color: hsla(194, 100%, 50%, 0.73) !important;
        }
        .text-info{
            color: hsl(194, 100%, 50%) !important;
        }
        .text-success{
            color: hsl(144, 100%, 45%) !important;
        }
        .text-danger{
            color: hsl(350, 100%, 60%) !important;
        }
        .tb-row:hover {
            background-color: hsla(219, 79%, 82%, 0.49);
            transition-delay: 0.5ms;
        }
        .btn-txt-color{
            color: hsl(0, 13%, 89%) ;
        }
        .btn-txt-color:hover{
            color: hsla(220, 81%, 61%, 0.32) !important;
        }
        @media(max-width: 992px) {
            body{
                height: 100%;
            }
        }
    </style>
</head>
<body>

<!-- Modal -->
<div class="modal fade bg-glass_sub" id="stress_1" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="" method="post">
            <div class="modal-content" style="width: auto">
                <div class="modal-header">
                    <div class="d-flex justify-content-centered">
                        <h5 class="modal-title fw-bold txt-gradient" id="exampleModalLabel">Test Your Mind
                            Status
                            (DASS21)
                            test
                        </h5>
                    </div>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body" id="q_body">
                    <div class="mb-4">
                        <p class="fw-normal" id="questions"></p>
                    </div>
                    <div class="md-btn-group-vertical d-flex flex-column flex-md-row bg-transparent btn-rounded">
                        <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" value="0">
                        <label class="btn btn-outline-secondary btn-rounded m-2" for="option1">0</label>

                        <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off" value="1">
                        <label class="btn btn-outline-secondary btn-rounded  m-2" for="option2">1</label>

                        <input type="radio" class="btn-check" name="options" id="option3" autocomplete="off" value="2">
                        <label class="btn btn-outline-secondary btn-rounded m-2" for="option3">2</label>

                        <input type="radio" class="btn-check" name="options" id="option4" autocomplete="off" value="3">
                        <label class="btn btn-outline-secondary btn-rounded m-2" for="option4">3</label>
                    </div>
                </div>
                <div class="modal-body" id="success" style="display: none;">
                    <div class="alert alert-success" role="alert">
                        Thank you for taking the time  for your responses.<br>
                        <small class="fw-light">Whenever you're ready, please click the <strong>"Finish"</strong> button to view your personalized stress level.</small>
                    </div>
                </div>
                <div class="modal-footer" >
                    <div class="note note-info mb-3" id="q_note">
                        <strong>Note :</strong> <small>0 - Did not apply to me at all | 1 - Applied to me to some degree, or some of the time | 2 - Applied to me to a considerable degree or a good part of time | 3 - Applied to me very much or most of the time</small>
                    </div>
                    <button type="button" id="btnNext" name="btbNext" class="btn btn-primary btn-floating" style="display: none;"><i class="fas fa-angle-right"></i></button>
                    <button type="button" id="btnFinish" name="btnFinish" class="btn btn-primary btn-rounded" style="display: none;"><i class="fas fa-check"></i> finish</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    window.onload = function () {
        const modal = new mdb.Modal(document.getElementById("stress_1"));
        modal.show();

        const nextButton = document.getElementById("btnNext");
        const radioButtons = document.querySelectorAll(".btn-check");

        // Function to enable or disable the Next button
        function updateNextButtonState() {
            nextButton.style.display = "block"; // Show the button
            nextButton.disabled = !document.querySelector('input[name="options"]:checked');
        }

        // Attach change event to radio buttons
        radioButtons.forEach(radio => {
            radio.addEventListener("change", () => {
                updateNextButtonState();
            });
        });

        // Initialize button state
        updateNextButtonState();

        // Variable to store the fetched data
        let questionsData = [];

        // Variable to keep track of the current question index
        let currentQuestionIndex = 0;

        // total score
        let totalScoreDepression = 0;
        let totalScoreAnxiety = 0;
        let totalScoreStress = 0;

        // Function to load and display a question
        function loadQuestion() {
            if (currentQuestionIndex < questionsData.length) {
                const question = questionsData[currentQuestionIndex]['q'];
                const question_type = questionsData[currentQuestionIndex]['type'];
                $("#questions").text(question);
                $("#btnNext").prop("disabled", true); // Disable the next button initially
                $("#btnFinish").hide(); // Hide the Finish button
                currentQuestionIndex++;
            } else {
                // Hide unnecessary elements
                $("#q_body").hide();
                $("#q_note").hide();
                $("#btnNext").hide();
                $("#btnFinish").show();
                $("#success").css('display', "block");
            }
        }

        // Fetch data from the PHP script when the document is ready
        $(document).ready(function () {
            $.ajax({
                url: "process/AJAX_request/stress_level.php",
                data: {stress_too_2 : ""},
                method: 'POST',
                dataType: "json",
                success: function (data) {
                    questionsData = data;
                    loadQuestion(); // Load the first question
                },
                error: function () {
                    console.error("Error fetching data.");
                }
            });
        });

        // Event listener for the btnNext button
        $("#btnNext").click(function () {
            // Ensure question_id is defined here
            const question_type = questionsData[currentQuestionIndex - 1]['type'];

            let mark = $("input[type='radio']:checked").val();
            let int_mark = parseInt(mark);
            if (question_type === 'S'){
                totalScoreStress = totalScoreStress + int_mark;
            }else if (question_type === 'A'){
                totalScoreAnxiety = totalScoreAnxiety + int_mark;
            }else  if (question_type === 'D'){
                totalScoreDepression = totalScoreDepression + int_mark;
            }
            loadQuestion();
            $("input[type='radio']").prop("checked", false); // Clear radio button selection
        });

        // Event listener for the btnFinish button
        $("#btnFinish").click(function () {
            // Display the total score
            //$("#questions").text("Total Score: " + totalScore);
            let url = "stress_report_2.php?Sscore=" + totalScoreStress + "&Ascore=" + totalScoreAnxiety + "&Dscore=" + totalScoreDepression;
            $(location).attr('href',url);

        });
    }
</script>
</body>
</html>




