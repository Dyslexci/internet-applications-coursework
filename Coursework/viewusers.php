<?php
    session_start();

    $db = new PDO("mysql:dbname=u_190232957_db;host=localhost","u-190232957","Sf2dk9N2Jt1IDbQ");
    $sql = "SELECT * FROM images";
    $result = $db->query($sql);
    foreach($result as $row) {
        if(isset($_POST[$row['id']])) {
            $db = new PDO("mysql:dbname=u_190232957_db;host=localhost","u-190232957","Sf2dk9N2Jt1IDbQ");
    
            $sql = "INSERT INTO animalrequests (requesteename, animalname) VALUES (?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_SESSION['username'], $row['name']]);
        }
    }
?>

<html lang='en'>

<head>
    <title>User Registry</title>
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
    <?php
        if(!empty($_SESSION['username']) && strcmp($_SESSION['username'], 'admin') == 0) {
            ?>
            <div class="container text-center pt-5">
                <div class="box">
                    <p class="big"><code>User Registry</code></p>
                    <p class="medium">Here all users currently registered with the service can be seen, with their requests status.</p>
                </div>
            </div>
            <div class="container text-center pt-5">
                <div class="box">
                    <?php
                        $db = new PDO("mysql:dbname=u_190232957_db;host=localhost","u-190232957","Sf2dk9N2Jt1IDbQ");
                        $sql = "SELECT * FROM users";
                        $result = $db->query($sql);
                        
                        foreach($result as $row) {
                            echo "<div id='img_div'>";
                            echo "<section>";
                                echo "<details>";
                                    echo "<summary class='big'><code>".$row['username']."</code></summary>";
                                    echo "<p class='medium'><code>Accepted Requests</code></p>";
                                        $db = new PDO("mysql:dbname=u_190232957_db;host=localhost","u-190232957","Sf2dk9N2Jt1IDbQ");
                                        $sth = $db->prepare("SELECT * FROM acceptedrequests WHERE username = :username");
                                        $sth->bindParam(':username', $row['username']);
                                        $sth->execute();
                                        $result2 = $sth->fetchAll();
                                        foreach($result2 as $row2) {
                                            echo "<div id='img_div'>";
                                                echo "<p class='medium'>".$row2['animalname']."</p>";
                                            echo "</div>";
                                        }
                                    echo "<p class='medium'><code>Pending Requests</code></p>";
                                        $db = new PDO("mysql:dbname=u_190232957_db;host=localhost","u-190232957","Sf2dk9N2Jt1IDbQ");
                                        $sth = $db->prepare("SELECT * FROM animalrequests WHERE requesteename = :username");
                                        $sth->bindParam(':username', $row['username']);
                                        $sth->execute();
                                        $result2 = $sth->fetchAll();
                                        foreach($result2 as $row2) {
                                            echo "<div id='img_div'>";
                                                echo "<p class='medium'>".$row2['animalname']."</p>";
                                            echo "</div>";
                                        }
                                    echo "<p class='medium'><code>Declined Requests</code></p>";
                                        $db = new PDO("mysql:dbname=u_190232957_db;host=localhost","u-190232957","Sf2dk9N2Jt1IDbQ");
                                        $sth = $db->prepare("SELECT * FROM declinedrequests WHERE username = :username");
                                        $sth->bindParam(':username', $row['username']);
                                        $sth->execute();
                                        $result2 = $sth->fetchAll();
                                        foreach($result2 as $row2) {
                                            echo "<div id='img_div'>";
                                                echo "<p class='medium'>".$row2['animalname']."</p>";
                                            echo "</div>";
                                        }
                                echo "</details";
                                echo "</section>";
                            echo "</div>";
                        }
                        
                    ?>
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