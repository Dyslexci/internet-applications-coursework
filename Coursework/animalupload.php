<?php
    session_start();
    $msg = "";

    if(isset($_POST['upload'])) {
        // Path to store the image
        $target = "images/".basename($_FILES['image']['name']);

        $db = new PDO("mysql:dbname=u_190232957_db;host=localhost","u-190232957","Sf2dk9N2Jt1IDbQ");

        $image = $_FILES['image']['name'];
        $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
        $detectedType = exif_imagetype($_FILES['image']['tmp_name']);
        $name = $_POST['name'];
        $dob = $_POST['dob'];
        $text = $_POST['text'];
        $owner = "none";

        // Validate the form
        if(!empty($image) && in_array($detectedType, $allowedTypes)) {
            if(!empty($name)) {
                if(!empty($dob)) {
                    if(!empty($text)) {
                        // Sanitise the text inputs
                        $name = stripcslashes($name);
                        $text = stripcslashes($text);
                        $name = htmlspecialchars($name);
                        $text = htmlspecialchars($text);

                        // Insert the record into the database
                        $sql = "INSERT INTO images (image, name, dob, text, owner) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $db->prepare($sql);
                        $stmt->execute([$image, $name, $dob, $text, $owner]);

                        if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                            $msg = "Image uploaded successfully";
                        } else {
                            $msg = "There was a problem uploading the image";
                        }
                    } else {
                        $msg = "A description is required.";
                    }
                } else {
                    $msg = "A date of birth is required.";
                }
            } else {
                $msg = "A name is required.";
            }
        } else {
            $msg = "An image is required.";
        }

        
    }
?>

<html lang='en'>

<head>
    <title>Upload</title>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    <link rel="stylesheet" href="css/cray.css">
    <style>
        html,
        body {
            height: 80%;
        }
        
        .centerContainer {
            height: 60%;
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
                <p class="medium">Successfully logged in as <?php echo "Welcome ".$_SESSION['username']; ?></p>
                <p class="medium">Here you can upload new animals to the database to be made available for adoption.</p>

            </div>
        </div>
        <div class="centerContainer container">
            <div class="row">
                <div class="box">
                    <div class="login-form">
                        <div id="content">
                            <div class="login-form">
                                <form method="post" action="animalupload.php" enctype="multipart/form-data">
                                    <h1 class="text-center">Upload</h1>
                                    <input type="hidden" name="size" value="1000000">
                                    <div>
                                        <input type="file" name="image">
                                    </div>
                                    <div>
                                        <input type="text" class="inp rounded" placeholder="Name" id="name" name="name" title="Enter the animal name here" />
                                    </div>
                                    <div>
                                        <input type="date" class="inp rounded" id="dob" name="dob" value="2000-12-31" title="Enter the animal's date of birth here" />
                                    </div>
                                    <div>
                                        <textarea name="text" class="inp rounded" cols="40" rows="4" placeholder="Say something about this image..."></textarea>
                                    </div>
                                    <div>
                                        <input type="submit" class="btn btn-block" name="upload" value="Add Animal">
                                    </div>
                                </form>
                                <?php echo $msg; ?>
                            </div>
                        </div>
                    </div>
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