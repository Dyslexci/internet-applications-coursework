<?php
    session_start();

    $registerfailed = '';

    // Connect to the server and select database
    try {
        $db = new PDO("mysql:dbname=u_190232957_db;host=localhost","u-190232957","Sf2dk9N2Jt1IDbQ");
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT count(*) FROM users WHERE username = :username";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $_POST['user']);
        $stmt->execute();
        $result = $stmt->fetchColumn();

        if(!empty($_POST['user'])) {
            if(!empty($_POST['pass'])) {
                if($result == 0) {
                    if(strcmp($_POST['user'], 'admin') != 0) {
                        // Get values passed from form
                        $username = $_POST['user'];
                        $password = $_POST['pass'];

                        // To prevent injection
                        $username = stripcslashes($username);
                        $password = stripcslashes($password);
                        $username = htmlspecialchars($username);
                        $password = htmlspecialchars($password);

                        $password = password_hash($password, PASSWORD_DEFAULT);

                        // Add data to the database
                        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
                        $stmt = $db->prepare($sql);
                        $stmt->execute([$username, $password]);

                        header('location: login.php');
                    } else {
                        $registerfailed = 'This name is unavailable.';
                    }
                } else {
                    $registerfailed = 'Someone else has already chosen this username.';
                }
            } else {
                $registerfailed = 'You must enter a password.';
            }
            
        } else {
            $registerfailed = 'You must enter a username.';
        }
    } catch (PDOExxception $ex) {
        
    }
?>

<html lang='en'>

<head>
    <title>Register</title>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    <link rel="stylesheet" href="css/cray.css">
    <style>
        html,
        body {
            height: 85%;
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

    <div class="centerContainer container">
        <div class="row">
            <div class="box">
                <div class="login-form">
                    <form action="register.php" method="post" name="register">
                        <h1 class="text-center">Register</h1>
                        <div class="form-group">
                            <input type="text" class="inp rounded" placeholder="Username" id="user" name="user" title="Enter your username here">
                            <i class="mdi mdi-account"></i>
                        </div>
                        <div class="form-group">
                            <input type="password" class="inp rounded" placeholder="Password" id="pass" name="pass" title="Enter your password here">
                            <i class="mdi mdi-account"></i>
                        </div>
                        <?php
                            if(!empty($_POST['register'])) {
                                ?>
                                <div class="alert alert-bad"><?php echo $registerfailed; ?></div>
                                <?php
                            } else {
                                ?>
                                <br>
                                <?php
                            }
                        ?>
                        <input type="submit" class="btn btn-block" id="register" name="register" value="Register" title="Register a new account with the details you have entered">
                        <input type="button" onclick="document.location='login.php'" class="btn btn-block" value="Login" title="Return to the login page">
                    </form>
                </div>
            </div>

        </div>

    </div>

    </div>

</body>

</html>