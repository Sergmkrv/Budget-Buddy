<?php
// register.php
$pageTitle = "Register";
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
    if (empty($_POST["first_name"])) {
        array_push($error_bucket, "A first name is required.");
    } else {
        $first_name = $_POST["first_name"];
    }
    if (empty($_POST["last_name"])) {
        array_push($error_bucket, "A last name is required.");
    } else {
        $last_name = $_POST["last_name"];
    }

    // if error bucket is empty, insert the user into the database
    if (count($error_bucket) == 0) {
        $sql = "INSERT INTO user (first_name,last_name,email,password) ";
        $sql .= "VALUES (:first_name,:last_name,:email,:password)";

        $stmt = $db->prepare($sql);
        $stmt->execute(["first_name" => $first_name, "last_name" => $last_name, "email" => $email, "password" => $password]);

        // check if the user was inserted
        // if not, show an error message
        if ($stmt->rowCount() == 0) {
            echo '<div class="alert alert-danger" role="alert">
        I am sorry, but I could not save that record for you.</div>';
        } else {
            // if the user was inserted, show a success message and redirect to the login page
            header("Location: login.php?");
            echo "User successfully registered";
        }
    } else {
        // if there are errors, display them
        display_error_bucket($error_bucket);
    }
}
?>

<!--register form-->
<div class="register-form mt-5 mb-5">
    <h1 class="text-center fw-bold">Register</h1>
    <div class="form-container d-flex justify-content-center">
        <form action="register.php" method="POST" class="form border rounded-3 p-3 shadow mt-2 col-6 shadow-md">
            <label class="col-form-label fw-bold" for="email">Email</label>
            <input class="form-control" type="email" id="email" name="email">
            <br><br>
            <label class="col-form-label fw-bold" for="password">Password</label>
            <input class="form-control" type="password" id="password" name="password">
            <br><br>
            <label class="col-form-label fw-bold" for="first_name">First Name</label>
            <input class="form-control" type="text" id="first_name" name="first_name">
            <br><br>
            <label class="col-form-label fw-bold" for="last_name">Last Name</label>
            <input class="form-control" type="text" id="last_name" name="last_name">
            <br><br>
            <input type="submit" value="Register" class="btn btn-light fw-bold mb-1 shadow">
        </form>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
<script src="css/bootstrap.min.css"></script>