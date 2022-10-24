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
            height: 300%;
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
        if(!empty($_SESSION['username']) && strcmp($_SESSION['username'], 'admin') == 0) {
            ?>
            <div class="container text-center pt-5">
                <div class="box">
                    <p class="big"><code><?php echo "Welcome ".$_SESSION['username']; ?>!</code></p>
                    <p class="medium">This is a super secret admin page.</p>
                </div>
                <div class="centerContainer container">
                    <div class="row">
                            <button type="submit" onclick="document.location='animalupload.php'" class="btn btn-block" title="Begin adding a new animal to the database">Upload New Animal</button>
                            <button type="submit" onclick="document.location='animalmanage.php'" class="btn btn-block" title="Manage available animals">Manage Available Animals</button>
                            <button type="submit" onclick="document.location='viewrequests.php'" class="btn btn-block" title="View current adoption requests">View Requests</button>
                            <button type="submit" onclick="document.location='viewanimals.php'" class="btn btn-block" title="View all registered animals">View Animals</button>
                            <button type="submit" onclick="document.location='viewusers.php'" class="btn btn-block" title="View all registered users">View Users</button>
                    </div>
                </div>
            </div>
            
            <?php
        } else {
            ?>
            <div class="container text-center pt-5">
                <div class="box">
                    <p class="medium"><code>You must log-in as an admin to access this page</code></p>  
                </div>
            </div>
            <?php
        }
    ?>
</body>
</html>