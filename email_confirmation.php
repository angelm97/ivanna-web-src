<?php 
    session_start();
    include './email-confirmation/index.php'; 
    $mail;
    if ($_SESSION['email_user_confirmation']) {
        $mail = $_SESSION['email_user_confirmation'];
        $param = '';
    }
    if ($_SESSION['email_user_confirmation_jobseeker']) {
        $mail = $_SESSION['email_user_confirmation_jobseeker'];
        $param = '&jobseeker=true';
    }
    phpmailertest($mail, $param, $_SESSION['user_name']);
    //var_dump($_SESSION['confirmation_code']);

  
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
    <style>
        @media only screen and (max-width: 990px) {
            .modal-content {
                background-color: #fefefe;
                margin: auto;
                padding: 20px;
                border: 1px solid #888;
                width: 87% !important;
            }
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */

        .clearfix {
            clear: both;
            float: none;
        }

        #btn, #btn2  {
            border: 1px solid transparent;
            color: whitesmoke;
            border-radius: 5px;
            font-size: 20px;
            background-color: rgb(18, 209, 209);
            margin: 5px;
        }

        .btn_div {
            width: 80%;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .right {
            float: right;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <img src="img/logo.png" alt="">
            
            <p> Hemos enviado un link a <?= $mail; // ?> para activar su cuenta.</p>
            <div class="btn_div">
                <button id="btn" class="right">Refrescar</button>
            </div>
            <div class="btn_div">
                <button id="btn2" class="right">Cerrar sesion </button>
            </div>

            <div class="clearfix"></div>

        </div>

    </div>

    <script>
        // Get the modal

        var modal = document.getElementById("myModal");
        modal.style.display = "block";

        var btn = document.getElementById("btn");
        btn.onclick = function () {
            window.location.href = '/index.php';
        }

        var btn2 = document.getElementById("btn2");
        btn2.onclick = function () {
            window.location.href = '/logout.php';
        }

    </script>

</body>

</html>

<?php 
    unset($_SESSION["email_user_confirmation"]);
?>