<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        body {
            font-family: sans-serif;
            background-color: #f5f5f5;
        }

        .thankyou-heading {
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .thankyou-message {
            font-size: 16px;
            line-height: 1.5;
        }

        .thankyou-button {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
        }

        .thankyou-button:hover {
            background-color: #0069d9;
            border-color: #0069d9;
        }

        .thankyou-container {
            background-image: url("https://www.google.lk/url?sa=i&url=https%3A%2F%2Fslidesdocs.com%2Fpowerpoint-background%2Fcalm&psig=AOvVaw0lclncWjlM1PaiEuZW8QMt&ust=1698329222707000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCKjblsKvkYIDFQAAAAAdAAAAABAF");
            background-size: cover;
            background-position: center;
            animation: background-pulse 1s infinite ease-in-out;
            margin: 0 auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes background-pulse {
            0% {
                filter: brightness(1);
            }

            50% {
                filter: brightness(0.9);
            }

            100% {
                filter: brightness(1);
            }
        }


        @keyframes element-pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }


        @keyframes background-fade-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .thankyou-heading,
        .thankyou-message,
        .thankyou-button {
            animation: element-pulse 1s infinite ease-in-out;
        }

        @keyframes element-fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body background="https://www.google.lk/url?sa=i&url=https%3A%2F%2Fslidesdocs.com%2Fpowerpoint-background%2Fcalm&psig=AOvVaw0lclncWjlM1PaiEuZW8QMt&ust=1698329222707000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCKjblsKvkYIDFQAAAAAdAAAAABAF">
<div class="thankyou-container">
    <h1 class="thankyou-heading">Thank You!</h1>
    <p class="thankyou-message">Check Your Email and Activate Your Account</p>
    <a href="https://mail.google.com/" class="thankyou-button">Check Your Mail</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>