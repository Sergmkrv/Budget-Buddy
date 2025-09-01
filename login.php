<?php
// login.php
// session_start();
$pageTitle = 'Login';
require 'inc/header.inc.php';
require_once 'inc/db_connect.inc.php';
require_once 'inc/functions.inc.php';

// create error bucket
$error_bucket = [];

// check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if there are any empty fields, if so, add them to the error bucket
    // if no errors, set the variables
    if (empty($_POST["email"])) {
        array_push($error_bucket, "An email is required.");
    } else {
        $email = $_POST["email"];
    }
    if (empty($_POST["password"])) {
        array_push($error_bucket, "A password is required.");
    } else {
        $password = hash('sha512', $_POST['password']);
    }

    // if error bucket is empty, check if the user exists in the database
    if (count($error_bucket) == 0) {
        $sql = "SELECT * FROM user WHERE email=:email AND password=:password LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->execute(["email" => $email, "password" => $password]);

        // check if the user was found
        if ($stmt->rowCount() == 1) {
            // if found fetch the data and start a session for the user
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            session_start();
            $_SESSION["is_logged_in"] = 1;
            $_SESSION["first_name"] = $row->first_name;
            $_SESSION["user_id"] = $row->user_id;
            // redirect to home page
            header("Location: home.php");
        } else {
            // if not found, show an error message
            echo '<div class="pt-4 alert alert-warning shadow" role="alert">';
            echo '<p>Invalid user credentials. Please try again.</p>';
            echo '</div>';
        }
    } else {
        // if there are errors, display them
        display_error_bucket($error_bucket);
    }
}

?>

<!--login form-->
<div class="login-form mt-5 mb-5">
    <h1 class="text-center fw-bold">Login</h1>
    <div class="form-container d-flex justify-content-center">
        <form action="login.php" method="POST" class="form border rounded-3 p-3 shadow mt-2 col-6 shadow-md">
            <label class="col-form-label fw-bold" for="email">Email</label>
            <br><br>
            <input class="form-control" type="email" name="email" id="email">
            <br><br>
            <label class="col-form-label fw-bold" for="password">Password</label>
            <span id="showPassword" onclick="showPassword();">Show Password</span>
            <br><br>
            <input class="form-control" type="password" name="password" id="password">
            <br><br>
            <input type="submit" value="Login" class="btn btn-light fw-bold mb-1 shadow">
        </form>
    </div>
</div>

<script src="js/script.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
<script src="js/bootstrap.min.js"></script>