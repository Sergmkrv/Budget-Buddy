<?php
session_start();
$pageTitle = "Profile";
require 'inc/header.inc.php';
require_once 'inc/db_connect.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Home PHP</title>
</head>

<body>
    <header>
        <!--navbar--------------------------------->
        <nav class="navbar navbar-expand-md">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="img/piggy-bank.png" alt="Budget Buddy Logo" class="logo ml-3">
                    <span class="align-middle">
                        <h1 class="m-2 py-2 d-inline" style="white-space: nowrap;">Budget Buddy</h1>
                    </span>
                </a>
                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="btn mr-2" href="home.php" role="button">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn mr-2" href="profile.php" role="button">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn mr-2" href="register.php" role="button">Register</a>
                        </li>
                        <?php if (isset($_SESSION["is_logged_in"])) { ?>
                            <li class="nav-item">
                                <a class="btn mr-2" href="logout.php" role="button">Logout</a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="btn mr-2" href="login.php" role="button">Login</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!--profile--------------------------------->
    <main>
        <div class="my_profile container mt-5 bg-light shadow rounded-lg p-3">
            <?php


            ?>
            <?php include "inc/upload.inc.php"; ?>

            <?php
            if (isset($_SESSION["is_logged_in"])) {
                require "inc/db_connect.inc.php";
                // fetch monthly income for the user
                $stmt = $db->prepare("SELECT first_name, last_name, email, monthly_income FROM user WHERE user_id = :user_id");
                $stmt->execute(['user_id' => $_SESSION['user_id']]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $first_name = $result['first_name'];
                $last_name = $result['last_name'];
                $email = $result['email'];
                $monthly_income = $result['monthly_income'];
            }

            ?>
            <h1 class="mb-5">My Profile</h1>
            <h2>Account Information</h2>
            <div class="row">
                <div class="col-md-6 profile-info">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($first_name), ' ', htmlspecialchars($last_name); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                    <p><strong>Monthly Income:</strong> $<?php echo number_format($monthly_income, 2); ?></p>
                    <button class="btn btn-primary mt-3" id="edit-income-btn">Edit Monthly Income</button>
                    <?php include "inc/edit_income.inc.php"; ?>
                </div>
            </div>
        </div>
    </main>
    <?php include "inc/footer.inc.php"; ?>
</body>

</html>