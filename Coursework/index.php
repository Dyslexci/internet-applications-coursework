<?php
    session_start();
?>

<html lang='en'>

<head>
    <title>Home</title>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    <link rel="stylesheet" href="css/cray.css">
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
</head>

<body>
    <?php
    include 'navbar.php';
    ?>

    <div class="container text-center pt-5">
        <div class="box">
            <p class="big"><code>Welcome to the Aston Animal Sanctuary</code></p>
            <p class="medium">Our mission is to protect the animals of Aston and find happy homes for them all. With your help, we can save an animal today!</p>
        </div>
    </div>

</body>

</html>