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
    <title>Animal Adoption</title>
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
            <p class="big"><code>Animals Page</code></p>
            <p class="medium">Welcome to the animal adoption service. Here you can view the current animals available for adoption and request to adopt one, or multiple, at your leisure. A representative will confirm or deny your request in course.</p>
        </div>
    </div>
    <div class="container text-center pt-5">
        <div class="box">
            <?php
                $db = new PDO("mysql:dbname=u_190232957_db;host=localhost","u-190232957","Sf2dk9N2Jt1IDbQ");
                $username = $_SESSION['username'];
                $sql = "SELECT * FROM images";
                $sql2 = "SELECT * FROM animalrequests";
                $result = $db->query($sql);
                $result2 = $db->query($sql2);
                foreach($result as $row) {
                    echo "<div id='img_div'>";
                        echo "<form action='' method='post' name='request'>";
                            echo "<p>".$row['name']."</p>";
                            echo "<img src='images/".$row['image']."' >";
                            echo "<p>".$row['dob']."</p>";
                            echo "<p>".$row['text']."</p>";
                            if(strcmp($row['owner'], 'none') == 0) {
                                foreach($result2 as $row2) {
                                    if(strcmp($row2['requesteename'], $_SESSION['username']) == 0) {
                                        echo "<p>You have already submitted a request for this animal!</p>";
                                    } else {
                                        echo "<button type='submit' class='btn btn-block' id=".$row['id']." name=".$row['id']." value='Request' title='Request adoption of this animal'>Request</button>";
                                    }
                                }
                            } else {
                                echo "<p>This animal has been adopted already.</p>";
                            }
                        echo "</form";
                    echo "</div>";
                }
            ?>
        </div>
    </div>

</body>

</html>