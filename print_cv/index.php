
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id='xxx'>
       
    </div>
</body>
</html>

<script>
     document.getElementById('xxx').innerHTML = "<div id='downl_cv' style='text-align: center'> <img style='width:100%; max-height: 950px !important;' src='"+localStorage.getItem("element")+"'> </div>";
     window.print();
</script>

<?php

