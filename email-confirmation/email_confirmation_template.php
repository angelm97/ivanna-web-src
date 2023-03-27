<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hola %username%</title>
</head>
<body>
    <p>
        Clic en el siguiente link para confirmar tu correo.
    </p>

    %tag-a-%

    <?= $_SESSION['confirmation_code']; ?>
    <div id="a">
        
    </div>
  
</body>
</html>

<script>
    document.getElementById("a").innerHTML = ' <a href="angel">Clic aqui para confirmar tu correo.</a>';
</script>