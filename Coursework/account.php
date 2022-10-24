<?php
    session_start();
?>

<html lang='en'>
    <head>
    <title>Logged In</title>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    <link rel="stylesheet" href="css/cray.css">
    <style>
        html,
        body {
            height: 30%;
        }
        
        .centerContainer {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
</head>

    <body>
    <?php
        include 'navbar.php';
    ?>
        <?php
            if(!empty($_SESSION['username'])) {
                ?>
                <div class="container text-center pt-5">
                    <div class="box">
                        <p class="big"><code><?php echo "Welcome ".$_SESSION['username']; ?>!</code></p>
                        <p class="medium">Here you can view your ongoing requests, successful adoptions and rejected requests with a given reason.</p>
                    </div>
                </div>
                <div class="centerContainer container">
                    <div class="row">
                            <button type="submit" onclick="document.location='userrequests.php'" class="btn btn-block" title="View the state of all your requests">View Requests</button>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="container text-center pt-5">
                    <div class="box">
                        <p class="medium"><code>You must log-in to access this page</code></p>
                        
                    </div>
                </div>
                <?php
            }
        ?>



    </body>
</html>