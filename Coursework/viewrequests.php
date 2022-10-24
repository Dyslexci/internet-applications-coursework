<?php
    session_start();

    $db = new PDO("mysql:dbname=u_190232957_db;host=localhost","u-190232957","Sf2dk9N2Jt1IDbQ");
    $sql = "SELECT * FROM images";
    
    $result = $db->query($sql);
    foreach($result as $row) {
        $sql2 = "SELECT * FROM animalrequests";
        $result2 = $db->query($sql2);
        foreach($result2 as $row2) {
            if(isset($_POST[$row2['id'].$row['id'].'accept'])) {
                // Update animal listing to display new owner
                $acceptsql = "UPDATE images SET owner = :newowner WHERE id = :requestid";
                $stmt = $db->prepare($acceptsql);
                $stmt->bindParam(':newowner', $row2['requesteename']);
                $stmt->bindParam(':requestid', $row['id']);
                $stmt->execute();
                // Add successful applicant to the accepted requests list
                $sql = "INSERT INTO acceptedrequests (username, animalname) VALUES (:username, :animalname)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':username', $row2['requesteename']);
                $stmt->bindParam(':animalname', $row['name']);
                $stmt->execute();
                // Remove successful applicant from the pending requests list
                $deletesql = "DELETE FROM animalrequests WHERE (animalname = :animalname AND requesteename = :username)";
                $stmt2 = $db->prepare($deletesql);
                $stmt2->bindParam(':animalname', $row['name']);
                $stmt2->bindParam(':username', $row2['requesteename']);
                $stmt2->execute();
                // Add all other records associated with this animal to the declined applicant list
                $sth = $db->prepare("SELECT * FROM animalrequests WHERE animalname = :animalname");
                $sth->bindParam(':animalname', $row['name']);
                $sth->execute();
                $result3 = $sth->fetchAll();
                foreach($result3 as $row3) {
                    $sql = "INSERT INTO declinedrequests (username, animalname) VALUES (:username, :animalname)";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':username', $row3['requesteename']);
                    $stmt->bindParam(':animalname', $row['name']);
                    $stmt->execute();
                }
                // Delete all other applicants from the pending requests list
                $deletesql = "DELETE FROM animalrequests WHERE animalname = :animalname";
                $stmt2 = $db->prepare($deletesql);
                $stmt2->bindParam(':animalname', $row['name']);
                $stmt2->execute();

            } else if(isset($_POST[$row2['id'].$row['id'].'decline'])) {
                $deletesql = "DELETE FROM animalrequests WHERE id = :requestid";
                $stmt = $db->prepare($deletesql);
                $stmt->bindParam(':requestid', $row2['id']);
                $stmt->execute();
            }
        }
    }
?>

<html lang='en'>

<head>
    <title>Current Requests</title>
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
                        <p class="big"><code>Current Requests</code></p>
                        <p class="medium">All current requests for each animal are available to view here, and to request or decline for each request.</p>
                    </div>
                </div>
                <div class="container text-center pt-5">
                    <div class="box">
                        <?php
                            $db = new PDO("mysql:dbname=u_190232957_db;host=localhost","u-190232957","Sf2dk9N2Jt1IDbQ");
                            $sql = "SELECT * FROM images";
                            $result = $db->query($sql);
                            
                            foreach($result as $row) {
                                $sql2count = "SELECT count(*) FROM animalrequests WHERE animalname = :animalname";
                                $result2count = $db->prepare($sql2count);
                                $result2count->bindParam(':animalname', $row['name']);
                                $result2count->execute();
                                $rownum = $result2count->fetchColumn();
                                if((strcmp($row['owner'], 'none') == 0) && $rownum != 0) {
                                    $currentanimal = $row['name'];
                                    $sql2 = "SELECT * FROM animalrequests";
                                    $result2 = $db->query($sql2);
                                    echo "<div id='img_div'>";
                                        echo "<form action='' method='post' name='request'>";
                                            echo "<p class='medium'>".$row['name']."</p>";
                                            foreach($result2 as $row2) {
                                                if(strcmp($row2['animalname'], $row['name']) == 0) {
                                                    echo "<p>".$row2['requesteename']."</p>";
                                                    echo "<button type='submit' class='btn btn-block' id=".$row2['id'].$row['id']."accept name=".$row2['id'].$row['id']."accept value='Accept' title='Request adoption of this animal'>".$row2['id'].$row['id']."Accept</button>";
                                                    echo "<button type='submit' class='btn btn-block' id=".$row2['id'].$row['id']."decline name=".$row2['id'].$row['id']."decline value='Request' title='Request adoption of this animal'>".$row2['id'].$row['id']."Decline</button>";
                                                }
                                                
                                            }
                                        echo "</form";
                                    echo "</div>";
                                }
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