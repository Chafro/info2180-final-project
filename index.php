<?php
require "bugme.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>BugMe Issue Tracker</title>
        <script  type="text/javascript" src="bugme.js" id="myscript"></script>
        <link rel="stylesheet" type="text/css" href="basic_outline.css">
    </head>
    <body>
        <header class="main-header">
            <div class="main-header-content">
                <h1>BugMe Issue Tracker</h1><br>
            </div>
        </header>

        <section class="container">
            
            <section id="main">
                <?php
                    if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
                        alltickets('all');
                    }
                    else{
                        logout('');
                    }
                ?>
                
            </section>

        </section>
    </body>
</html>
