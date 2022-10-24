    <nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
        <a class='navbar-brand' href='index.php'>AAS</a>
        <button class='navbar-toggler' data-target='#my-nav' data-toggle='collapse' aria-controls='my-nav' aria-expanded='false' aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon'></span>
    </button>
        <div id='my-nav' class='collapse navbar-collapse'>
            <ul class='navbar-nav ml-auto'>
                <li class='nav-item active'>
                    <a class='nav-link' href='index.php' title="Home page">Home<span class='sr-only'>(current)</span></a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='animals.php' tabindex='-1' title="Animal adoption service page">Animals</a>
                </li>
                <li class='nav-item'>
                    <?php
                        if(!empty($_SESSION['username']) && strcmp($_SESSION['username'], 'admin') == 0) {
                            ?>
                            <a class='nav-link' href='admin.php' tabindex='-1' title="Account page">Admin</a>
                            <?php
                        } else {
                            ?>
                            <a class='nav-link' href='account.php' tabindex='-1' title="Account page">Account</a>
                            <?php
                        }
                    ?>
                </li>
                <li class='nav-item'>
                    <?php
                        if(!empty($_SESSION['username'])) {
                            ?>
                            <a class='nav-link' href='logout.php' tabindex='-1' title="Log out of your account">Logout</a>
                            <?php
                        } else {
                            ?>
                            <a class='nav-link' href='login.php' tabindex='-1' title="Login to your account">Login</a>
                            <?php
                        }
                    ?>
                </li>
            </ul>
        </div>
    </nav>