<?php
    session_start();

    $db = new PDO("mysql:dbname=u_190232957_db;host=localhost","u-190232957","Sf2dk9N2Jt1IDbQ");
    $sql = "SELECT * FROM images";
    $result = $db->query($sql);
    foreach($result as $row) {
        if(isset($_POST[$row['id']])) {
            $record = $row['id'];
            $sql = "DELETE FROM images WHERE id=$record";
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
    }
?>

<html lang='en'>

<head>
    <title>Animal Management</title>
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
                    <p class="big"><code>Animal Record Management</code></p>
                    <p class="medium">On this page a record of each animal currently registered with the service is shown, with options to edit or delete each record if possible. An animal which has been adopted already cannot be edited or deleted.</p>
                </div>
            </div>
            <div class="container text-center pt-5">
                <div class="box">
                    <?php
                        $db = new PDO("mysql:dbname=u_190232957_db;host=localhost","u-190232957","Sf2dk9N2Jt1IDbQ");
                        $sql = "SELECT * FROM images";
                        $result = $db->query($sql);
                        foreach($result as $row) {
                            echo "<div id='img_div'>";
                                echo "<form action='' method='post' name='manage'>";
                                    echo "<p>".$row['name']."</p>";
                                    echo "<img src='images/".$row['image']."' >";
                                    echo "<p>".$row['dob']."</p>";
                                    echo "<p>Owner: ".$row['owner']."</p>";
                                    if(strcmp($row['owner'], 'none') == 0) {
                                        echo "<button type='submit' class='btn btn-block' id=".$row['id']." name=".$row['id']." value='Delete' title='Delete this animal from the database'>Delete</button>";
                                    } else {
                                        echo "This animal has been adopted already, and therefore cannot be edited in any way.";
                                    }
                                echo "</form";
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